<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Menambahkan produk default.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil kategori
        |--------------------------------------------------------------------------
        */

        $coffee = Category::where('name', 'Coffee')->firstOrFail();
        $nonCoffee = Category::where('name', 'Non Coffee')->firstOrFail();
        $tea = Category::where('name', 'Tea')->firstOrFail();
        $snack = Category::where('name', 'Snack')->firstOrFail();
        $dessert = Category::where('name', 'Dessert')->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Data Produk
        |--------------------------------------------------------------------------
        */

        $products = [

            // =========================
            // COFFEE
            // =========================

            [
                'category_id' => $coffee->id,
                'name' => 'Espresso',
                'description' => 'Espresso kopi dengan rasa kuat dan aroma khas.',
                'price' => 18000,
                'stock' => 50,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $coffee->id,
                'name' => 'Americano',
                'description' => 'Espresso yang dipadukan dengan air panas.',
                'price' => 20000,
                'stock' => 50,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $coffee->id,
                'name' => 'Cappuccino',
                'description' => 'Espresso dengan steamed milk dan foam lembut.',
                'price' => 25000,
                'stock' => 40,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $coffee->id,
                'name' => 'Cafe Latte',
                'description' => 'Espresso dengan susu yang lembut dan creamy.',
                'price' => 25000,
                'stock' => 40,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $coffee->id,
                'name' => 'Mocha',
                'description' => 'Perpaduan espresso, susu, dan cokelat.',
                'price' => 28000,
                'stock' => 35,
                'image' => null,
                'is_active' => true,
            ],

            // =========================
            // NON COFFEE
            // =========================

            [
                'category_id' => $nonCoffee->id,
                'name' => 'Chocolate',
                'description' => 'Minuman cokelat creamy dengan rasa manis.',
                'price' => 23000,
                'stock' => 40,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $nonCoffee->id,
                'name' => 'Matcha Latte',
                'description' => 'Matcha latte dengan rasa lembut dan creamy.',
                'price' => 26000,
                'stock' => 35,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $nonCoffee->id,
                'name' => 'Red Velvet',
                'description' => 'Minuman red velvet dengan rasa manis lembut.',
                'price' => 25000,
                'stock' => 35,
                'image' => null,
                'is_active' => true,
            ],

            // =========================
            // TEA
            // =========================

            [
                'category_id' => $tea->id,
                'name' => 'English Breakfast Tea',
                'description' => 'Teh hitam dengan aroma dan rasa yang kuat.',
                'price' => 15000,
                'stock' => 40,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $tea->id,
                'name' => 'Lemon Tea',
                'description' => 'Teh dengan perpaduan lemon yang segar.',
                'price' => 18000,
                'stock' => 40,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $tea->id,
                'name' => 'Peach Tea',
                'description' => 'Teh dengan aroma dan rasa buah peach.',
                'price' => 20000,
                'stock' => 35,
                'image' => null,
                'is_active' => true,
            ],

            // =========================
            // SNACK
            // =========================

            [
                'category_id' => $snack->id,
                'name' => 'French Fries',
                'description' => 'Kentang goreng renyah dengan bumbu gurih.',
                'price' => 18000,
                'stock' => 30,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $snack->id,
                'name' => 'Chicken Wings',
                'description' => 'Sayap ayam dengan bumbu gurih dan lezat.',
                'price' => 28000,
                'stock' => 25,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $snack->id,
                'name' => 'Toast',
                'description' => 'Roti panggang dengan pilihan topping.',
                'price' => 20000,
                'stock' => 30,
                'image' => null,
                'is_active' => true,
            ],

            // =========================
            // DESSERT
            // =========================

            [
                'category_id' => $dessert->id,
                'name' => 'Brownies',
                'description' => 'Brownies cokelat dengan tekstur lembut.',
                'price' => 22000,
                'stock' => 25,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $dessert->id,
                'name' => 'Cheesecake',
                'description' => 'Cheesecake lembut dengan rasa creamy.',
                'price' => 25000,
                'stock' => 20,
                'image' => null,
                'is_active' => true,
            ],

            [
                'category_id' => $dessert->id,
                'name' => 'Chocolate Cake',
                'description' => 'Kue cokelat lembut dengan rasa cokelat yang kuat.',
                'price' => 24000,
                'stock' => 20,
                'image' => null,
                'is_active' => true,
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Simpan Produk
        |--------------------------------------------------------------------------
        */

        foreach ($products as $product) {
            Product::updateOrCreate(
                [
                    'name' => $product['name'],
                ],
                $product
            );
        }
    }
}