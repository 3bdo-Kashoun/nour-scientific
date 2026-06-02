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
            <input type="text" placeholder="أدخل اسمك الثلاثي" required name="name" value="{{ old('name') }}"/>
            @error('name')
                <div class="field-error" style="display: block;">
                    <i class="fa-solid fa-circle-exclamation"></i> <span>{{ $message }}</span>
                </div>
            @enderror
          </div>

          <div class="input-box">
            <label><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
            <input type="email" placeholder="example@nour.ly" required name="email" id="reg-email" value="{{ old('email') }}"/>
            <div class="field-error" id="email-error" style="display: none;">
                <i class="fa-solid fa-circle-exclamation"></i> <span></span>
            </div>
            @error('email')
                <div class="field-error" style="display: block;">
                    <i class="fa-solid fa-circle-exclamation"></i> <span>{{ $message }}</span>
                </div>
            @enderror
          </div>

          <div class="input-box">
            <label><i class="fas fa-lock"></i> كلمة المرور</label>
            <input type="password" id="password" placeholder="••••••••" required name="password" />
            
            <!-- مقياس قوة كلمة المرور -->
            <div class="reg-strength-container">
                <div class="reg-strength-bar-wrapper">
                    <div class="reg-strength-bar" id="reg-strength-bar"></div>
                </div>
                <div class="reg-strength-text" id="reg-strength-text">يجب أن تحتوي على حروف إنجليزية وأرقام (8 رموز على الأقل).</div>
            </div>
            @error('password')
                <div class="field-error" style="display: block;">
                    <i class="fa-solid fa-circle-exclamation"></i> <span>{{ $message }}</span>
                </div>
            @enderror
          </div>

          <div class="input-box">
            <label><i class="fas fa-shield-halved"></i> تأكيد كلمة المرور</label>
            <input type="password" id="confirm_password" placeholder="••••••••" required name="password_confirmation" />
            <div class="field-error" id="confirm-error" style="display: none;">
                <i class="fa-solid fa-circle-exclamation"></i> <span>كلمتا المرور غير متطابقتين.</span>
            </div>
          </div>

          <button type="submit" class="btn-login btn-register" id="btn-register" disabled>إنشاء الحساب</button>

          <div class="back-home">
            <a href="{{ route('login') }}">لديك حساب بالفعل؟ سجل دخولك</a>
          </div>
        </form>
      </div>
    </div>

    <style>
        /* مقياس قوة كلمة المرور */
        .reg-strength-container {
            margin-top: 10px;
        }
        .reg-strength-bar-wrapper {
            width: 100%;
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 999px;
            overflow: hidden;
        }
        .reg-strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 999px;
            transition: width 0.4s ease, background-color 0.4s ease;
        }
        .reg-strength-text {
            font-size: 0.8rem;
            margin-top: 6px;
            color: #64748b;
            text-align: right;
        }
        /* رسائل الخطأ الفورية */
        .field-error {
            font-size: 0.8rem;
            color: #ef4444;
            margin-top: 6px;
            text-align: right;
            animation: shakeIn 0.3s ease;
        }
        @keyframes shakeIn {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(4px); }
            75% { transform: translateX(-4px); }
        }
        .input-box input.input-error {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important;
        }
        .input-box input.input-success {
            border-color: #22c55e !important;
        }
        .btn-register:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }
    </style>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm_password');
        const emailInput = document.getElementById('reg-email');
        const strengthBar = document.getElementById('reg-strength-bar');
        const strengthText = document.getElementById('reg-strength-text');
        const submitBtn = document.getElementById('btn-register');
        const emailError = document.getElementById('email-error');
        const confirmError = document.getElementById('confirm-error');

        let passwordValid = false;
        let emailValid = false;

        // 1. فحص قوة كلمة المرور لحظياً
        function checkPasswordStrength() {
            const password = passwordInput.value;
            const confirmVal = confirmInput.value;

            if (!password) {
                strengthBar.style.width = '0%';
                strengthText.innerText = 'يجب أن تحتوي على حروف إنجليزية وأرقام (8 رموز على الأقل).';
                strengthText.style.color = '#64748b';
                passwordValid = false;
                updateSubmitButton();
                return;
            }

            const hasLetters = /[a-zA-Z]/.test(password);
            const hasNumbers = /[0-9]/.test(password);
            const hasSpecial = /[^a-zA-Z0-9\s]/.test(password);
            const length = password.length;

            if (!hasLetters || !hasNumbers) {
                strengthBar.style.width = '15%';
                strengthBar.style.backgroundColor = '#ef4444';
                strengthText.innerText = 'ضعيفة جداً (يجب استخدام حروف إنجليزية وأرقام معاً).';
                strengthText.style.color = '#ef4444';
                passwordValid = false;
                updateSubmitButton();
                return;
            }

            if (length < 8) {
                strengthBar.style.width = '25%';
                strengthBar.style.backgroundColor = '#ef4444';
                strengthText.innerText = 'ضعيفة (يجب ألا تقل عن 8 رموز).';
                strengthText.style.color = '#ef4444';
                passwordValid = false;
                updateSubmitButton();
                return;
            }

            let score = 2;
            if (length >= 10) score++;
            if (length >= 12) score++;
            if (hasSpecial) score++;

            if (score <= 2) {
                strengthBar.style.width = '50%';
                strengthBar.style.backgroundColor = '#f97316';
                strengthText.innerText = 'متوسطة (يمكن تحسينها بإضافة رموز أو زيادة الطول).';
                strengthText.style.color = '#f97316';
            } else if (score === 3) {
                strengthBar.style.width = '75%';
                strengthBar.style.backgroundColor = '#3b82f6';
                strengthText.innerText = 'قوية.';
                strengthText.style.color = '#3b82f6';
            } else if (score >= 4) {
                strengthBar.style.width = '100%';
                strengthBar.style.backgroundColor = '#22c55e';
                strengthText.innerText = 'قوية جداً! 👍';
                strengthText.style.color = '#22c55e';
            }

            passwordValid = true;

            // فحص التطابق
            if (confirmVal && password !== confirmVal) {
                confirmError.style.display = 'block';
                confirmInput.classList.add('input-error');
                confirmInput.classList.remove('input-success');
                passwordValid = false;
            } else if (confirmVal) {
                confirmError.style.display = 'none';
                confirmInput.classList.remove('input-error');
                confirmInput.classList.add('input-success');
            }

            updateSubmitButton();
        }

        // 2. فحص البريد الإلكتروني عند مغادرة الحقل (صيغة + تكرار من قاعدة البيانات)
        emailInput.addEventListener('blur', function() {
            const email = emailInput.value.trim();
            if (!email) {
                emailError.style.display = 'none';
                emailInput.classList.remove('input-error', 'input-success');
                emailValid = false;
                updateSubmitButton();
                return;
            }

            // أولاً: فحص الصيغة محلياً
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                emailError.querySelector('span').innerText = 'صيغة البريد الإلكتروني غير صحيحة.';
                emailError.style.display = 'block';
                emailInput.classList.add('input-error');
                emailInput.classList.remove('input-success');
                emailValid = false;
                updateSubmitButton();
                return;
            }

            // ثانياً: فحص التكرار من قاعدة البيانات عبر AJAX
            fetch('{{ route("register.check-email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ email: email })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.available) {
                    emailError.querySelector('span').innerText = data.message || 'هذا البريد الإلكتروني مسجّل بالفعل.';
                    emailError.style.display = 'block';
                    emailInput.classList.add('input-error');
                    emailInput.classList.remove('input-success');
                    emailValid = false;
                } else {
                    emailError.style.display = 'none';
                    emailInput.classList.remove('input-error');
                    emailInput.classList.add('input-success');
                    emailValid = true;
                }
                updateSubmitButton();
            })
            .catch(() => {
                // في حالة فشل الطلب، نقبل البريد مبدئياً (السيرفر سيتحقق لاحقاً)
                emailError.style.display = 'none';
                emailInput.classList.remove('input-error');
                emailInput.classList.add('input-success');
                emailValid = true;
                updateSubmitButton();
            });
        });

        // 3. فحص تطابق كلمة المرور
        confirmInput.addEventListener('input', function() {
            if (confirmInput.value && passwordInput.value !== confirmInput.value) {
                confirmError.style.display = 'block';
                confirmInput.classList.add('input-error');
                confirmInput.classList.remove('input-success');
            } else if (confirmInput.value) {
                confirmError.style.display = 'none';
                confirmInput.classList.remove('input-error');
                confirmInput.classList.add('input-success');
            } else {
                confirmError.style.display = 'none';
                confirmInput.classList.remove('input-error', 'input-success');
            }
            checkPasswordStrength();
        });

        // 4. تحديث حالة الزر
        function updateSubmitButton() {
            const confirmMatch = passwordInput.value === confirmInput.value && confirmInput.value !== '';
            submitBtn.disabled = !(passwordValid && emailValid && confirmMatch);
        }

        passwordInput.addEventListener('input', checkPasswordStrength);

        // 5. فحص مبدئي عند تحميل الصفحة (مثلاً لو أرجع الصفحة بسبب خطأ)
        if (emailInput.value) {
            emailInput.dispatchEvent(new Event('blur'));
        }
    </script>
  </body>
</html>

