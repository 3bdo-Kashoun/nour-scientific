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
            'password' => ['required', 'string', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/', 'confirmed'],
        ], [
            'name.required' => 'الاسم الكامل مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'يجب ألا تقل كلمة المرور عن 8 رموز.',
            'password.regex' => 'يجب أن تحتوي كلمة المرور على حروف إنجليزية وأرقام معاً.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        // 2. إنشاء المستخدم الجديد
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        // 3. تسجيل الدخول تلقائياً بعد التسجيل
        Auth::login($user);

        // 4. حفظ الاسم في الجلسة (مثل LoginController) حتى يظهر في الـ Navbar
        $request->session()->put('name', $user->name);

        // 5. التوجيه للصفحة الرئيسية مع رسالة نجاح
        return redirect('/')->with('success_register', 'تم إنشاء حسابك بنجاح! مرحباً بك في نور العلمية 🎉');
    }

    /**
     * التحقق من توفر البريد الإلكتروني عبر AJAX
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {
            return response()->json(['available' => false]);
        }

        $exists = User::where('email', $email)->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'هذا البريد الإلكتروني مسجّل بالفعل.' : ''
        ]);
    }
}
