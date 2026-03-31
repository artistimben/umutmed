<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ManualSyncProducts extends Command
{
    protected $signature = 'manual:sync';

    public function handle()
    {
        $products = [
          [
            "title" => "Canped Emici Külot Large, Büyük, 60 Adet",
            "price" => 2100,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1638/prod/QC/20250219/06/e25aed22-da05-33e4-b6d3-a279fded4490/1_org_zoom.jpg",
            "brand" => "Canped",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "PROSAFE Belbantlı Bez 4x30 Adet Xl",
            "price" => 1850,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1620/prod/QC/20250109/09/daf84d61-99cc-392d-bd12-9f538103b617/1_org_zoom.jpg",
            "brand" => "PROSAFE",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Canped Belbantlı Small 4*30 Lu Paket 120 adet",
            "price" => 2995,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1348/product/media/images/prod/QC/20240603/14/b1054c07-43db-3368-b068-734da322c014/1_org_zoom.jpg",
            "brand" => "Canped",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Canped STD Emici Külot Dev Eko Pk 60 Adet Extra Large",
            "price" => 2135,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty371/product/media/images/20220322/23/74756587/423382629/1/1_org_zoom.jpg",
            "brand" => "Canped",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Canped Belbantlı Hasta Bezi Orta Boy Medium 30 Lu",
            "price" => 980,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1831/prod/QC_ENRICHMENT/20260227/18/31d04c2d-939b-3887-b7bd-ff322a80d4ef/1_org_zoom.jpg",
            "brand" => "Canped",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Canped Tekstil Yüzeyli Belbantlı Yetişkin Bezi Xl 30'lu",
            "price" => 1005,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1641/prod/QC/20250221/12/a5de7d25-5e14-33bb-9321-9e7c9dd2726c/1_org_zoom.jpg",
            "brand" => "Canped",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Canped Emici Külot Hasta Bezi Büyük 3x30 Adet",
            "price" => 2940,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty103/product/media/images/20210417/15/80858237/164761561/1/1_org_zoom.jpg",
            "brand" => "Canped",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Canped Emici Külot Hasta Bezi Orta Boy (m) 30'lu",
            "price" => 980,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1620/prod/QC/20250109/08/e4b89a31-a0bd-3228-9c0a-fcb29ec46e42/1_org_zoom.jpg",
            "brand" => "Canped",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Freely Ekose Tekerlekli Sandalye Katlanabilir",
            "price" => 5950,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1830/prod/QC_ENRICHMENT/20260227/19/b30fb39b-ee6e-34d1-91ec-e52c409c0686/1_org_zoom.jpg",
            "brand" => "Freely",
            "category" => "Tekerlekli Sandalye"
          ],
          [
            "title" => "Canped Hasta Bezi Yetişkin Bel Bantlı L-Büyük Boy 180 Adet",
            "price" => 5880,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1739/prod/QC_ENRICHMENT/20250825/10/144d64d9-a0e7-387b-a48b-7936bcf4cd29/1_org_zoom.jpg",
            "brand" => "Canped",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Freshlife Medium Emici Külot 30 Adet",
            "price" => 850,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1843/prod/QC_ENRICHMENT/20260324/09/05baae51-ceac-3f2b-8488-5ca206f5a6db/1_org_zoom.jpg",
            "brand" => "Freshlife",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Freshlife Yatak Koruyucu Örtü 90x180 Cm 30 Adet",
            "price" => 490,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1648/prod/QC/20250307/09/c9d611f7-09e3-3b87-ade2-fa40d427e618/1_org_zoom.jpg",
            "brand" => "Freshlife",
            "category" => "Yatak Koruyucu"
          ],
          [
            "title" => "giggles Külotlu Yetişkin Hasta Bezi Large 90 Adet",
            "price" => 2850,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1632/prod/QC/20250208/10/27ddcb59-d154-3b6d-8a05-82085f6b4130/1_org_zoom.jpg",
            "brand" => "Giggles",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Dr. Comfort 30'lu Large Külot Bez Büyük Boy 120 Adet",
            "price" => 3500,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1000381/product/media/images/prod/PIM/20260330/08/7b60964c-29c6-4760-9f6e-0400cfa2c47a/1_org_zoom.jpg",
            "brand" => "Dr.Comfort",
            "category" => "Hasta Bezi"
          ],
          [
            "title" => "Golfi G105 Transfer Hasta Yaşlı Engelli Sandalyesi",
            "price" => 4500,
            "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1000380/product/media/images/prod/PIM/20260330/08/af90f48b-0e4c-4f68-b6ff-ef747424d72c/1_org_zoom.jpg",
            "brand" => "Golfi",
            "category" => "Tekerlekli Sandalye"
          ],
          [
             "title" => "Canped Tekstil Yüzeyli Belbantlı Bezi Large 30 Adet",
             "price" => 980,
             "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1000379/product/media/images/prod/PIM/20260330/08/0e0733f3-9fab-466d-bbd0-ad1793137535/1_org_zoom.jpg",
             "brand" => "Canped",
             "category" => "Hasta Bezi"
          ],
          [
             "title" => "GOLFİ G102 Standart Tekerlekli Sandalye",
             "price" => 6500,
             "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1696/prod/QC_ENRICHMENT/20250620/10/3126292e-9ae4-33c7-b0a4-b1a6db80c76c/1_org_zoom.jpg",
             "brand" => "Golfi",
             "category" => "Tekerlekli Sandalye"
          ],
          [
             "title" => "MedikalSağlık Galena Steril Idrar Torbası 40 Adet",
             "price" => 850,
             "mainImageUrl" => "https://cdn.dsmcdn.com/mnresize/400/-/ty1642/prod/QC/20250221/12/b0ac1bcf-0f76-3b19-b22f-3f331f820c9f/1_org_zoom.jpg",
             "brand" => "Galena",
             "category" => "Medikal Malzeme"
          ]
        ];

        // Clear only manually synced ones if needed, or just let updateOrCreate handle it
        foreach ($products as $item) {
            $brandSlug = Str::slug($item['brand']);
            $brand = Brand::firstOrCreate(['slug' => $brandSlug], ['name' => $item['brand']]);
            
            $catSlug = Str::slug($item['category']);
            $category = Category::firstOrCreate(['slug' => $catSlug], ['name' => $item['category']]);

            $product = Product::updateOrCreate(
                ['title' => $item['title']],
                [
                    'slug' => Str::slug($item['title']),
                    'price' => $item['price'],
                    'brand_id' => $brand->id,
                    'category_id' => $category->id,
                    'stock' => 100,
                    'is_active' => true,
                ]
            );

            $product->images()->delete();
            $product->images()->create([
                'image_url' => $item['mainImageUrl'],
                'sort_order' => 0
            ]);
        }

        $this->info("Successfully imported products with working images.");
    }
}
