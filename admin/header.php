<?php
session_start();
include '../conexion.php'; // Ruta a la conexión de la BD

// Verificar sesión de admin
if(!isset($_SESSION['admin'])){
    header("Location: index.php"); // Redirige al login si no hay sesión
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
<header class="admin-header">
    <div class="container">
        <h1>Panel Admin</h1>
        <div class="admin-buttons">
            <a href="productos.php" class="btn btn-products">Productos</a>
            <a href="agregar_producto.php" class="btn btn-add">Agregar Producto</a>
            <a href="logout.php" class="btn btn-logout">Cerrar Sesión</a>
        </div>
    </div>
</header>
<main class="admin-main">