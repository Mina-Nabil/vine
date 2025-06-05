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
        Product::all()->each(function ($product) {
            $product->images()->each(function ($image) {
                $image->delete();
            });
            $product->delete();
        });

        $products = [
            [
                'name' => 'Ancient Egyptian Warrior Goddess Sekhmet',
                'arbcName' => 'تمثال الإلهة المحاربة سخمت',
                'desc' => 'A handmade replica of an ancient Egyptian warrior goddess Sekhmet statue. The artists used black ink to emphasize the fine details of the amulet, and the carvings reflect the work of qualified Egyptian craftsmanship.',
                'arbcDesc' => 'نسخة مصنوعة يدوياً من تمثال الإلهة المحاربة المصرية القديمة سخمت. استخدم الفنانون الحبر الأسود لإبراز التفاصيل الدقيقة للتميمة، والنقوش تعكس عمل الحرفية المصرية المؤهلة.',
                'category' => 1,
                'price' => 85.00,
                'material' => 'Resin with black ink details',
                'dimensions' => '15x8x25 cm',
                'handled_topics' => 'Egyptian Mythology, Goddess Worship, Ancient Religion',
                'offer' => null
            ],
            [
                'name' => 'Bust of Ramses the Second',
                'arbcName' => 'تمثال نصفي لرمسيس الثاني',
                'desc' => 'A detailed replica of the famous pharaoh Ramses II bust, showcasing the grandeur and power of ancient Egyptian royalty.',
                'arbcDesc' => 'نسخة مفصلة من التمثال النصفي الشهير للفرعون رمسيس الثاني، يُظهر عظمة وقوة الملكية المصرية القديمة.',
                'category' => 1,
                'price' => 120.00,
                'material' => 'High-quality resin with gold accents',
                'dimensions' => '20x15x30 cm',
                'handled_topics' => 'Pharaohs, Ancient Egyptian History, Royal Dynasty',
                'offer' => 95.00
            ],
            [
                'name' => 'Iconic Vintage 1:2 Replica of the Iconic Golden Mask of Tutankhamun',
                'arbcName' => 'نسخة أثرية 1:2 من القناع الذهبي الأيقوني لتوت عنخ آمون',
                'desc' => 'A vintage 1:2 replica of the iconic golden mask of the boy-king Tutankhamun. The dimensions of the pendant are perfect as a jewelry item, a part of an ancient Egyptian antique collection you can add to your personality.',
                'arbcDesc' => 'نسخة أثرية بنسبة 1:2 من القناع الذهبي الأيقوني للملك الصبي توت عنخ آمون. أبعاد القلادة مثالية كقطعة مجوهرات، جزء من مجموعة التحف المصرية القديمة يمكنك إضافتها إلى شخصيتك.',
                'category' => 1,
                'price' => 150.00,
                'material' => 'Gold-plated resin with precious stone inlays',
                'dimensions' => '12x8x15 cm',
                'handled_topics' => 'King Tutankhamun, Golden Treasures, Ancient Egyptian Jewelry',
                'offer' => null
            ],
            [
                'name' => 'Bust of Ancient Egyptian Princess Nefertiti',
                'arbcName' => 'تمثال نصفي للأميرة المصرية القديمة نفرتيتي',
                'desc' => 'An exquisite replica of the famous limestone bust of Queen Nefertiti, known for her beauty and elegance in ancient Egypt.',
                'arbcDesc' => 'نسخة رائعة من التمثال النصفي الشهير من الحجر الجيري للملكة نفرتيتي، المعروفة بجمالها وأناقتها في مصر القديمة.',
                'category' => 1,
                'price' => 110.00,
                'material' => 'Limestone-textured resin',
                'dimensions' => '18x12x28 cm',
                'handled_topics' => 'Queen Nefertiti, Ancient Egyptian Beauty, Royal Women',
                'offer' => 89.00
            ],
            [
                'name' => 'Replica of Ancient Egyptian Winged Scarab',
                'arbcName' => 'نسخة من الجعران المجنح المصري القديم',
                'desc' => 'A handmade replica of an ancient Egyptian winged scarab beetle. The artists used black ink to emphasize the fine details of the amulet, and the carvings reflect the work of qualified Egyptian craftsmanship.',
                'arbcDesc' => 'نسخة مصنوعة يدوياً من خنفساء الجعران المجنحة المصرية القديمة. استخدم الفنانون الحبر الأسود لإبراز التفاصيل الدقيقة للتميمة، والنقوش تعكس عمل الحرفية المصرية المؤهلة.',
                'category' => 1,
                'price' => 75.00,
                'material' => 'Resin with turquoise and gold details',
                'dimensions' => '25x15x8 cm',
                'handled_topics' => 'Sacred Symbols, Protection Amulets, Ancient Egyptian Religion',
                'offer' => 65.00
            ],
            [
                'name' => 'Anubis Statue - God of the Afterlife',
                'arbcName' => 'تمثال أنوبيس - إله الحياة الآخرة',
                'desc' => 'A vintage replica of an ancient Egyptian god Anubis, the jackal-headed deity associated with mummification and the afterlife.',
                'arbcDesc' => 'نسخة أثرية من الإله المصري القديم أنوبيس، الإله برأس ابن آوى المرتبط بالتحنيط والحياة الآخرة.',
                'category' => 1,
                'price' => 95.00,
                'material' => 'Black resin with gold hieroglyphic details',
                'dimensions' => '20x10x35 cm',
                'handled_topics' => 'Egyptian Gods, Afterlife, Mummification, Ancient Religion',
                'offer' => null
            ],
            [
                'name' => 'Papyrus Scroll with Hieroglyphics',
                'arbcName' => 'لفافة بردي بالهيروغليفية',
                'desc' => 'Authentic papyrus scroll featuring ancient Egyptian hieroglyphics and scenes from the Book of the Dead.',
                'arbcDesc' => 'لفافة بردي أصلية تحتوي على الهيروغليفية المصرية القديمة ومشاهد من كتاب الموتى.',
                'category' => 1,
                'price' => 45.00,
                'material' => 'Genuine papyrus with natural pigments',
                'dimensions' => '40x30 cm',
                'handled_topics' => 'Hieroglyphics, Book of the Dead, Ancient Writing',
                'offer' => 38.00
            ],
            [
                'name' => 'Egyptian Canopic Jar Set',
                'arbcName' => 'مجموعة جرار الكانوبية المصرية',
                'desc' => 'A complete set of four canopic jars representing the four sons of Horus, used in ancient Egyptian mummification.',
                'arbcDesc' => 'مجموعة كاملة من أربع جرار كانوبية تمثل أبناء حورس الأربعة، المستخدمة في التحنيط المصري القديم.',
                'category' => 1,
                'price' => 180.00,
                'material' => 'Ceramic with painted details',
                'dimensions' => '12x12x20 cm each',
                'handled_topics' => 'Mummification, Sons of Horus, Burial Rituals',
                'offer' => 160.00
            ],
            [
                'name' => 'Bastet Cat Goddess Statue',
                'arbcName' => 'تمثال الإلهة باستت القطة',
                'desc' => 'A vintage replica of an ancient Egyptian goddess Bastet, the cat goddess associated with protection, fertility, and motherhood.',
                'arbcDesc' => 'نسخة أثرية من الإلهة المصرية القديمة باستت، إلهة القطط المرتبطة بالحماية والخصوبة والأمومة.',
                'category' => 1,
                'price' => 70.00,
                'material' => 'Bronze-finished resin',
                'dimensions' => '15x8x22 cm',
                'handled_topics' => 'Cat Worship, Goddess Bastet, Protection Deities',
                'offer' => null
            ],
            [
                'name' => 'Egyptian Obelisk Miniature',
                'arbcName' => 'مسلة مصرية مصغرة',
                'desc' => 'A detailed miniature replica of an ancient Egyptian obelisk with authentic hieroglyphic inscriptions.',
                'arbcDesc' => 'نسخة مصغرة مفصلة من مسلة مصرية قديمة مع نقوش هيروغليفية أصلية.',
                'category' => 1,
                'price' => 55.00,
                'material' => 'Granite-textured resin',
                'dimensions' => '8x8x35 cm',
                'handled_topics' => 'Monuments, Hieroglyphic Inscriptions, Ancient Architecture',
                'offer' => 48.00
            ]
        ];

        foreach ($products as $product) {
            Product::create($product['name'], $product['arbcName'], $product['desc'], $product['arbcDesc'], $product['category'], $product['price'], $product['material'], $product['dimensions'], $product['handled_topics'], $product['offer']);
        }
    }
}
