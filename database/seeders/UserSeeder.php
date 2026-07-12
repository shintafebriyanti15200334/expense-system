<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([

            [
                'role_id'=>1,
                'name'=>'Staff',
                'email'=>'staff@test.com',
                'password'=>Hash::make('password'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'role_id'=>2,
                'name'=>'Supervisor',
                'email'=>'spv@test.com',
                'password'=>Hash::make('password'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'role_id'=>3,
                'name'=>'Manager',
                'email'=>'manager@test.com',
                'password'=>Hash::make('password'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'role_id'=>4,
                'name'=>'Direktur',
                'email'=>'director@test.com',
                'password'=>Hash::make('password'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'role_id'=>5,
                'name'=>'Finance',
                'email'=>'finance@test.com',
                'password'=>Hash::make('password'),
                'created_at'=>now(),
                'updated_at'=>now()
            ]

        ]);
    }
}