<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class MedicalCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Tansiyon Aletleri',
            'Ateş Ölçerler',
            'Maske & Dezenfektan',
            'Ortopedik Ürünler',
            'Diyabet Ürünleri',
            'Yara Bakım Peluşları',
            'Hastane Ekipmanları',
            'Laboratuvar Ürünleri'
        ];

        $brand = Brand::updateOrCreate(['name' => 'Umut Medikal'], ['slug' => 'umut-medikal']);

        foreach ($categories as $cat) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat]
            );

            // Add 3 sample products per category
            for ($i = 1; $i <= 3; $i++) {
                $title = $cat . ' - Ürün ' . $i;
                $product = Product::updateOrCreate(
                    ['slug' => Str::slug($title)],
                    [
                        'title' => $title,
                        'description' => $cat . ' kategorisinde yer alan yüksek kaliteli medikal ürün. Umut Medikal güvencesiyle.',
                        'price' => rand(100, 2500),
                        'discounted_price' => rand(50, 2000),
                        'stock' => rand(10, 100),
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'is_active' => true,
                    ]
                );

                ProductImage::updateOrCreate(
                    ['product_id' => $product->id],
                    ['image_url' => 'https://via.placeholder.com/600x400?text=' . urlencode($title), 'sort_order' => 1]
                );
            }
        }
    }
}
