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
    <div class="title">Bienvenido a Draco</div>
</div>

<div class="divider"></div>

<h3>Enhorabuena {{ $name }}</h3>

<p>
Te has registrado satisfactoriamente en Draco.<br><br>

A partir de ahora puedes acceder a todas las funcionalidades de la plataforma y comenzar a probar tus conocimientos sobre tus temas favoritos.

Si no has sido tú quien ha realizado este registro, ignora este correo.
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
