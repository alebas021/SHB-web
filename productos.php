<?php
include 'conexion.php';
include 'header.php';

$productosPorPagina = 12;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $productosPorPagina;

$terminoBusqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$categoriaSeleccionada = isset($_GET['categoria']) ? (int)$_GET['categoria'] : null;

// Obtener categorías
$stmtCat = $pdo->query("SELECT * FROM categorias ORDER BY nombre ASC");
$categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

// Construcción dinámica del SQL
$sqlBase = "FROM productos WHERE 1";
$parametros = [];

// Filtro por categoría
if ($categoriaSeleccionada) {
    $sqlBase .= " AND categoria_id = ?";
    $parametros[] = $categoriaSeleccionada;
}

// Filtro por búsqueda
if ($terminoBusqueda !== '') {
    $sqlBase .= " AND nombre LIKE ?";
    $parametros[] = "%$terminoBusqueda%";
}

// Total de productos filtrados
$stmtTotal = $pdo->prepare("SELECT COUNT(*) " . $sqlBase);
$stmtTotal->execute($parametros);
$totalProductos = $stmtTotal->fetchColumn();

$totalPaginas = ceil($totalProductos / $productosPorPagina);

// Obtener productos filtrados para la página actual
$sqlProductos = "SELECT * " . $sqlBase . " ORDER BY nombre ASC LIMIT $offset, $productosPorPagina";
$stmtProd = $pdo->prepare($sqlProductos);
$stmtProd->execute($parametros);
$productos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="productos-container">

    <aside class="sidebar">
        <h3>Categorías</h3>
        <ul>
            <li><a href="productos.php" class="<?= !$categoriaSeleccionada ? 'active' : '' ?>">Todos</a></li>

            <?php foreach ($categorias as $cat): ?>
                <li>
                    <a 
                        href="productos.php?categoria=<?= $cat['id'] ?>"
                        class="<?= ($categoriaSeleccionada == $cat['id']) ? 'active' : '' ?>"
                    >
                        <?= htmlspecialchars($cat['nombre']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <section class="productos-main">

        <h2>
            <?php
            if ($terminoBusqueda !== '') {
                echo "Resultados para: " . htmlspecialchars($terminoBusqueda);
            } elseif ($categoriaSeleccionada) {
                foreach ($categorias as $cat) {
                    if ($cat['id'] == $categoriaSeleccionada) {
                        echo "Productos de " . htmlspecialchars($cat['nombre']);
                        break;
                    }
                }
            } else {
                echo "Todos los productos";
            }
            ?>
        </h2>

        <?php if (empty($productos)): ?>
            <p style="margin-top:1rem;">No se encontraron productos.</p>

        <?php else: ?>

            <div class="products-grid">
                <?php foreach ($productos as $producto): ?>
                    <div class="product-card card-base">
                        <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="">
                        <h4><?= htmlspecialchars($producto['nombre']) ?></h4>
                        <p><?= htmlspecialchars($producto['descripcion']) ?></p>
                        <p><strong>$<?= htmlspecialchars($producto['precio']) ?></strong></p>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

        <!-- PAGINACIÓN -->
        <div class="pagination">
            <?php if ($paginaActual > 1): ?>
                <a href="productos.php?pagina=<?= $paginaActual - 1 ?>
                    <?= $categoriaSeleccionada ? '&categoria=' . $categoriaSeleccionada : '' ?>
                    <?= $terminoBusqueda ? '&buscar=' . urlencode($terminoBusqueda) : '' ?>">
                    Anterior
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <a 
                    href="productos.php?pagina=<?= $i ?>
                        <?= $categoriaSeleccionada ? '&categoria=' . $categoriaSeleccionada : '' ?>
                        <?= $terminoBusqueda ? '&buscar=' . urlencode($terminoBusqueda) : '' ?>"
                    class="<?= ($i == $paginaActual) ? 'active' : '' ?>"
                >
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($paginaActual < $totalPaginas): ?>
                <a href="productos.php?pagina=<?= $paginaActual + 1 ?>
                    <?= $categoriaSeleccionada ? '&categoria=' . $categoriaSeleccionada : '' ?>
                    <?= $terminoBusqueda ? '&buscar=' . urlencode($terminoBusqueda) : '' ?>">
                    Siguiente
                </a>
            <?php endif; ?>
        </div>

    </section>

</main>

<?php include 'footer.php'; ?>
