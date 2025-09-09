<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $galleries = [
            [
                'title' => [
                    'en' => 'Nature Gallery',
                    'ka' => 'ბუნების გალერეა'
                ],
                'status' => true,
                'sort' => 1,
            ],
            [
                'title' => [
                    'en' => 'Architecture Gallery',
                    'ka' => 'არქიტექტურის გალერეა'
                ],
                'status' => true,
                'sort' => 2,
            ],
            [
                'title' => [
                    'en' => 'Events Gallery',
                    'ka' => 'ღონისძიებების გალერეა'
                ],
                'status' => false,
                'sort' => 3,
            ],
        ];

        foreach ($galleries as $galleryData) {
            Gallery::create($galleryData);
        }
    }
}
