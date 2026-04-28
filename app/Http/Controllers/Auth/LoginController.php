<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            $request->session()->put('name', Auth::user()->name);

            $request->session()->put('auth.password_confirmed_at', time());
            if ($request->has('remember')) {

                Cookie::queue('remember_email', $request->email, 60 * 24 * 365);
            }
            else{
                Cookie::queue(Cookie::forget('remember_email'));
            }
            $user = Auth::user();
            if ($user->is_admin) {
                return redirect()->intended(route('filament.admin.pages.dashboard'));
            } else {
                return redirect('/');
            }
        }
        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ]);
    }
}
