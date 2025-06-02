<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Respuesta de DeepSeek</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color: #f5f5f5;
        }

        .card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .titulo {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .respuesta {
            font-size: 1.2rem;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="titulo">Respuesta de DeepSeek:</div>
        <div class="respuesta">{{ $respuesta }}</div>
    </div>
</body>
</html>
