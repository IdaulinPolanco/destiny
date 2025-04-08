<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: inicio_de_sesion.html");
    exit();
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "destiny");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'];

// Consultar las reservas del usuario
$sql_reservas = "SELECT r.id_reserva, r.fecha_reserva, r.hora_reserva, r.cantidad_personas, r.creacion, l.Nombre
                 FROM reserva r 
                 INNER JOIN lugares l ON r.id_lugar = l.id_lugar 
                 WHERE r.id_usuario = ? 
                 ORDER BY r.creacion DESC";
$stmt = $conn->prepare($sql_reservas);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado_reservas = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="estilos_ver.css">
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo">
            <a href="index.php">
                <img src="/imagen_del_proyecto_final/image.png" alt="Logo" width="100" height="100">
            </a>
        </div>
        <h1>Mis Reservas</h1>
        <div class="back-link">
    <a href="index.php" class="link">Volver a la página principal</a>
</div>
    </div>
</header>

<div class="reservas-container">
    <h2>Tus Reservas</h2><br>
    

    <?php if ($resultado_reservas->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Lugar</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Personas</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($reserva = $resultado_reservas->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['fecha_reserva']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['hora_reserva']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['cantidad_personas']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['creacion']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes reservas registradas.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php
// Cerrar la conexión
$stmt->close();
$conn->close();
?>
