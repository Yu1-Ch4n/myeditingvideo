<?php

namespace Database\Seeders;

use App\Models\Information;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i = 1; $i <= 10; $i++) {

            $title = "Judul Informasi Ke " . $i ;

            Information::create([
                'title' => $title,
                'meta_desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla exercitationem tenetur ad. Cum quo illum dolores dolore optio eius accusantium beatae incidunt repudiandae?',
                'slug' => Str::slug($title),
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla exercitationem tenetur ad. Cum quo illum dolores dolore optio eius accusantium beatae incidunt repudiandae? Perspiciatis temporibus omnis, optio enim asperiores ducimus?',
                'status' => true,
            ]);
        }
    }
}
