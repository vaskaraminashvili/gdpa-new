<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $slides = [
            [
                'title' => [
                    'en' => 'Welcome to Our Platform',
                    'ka' => 'კეთილი იყოს თქვენი მობრძანება ჩვენს პლატფორმაზე',
                ],
                'description' => [
                    'en' => '<p>Discover <strong>amazing features</strong> and services that will transform your experience.</p>',
                    'ka' => '<p>აღმოაჩინეთ <strong>შესანიშნავი ფუნქციები</strong> და სერვისები, რომლებიც შეცვლის თქვენს გამოცდილებას.</p>',
                ],
                'status' => true,
                'sort' => 1,
            ],
            [
                'title' => [
                    'en' => 'Innovative Solutions',
                    'ka' => 'ინოვაციური გადაწყვეტილებები',
                ],
                'description' => [
                    'en' => '<p>We provide <em>cutting-edge technology solutions</em> for modern businesses:</p><ul><li>Advanced analytics</li><li>Cloud integration</li><li>24/7 support</li></ul>',
                    'ka' => '<p>ჩვენ ვთავაზობთ <em>უახლესი ტექნოლოგიების გადაწყვეტილებებს</em> თანამედროვე ბიზნესისთვის:</p><ul><li>მოწინავე ანალიტიკა</li><li>ღრუბლოვანი ინტეგრაცია</li><li>24/7 მხარდაჭერა</li></ul>',
                ],
                'status' => true,
                'sort' => 2,
            ],
            [
                'title' => [
                    'en' => 'Join Our Community',
                    'ka' => 'შემოუერთდით ჩვენს საზოგადოებას',
                ],
                'description' => [
                    'en' => '<p>Connect with <strong>like-minded individuals</strong> and grow together.</p><p>Benefits include:</p><ol><li>Networking opportunities</li><li>Knowledge sharing</li><li>Collaborative projects</li></ol>',
                    'ka' => '<p>დაუკავშირდით <strong>მსგავსი აზროვნების ადამიანებს</strong> და იზრდებოდით ერთად.</p><p>უპირატესობები მოიცავს:</p><ol><li>ქსელური შესაძლებლობები</li><li>ცოდნის გაზიარება</li><li>თანამშრომლობითი პროექტები</li></ol>',
                ],
                'status' => false,
                'sort' => 3,
            ],
        ];

        foreach ($slides as $slideData) {
            Slide::create($slideData);
        }
    }
}
