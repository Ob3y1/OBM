<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Sitting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Sitting::insert([
            ['key' => 'Balance','value'=> '0'],
        ]);

        // \App\Models\User::factory(10)->create();
        Role::insert([
            ['role' => 'Admin'],
            ['role' => 'User'],
        ]);
        DB::table('users')->insert([
            [
                'name' => 'Obay',
                'phone_number' => '+963962256897',
                'password' => Hash::make('111q'),
                'role_id' => 1, // Admin
            ]
        ]);
        Category::insert([
            ['name' => 'ترميمية','description' =>' '],
            ['name' => 'تعويضات ثابتة','description' =>' '],
            ['name' => 'سنابل','description' =>' '],
            ['name' => 'لبية','description' =>' '],
            ['name' => 'معدنيات','description' =>' '],
            ['name' => 'ملحقات','description' =>' '],
        ]);

        Supplier::insert([
            ['name' => 'نشاوي','location' =>'شارع  بغداد','contact'=>'0967247444 واتس'],
            ['name' => 'الشام','location' =>'المزة','contact'=>'0966684777 واتس'],
            ['name' => 'سيريانا','location' =>'الحلبوني','contact'=>'0947989723 واتس'],
            ['name' => 'اوميجا','location' =>'الحلبوني','contact'=>''],
            ['name' => 'كوشة','location' =>'برامكة','contact'=>'0988369798 واتس'],
            ['name' => 'ادلب','location' =>'الحلبوني','contact'=>''],
            ['name' => 'اوكسجين','location' =>'مجتهد','contact'=>'0994481378 اتصال'],
            ['name' => 'قباني','location' =>'الحلبوني','contact'=>''],
        ]);

        Product::insert([
            ['category_id'=>'1','name' => 'كومبوزيت NTPremiume','description' =>'A3	','cost'=>'5.50','price'=>'6.50'],
            ['category_id'=>'1','name' => 'كومبوزيت Crownfil','description' =>'A2','cost'=>'2.5','price'=>'3'],
            ['category_id'=>'1','name' => 'سيال Meta-Nexcomp	','description' =>'A3-A2-A1	','cost'=>'4.546','price'=>'6'],
            ['category_id'=>'1','name' => 'سيال Ruby','description' =>'A3	','cost'=>'2','price'=>'3'],
            ['category_id'=>'1','name' => 'بوند Ex-Bond','description' =>' ','cost'=>'5','price'=>'6'],
            ['category_id'=>'1','name' => 'مخرش Denfill','description' =>'كوري مع كل تيوب 6 روؤس','cost'=>'1.584','price'=>'3'],
            ['category_id'=>'1','name' => 'فراشي بوند','description' =>'اصفر','cost'=>'1.25','price'=>'1.5'],
            ['category_id'=>'1','name' => 'فراشي بوند','description' =>'بنفسجي','cost'=>'1','price'=>'1.5'],
            ['category_id'=>'1','name' => 'املغم دفعة','description' =>'اسباني','cost'=>'0.52','price'=>'0.7'],
            ['category_id'=>'1','name' => 'املغم دفعتين','description' =>'اسباني','cost'=>'0.64','price'=>'0.8'],
            ['category_id'=>'1','name' => 'مشارط MOD','description' =>'1 متر تركي','cost'=>'0.5','price'=>'1'],
            ['category_id'=>'1','name' => 'مشارط MOD','description' =>'3 متر صيني','cost'=>'2','price'=>'2.5'],
            ['category_id'=>'1','name' => 'مساند MO','description' =>'JK','cost'=>'3.182','price'=>'4'],
            ['category_id'=>'1','name' => 'مساند MOD','description' =>'JK','cost'=>'3.182','price'=>'4'],
            ['category_id'=>'1','name' => 'مشارط MO','description' =>'تركي','cost'=>'0.8','price'=>'1.5'],
            ['category_id'=>'2','name' => 'GIC','description' =>'صيني','cost'=>'1.4','price'=>'2'],
            ['category_id'=>'2','name' => 'الجينات hygedent','description' =>' ','cost'=>'4','price'=>'4.5'],
            ['category_id'=>'2','name' => 'حشوة مؤقتة','description' =>'وطني سيبتا','cost'=>'1.75','price'=>'2'],
            ['category_id'=>'2','name' => 'حشوة مؤقتة','description' =>'روسي','cost'=>'2.3','price'=>'3'],
            ['category_id'=>'3','name' => 'سنبلة انهاء لهب شمعة','description' =>' ','cost'=>'0.22','price'=>'0.50'],
            ['category_id'=>'3','name' => 'سنبلة انهاء مخروطية','description' =>' ','cost'=>'0.30','price'=>'0.50'],
            ['category_id'=>'3','name' => 'سنبلة تحضير شبه كتف','description' =>' ','cost'=>'0.38','price'=>'0.50'],
            ['category_id'=>'3','name' => 'سنبلة تحضير فصل','description' =>' ','cost'=>'0.38','price'=>'0.50'],
            ['category_id'=>'3','name' => 'سنبلة تحضير لهب شمعة','description' =>' ','cost'=>'0.38','price'=>'0.50'],
            ['category_id'=>'3','name' => 'سنبلة كروية توربين','description' =>' ','cost'=>'0.22','price'=>'0.5'],
            ['category_id'=>'3','name' => 'سنبلة كروية توربين صغيرة','description' =>' ','cost'=>'0.38','price'=>'0.5'],
            ['category_id'=>'3','name' => 'سنبلة قمعية توربين','description' =>' ','cost'=>'0.22','price'=>'0.5'],
            ['category_id'=>'3','name' => 'سنبلة شاقة توربين','description' =>' ','cost'=>'0.22','price'=>'0.5'],
            ['category_id'=>'3','name' => 'سنبلة توربين شاقة طويلة','description' =>' ','cost'=>'0.38','price'=>'0.5'],
            ['category_id'=>'3','name' => 'سنبلة توربين شاقة طويلة','description' =>' ','cost'=>'0.36','price'=>'0.5'],
            ['category_id'=>'3','name' => 'سنبلة مكروتور شاقة','description' =>' ','cost'=>'0.45','price'=>'0.7'],
            ['category_id'=>'3','name' => 'سنبلة مكروتور كروية','description' =>' ','cost'=>'0.45','price'=>'0.7'],
            ['category_id'=>'3','name' => 'سنبلة مكروتور قمعية','description' =>' ','cost'=>'0.50','price'=>'0.7'],
            ['category_id'=>'3','name' => 'zسنبلة اندو','description' =>' ','cost'=>'1.4','price'=>'1.8'],
            ['category_id'=>'3','name' => 'سنابل gg','description' =>' ','cost'=>'3.75','price'=>'4.25'],
            ['category_id'=>'4','name' => 'مبارد يدوية DEGER','description' =>'K-file ملون','cost'=>'1.25','price'=>'1.60'],
            ['category_id'=>'4','name' => 'مبارد يدوية DEGER','description' =>'H-file ملون','cost'=>'1.25','price'=>'1.60'],
            ['category_id'=>'4','name' => 'مبارد يدوية DEGER','description' =>'Spredaers ملون','cost'=>'1.25','price'=>'1.60'],
            ['category_id'=>'4','name' => 'مبارد Videyea','description' =>'ابيض','cost'=>'1.682','price'=>'2.00'],
            ['category_id'=>'4','name' => 'مبارد Videyea','description' =>'بنفسجي','cost'=>'1.682','price'=>'2.00'],
            ['category_id'=>'4','name' => 'كوتا Meta','description' =>'ملون Taper 0.02','cost'=>'2.25','price'=>'2.50'],
            ['category_id'=>'4','name' => 'كوتا Sani','description' =>'ملون Taper 0.02','cost'=>'1.75','price'=>'2.30'],
            ['category_id'=>'4','name' => 'اقماع تجفيف Meta','description' =>'ملون Taper 0.02','cost'=>'2.063','price'=>'2.30'],
            ['category_id'=>'4','name' => 'اوكسيد الزنك','description' =>'وطني سيبتا','cost'=>'1.60','price'=>'2'],
            ['category_id'=>'4','name' => 'اوجينول','description' =>'وطني سيبتا','cost'=>'2.50','price'=>'3.00'],
            ['category_id'=>'5','name' => 'طقم فحص','description' =>'باكستاني','cost'=>'1.75','price'=>'3'],
            ['category_id'=>'5','name' => 'محقنة','description' =>'JK','cost'=>'6','price'=>'7'],
            ['category_id'=>'5','name' => 'اداة حشي مواد لينة','description' =>'JK','cost'=>'1.182','price'=>'1.50'],
            ['category_id'=>'5','name' => 'سكين شمع','description' =>'JK','cost'=>'1.182','price'=>'1.50'],
            ['category_id'=>'5','name' => 'منحتة شمع','description' =>'JK','cost'=>'1.091','price'=>'1.5'],
            ['category_id'=>'5','name' => 'منحتة املغم','description' =>'JK','cost'=>'1.091','price'=>'1.5'],
            ['category_id'=>'5','name' => 'مثقلة املغم','description' =>'JK','cost'=>'1.11','price'=>'1.5'],
            ['category_id'=>'5','name' => 'مدك املفم','description' =>'JK','cost'=>'1.11','price'=>'1.5'],
            ['category_id'=>'5','name' => 'سباتول','description' =>' ','cost'=>'0.90','price'=>'1.30'],
            ['category_id'=>'5','name' => 'اداة تبطين','description' =>' ','cost'=>'0.90','price'=>'1.30'],
            ['category_id'=>'5','name' => 'مدفع املغم','description' =>' ','cost'=>'2','price'=>'2.5'],
            ['category_id'=>'5','name' => 'جرن املغم','description' =>' ','cost'=>'0.6','price'=>'1.5'],
            ['category_id'=>'6','name' => 'كفوف نتريل','description' =>'Large','cost'=>'2.15','price'=>'3'],   
            ['category_id'=>'6','name' => 'كفوف نتريل','description' =>'Small','cost'=>'2.15','price'=>'3'],
            ['category_id'=>'6','name' => 'كمامات','description' =>' ','cost'=>'0.47','price'=>'1'],
            ['category_id'=>'6','name' => 'شمع','description' =>'صيني','cost'=>'0.195','price'=>'0.30'],
            ['category_id'=>'6','name' => 'مطاط رابر دام','description' =>' ','cost'=>'0.149','price'=>'0.25'],
            ['category_id'=>'6','name' => 'لفافات قطنية','description' =>'Bournas','cost'=>'0.467','price'=>'0.7'],
            ['category_id'=>'6','name' => 'روؤس ارواء','description' =>'فتحة واحدة','cost'=>'0.08','price'=>'0.12'],
            ['category_id'=>'6','name' => 'روؤس ارواء','description' =>'فتحتين','cost'=>'0.08','price'=>'0.12'],
            ['category_id'=>'6','name' => 'سيرينغات','description' =>' ','cost'=>'0.025','price'=>'0.10'],
            ['category_id'=>'6','name' => 'روؤس ابر','description' =>'طويلة','cost'=>'0.028','price'=>'0.05'],
            ['category_id'=>'6','name' => 'روؤس ابر','description' =>'قصيرة','cost'=>'0.028','price'=>'0.05'],
            ['category_id'=>'6','name' => 'معقم سطوح','description' =>'1 لتر سيبتا','cost'=>'2.50','price'=>'3.00'],
            ['category_id'=>'6','name' => 'لوح زجاجي','description' =>' ','cost'=>'0.15','price'=>'0.25'],
            ['category_id'=>'6','name' => 'ماصات وطني','description' =>' ','cost'=>'2.00','price'=>'2.30'],
            ['category_id'=>'6','name' => 'ماصات صيني','description' =>' ','cost'=>'2.5','price'=>'2.8'],
            ['category_id'=>'6','name' => 'شانات مريض','description' =>' ','cost'=>'1.10','price'=>'1.50'],
            ['category_id'=>'6','name' => 'شانات طاولة','description' =>' ','cost'=>'0.7','price'=>'1'],
            ['category_id'=>'6','name' => 'مخدر وطني','description' =>'مع مقبض','cost'=>'0.25','price'=>'0.4'],
            ['category_id'=>'6','name' => 'مخدر وطني','description' =>'مع مقبض','cost'=>'0.28','price'=>'0.45'],
            ['category_id'=>'6','name' => 'مخدر كولومبي','description' =>'مع مقبض','cost'=>'0.3','price'=>'0.42'],
            ['category_id'=>'6','name' => 'اقلام كير','description' =>' ','cost'=>'0.80','price'=>'0.92'],
            ['category_id'=>'6','name' => 'افلام اشعة','description' =>' ','cost'=>'0.187','price'=>'0.25'],
        ]);
    }
}
