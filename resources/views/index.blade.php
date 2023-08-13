<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Training Ground - Online Shop</title>
    </head>
    <body>
        <ul>
            <li><a href="{{ config('app.url') }}/docs" target="_blank">API Documentation (Swagger UI)</a></li>
            <li><a href="http://localhost:{{ config('forward.phpmyadmin_port') }}" target="_blank">PhpMyAdmin</a></li>
            <li><a href="http://localhost:{{ config('forward.mail_ui_port') }}" target="_blank">MailPit</a></li>
            <li><a href="{{ config('frontend.url') }}" target="_blank">Frontend Application</a></li>
        </ul>
    </body>
</html>