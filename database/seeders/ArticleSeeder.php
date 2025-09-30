<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('role', 'admin')->first();
        $authorUser = User::where('role', 'author')->first();
        $categories = Category::all();

        if ($adminUser && $authorUser && $categories->count() > 0) {
            for ($i = 1; $i <= 10; $i++) {
                $user = ($i % 2 == 0) ? $adminUser : $authorUser;
                $category = $categories->random();

                $title = "Sample Article " . $i . " - " . $category->name;
                Article::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'title' => $title,
                    'meta_desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
                    'slug' => Str::slug($title),
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    'image' => null,
                    'status' => true,
                ]);
            }
        }
    }
}