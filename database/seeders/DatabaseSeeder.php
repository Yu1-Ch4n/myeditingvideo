<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil UserTableSeeder di sini
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(InformationSeeder::class);
        $this->call(ProductSeeder::class);
    }
}