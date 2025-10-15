<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado | SIGCAP</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .navbar {
            background-color: #1976d2;
            padding: 15px 40px;
            color: white;
            display: flex;
            align-items: center;
        }

        .navbar img {
            height: 50px;
            margin-right: 15px;
        }

        .navbar h1 {
            font-size: 20px;
            margin: 0;
            font-weight: 500;
        }

        .container {
            text-align: center;
            margin-top: 100px;
        }

        .card {
            display: inline-block;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 40px 60px;
            max-width: 600px;
        }

        .code {
            font-size: 100px;
            color: #1976d2;
            font-weight: 700;
            margin: 0;
        }

        .message {
            font-size: 20px;
            margin-top: 10px;
            color: #555;
        }

        .details {
            margin-top: 15px;
            color: #777;
        }

        a.btn {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 25px;
            background-color: #1976d2;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }

        a.btn:hover {
            background-color: #125ea2;
        }
        
    </style>
</head>
<body>

    <div class="navbar" style="background:#1C77B9!important;padding:0.5rem 1rem">
        <a href="{{ route('frontend.index') }}" class="navbar-brand_">
			<img src="<?php echo URL::to('/') ?>/img/logo-sin-fondo2.png" alt="" style="padding:0px;margin:0px;width:180px;height:70px">
		</a>
    </div>

    <div class="container">
        <div class="card">
            <div class="code">403</div>
            <div class="message">Acceso denegado</div>
            <div class="details">No tiene permisos para acceder a esta sección del sistema.</div>
            <a href="{{ url('/') }}" class="btn">Volver al inicio</a>
        </div>
    </div>

</body>
</html>
