<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('role', 'admin')->first();
        $authorUser = User::where('role', 'author')->first();
        $types = Type::all();

        if ($adminUser && $authorUser && $types->count() > 0) {
            for ($i = 1; $i <= 10; $i++) {
                $user = ($i % 2 == 0) ? $adminUser : $authorUser;
                $type = $types->random();

                $title = "Sample Product " . $i . " - " . $type->name;
                Product::create([
                    'user_id' => $user->id,
                    'type_id' => $type->id,
                    'title' => $title,
                    'meta_desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
                    'slug' => Str::slug($title),
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    'price' => rand(10000, 100000),
                    'discount' => rand(0, 5000),
                    'stock' => rand(1, 100),
                    'sku' => 'SKU-' . Str::upper(Str::random(8)),
                    'image' => null,
                    'status' => true,
                ]);
            }
        }
    }
}
