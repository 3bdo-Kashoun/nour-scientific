<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إنشاء حساب جديد - نور العلمية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('pages/login.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet" />
  </head>
  <body>
    <div class="login-wrapper">
      <div class="login-card shadow-lg">
        <div class="login-header">
          <div class="icon-container highlight">
             <i class="fa-solid fa-user-plus"></i>
          </div>
          <h1>انضم إلينا</h1>
          <p>قم بإنشاء حسابك للبدء في استخدام خدمات نور</p>
        </div>

        <form action="{{ route('register') }}" method="POST" id="registerForm">
          @csrf
          <div class="input-box">
            <label><i class="fas fa-user"></i> الاسم الكامل</label>
            <input type="text" placeholder="أدخل اسمك الثلاثي" required name="name"/>
          </div>

          <div class="input-box">
            <label><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
            <input type="email" placeholder="example@nour.ly" required name="email"/>
          </div>

          <div class="input-box">
            <label><i class="fas fa-lock"></i> كلمة المرور</label>
            <input type="password" id="password" placeholder="••••••••" required name="password" minlength="8" />
            <small class="hint">يجب أن تكون 8 رموز على الأقل (أرقام وحروف)</small>
          </div>

          <div class="input-box">
            <label><i class="fas fa-shield-halved"></i> تأكيد كلمة المرور</label>
            <input type="password" id="confirm_password" placeholder="••••••••" required name="password_confirmation" />
          </div>

          <button type="submit" class="btn-login btn-register">إنشاء الحساب</button>

          <div class="back-home">
            <a href="{{ route('login') }}">لديك حساب بالفعل؟ سجل دخولك</a>
          </div>
        </form>
      </div>
    </div>

    <script>
        const password = document.getElementById("password");
        const confirm_password = document.getElementById("confirm_password");

        function validatePassword(){
          if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("كلمات المرور غير متطابقة");
          } else {
            confirm_password.setCustomValidity('');
          }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>
  </body>
</html>
