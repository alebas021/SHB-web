<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SHBasmadji</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <div class="container header-top">

        <div class="logo-area">
            <a href="index.php" class="logo-link">
                <img src="imagenes/surtihogar03.png" alt="Logo SHB" class="logo-img">
            </a>
        </div>

        <form action="productos.php" method="get" class="search-bar">
            <input type="text" name="buscar" id="buscar" placeholder="Buscar productos..." required>
            <button type="submit">Buscar</button>
        </form>

    </div>

    <nav class="main-nav simple-nav">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>
</header>