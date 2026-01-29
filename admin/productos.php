<?php
include 'header.php'; // Solo sesión y conexión limpia

// ------------------------
// Obtener categorías únicas
// ------------------------
// Evitamos duplicados directamente desde la BD
$stmtCat = $pdo->query("SELECT DISTINCT nombre, MIN(id) as id FROM categorias GROUP BY nombre ORDER BY nombre ASC");
$categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

// ------------------------
// Filtrado por categoría
// ------------------------
$filtroCat = $_GET['categoria'] ?? '';

// ------------------------
// Paginación
// ------------------------
$porPagina = 10;
$pagina = $_GET['pagina'] ?? 1;
$inicio = ($pagina - 1) * $porPagina;

// ------------------------
// Consulta productos con filtro opcional
// ------------------------
if ($filtroCat) {
    $stmtProd = $pdo->prepare("
        SELECT p.*, c.nombre AS categoria_nombre
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.categoria_id = ?
        ORDER BY p.nombre ASC
        LIMIT ?, ?
    ");
    $stmtProd->bindValue(1, $filtroCat, PDO::PARAM_INT);
    $stmtProd->bindValue(2, $inicio, PDO::PARAM_INT);
    $stmtProd->bindValue(3, $porPagina, PDO::PARAM_INT);
    $stmtProd->execute();
} else {
    $stmtProd = $pdo->prepare("
        SELECT p.*, c.nombre AS categoria_nombre
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
        ORDER BY p.nombre ASC
        LIMIT ?, ?
    ");
    $stmtProd->bindValue(1, $inicio, PDO::PARAM_INT);
    $stmtProd->bindValue(2, $porPagina, PDO::PARAM_INT);
    $stmtProd->execute();
}

$productos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);

// ------------------------
// Contar total para paginación
// ------------------------
if ($filtroCat) {
    $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM productos WHERE categoria_id = ?");
    $stmtCount->execute([$filtroCat]);
} else {
    $stmtCount = $pdo->query("SELECT COUNT(*) FROM productos");
}
$totalProductos = $stmtCount->fetchColumn();
$totalPaginas = ceil($totalProductos / $porPagina);
?>

<div class="admin-container">
    <!-- Sidebar categorías -->
    <aside class="admin-sidebar">
        <h3>Categorías</h3>
        <ul>
            <li><a href="productos.php">Todas</a></li>
            <?php foreach($categorias as $c): ?>
                <li>
                    <a href="productos.php?categoria=<?= $c['id'] ?>" class="<?= ($filtroCat == $c['id']) ? 'active' : '' ?>">
                        <?= htmlspecialchars($c['nombre']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <!-- Contenido productos -->
    <section class="admin-content">
        <h2>Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productos as $prod): ?>
                    <tr>
                        <td><img src="../<?= $prod['imagen'] ?>" width="60"></td>
                        <td><?= htmlspecialchars($prod['nombre']) ?></td>
                        <td>$<?= $prod['precio'] ?></td>
                        <td><?= htmlspecialchars($prod['categoria_nombre']) ?></td>
                        <td>
                            <a href="editar_producto.php?id=<?= $prod['id'] ?>" class="btn-edit">Editar</a>
                            <a href="eliminar_producto.php?id=<?= $prod['id'] ?>" class="btn-delete" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="pagination">
            <?php for($i=1; $i<=$totalPaginas; $i++): ?>
                <a href="?<?= $filtroCat ? 'categoria='.$filtroCat.'&' : '' ?>pagina=<?= $i ?>" class="<?= ($i==$pagina) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>