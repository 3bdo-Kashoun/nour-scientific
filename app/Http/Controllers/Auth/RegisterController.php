<?php



namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // 1. التحقق من البيانات
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], //Confirmed تعني لازم حقل password_confirmation يكون موجود
        ]);

        // 2. إنشاء المستخدم الجديد
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false, // أي حد يسجل من هنا مش أدمن طبعاً
        ]);

        // 3. تسجيل الدخول تلقائياً بعد التسجيل
        Auth::login($user);

        // 4. التوجيه للصفحة الرئيسية (بما أنه مش أدمن)
        return redirect('/')->with('success', 'تم إنشاء الحساب بنجاح');
    }
}
