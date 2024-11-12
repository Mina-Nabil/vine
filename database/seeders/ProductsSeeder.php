<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Learning Mat',
                'arbcName' => 'حصيرة التعليم',
                'desc' => 'A mat designed to help children learn through play.',
                'arbcDesc' => 'حصيرة مصممة لمساعدة الأطفال على التعلم من خلال اللعب.',
                'category' => 1,
                'price' => 25.99,
                'material' => 'Rubber',
                'dimensions' => '100x150 cm',
                'handled_topics' => 'Alphabet, Numbers',
                'offer' => 20.99
            ],
            [
                'name' => 'Storybook Set',
                'arbcName' => 'مجموعة كتب القصص',
                'desc' => 'A set of storybooks to foster imagination and creativity.',
                'arbcDesc' => 'مجموعة كتب قصص لتعزيز الخيال والإبداع.',
                'category' => 2,
                'price' => 15.50,
                'material' => 'Paper',
                'dimensions' => 'N/A',
                'handled_topics' => 'Fairy Tales, Morals',
                'offer' => null
            ],
            [
                'name' => 'Flashcards',
                'arbcName' => 'بطاقات فلاش',
                'desc' => 'Flashcards for quick learning and memory improvement.',
                'arbcDesc' => 'بطاقات فلاش للتعلم السريع وتحسين الذاكرة.',
                'category' => 3,
                'price' => 8.99,
                'material' => 'Cardboard',
                'dimensions' => '10x15 cm',
                'handled_topics' => 'Vocabulary, Shapes',
                'offer' => 7.99
            ],
            [
                'name' => 'Puzzle Game',
                'arbcName' => 'لعبة الألغاز',
                'desc' => 'A puzzle game to develop problem-solving skills.',
                'arbcDesc' => 'لعبة ألغاز لتطوير مهارات حل المشكلات.',
                'category' => 4,
                'price' => 12.99,
                'material' => 'Wood',
                'dimensions' => '30x30 cm',
                'handled_topics' => 'Logic, Patterns',
                'offer' => null
            ],
            [
                'name' => 'Coloring Book',
                'arbcName' => 'كتاب التلوين',
                'desc' => 'A coloring book to unleash creativity.',
                'arbcDesc' => 'كتاب تلوين لإطلاق العنان للإبداع.',
                'category' => 1,
                'price' => 5.99,
                'material' => 'Paper',
                'dimensions' => 'A4',
                'handled_topics' => 'Colors, Art',
                'offer' => 4.99
            ],
            [
                'name' => 'Math Workbook',
                'arbcName' => 'دفتر التمارين الرياضية',
                'desc' => 'A workbook designed for practicing basic math skills.',
                'arbcDesc' => 'دفتر تمارين مصمم لممارسة مهارات الرياضيات الأساسية.',
                'category' => 1,
                'price' => 9.50,
                'material' => 'Paper',
                'dimensions' => 'A4',
                'handled_topics' => 'Addition, Subtraction',
                'offer' => null
            ],
            [
                'name' => 'Science Kit',
                'arbcName' => 'مجموعة العلوم',
                'desc' => 'A hands-on kit to explore basic science concepts.',
                'arbcDesc' => 'مجموعة عملية لاستكشاف مفاهيم العلوم الأساسية.',
                'category' => 3,
                'price' => 30.00,
                'material' => 'Plastic',
                'dimensions' => '30x40x10 cm',
                'handled_topics' => 'Physics, Chemistry',
                'offer' => 28.50
            ],
            [
                'name' => 'Music Book',
                'arbcName' => 'كتاب الموسيقى',
                'desc' => 'A book to learn basic music theory and practice.',
                'arbcDesc' => 'كتاب لتعلم أساسيات نظرية الموسيقى والممارسة.',
                'category' => 2,
                'price' => 10.00,
                'material' => 'Paper',
                'dimensions' => 'A4',
                'handled_topics' => 'Notes, Rhythm',
                'offer' => null
            ],
            [
                'name' => 'Geography Atlas',
                'arbcName' => 'أطلس الجغرافيا',
                'desc' => 'An atlas to help children learn about world geography.',
                'arbcDesc' => 'أطلس لمساعدة الأطفال على التعرف على جغرافيا العالم.',
                'category' => 4,
                'price' => 18.99,
                'material' => 'Paper',
                'dimensions' => 'A3',
                'handled_topics' => 'Countries, Maps',
                'offer' => 16.99
            ],
            [
                'name' => 'History Cards',
                'arbcName' => 'بطاقات التاريخ',
                'desc' => 'Cards that teach historical events and figures.',
                'arbcDesc' => 'بطاقات تعلم الأحداث التاريخية والشخصيات.',
                'category' => 3,
                'price' => 14.99,
                'material' => 'Cardboard',
                'dimensions' => '10x15 cm',
                'handled_topics' => 'Wars, Leaders',
                'offer' => 13.50
            ]
        ];

        foreach ($products as $product) {
            Product::create(...$product);
        }
    }
}
