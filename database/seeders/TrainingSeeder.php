<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $trainings = [
            [
                'title' => [
                    'en' => 'Digital Marketing Fundamentals',
                    'ka' => 'ციფრული მარკეტინგის საფუძვლები'
                ],
                'description' => [
                    'en' => '<p>Learn the basics of digital marketing including SEO, social media marketing, and email campaigns. This comprehensive course covers all essential aspects of modern digital marketing strategies.</p>',
                    'ka' => '<p>ისწავლეთ ციფრული მარკეტინგის საფუძვლები, მათ შორის SEO, სოციალური მედიის მარკეტინგი და ელფოსტის კამპანიები. ეს ყოვლისმომცველი კურსი მოიცავს თანამედროვე ციფრული მარკეტინგის სტრატეგიების ყველა მნიშვნელოვან ასპექტს.</p>'
                ],
                'date_from' => now()->addDays(15)->setHour(10)->setMinute(0),
                'date_to' => now()->addDays(15)->setHour(17)->setMinute(0),
                'status' => true,
                'number_of_places' => 25,
            ],
            [
                'title' => [
                    'en' => 'Project Management Workshop',
                    'ka' => 'პროექტების მართვის ვორკშოპი'
                ],
                'description' => [
                    'en' => '<p>A hands-on workshop covering project management methodologies, tools, and best practices. Participants will learn Agile, Scrum, and traditional project management approaches.</p>',
                    'ka' => '<p>პრაქტიკული ვორკშოპი, რომელიც მოიცავს პროექტების მართვის მეთოდოლოგიებს, ინსტრუმენტებს და საუკეთესო პრაქტიკას. მონაწილეები ისწავლიან Agile, Scrum და პროექტების მართვის ტრადიციულ მიდგომებს.</p>'
                ],
                'date_from' => now()->addDays(30)->setHour(9)->setMinute(0),
                'date_to' => now()->addDays(32)->setHour(18)->setMinute(0),
                'status' => true,
                'number_of_places' => 20,
            ],
            [
                'title' => [
                    'en' => 'Data Analysis with Excel',
                    'ka' => 'მონაცემთა ანალიზი Excel-ით'
                ],
                'description' => [
                    'en' => '<p>Master data analysis techniques using Microsoft Excel. Learn pivot tables, advanced formulas, data visualization, and statistical analysis methods.</p>',
                    'ka' => '<p>დაეუფლეთ მონაცემთა ანალიზის ტექნიკას Microsoft Excel-ის გამოყენებით. ისწავლეთ pivot ცხრილები, მოწინავე ფორმულები, მონაცემთა ვიზუალიზაცია და სტატისტიკური ანალიზის მეთოდები.</p>'
                ],
                'date_from' => now()->addDays(45)->setHour(14)->setMinute(0),
                'date_to' => now()->addDays(45)->setHour(18)->setMinute(0),
                'status' => true,
                'number_of_places' => 15,
            ],
            [
                'title' => [
                    'en' => 'Leadership Skills Development',
                    'ka' => 'ლიდერობის უნარების განვითარება'
                ],
                'description' => [
                    'en' => '<p>Develop essential leadership skills including team management, communication, decision-making, and conflict resolution. Perfect for managers and aspiring leaders.</p>',
                    'ka' => '<p>განავითარეთ ლიდერობის აუცილებელი უნარები, მათ შორის გუნდის მართვა, კომუნიკაცია, გადაწყვეტილების მიღება და კონფლიქტების მოგვარება. იდეალურია მენეჯერებისა და მომავალი ლიდერებისთვის.</p>'
                ],
                'date_from' => now()->subDays(10)->setHour(10)->setMinute(0),
                'date_to' => now()->subDays(8)->setHour(16)->setMinute(0),
                'status' => false,
                'number_of_places' => 30,
            ],
            [
                'title' => [
                    'en' => 'Web Development Bootcamp',
                    'ka' => 'ვებ განვითარების ბუთკემპი'
                ],
                'description' => [
                    'en' => '<p>Intensive bootcamp covering HTML, CSS, JavaScript, and modern web development frameworks. Build real-world projects and portfolio.</p>',
                    'ka' => '<p>ინტენსიური ბუთკემპი, რომელიც მოიცავს HTML, CSS, JavaScript-ს და თანამედროვე ვებ განვითარების ჩარჩოებს. ააშენეთ რეალური პროექტები და პორტფოლიო.</p>'
                ],
                'date_from' => now()->addDays(60)->setHour(9)->setMinute(0),
                'date_to' => now()->addDays(74)->setHour(17)->setMinute(0),
                'status' => true,
                'number_of_places' => 12,
            ]
        ];

        foreach ($trainings as $training) {
            Training::create($training);
        }
    }
}
