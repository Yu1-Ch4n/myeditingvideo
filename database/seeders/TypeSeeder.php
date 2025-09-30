<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Video', 'Audio', 'Image', 'Document'];

        foreach ($types as $type) {
            Type::create([
                'name' => $type,
                'slug' => Str::slug($type),
            ]);
        }
    }
}