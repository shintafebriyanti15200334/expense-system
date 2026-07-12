<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            [
                'name'=>'Staff',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'SPV',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'Manager',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'Director',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'Finance',
                'created_at'=>now(),
                'updated_at'=>now()
            ]
        ]);
    }
}