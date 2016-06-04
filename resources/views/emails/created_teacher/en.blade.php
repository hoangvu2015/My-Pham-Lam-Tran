<!DOCTYPE html>
<html>
<head lang="{{ $site_locale }}">
    <meta charset="utf-8">
</head>
<body>
<h2>Hello {{ $name }}</h2>

<div>
    You've been approved to be a teacher of <a href="{{ homeURL($site_locale) }}">{{ $site_name }}</a>.<br>
    You can log in the site now with this following information:<br>
    - Email: {{ $email }}<br>
    - Password: {{ $password }}<br>
    <br>
    <h3>Congratulation!</h3>
    <br>
    Best regards,<br>
    From {{ $site_name }} Team
</div>
</body>
</html>
