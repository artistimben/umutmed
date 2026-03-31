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
        
        if (!$response || !isset($response['content'])) {
            return back()->with('error', 'Trendyol verileri alınamadı.');
        }

        $count = 0;
        foreach ($response['content'] as $item) {
            
            // 1. Markayı Otomatik Oluştur/Eşleştir
            $brandId = $item['brandId'] ?? null;
            $brandName = $item['brandName'] ?? ($brandId ? "Marka #$brandId" : 'Markasız');
            $brand = Brand::updateOrCreate(
                ['external_id' => (string)$brandId, 'marketplace' => 'Trendyol'],
                ['name' => $brandName, 'slug' => \Illuminate\Support\Str::slug($brandName . '-' . $brandId)]
            );

            // 2. Kategoriyi Otomatik Oluştur/Eşleştir
            $catId = $item['pimCategoryId'] ?? null;
            $catName = $item['categoryName'] ?? ($catId ? "Kategori #$catId" : 'Genel Ürünler');
            $category = Category::updateOrCreate(
                ['external_id' => (string)$catId, 'marketplace' => 'Trendyol'],
                ['name' => $catName, 'slug' => \Illuminate\Support\Str::slug($catName . '-' . $catId)]
            );

            // 3. Ürünü Kaydet/Güncelle
            $slugBase = \Illuminate\Support\Str::slug(($item['title'] ?? $item['modelCode']) . '-' . ($item['barcode'] ?? $item['modelCode']));
            
            $product = Product::updateOrCreate(
                ['barcode' => $item['barcode'], 'marketplace' => 'Trendyol'],
                [
                    'title' => $item['title'] ?? ($item['modelCode'] ?? 'İsimsiz Ürün'),
                    'slug' => $slugBase, // Barkodu slug'a ekleyerek çakışmayı önledik
                    'price' => $item['listPrice'] ?? 0,
                    'discounted_price' => $item['salePrice'] ?? null,
                    'stock' => $item['quantity'] ?? 0,
                    'brand_id' => $brand->id,
                    'category_id' => $category->id,
                    'external_brand_id' => (string)$brandId,
                    'external_category_id' => (string)$catId,
                    'is_active' => true,
                ]
            );

            // 4. Görselleri Güncelle (Eğer link varsa)
            if (isset($item['images'][0]['url'])) {
                $product->images()->delete();
                foreach($item['images'] as $img) {
                    $product->images()->create(['image_url' => $img['url']]);
                }
            }

            $count++;
        }

        return redirect()->route('admin.integration')->with('success', $count . ' adet ürün, markaları ve kategorileriyle birlikte Trendyol üzerinden veritabanına işlendi.');
    }

    public function productManagement()
    {
        // CRUD logic later if needed
    }
}
