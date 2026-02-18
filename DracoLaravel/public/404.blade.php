<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #1f2125; /* El color oscuro de tu imagen */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: sans-serif;
            color: white;
            text-align: center;
        }

        .error-container {
            max-width: 90%;
        }

        .error-container img {
            max-width: 100%;
            height: auto;
            /* Opcional: añade un ligero brillo para que resalte */
            filter: drop-shadow(0 0 10px rgba(255, 0, 128, 0.2));
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #ff0080; /* El rosa del dragón */
            text-decoration: none;
            font-weight: bold;
            font-size: 0.9rem;
            opacity: 0.7;
            transition: opacity 0.3s;
        }

        .back-link:hover {
            opacity: 1;
        }
    </style>
</head>
<body>

    <div class="error-container">
        <img src="{{ asset('media/404.png') }}" alt="Error 404 - Draco Project">
        
        <a href="/" class="back-link">← Volver a la guarida</a>
    </div>

</body>
</html>