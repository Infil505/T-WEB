<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Contacto</title>
    <style>
        /* Fuentes */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        /* Reseteo y estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 2rem;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #e4eaec 100%);
        }

        /* Encabezado */
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            color: #2c3e50;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            padding-bottom: 0.5rem;
        }

        h1::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #4a6cf7, #6e8dfb);
            border-radius: 2px;
        }

        /* Contenedor de información */
        .info-container {
            max-width: 600px;
            margin: 0 auto 2rem auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        /* Información de contacto */
        .info-container p {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eaeaea;
            font-size: 1.1rem;
        }

        .info-container p:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-container p strong {
            color: #2c3e50;
            font-weight: 600;
            display: inline-block;
            width: 100px;
        }

        /* Enlaces */
        .link-container {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        .btn {
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            text-align: center;
            flex: 1;
        }

        .btn-primary {
            background: linear-gradient(90deg, #4a6cf7, #6e8dfb);
            color: white;
            box-shadow: 0 4px 12px rgba(74, 108, 247, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #3a5ce5, #5e7deb);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(74, 108, 247, 0.3);
        }

        .btn-secondary {
            background-color: white;
            color: #4a6cf7;
            border: 2px solid #4a6cf7;
        }

        .btn-secondary:hover {
            background-color: rgba(74, 108, 247, 0.08);
            transform: translateY(-2px);
        }

        .btn.back::before {
            content: "←";
            margin-right: 8px;
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            .info-container,
            .link-container {
                padding: 1.5rem;
            }

            .link-container {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <h1>Información de Contacto Ingresada</h1>

    <div class="info-container">
        <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
        <p><strong>Teléfono:</strong> {{ $data['phone'] }}</p>
        <p><strong>Dirección:</strong> {{ $data['address'] }}</p>
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
    </div>

    <div class="link-container">
        <a href="/contact" class="btn btn-secondary back">Volver al formulario</a>
        <a href="/" class="btn btn-primary">Ir a la página principal</a>
    </div>
</body>

</html>