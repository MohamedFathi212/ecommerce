<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'  => 'Mohamed Fathi',
            'email' => 'mohamed@example.com',
            'password' =>Hash::make('admin'),
            'phone_number' => '123456789',
        ]);


        DB::table('users')->insert([
            'name' => 'Ahmed',
            'email' => 'ahmed@example.com',
            'password' =>Hash::make('admin'),
            'phone_number' => '123456'
        ]);
    }
}
