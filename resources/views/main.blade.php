<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
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
            font-size: 3rem;
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

        /* Navegación */
        nav {
            max-width: 900px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        nav:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1.2rem;
        }

        nav ul li {
            transition: all 0.3s ease;
        }

        nav ul li a {
            text-decoration: none;
            color: #4a6cf7;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
        }

        nav ul li a::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #4a6cf7, #6e8dfb);
            transition: width 0.3s, left 0.3s;
            transform: translateY(5px);
            border-radius: 2px;
        }

        nav ul li a:hover {
            color: #1e40af;
            background-color: rgba(74, 108, 247, 0.08);
            transform: translateY(-2px);
        }

        nav ul li a:hover::after {
            width: 80%;
            left: 10%;
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            h1 {
                font-size: 2.2rem;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
            }

            nav ul li {
                width: 100%;
                text-align: center;
            }

            nav ul li a {
                display: block;
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <h1>Main Page</h1>
    <nav>
        <ul>
            <li><a href="/books">Books</a></li>
            <li><a href="/authors">Authors</a></li>
            <li><a href="/publishers">Publishers</a></li>
            <li><a href="/contact">Agregar contacto</a></li>
        </ul>
    </nav>
</body>

</html>