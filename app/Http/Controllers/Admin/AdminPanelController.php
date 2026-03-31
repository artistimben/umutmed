<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\CurrentAccount;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Artisan;

class AdminPanelController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_customers' => CurrentAccount::where('type', 'customer')->count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total_amount'),
        ];
        
        $recent_orders = Order::latest()->limit(5)->get();
        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }

    public function products()
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    public function currentAccounts()
    {
        $accounts = CurrentAccount::latest()->paginate(15);
        return view('admin.current_accounts.index', compact('accounts'));
    }

    public function syncTrendyol()
    {
        try {
            Artisan::call('trendyol:sync');
            return back()->with('success', 'Trendyol ürünleri başarıyla çekildi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Sync Hatası: ' . $e->getMessage());
        }
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeSettings()
    {
        return view('admin.settings.index');
    }

    public function updateSettings(Request $request)
    {
        // For a real production app, we'd save these to a database table 'settings'
        // But for now, we'll demonstrate the UI and logic.
        return back()->with('success', 'Trendyol mağaza ayarları başarıyla güncellendi.');
    }

    public function trendyolIntegration(\App\Services\TrendyolService $trendyolService)
    {
        $response = $trendyolService->getIntegrationProducts(0, 50);
        return view('admin.integration.index', compact('response'));
    }

    public function syncIntegrationProducts(\App\Services\TrendyolService $trendyolService)
    {
        $response = $trendyolService->getIntegrationProducts(0, 100);
        $categoryTree = $trendyolService->getCategoryTree(); // Trendyol hiyerarşisini çek
        
        if (!$response || !isset($response['content'])) {
            return back()->with('error', 'Trendyol verileri alınamadı.');
        }

        // Hiyerarşi için basit bir harita oluştur
        $categoryMap = [];
        $this->flattenCategories($categoryTree['categories'] ?? [], $categoryMap);

        $count = 0;
        foreach ($response['content'] as $item) {
            
            // 1. Markayı Otomatik Oluştur/Eşleştir
            $brandId = $item['brandId'] ?? null;
            $brandName = $item['brandName'] ?? ($brandId ? "Marka #$brandId" : 'Markasız');
            $brand = Brand::updateOrCreate(
                ['external_id' => (string)$brandId, 'marketplace' => 'Trendyol'],
                ['name' => $brandName, 'slug' => \Illuminate\Support\Str::slug($brandName . '-' . $brandId)]
            );

            // 2. Kategoriyi ve Üst Kategorilerini Hiyerarşik Oluştur
            $catId = $item['pimCategoryId'] ?? null;
            $category = $this->syncCategoryWithParents($catId, $categoryMap);

            // 3. Ürünü Akıllıca Eşleştir (Barkod veya Slug)
            $slugBase = \Illuminate\Support\Str::slug(($item['title'] ?? $item['modelCode']) . '-' . ($item['barcode'] ?? $item['modelCode']));
            $product = Product::where('barcode', $item['barcode'])->first() ?? Product::where('slug', $slugBase)->first();

            $productData = [
                'title' => $item['title'] ?? ($item['modelCode'] ?? 'İsimsiz Ürün'),
                'slug' => $slugBase,
                'barcode' => $item['barcode'],
                'marketplace' => 'Trendyol',
                'price' => $item['listPrice'] ?? 0,
                'discounted_price' => $item['salePrice'] ?? null,
                'stock' => $item['quantity'] ?? 0,
                'brand_id' => $brand->id,
                'category_id' => $category ? $category->id : null,
                'external_brand_id' => (string)$brandId,
                'external_category_id' => (string)$catId,
                'is_active' => true,
            ];

            if ($product) {
                $product->update($productData);
            } else {
                $product = Product::create($productData);
            }

            // 4. Görselleri Güncelle
            if (isset($item['images'][0]['url'])) {
                $product->images()->delete();
                foreach($item['images'] as $img) {
                    $product->images()->create(['image_url' => $img['url']]);
                }
            }

            $count++;
        }

        return redirect()->route('admin.integration')->with('success', $count . ' adet ürün, hiyerarşik kategorileriyle birlikte Tastyol üzerinden işlendi.');
    }

    /**
     * Hiyerarşik kategori oluşturma yardımı (Özyinelemeli/Recursive)
     */
    private function syncCategoryWithParents($catId, &$categoryMap)
    {
        if (!$catId || !isset($categoryMap[$catId])) return null;

        $catData = $categoryMap[$catId];
        $parentId = null;

        // Eğer bir üst kategorisi varsa, önce onu (ve onun üstünü) oluştur
        if (!empty($catData['parentId'])) {
            $parentCat = $this->syncCategoryWithParents($catData['parentId'], $categoryMap);
            $parentId = $parentCat ? $parentCat->id : null;
        }

        return Category::updateOrCreate(
            ['external_id' => (string)$catId, 'marketplace' => 'Trendyol'],
            [
                'name' => $catData['name'],
                'slug' => \Illuminate\Support\Str::slug($catData['name'] . '-' . $catId),
                'parent_id' => $parentId
            ]
        );
    }

    /**
     * Trendyol ağaç yapısını düz listeye çevirme (Map)
     */
    private function flattenCategories($categories, &$map)
    {
        foreach ($categories as $cat) {
            $map[$cat['id']] = $cat;
            if (!empty($cat['subCategories'])) {
                $this->flattenCategories($cat['subCategories'], $map);
            }
        }
    }

    public function productManagement()
    {
        // CRUD logic later if needed
    }
}
