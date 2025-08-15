<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رزرو موفق</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #f1f1f1);
            font-family: sans-serif;
        }

        .thank-card {
            max-width: 550px;
            margin: 80px auto;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            text-align: center;
            padding: 40px 30px;
            background: #fff;
            animation: fadeInUp 0.7s ease-in-out;
        }

        .logo {
            margin-bottom: 20px;
        }

        .thank-icon {
            background-color: #E30613;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: popIn 0.6s ease-in-out;
        }

        .thank-icon svg {
            width: 50px;
            height: 50px;
            color: #fff;
        }

        h1 {
            color: #E30613;
            font-size: 1.9rem;
            margin-bottom: 15px;
        }

        p {
            color: #6c757d;
            font-size: 1.05rem;
            margin-bottom: 25px;
        }

        .btn-home {
            padding: 10px 25px;
            font-size: 1rem;
            border-radius: 8px;
            background-color: #E30613;
            border: none;
        }

        .btn-home:hover {
            background-color: #b7050f;
        }

        .contact-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 0.95rem;
        }

        .contact-info a {
            text-decoration: none;
            color: #495057;
        }

        .contact-info a:hover {
            color: #E30613;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes popIn {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>

    <div class="thank-card">
        <div class="logo">
            <img src="{{ asset('assets/reserve/assets/images/logo.png') }}" width="100" alt="KARA Plus">
        </div>
        <div class="thank-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                <path
                    d="M13.485 1.929a.75.75 0 0 1 .086 1.056l-7.25 9a.75.75 0 0 1-1.08.04L2.43 7.982a.75.75 0 0 1 1.06-1.06l2.41 2.41 6.72-8.34a.75.75 0 0 1 1.056-.086" />
            </svg>
        </div>
        <h1>رزرو شما با موفقیت ثبت شد!</h1>
        <p>با تشکر از اعتماد شما، درخواست شما با موفقیت ثبت گردید. همکاران ما در کوتاه‌ترین زمان ممکن با شما تماس خواهند
            گرفت.</p>
        <a href="{{ url('/') }}" class="btn btn-danger btn-home">بازگشت به صفحه اصلی</a>

        <div class="contact-info">
            <p class="fw-bold mb-2">اطلاعات تماس شرکت</p>
            <p>📍 تهران، خیابان مثال، پلاک ۱۲۳</p>
            <p>📞 <a href="tel:02112345678">021-12345678</a></p>
            <p>📱 <a href="tel:09121234567">0912-123-4567</a></p>
            <p>✉️ <a href="mailto:info@example.com">info@example.com</a></p>
        </div>
    </div>

</body>

</html>
