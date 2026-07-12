<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Budget;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        Budget::insert([

            [
                'category_id'=>1,
                'budget_amount'=>100000000,
                'used_amount'=>0,
                'year'=>date('Y'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'category_id'=>2,
                'budget_amount'=>30000000,
                'used_amount'=>0,
                'year'=>date('Y'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'category_id'=>3,
                'budget_amount'=>50000000,
                'used_amount'=>0,
                'year'=>date('Y'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'category_id'=>4,
                'budget_amount'=>20000000,
                'used_amount'=>0,
                'year'=>date('Y'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'category_id'=>5,
                'budget_amount'=>15000000,
                'used_amount'=>0,
                'year'=>date('Y'),
                'created_at'=>now(),
                'updated_at'=>now()
            ]

        ]);
    }
}