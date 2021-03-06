<!DOCTYPE html>
<html lang="{{ $site_locale }}">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Chào mừng bạn đến với chúng tôi</h2>
<div>
    Cảm ơn {{ $name }} đã tham gia cộng đồng <a href="{{ homeURL($site_locale) }}">{{ $site_name }}</a>.<br>
    Bạn có thể sử dụng tài khoản {{ $provider }} hiện tại để truy cập các dịch vụ của chúng tôi.<br>
    Hoặc bạn có thể đăng nhập với thông tin người dùng tương ứng mà hệ thống tự động tạo ra như bên dưới:<br>
    - Hộp thư điện tử: {{ $email }}<br>
    - Mật khẩu: {{ $password }}<br>
    <br>
    <br>
    Trân trọng,<br>
    {{ $site_name }} Team
</div>
</body>
</html>
