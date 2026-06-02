<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * عرض صفحة حسابي والطلبيات السابقة
     */
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->get();

        return view('profile', compact('user', 'orders'));
    }

    /**
     * تحديث البيانات الشخصية (الاسم والبريد الإلكتروني فقط)
     */
    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'الاسم الكامل مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل من قبل حساب آخر.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // تحديث الاسم في الجلسة إذا كان معتمداً
        session(['name' => $request->name]);

        return back()->with('success_info', 'تم تحديث معلوماتك الشخصية بنجاح! 🎉');
    }

    /**
     * تغيير كلمة المرور بأمان مع الفحص والتحقق
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/', // يحتوي على حروف إنجليزية
                'regex:/[0-9]/',     // يحتوي على أرقام
                'confirmed'          // متطابق مع تأكيد كلمة المرور
            ]
        ], [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة.',
            'new_password.required' => 'كلمة المرور الجديدة مطلوبة.',
            'new_password.min' => 'يجب ألا تقل كلمة المرور الجديدة عن 8 رموز.',
            'new_password.regex' => 'يجب أن تحتوي كلمة المرور على حروف إنجليزية وأرقام معاً.',
            'new_password.confirmed' => 'تأكيد كلمة المرور الجديدة غير متطابق.'
        ]);

        // التحقق من تطابق كلمة المرور الحالية
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }

        // حفظ كلمة المرور الجديدة المشفرة
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success_password', 'تم تغيير كلمة المرور بنجاح! 🔑');
    }

    /**
     * جلب تفاصيل الطلب عبر AJAX
     */
    public function orderDetails($orderId)
    {
        $user = Auth::user();
        $order = $user->orders()->with('products')->findOrFail($orderId);

        $productsData = $order->products->map(function ($product) {
            return [
                'name' => $product->name,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
                'price' => number_format($product->pivot->price, 2),
                'quantity' => $product->pivot->quantity,
                'total' => number_format($product->pivot->price * $product->pivot->quantity, 2)
            ];
        });

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'created_at' => $order->created_at->format('Y-m-d H:i'),
                'total_price' => number_format($order->total_price, 2),
                'delivery_requested' => $order->delivery_requested,
                'delivery_price' => number_format($order->delivery_price, 2),
                'status' => $order->status,
                'phone' => $order->phone
            ],
            'products' => $productsData
        ]);
    }
}
