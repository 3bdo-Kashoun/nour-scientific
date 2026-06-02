<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انتهت صلاحية الجلسة - نور العلمية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary: #028137;
            --primary-hover: #026d2e;
            --bg-dark: #0f172a;
            --card-dark: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

        /* Background animated blobs */
        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(2, 129, 55, 0.15) 0%, rgba(0,0,0,0) 70%);
            filter: blur(50px);
            z-index: 1;
            animation: float 10s infinite alternate;
        }

        .blob-1 {
            top: -10%;
            right: -10%;
        }

        .blob-2 {
            bottom: -10%;
            left: -10%;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 50px) scale(1.1); }
        }

        .error-container {
            position: relative;
            z-index: 10;
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-wrapper {
            width: 100px;
            height: 100px;
            background: rgba(2, 129, 55, 0.1);
            border: 2px dashed var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            position: relative;
            animation: pulse-ring 2s infinite;
        }

        .icon-wrapper i {
            font-size: 40px;
            color: var(--primary);
        }

        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(2, 129, 55, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(2, 129, 55, 0); }
            100% { box-shadow: 0 0 0 0 rgba(2, 129, 55, 0); }
        }

        .error-code {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }

        h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .actions-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 28px;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            width: 100%;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
            box-shadow: 0 4px 14px rgba(2, 129, 55, 0.3);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(2, 129, 55, 0.4);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--text-main);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="error-container">
        <div class="icon-wrapper">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <div class="error-code">رمز الخطأ 419</div>
        <h1>انتهت صلاحية الجلسة</h1>
        <p>لقد انتهت صلاحية هذه الصفحة أو انتهت فترة الجلسة الخاصة بك بسبب عدم النشاط لفترة طويلة. يرجى إعادة تحميل الصفحة أو تسجيل الدخول مجدداً.</p>
        
        <div class="actions-group">
            <button onclick="window.location.reload();" class="btn btn-primary">
                <i class="fa-solid fa-rotate-right"></i> تحديث الصفحة
            </button>
            <a href="/login" class="btn btn-secondary">
                <i class="fa-solid fa-right-to-bracket"></i> العودة لتسجيل الدخول
            </a>
        </div>
    </div>
</body>
</html>
