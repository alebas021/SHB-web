<?php
// admin/editar_producto.php
include 'header.php'; // carga $pdo y valida sesión automáticamente

// ===============================
// VALIDAR ID DEL PRODUCTO
// ===============================
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: productos.php");
    exit;
}

// ===============================
// OBTENER DATOS DEL PRODUCTO
// ===============================
$stmtProd = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
$stmtProd->execute([$id]);
$producto = $stmtProd->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    header("Location: productos.php");
    exit;
}

// ===============================
// OBTENER CATEGORÍAS
// ===============================
$stmtCat = $pdo->query("SELECT * FROM categorias ORDER BY nombre ASC");
$categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

$error = "";
$success = "";

// ===============================
// SI ENVIARON EL FORMULARIO
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $precio = trim($_POST['precio'] ?? '');
    $categoria = intval($_POST['categoria'] ?? 0);
    $descripcion = trim($_POST['descripcion'] ?? '');

    if (!$nombre || $precio === '' || !$categoria) {
        $error = "Completa los campos obligatorios.";
    } else {

        $pdo->beginTransaction();

        try {
            // Imagen por defecto → la ya existente
            $imagenDB = $producto['imagen'];

            // ===============================
            // SI SUBIERON UNA NUEVA IMAGEN
            // ===============================
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                
                $file = $_FILES['imagen'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($ext, $allowed)) {
                    throw new Exception("Formato de imagen no permitido.");
                }

                $nuevoNombre = uniqid('prod_', true) . '.' . $ext;
                $rutaRelativaDB = "imagenes/productos/" . $nuevoNombre;
                $destinoFisico = __DIR__ . "/../" . $rutaRelativaDB;

                if (!move_uploaded_file($file['tmp_name'], $destinoFisico)) {
                    throw new Exception("Error al subir la nueva imagen.");
                }

                // Borrar la imagen anterior
                if (!empty($producto['imagen'])) {
                    $antigua = __DIR__ . "/../" . $producto['imagen'];
                    if (file_exists($antigua)) {
                        unlink($antigua);
                    }
                }

                $imagenDB = $rutaRelativaDB;
            }

            // ===============================
            // ACTUALIZAR REGISTRO
            // ===============================
            $stmtUpd = $pdo->prepare("
                UPDATE productos 
                SET nombre = ?, descripcion = ?, precio = ?, imagen = ?, categoria_id = ?
                WHERE id = ?
            ");

            $stmtUpd->execute([
                $nombre,
                $descripcion,
                $precio,
                $imagenDB,
                $categoria,
                $id
            ]);

            $pdo->commit();

            header("Location: productos.php?edited=1");
            exit;

        } catch (Exception $e) {
            $pdo->rollBack();
            $error = $e->getMessage();
        }
    }
}
?>

<!-- ===============================
     FORMULARIO
=============================== -->
<div class="form-wrapper">
    <div class="form-card">
        <h2 class="form-title">Editar Producto</h2>

        <?php if ($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" required
                       value="<?= htmlspecialchars($producto['nombre']) ?>">
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" rows="4"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Precio ($)</label>
                <input type="number" step="0.01" name="precio" required
                       value="<?= htmlspecialchars($producto['precio']) ?>">
            </div>

            <div class="form-group">
                <label>Categoría</label>
                <select name="categoria" required>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?= $cat['id'] == $producto['categoria_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Imagen actual</label><br>

                <?php 
                $rutaImagen = __DIR__ . "/../" . $producto['imagen'];
                if (!empty($producto['imagen']) && file_exists($rutaImagen)): 
                ?>
                    <img src="../<?= htmlspecialchars($producto['imagen']) ?>" width="150" style="border-radius:6px;">
                <?php else: ?>
                    <p>No hay imagen disponible.</p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Subir nueva imagen (opcional)</label>
                <input type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp">
            </div>

            <button type="submit" class="btn-submit">Guardar Cambios</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>