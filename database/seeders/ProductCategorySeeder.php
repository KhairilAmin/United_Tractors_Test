<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = array(['name' => 'Clothing'], ['name' => 'Handy']);

        foreach($categories as $category)
        {
            $category = CategoryProduct::create($category);
        }
    }
}
