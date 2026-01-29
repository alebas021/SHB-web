<?php
// admin/agregar_producto.php
include 'header.php'; // debe incluir ../conexion.php y validar sesión

$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = trim($_POST['precio'] ?? '');
    $categoria = intval($_POST['categoria'] ?? 0);
    $descripcion = trim($_POST['descripcion'] ?? '');

    if (!$nombre || $precio === '' || !$categoria || !isset($_FILES['imagen'])) {
        $error = "Completa todos los campos y selecciona una imagen.";
    } else {
        $file = $_FILES['imagen'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error = "Error al subir la imagen (código {$file['error']}).";
        } else {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','webp'];
            if (!in_array($ext, $allowed)) {
                $error = "Formato no permitido. Usa JPG, PNG o WEBP.";
            } else {
                // Nombre único
                $nombreArchivo = uniqid('prod_', true) . '.' . $ext;
                $rutaRelativaDB = "imagenes/productos/" . $nombreArchivo; // lo que guardamos en DB
                $destinoFisico = __DIR__ . "/../" . $rutaRelativaDB; // desde admin/

                // Intentar mover
                if (!move_uploaded_file($file['tmp_name'], $destinoFisico)) {
                    $error = "No se pudo mover la imagen al destino. Revisa permisos en la carpeta imagenes/productos.";
                } else {
                    // Insertar en BD
                    $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, imagen, categoria_id) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$nombre, $descripcion, $precio, $rutaRelativaDB, $categoria]);

                    // Redirect al listado (o mostrar success)
                    header("Location: productos.php?added=1");
                    exit;
                }
            }
        }
    }
}

// Obtener categorías para el select
$stmtCat = $pdo->query("SELECT * FROM categorias ORDER BY nombre ASC");
$categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="form-wrapper">
  <div class="form-card">
    <h2 class="form-title">Agregar Producto</h2>

    <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="admin-form">
      <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" required value="<?= isset($nombre) ? htmlspecialchars($nombre) : '' ?>">
      </div>

      <div class="form-group">
        <label>Descripción</label>
        <textarea name="descripcion" rows="3"><?= isset($descripcion) ? htmlspecialchars($descripcion) : '' ?></textarea>
      </div>

      <div class="form-group">
        <label>Precio</label>
        <input type="number" step="0.01" name="precio" required value="<?= isset($precio) ? htmlspecialchars($precio) : '' ?>">
      </div>

      <div class="form-group">
        <label>Categoría</label>
        <select name="categoria" required>
          <option value="">Selecciona una categoría</option>
          <?php foreach($categorias as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label>Imagen</label>
        <input type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp" required>
      </div>

      <button type="submit" class="btn-submit">Agregar Producto</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
