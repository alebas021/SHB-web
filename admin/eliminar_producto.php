<?php
include 'header.php'; // $pdo y verificación de sesión ya están incluidos

$id = (int)$_GET['id'];

// Obtener la ruta de la imagen del producto
$stmt = $pdo->prepare("SELECT imagen FROM productos WHERE id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch();

if ($producto) {
    // Construir ruta absoluta segura
    $imagenPath = realpath(__DIR__ . '/../' . $producto['imagen']);

    // Borrar registro de la base de datos
    $stmtDel = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmtDel->execute([$id]);

    // Borrar archivo físico si existe
    if ($imagenPath && file_exists($imagenPath)) {
        unlink($imagenPath);
    }
}

// Redirigir a la lista de productos
header('Location: productos.php');
exit;
?>
