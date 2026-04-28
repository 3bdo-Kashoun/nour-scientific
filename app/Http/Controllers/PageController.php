<?php

namespace App\Http\Controllers;

use App\Models\Engineer;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function home()

    {

        // هنا يمكنك لاحقاً جلب المنتجات من قاعدة البيانات

        return view('home');
    }



    public function about()

    {

        // لنفترض أننا نريد إرسال إحصائيات الشركة ديناميكياً

        $stats = [

            ['icon' => 'fa-certificate', 'title' => 'سنوات الخبرة', 'target' => '20', 'number' => '+15'],

            ['icon' => 'fa-users', 'title' => 'عميل راضٍ', 'target' => '500', 'number' => '+500'],
            ['icon' => 'fa-flask-vial', 'title' => 'منتج كيميائي', 'target' => '200', 'number' => '+200'],
            ['icon' => 'fa-shield-halved', 'title' => 'معايير الجودة', 'target' => 'ISO', 'number' => 'ISO']

        ];
        $partners = [
            ['name' => 'Weiteg', 'origin' => 'ألمانيا', 'logo' => 'witeg-1536x458.png'],
            ['name' => 'Sigma-Aldrich', 'origin' => 'المملكة المتحدة', 'logo' => '1.png'],
            ['name' => 'Lovibond', 'origin' => 'ألمانيا', 'logo' => '3.png'],
            ['name' => 'Scharlab', 'origin' => 'إسبانيا', 'logo' => '4.png'],
            ['name' => 'J.P. SELECTA s.a.u', 'origin' => 'إسبانيا', 'logo' => '5.png'],
            ['name' => 'Glentham Life Sciences Ltd', 'origin' => 'المملكة المتحدة', 'logo' => '6.png'],
            ['name' => 'Glassco Laboratory Equipments', 'origin' => 'الهند', 'logo' => '7.png'],
            ['name' => 'Carlo Erba Reagents', 'origin' => 'ألمانيا', 'logo' => '8.png'],
        ];



        return view('about', compact('stats', 'partners'));
    }
    public function contact()

    {

        // يمكنك هنا معالجة بيانات الاتصال أو إرسالها إلى البريد الإلكتروني

        $members =Engineer::all(); // جلب جميع المهندسين من قاعدة البيانات
        return view('contact', compact('members'));
    }
    
}
