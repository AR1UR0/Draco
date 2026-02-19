<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .box { border: 2px solid #98b705; padding: 20px; border-radius: 10px; max-width: 500px; }
        .pass { font-size: 20px; font-weight: bold; color: #98b705; background: #f4f4f4; padding: 10px; display: inline-block; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Hola, {{ $name }}</h2>
        <p>Has solicitado restablecer tu contraseña en Draco.</p>
        <p>Tu nueva contraseña temporal es:</p>
        <div class="pass">{{ $password }}</div>
        <p>Usa esta contraseña para entrar. <strong>Próximamente</strong> habilitaremos la opción de cambiarla desde tu perfil para que pongas una de tu elección.</p>
        <p>¡Nos vemos en los tests!</p>
    </div>
</body>
</html>