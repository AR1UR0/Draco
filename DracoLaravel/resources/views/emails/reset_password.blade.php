<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
body {
    font-family: Arial, sans-serif;
    background:#f4f4f4;
    padding:20px;
}

.container {
    max-width:600px;
    margin:auto;
    background:white;
    padding:30px;
}

.header {
    text-align:center;
    margin-bottom:20px;
}

.header img {
    width:80px;
}

.title {
    font-size:22px;
    font-weight:bold;
    margin-top:10px;
}

.divider {
    border-top:1px solid #ddd;
    margin:25px 0;
}

.footer {
    font-size:12px;
    color:#777;
    margin-top:30px;
    text-align:center;
}
</style>
</head>

<body>

<div class="container">

<div class="header">
    <img src="{{ $logo }}" alt="Draco">
    <div class="title">Recupera tu contraseña</div>
</div>

<div class="divider"></div>

<h3>Hola {{ $name }}</h3>

<p>
Hemos recibido una solicitud para restablecer tu contraseña.<br><br>

Haz clic en el siguiente botón para cambiar tu contraseña:
</p>

<p style="text-align:center;">
    <a href="{{ $url }}" style="background:#98b705;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">Restablecer Contraseña</a>
</p>

<p>
Si no solicitaste este cambio, ignora este correo.
</p>

<div class="divider"></div>

<div class="footer">
Este correo ha sido enviado automáticamente por Draco.<br>
No respondas a este mensaje.<br><br>
© {{ date('Y') }} Draco — Todos los derechos reservados.
</div>

</div>

</body>
</html>
