<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DummySaleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $products = Product::all();
        $customers = Customer::all();
        $admin = User::first();

        if ($products->isEmpty() || $customers->isEmpty()) {
            return;
        }

        // Generate 30 orders over the last 30 days
        for ($i = 0; $i < 40; $i++) {
            $date = $faker->dateTimeBetween('-30 days', 'now');
            
            $order = Order::create([
                'user_id' => $admin->id,
                'customer_id' => $customers->random()->id,
                'discount' => $faker->randomElement([0, 0, 0, 1000, 2000, 5000]),
                'sub_total' => 0, // Will update after adding products
                'total' => 0,
                'paid' => 0,
                'due' => 0,
                'note' => $faker->sentence(),
                'status' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $subtotal = 0;
            // Add 1-5 products per order
            $orderProducts = $products->random(rand(1, 4));
            
            foreach ($orderProducts as $product) {
                $qty = rand(1, 3);
                $itemSubtotal = $product->price * $qty;
                
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'purchase_price' => $product->purchase_price,
                    'discount' => 0,
                    'sub_total' => $itemSubtotal,
                    'total' => $itemSubtotal,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
                $subtotal += $itemSubtotal;
            }

            $order->update([
                'sub_total' => $subtotal,
                'total' => $subtotal - $order->discount,
                'paid' => $subtotal - $order->discount, // All paid for dummy
                'due' => 0,
            ]);
        }
    }
}
