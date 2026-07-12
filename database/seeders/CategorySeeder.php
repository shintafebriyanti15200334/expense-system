<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([

            [
                'name'=>'PO Produk',
                'description'=>'Purchase Order Produk',
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'name'=>'ATK',
                'description'=>'Alat Tulis Kantor',
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'name'=>'Operasional',
                'description'=>'Biaya Operasional',
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'name'=>'Transportasi',
                'description'=>'Biaya Perjalanan',
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'name'=>'Lainnya',
                'description'=>'Kategori Lainnya',
                'created_at'=>now(),
                'updated_at'=>now()
            ]

        ]);
    }
}