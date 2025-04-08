<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "destiny");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consultar 3 lugares aleatorios
$sql_recomendados = "SELECT id_lugar, Nombre, Imagen FROM lugares ORDER BY RAND() LIMIT 3";
$query_recomendados = $conn->query($sql_recomendados);

// Manejo de la búsqueda
$resultados = [];
if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
    $busqueda = $conn->real_escape_string($_GET['busqueda']);
    $sql = "SELECT * FROM lugares WHERE Nombre LIKE '%$busqueda%' OR Descripcion LIKE '%$busqueda%'";
    $query = $conn->query($sql);
    if ($query->num_rows > 0) {
        $resultados = $query->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Reservas de Lugares</title>
    <link rel="stylesheet" href="estilos_principal.css">
</head>
<body>

<header>   
    <div class="header-container"> 
        <div class="logo">
            <a href="index.php">
                <img src="/imagen_del_proyecto_final/image.png" alt="Logo" width="100" height="100">
            </a>
        </div>
        <h1>DESTINY</h1>
        <div class="user-actions">
    <?php if (isset($_SESSION['id_usuario'])): ?>
        <a href="ver_reservas.php" class="reservas-link">Mis Reservas</a>
        <a href="logout.php" class="logout-link">Cerrar Sesión</a>
    <?php else: ?>
        <a href="Inicio_de_sesion.html" class="login-link">Iniciar Sesión</a>
        <a href="registrate.html" class="register-link">Registrarse</a>
    <?php endif; ?>
</div>
    </div>
</header>

<!-- Barra de búsqueda -->
<div class="search-container">
    <form method="GET" action="Pagina_principal.php">
        <input type="text" name="busqueda" placeholder="Busca un lugar (e.g., restaurantes, zoo´s)" value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
        <button type="submit">Buscar</button>
    </form>
</div>

<!-- Opciones de usuario -->


<!-- Resultados de búsqueda -->
<?php if (!empty($resultados)): ?>
    <div class="search-results">
        <h2>Resultados de la búsqueda:</h2>
        <ul>
            <?php foreach ($resultados as $lugar): ?>
                     
                <li class="ulz">
                    <img src="<?php echo htmlspecialchars($lugar['Imagen']); ?>" alt="Imagen del lugar" width="60" height="60">
                    <a href="detalle_lugar.php?id_lugar=<?php echo $lugar['id_lugar']; ?>">
                        <strong><?php echo htmlspecialchars($lugar['Nombre']); ?></strong>
                    </a><br>
                    <span><?php echo htmlspecialchars($lugar['Descripcion']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php elseif (isset($_GET['busqueda']) && empty($resultados)): ?>
    <div class="search-results">
        <p>No se encontraron resultados para "<?php echo htmlspecialchars($_GET['busqueda']); ?>".</p>
    </div>
<?php endif; ?>

<!-- Lugares recomendados -->
<div class="recommended-places">
    <h2>Lugares Recomendados</h2>
    <?php if ($query_recomendados->num_rows > 0): ?>
        <?php while ($lugar = $query_recomendados->fetch_assoc()): ?>
            <div class="place-card">
                <img src="<?php echo htmlspecialchars($lugar['Imagen']); ?>" alt="Imagen del lugar" width="80" height="80">
                <div>
                    <a href="detalle_lugar.php?id_lugar=<?php echo $lugar['id_lugar']; ?>">
                        <?php echo htmlspecialchars($lugar['Nombre']); ?>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No hay lugares recomendados disponibles en este momento.</p>
    <?php endif; ?>
</div>

</body>
</html>
