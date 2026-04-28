<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل الدخول - نور العلمية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('pages/login.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet" />
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="icon-container">
                    <i class="fa-solid fa-user-lock"></i>
                </div>
                <h1>نور العلمية</h1>
                <p>مرحباً بك، يرجى تسجيل الدخول للوصول إلى حسابك</p>
            </div>

            <form action="{{ route('filament.admin.auth.login') }}" method="POST">
                @csrf
                @error('email')
                    <div
                        style="color: #e74c3c; font-size: 13px; margin-bottom: 12px; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
                <div class="input-box">
                    <label><i class="fas fa-envelope"></i> البريد الإلكتروني</label>

                    <input type="email" name="email"
                        style="direction: ltr"
                        value="{{ request()->cookie('remember_email') ?? old('email') }}" placeholder="example@nour.ly"
                        required />
                </div>

                <div class="input-box">
                    <label><i class="fas fa-lock"></i> كلمة المرور</label>
                    <input type="password" placeholder="••••••••" required name="password" style="direction: ltr"/>
                </div>

                <div class="options-row">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" name="remember" {{ Cookie::has('remember_email') ? 'checked' : '' }}/>
                        <span class="checkmark" ></span>
                        تذكرني
                    </label>
                    <a href="#" class="forgot-link">نسيت كلمة المرور؟</a>
                </div>

                <button type="submit" class="btn-login">تسجيل الدخول</button>

                <div class="back-home">
                    <a href="/"><i class="fas fa-arrow-right"></i> العودة للرئيسية</a>
                </div>
                <div class="register-link">
                    <span>ليس لديك حساب؟</span>
                    <a href="{{ route('register') }}">أنشئ حساباً الآن</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
