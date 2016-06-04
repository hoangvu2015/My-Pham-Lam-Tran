<!DOCTYPE html>
<html>
<head lang="{{ $site_locale }}">
    <meta charset="utf-8">
</head>
<body>
<h2>Chào {{ $name }}</h2>

<div>
    Bạn đã được tạo tài khoản giáo viên tại <a href="{{ homeURL($site_locale) }}">{{ $site_name }}</a>.<br>
    Để bắt đầu sử dụng, hãy truy cập trang web và đăng nhập với thông tin bên dưới:<br>
    - Hộp thư điện tử: {{ $email }}<br>
    - Mật khẩu: {{ $password }}<br>
    <br>
    <h3>Xin chức mừng!</h3>
    <br>
    Trân trọng,<br>
    {{ $site_name }} Team
</div>
</body>
</html>
