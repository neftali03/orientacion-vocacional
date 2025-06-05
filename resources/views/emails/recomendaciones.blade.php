<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recomendaciones de carrera</title>
</head>
<body>
    <h2>Hola aspirante,</h2>
    <p>Según tu evaluación vocacional, estas son las carreras recomendadas para ti:</p>
    <ul>
        @foreach ($careers as $career)
            <li>
                <strong>{{ $career['name'] }}</strong><br>
                {{ $career['description'] ?? 'Sin descripción' }}<br>
                @if (!empty($career['portalUrl']))
                    <a href="{{ $career['portalUrl'] }}">{{ $career['portalUrl'] }}</a>
                @endif
            </li>
            <br>
        @endforeach
    </ul>
    <p>¡Te deseamos mucho éxito!</p>
    <p>Atentamente,<br>Equipo de ITCA</p>
</body>
</html>
