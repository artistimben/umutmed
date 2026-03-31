<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class DummyProductsSeeder extends Seeder
{
    public function run(): void
    {
        $brand = Brand::create(['name' => 'Umut Medikal', 'slug' => 'umut-medikal']);
        
        $catMaske = Category::create(['name' => 'Maskeler', 'slug' => 'maskeler']);
        $catEldiven = Category::create(['name' => 'Eldivenler', 'slug' => 'eldivenler']);
        $catCihaz = Category::create(['name' => 'Medikal Cihazlar', 'slug' => 'medikal-cihazlar']);

        $products = [
            [
                'title' => 'Cerrahi Yüz Maskesi 3 Katlı Telli 50 Adet',
                'description' => 'Yüksek koruma sağlayan 3 katlı, ultrasonik burun telli cerrahi maske. Günlük kullanıma uygundur.',
                'price' => 45.00,
                'discounted_price' => 35.90,
                'stock' => 1000,
                'category_id' => $catMaske->id,
                'images' => ['https://images.unsplash.com/photo-1586942540058-df3a6703b0d2?auto=format&fit=crop&q=80&w=600']
            ],
            [
                'title' => 'Pudrasız Nitril Muayene Eldiveni M Beden 100lü',
                'description' => 'Mavi renkli, yırtılmalara karşı dayanıklı nitril eldiven. Lateks içermez.',
                'price' => 120.00,
                'discounted_price' => 99.00,
                'stock' => 500,
                'category_id' => $catEldiven->id,
                'images' => ['https://images.unsplash.com/photo-1584308666744-24d5e4a500b0?auto=format&fit=crop&q=80&w=600']
            ],
            [
                'title' => 'Dijital Temassız Ateş Ölçer Termometre',
                'description' => '1 saniyede hızlı ölçüm yapan hassas dijital ateş ölçer.',
                'price' => 450.00,
                'discounted_price' => 380.00,
                'stock' => 50,
                'category_id' => $catCihaz->id,
                'images' => ['https://images.unsplash.com/photo-1584017911766-d451b3d0e843?auto=format&fit=crop&q=80&w=600']
            ],
            [
                'title' => 'Tansiyon Aleti Koldan Ölçer Dijital',
                'description' => 'Geniş ekranlı, aritmi uyarılı tam otomatik dijital tansiyon aleti.',
                'price' => 850.00,
                'discounted_price' => null,
                'stock' => 30,
                'category_id' => $catCihaz->id,
                'images' => ['https://images.unsplash.com/photo-1629881180295-8c01d4aef99e?auto=format&fit=crop&q=80&w=600']
            ]
        ];

        foreach ($products as $index => $item) {
            $images = $item['images'];
            unset($item['images']);
            
            $item['slug'] = Str::slug($item['title'] . '-' . uniqid());
            $item['brand_id'] = $brand->id;
            
            $product = Product::create($item);
            
            foreach ($images as $imgIndex => $url) {
                $product->images()->create([
                    'image_url' => $url,
                    'sort_order' => $imgIndex
                ]);
            }
        }
    }
}
