<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Menambahkan kategori produk.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Coffee',
            ],
            [
                'name' => 'Non Coffee',
            ],
            [
                'name' => 'Tea',
            ],
            [
                'name' => 'Snack',
            ],
            [
                'name' => 'Dessert',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                [
                    'name' => $category['name'],
                ],
                $category
            );
        }
    }
}