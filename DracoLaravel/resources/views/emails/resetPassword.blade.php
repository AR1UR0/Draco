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

.button {
    display:inline-block;
    padding:12px 20px;
    background:#4CAF50;
    color:white;
    text-decoration:none;
    margin-top:20px;
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
    <div class="title">Recuperar contraseña</div>
</div>

<div class="divider"></div>

<h3>Hola {{ $name }}</h3>

<p>
Hemos recibido una solicitud para restablecer tu contraseña.<br><br>

Pulsa en el siguiente botón para crear una nueva contraseña:
</p>

<a href="{{ $url }}" class="button">Restablecer contraseña</a>

<p style="margin-top:20px;">
Si no has solicitado este cambio, puedes ignorar este correo.
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
