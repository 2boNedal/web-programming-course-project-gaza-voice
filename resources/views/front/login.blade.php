<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>تسجيل الدخول - وكالة صوت غزة الإخبارية</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Login Page" name="keywords" />
    <meta content="Login to News24" name="description" />

    <!-- Favicon -->
    <link href="/front/img/favicon.ico" rel="icon" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet" />

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="/front/css/style.css" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            height: 100vh;
        }

        .image-side {
            flex: 1;
            background: url('/front/img/top-news-1.jpg') center/cover no-repeat;
            position: relative;
        }

        .image-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        .login-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #ffffff;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .site-name {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            height: 50px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0 15px;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #E47A2E;
            box-shadow: 0 0 0 0.2rem rgba(228, 122, 46, 0.18);
        }

        #password:focus {
            box-shadow: none;
        }

        .input-group {
            position: relative;
        }

        .input-group-append {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        #password {
            padding-right: 50px;
        }

        #togglePassword {
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 2px 4px;
            width: auto;
            height: auto;
            color: #666;
            cursor: pointer;
            transition: color 0.3s ease, border-color 0.3s ease;
            z-index: 10;
        }

        #togglePassword:hover {
            color: #E47A2E;
            border-color: #E47A2E;
        }

        .btn-login {
            width: 100%;
            height: 50px;
            background: #E47A2E;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-login:hover {
            background: #d66a26;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me input {
            margin-left: 10px;
            margin-right: 0;
        }

        .back-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-home a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        .back-home a:hover {
            color: #E47A2E;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .image-side {
                height: 200px;
                flex: none;
            }

            .login-box {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="image-side"></div>
        <div class="login-side">
            <div class="login-box">
                <div class="site-name">وكالة صوت غزة الإخبارية</div>
                <form id="loginForm">
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" placeholder="البريد الإلكتروني" required />
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" placeholder="كلمة المرور"
                                required />
                            <div class="input-group-append">
                                <button type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="remember-me">
                        <input type="checkbox" id="rememberMe" />
                        <label for="rememberMe">تذكرني</label>
                    </div>
                    <button type="submit" class="btn-login">تسجيل الدخول</button>
                </form>
                <div class="back-home">
                    <a href="index.html">العودة إلى الصفحة الرئيسية</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

    <!-- Template Javascript -->
    <script src="/front/js/main.js"></script>

    <script>
        $(document).ready(function () {
            $('#togglePassword').click(function () {
                const passwordInput = $('#password');
                const icon = $(this).find('i');
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            $('#loginForm').submit(function (e) {
                e.preventDefault();
                // Placeholder for login logic
                alert('Login functionality not implemented yet.');
            });
        });
    </script>
</body>

</html>