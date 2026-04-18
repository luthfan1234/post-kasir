<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // 1. Realistic Indonesian Categories
        $categories = [
            'Makanan Ringan', 'Minuman Dingin', 'Sembako', 'Kebutuhan Mandi', 'Perawatan Rumah', 'Bumbu Dapur'
        ];
        
        $catIds = [];
        foreach ($categories as $cat) {
            $created = Category::firstOrCreate(['name' => $cat]);
            $catIds[$cat] = $created->id;
        }

        // 2. Realistic Indonesian Brands
        $brands = [
            'Indofood', 'Wings', 'Mayora', 'Unilever', 'Danone', 'GarudaFood', 'Kino', 'ABC'
        ];
        
        $brandIds = [];
        foreach ($brands as $brand) {
            $created = Brand::firstOrCreate(['name' => $brand]);
            $brandIds[$brand] = $created->id;
        }
        
        // 3. Realistic Indonesian Products (Pricing in IDR)
        $indonesianProducts = [
            ['name' => 'Indomie Mi Goreng Spesial', 'price' => 3500, 'c' => 'Sembako', 'b' => 'Indofood'],
            ['name' => 'Indomie Ayam Bawang', 'price' => 3000, 'c' => 'Sembako', 'b' => 'Indofood'],
            ['name' => 'Kopi Kapal Api Mix 10s', 'price' => 15000, 'c' => 'Sembako', 'b' => 'Mayora'],
            ['name' => 'Aqua Air Mineral 600ml', 'price' => 3500, 'c' => 'Minuman Dingin', 'b' => 'Danone'],
            ['name' => 'Aqua Galon 19L', 'price' => 20000, 'c' => 'Minuman Dingin', 'b' => 'Danone'],
            ['name' => 'Teh Pucuk Harum 350ml', 'price' => 4000, 'c' => 'Minuman Dingin', 'b' => 'Mayora'],
            ['name' => 'Le Minerale 600ml', 'price' => 4000, 'c' => 'Minuman Dingin', 'b' => 'Mayora'],
            ['name' => 'Pocari Sweat Can 330ml', 'price' => 7500, 'c' => 'Minuman Dingin', 'b' => 'ABC'],
            ['name' => 'Chitato Sapi Panggang 68g', 'price' => 11500, 'c' => 'Makanan Ringan', 'b' => 'Indofood'],
            ['name' => 'Qtela Singkong Balado', 'price' => 16500, 'c' => 'Makanan Ringan', 'b' => 'Indofood'],
            ['name' => 'Kacang Garuda Rosta', 'price' => 9500, 'c' => 'Makanan Ringan', 'b' => 'GarudaFood'],
            ['name' => 'Taro Net Seaweed', 'price' => 6000, 'c' => 'Makanan Ringan', 'b' => 'Kino'],
            ['name' => 'Roma Kelapa 300g', 'price' => 11000, 'c' => 'Makanan Ringan', 'b' => 'Mayora'],
            ['name' => 'Beng-Beng Share It', 'price' => 15500, 'c' => 'Makanan Ringan', 'b' => 'Mayora'],
            ['name' => 'Sabun Mandi Lifebuoy Red 110g', 'price' => 4500, 'c' => 'Kebutuhan Mandi', 'b' => 'Unilever'],
            ['name' => 'Pepsodent White 120g', 'price' => 9000, 'c' => 'Kebutuhan Mandi', 'b' => 'Unilever'],
            ['name' => 'Shampoo Clear Menthol 170ml', 'price' => 24000, 'c' => 'Kebutuhan Mandi', 'b' => 'Unilever'],
            ['name' => 'Rinso Anti Noda 800g', 'price' => 26500, 'c' => 'Perawatan Rumah', 'b' => 'Unilever'],
            ['name' => 'Sunlight Jeruk Nipis 755ml', 'price' => 18500, 'c' => 'Perawatan Rumah', 'b' => 'Unilever'],
            ['name' => 'Super Pel Karbol Wangi 770ml', 'price' => 14000, 'c' => 'Perawatan Rumah', 'b' => 'Unilever'],
            ['name' => 'So Klin Liquid 800ml', 'price' => 17500, 'c' => 'Perawatan Rumah', 'b' => 'Wings'],
            ['name' => 'Mie Sedaap Soto', 'price' => 3000, 'c' => 'Sembako', 'b' => 'Wings'],
            ['name' => 'Kecap Bango Manis 550ml', 'price' => 25000, 'c' => 'Bumbu Dapur', 'b' => 'Unilever'],
            ['name' => 'Saus Sambal ABC 340ml', 'price' => 16500, 'c' => 'Bumbu Dapur', 'b' => 'ABC'],
            ['name' => 'Minyak Goreng Bimoli 2L', 'price' => 38500, 'c' => 'Sembako', 'b' => 'Indofood'],
        ];

        // Ensure there's at least one unit
        $defaultUnit = Unit::firstOrCreate([
            'title' => 'Pcs',
            'short_name' => 'pcs'
        ]);

        foreach ($indonesianProducts as $item) {
            $imageKey = strtolower(str_replace(' ', '-', $item['name']));
            Product::create([
                'image' => "https://picsum.photos/seed/{$imageKey}/400/400", // Dynamic high-quality placeholder
                'name' => $item['name'],
                'slug' => \Illuminate\Support\Str::slug($item['name']),
                'sku' => strtoupper(\Illuminate\Support\Str::random(8)),
                'description' => 'Produk berkualitas dari ' . $item['b'] . '. Cocok untuk stok harian Anda.',
                'category_id' => $catIds[$item['c']],
                'brand_id' => $brandIds[$item['b']],
                'unit_id' => $defaultUnit->id,
                'price' => $item['price'],
                'discount' => 0,
                'discount_type' => 'fixed',
                'purchase_price' => $item['price'] * 0.85, // 15% margin
                'quantity' => $faker->numberBetween(10, 150),
                'expire_date' => $faker->dateTimeBetween('+3 months', '+2 years'),
                'status' => 1,
            ]);
        }
    }
}
