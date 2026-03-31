<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use App\Services\TrendyolService;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

#[Signature('trendyol:sync')]
#[Description('Sync products from Trendyol API')]
class SyncTrendyolProducts extends Command
{
    public function handle(TrendyolService $trendyolService)
    {
        $this->info('Starting Trendyol product sync...');
        
        $page = 0;
        $size = 50;
        $syncedCount = 0;
        
        do {
            $this->line("Fetching page {$page}...");
            $response = $trendyolService->getProducts($page, $size);
            
            if (!$response) {
                $this->error('Failed to fetch data from Trendyol API. Request was blocked or timed out.');
                return 1;
            }

            if (!isset($response['content'])) {
                $this->error('Invalid response format or error occurred. Check response body.');
                return 1;
            }
            
            $products = $response['content'];
            if (empty($products)) {
                break;
            }
            
            foreach ($products as $item) {
                // Sync Brand
                $brand = null;
                if (!empty($item['brandId'])) {
                    $brand = Brand::firstOrCreate(
                        ['trendyol_id' => $item['brandId']],
                        [
                            'name' => $item['brand'] ?? 'Unknown',
                            'slug' => Str::slug($item['brand'] ?? 'Unknown-'.uniqid())
                        ]
                    );
                }
                
                // Sync Category
                $category = null;
                if (!empty($item['categoryName'])) {
                    $categoryName = $item['categoryName'];
                    $category = Category::firstOrCreate(
                        ['name' => $categoryName],
                        [
                            'slug' => Str::slug($categoryName . '-' . uniqid())
                        ]
                    );
                }
                
                // Sync Product
                $product = Product::updateOrCreate(
                    [
                        'trendyol_id' => $item['id'] ?? null,
                        'barcode' => $item['barcode'] ?? null,
                    ],
                    [
                        'title' => $item['title'],
                        'slug' => Str::slug($item['title'] . '-' . ($item['barcode'] ?? uniqid())),
                        'description' => $item['description'] ?? null,
                        'brand_id' => $brand?->id,
                        'category_id' => $category?->id,
                        'price' => $item['listPrice'] ?? 0,
                        'discounted_price' => $item['salePrice'] ?? null,
                        'stock' => $item['quantity'] ?? 0,
                        'is_active' => true,
                    ]
                );
                
                // Sync Images
                if (!empty($item['images'])) {
                    // Remove old images first to avoid duplicates or keep them synced
                    $product->images()->delete();
                    
                    foreach ($item['images'] as $index => $image) {
                        $product->images()->create([
                            'image_url' => $image['url'],
                            'sort_order' => $index,
                        ]);
                    }
                }
                
                $syncedCount++;
            }
            
            $page++;
            
            // Temporary break for deep fetches if totalPages is present, but simple loop works if empty means done
            if (count($products) < $size) {
                break;
            }
            
        } while (true);

        $this->info("Successfully synced {$syncedCount} products!");
        return 0;
    }
}
