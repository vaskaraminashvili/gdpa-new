<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsData = [
            [
                'title' => [
                    'en' => 'Breaking: Major Technology Breakthrough',
                    'ka' => 'ბრეიკინგი: მნიშვნელოვანი ტექნოლოგიური გარღვევა'
                ],
                'description' => [
                    'en' => 'Scientists have made a groundbreaking discovery that could revolutionize the tech industry.',
                    'ka' => 'მეცნიერებმა გააკეთეს გარღვევითი აღმოჩენა, რომელსაც შეუძლია რევოლუცია მოახდინოს ტექნოლოგიების ინდუსტრიაში.'
                ],
                'status' => true,
                'publish_date' => now()->subDays(2),
            ],
            [
                'title' => [
                    'en' => 'Economic Growth Reaches New Heights',
                    'ka' => 'ეკონომიკური ზრდა ახალ სიმაღლეებს აღწევს'
                ],
                'description' => [
                    'en' => 'The national economy shows unprecedented growth rates in the past quarter.',
                    'ka' => 'ეროვნული ეკონომიკა უჩვენებს უნიკალურ ზრდის მაჩვენებლებს ბოლო კვარტალში.'
                ],
                'status' => true,
                'publish_date' => now()->subDay(),
            ],
            [
                'title' => [
                    'en' => 'Environmental Initiative Launched',
                    'ka' => 'გარემოსდაცვითი ინიციატივა დაიწყო'
                ],
                'description' => [
                    'en' => 'A new environmental protection program has been launched to combat climate change.',
                    'ka' => 'ახალი გარემოს დაცვის პროგრამა დაიწყო კლიმატის ცვლილებასთან საბრძოლველად.'
                ],
                'status' => true,
                'publish_date' => now(),
            ],
            [
                'title' => [
                    'en' => 'Cultural Festival Announcement',
                    'ka' => 'კულტურული ფესტივალის გამოცხადება'
                ],
                'description' => [
                    'en' => 'Annual cultural festival celebrating diversity and tradition will take place next month.',
                    'ka' => 'წლიური კულტურული ფესტივალი, რომელიც აღნიშნავს მრავალფეროვნებას და ტრადიციას, შემდეგ თვეს გაიმართება.'
                ],
                'status' => false,
                'publish_date' => now()->addWeek(),
            ],
        ];

        foreach ($newsData as $data) {
            News::create($data);
        }
    }
}
