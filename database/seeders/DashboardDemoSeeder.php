<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\StockMovement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DashboardDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء مستخدمين ليبيين (زبائن)
        $usersData = [
            [
                'name' => 'أحمد المهدي الفرجاني',
                'email' => 'ahmed.ferjani@gmail.com',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ],
            [
                'name' => 'سارة مصطفى الترهوني',
                'email' => 'sara.tarhuni@gmail.com',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ],
            [
                'name' => 'علي عمر الخوجة',
                'email' => 'ali.khoja@gmail.com',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ],
            [
                'name' => 'محمد الهادي الزوي',
                'email' => 'mohamed.zway@gmail.com',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ],
            [
                'name' => 'مريم مفتاح الغرياني',
                'email' => 'maryam.gharyani@gmail.com',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ],
        ];

        $users = [];
        foreach ($usersData as $userData) {
            $users[] = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // 2. إنشاء منتجات طبية/علمية للشركة
        $productsData = [
            [
                'name' => 'جهاز الطرد المركزي للمختبرات CD-0412',
                'price' => 3500.00,
                'dos_value' => '1',
                'category_id' => 1,
                'dosage_id' => 1,
                'company_id' => 1,
                'code' => 'PRD-CENT-01',
                'stock_quantity' => 15,
                'expiry_date' => '2030-12-31',
            ],
            [
                'name' => 'مجهر بيولوجي ثنائي العينين XSZ-107T',
                'price' => 4800.00,
                'dos_value' => '1',
                'category_id' => 1,
                'dosage_id' => 1,
                'company_id' => 1,
                'code' => 'PRD-MICR-02',
                'stock_quantity' => 8,
                'expiry_date' => '2029-06-30',
            ],
            [
                'name' => 'جهاز تحليل الكيمياء الحيوية الأوتوماتيكي',
                'price' => 75000.00,
                'dos_value' => '1',
                'category_id' => 1,
                'dosage_id' => 1,
                'company_id' => 1,
                'code' => 'PRD-BIOCHEM-03',
                'stock_quantity' => 3,
                'expiry_date' => '2028-09-15',
            ],
            [
                'name' => 'حاضنة عينات معملية سعة 50 لتر',
                'price' => 8200.00,
                'dos_value' => '1',
                'category_id' => 1,
                'dosage_id' => 1,
                'company_id' => 1,
                'code' => 'PRD-INCUB-04',
                'stock_quantity' => 5,
                'expiry_date' => '2028-11-20',
            ],
            [
                'name' => 'ميزان حرارة طبي رقمي بالأشعة تحت الحمراء',
                'price' => 150.00,
                'dos_value' => '1',
                'category_id' => 1,
                'dosage_id' => 1,
                'company_id' => 1,
                'code' => 'PRD-THERM-05',
                'stock_quantity' => 100,
                'expiry_date' => '2027-01-01',
            ],
        ];

        $products = [];
        foreach ($productsData as $productData) {
            $products[] = Product::updateOrCreate(
                ['code' => $productData['code']],
                $productData
            );
        }

        // مسح الطلبات وحركات المخزون القديمة لتفادي تكرار البيانات
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Order::truncate();
        \Illuminate\Support\Facades\DB::table('order_product')->truncate();
        StockMovement::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 3. إنشاء طلبات (فواتير) مع علاقة بالزبائن الليبيين
        // طلب 1: قيد الانتظار (أحمد الفرجاني)
        $order1 = Order::create([
            'user_id' => $users[0]->id,
            'phone' => '0913344556',
            'delivery_requested' => true,
            'delivery_price' => 20.00,
            'status' => 'pending',
            'total_price' => (3500.00 * 2) + 20.00,
        ]);
        $order1->products()->attach($products[0]->id, ['quantity' => 2, 'price' => 3500.00]);

        // طلب 2: تم البيع (سارة الترهوني - مركز طرابلس الطبي)
        $order2 = Order::create([
            'user_id' => $users[1]->id,
            'phone' => '0925566778',
            'delivery_requested' => true,
            'delivery_price' => 50.00,
            'status' => 'sold',
            'total_price' => (75000.00 * 3) + (8200.00 * 1) + 50.00, // 233250.00
        ]);
        $order2->products()->attach($products[2]->id, ['quantity' => 3, 'price' => 75000.00]);
        $order2->products()->attach($products[3]->id, ['quantity' => 1, 'price' => 8200.00]);

        // طلب 3: قيد التوصيل (علي الخوجة - مستشفى الهضبة الخضراء)
        $order3 = Order::create([
            'user_id' => $users[2]->id,
            'phone' => '0942233445',
            'delivery_requested' => true,
            'delivery_price' => 15.00,
            'status' => 'in_delivery',
            'total_price' => (4800.00 * 3) + 15.00, // 14415.00
        ]);
        $order3->products()->attach($products[1]->id, ['quantity' => 3, 'price' => 4800.00]);

        // طلب 4: ملغية (محمد الزوي)
        $order4 = Order::create([
            'user_id' => $users[3]->id,
            'phone' => '0917788990',
            'delivery_requested' => false, // حجز واستلام شخصي
            'delivery_price' => 0.00,
            'status' => 'cancelled',
            'total_price' => (150.00 * 10), // 1500.00
        ]);
        $order4->products()->attach($products[4]->id, ['quantity' => 10, 'price' => 150.00]);

        // طلب 5: تم البيع (مريم الغرياني - مستشفى الجلاء بنغازي)
        $order5 = Order::create([
            'user_id' => $users[4]->id,
            'phone' => '0928877665',
            'delivery_requested' => true,
            'delivery_price' => 150.00, // شحن لبنغازي
            'status' => 'sold',
            'total_price' => (3500.00 * 1) + (4800.00 * 2) + 150.00, // 13250.00
        ]);
        $order5->products()->attach($products[0]->id, ['quantity' => 1, 'price' => 3500.00]);
        $order5->products()->attach($products[1]->id, ['quantity' => 2, 'price' => 4800.00]);


        // 4. إنشاء حركات مخزون بلهجة ليبية وتفاصيل دقيقة
        $stockMovements = [
            [
                'product_id' => $products[0]->id,
                'quantity' => 20,
                'type' => 'in',
                'reason' => 'توريد شحنة جديدة من الوكيل المعتمد في طرابلس',
            ],
            [
                'product_id' => $products[0]->id,
                'quantity' => -2,
                'type' => 'out',
                'reason' => 'حجز مبدئي لمركز طرابلس الطبي - فاتورة رقم ' . $order1->id,
            ],
            [
                'product_id' => $products[2]->id,
                'quantity' => 5,
                'type' => 'in',
                'reason' => 'استلام شحنة أجهزة تحاليل مستوردة عن طريق ميناء الخمس',
            ],
            [
                'product_id' => $products[2]->id,
                'quantity' => -3,
                'type' => 'out',
                'reason' => 'تسليم وتركيب أجهزة في مركز طرابلس الطبي - فاتورة رقم ' . $order2->id,
            ],
            [
                'product_id' => $products[1]->id,
                'quantity' => 10,
                'type' => 'in',
                'reason' => 'شراء وتوريد مجاهر مخبرية من ألمانيا لشمال أفريقيا',
            ],
            [
                'product_id' => $products[1]->id,
                'quantity' => -3,
                'type' => 'out',
                'reason' => 'شحن وتوصيل لمستشفى الهضبة الخضراء - فاتورة رقم ' . $order3->id,
            ],
            [
                'product_id' => $products[4]->id,
                'quantity' => 10,
                'type' => 'in',
                'reason' => 'إرجاع بضاعة صالحة للمخزن بعد إلغاء الطلبية من الزبون محمد الزوي',
            ],
        ];

        foreach ($stockMovements as $movement) {
            StockMovement::create($movement);
        }
    }
}
