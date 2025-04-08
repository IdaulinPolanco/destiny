<?php 
session_start();
require_once 'conexion.php'; // Asegúrate de tener tu archivo de conexión a la base de datos.

// Verificar si hay un inicio de sesión activo
if (!isset($_SESSION['id_usuario'])) {
    header('Location: inicio_de_sesion.html');
    exit();
}

// Obtener el id del lugar desde el parámetro GET
if (!isset($_GET['id_lugar'])) {
    echo "Lugar no especificado.";
    exit();
}

$id_lugar = (int)$_GET['id_lugar'];

// Obtener detalles del lugar
$query_lugar = "SELECT * FROM lugares WHERE id_lugar = ?";
$stmt_lugar = $conn->prepare($query_lugar);
$stmt_lugar->bind_param('i', $id_lugar);
$stmt_lugar->execute();
$result_lugar = $stmt_lugar->get_result();
$lugar = $result_lugar->fetch_assoc();

if (!$lugar) {
    echo "Lugar no encontrado.";
    exit();
}

$mensaje = ""; // Variable para almacenar mensajes al usuario

// Manejar la reserva
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservar'])) {
    $fecha_reserva = $_POST['fecha_reserva'];
    $hora_reserva = $_POST['hora_reserva'];
    $cantidad_personas = (int)$_POST['cantidad_personas'];
    $id_usuario = $_SESSION['id_usuario'];

    // Verificar si ya existe una reserva para la misma fecha y hora
    $query_verificar = "SELECT COUNT(*) AS total FROM reserva WHERE id_lugar = ? AND fecha_reserva = ? AND hora_reserva = ?";
    $stmt_verificar = $conn->prepare($query_verificar);
    $stmt_verificar->bind_param('iss', $id_lugar, $fecha_reserva, $hora_reserva);
    $stmt_verificar->execute();
    $result_verificar = $stmt_verificar->get_result();
    $row_verificar = $result_verificar->fetch_assoc();

    if ($row_verificar['total'] > 0) {
        // Ya existe una reserva para la misma fecha y hora
        $mensaje = "<p style='color: red;'>Ya existe una reserva para esta fecha y hora. Por favor, elige otro horario.</p>";
    } else {
        // Insertar la nueva reserva
        $query_reserva = "INSERT INTO reserva (id_usuario, id_lugar, fecha_reserva, hora_reserva, cantidad_personas, creacion) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt_reserva = $conn->prepare($query_reserva);
        $stmt_reserva->bind_param('iissi', $id_usuario, $id_lugar, $fecha_reserva, $hora_reserva, $cantidad_personas);

        if ($stmt_reserva->execute()) {
            $mensaje = "<p style='color: green;'>Reserva realizada con éxito.</p>";
        } else {
            $mensaje = "<p style='color: red;'>Error al realizar la reserva.</p>";
        }
    }
}

// Obtener comentarios del lugar
$query_opiniones = "SELECT o.comentario, o.fecha, u.nombre AS usuario FROM opiniones o INNER JOIN usuarios u ON o.id_usuario = u.id_usuario WHERE o.id_lugar = ? ORDER BY o.fecha DESC";
$stmt_opiniones = $conn->prepare($query_opiniones);
$stmt_opiniones->bind_param('i', $id_lugar);
$stmt_opiniones->execute();
$result_opiniones = $stmt_opiniones->get_result();
$opiniones = $result_opiniones->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($lugar['Nombre']); ?></title>
    <link rel="stylesheet" href="http://localhost/estilos_detalle.css">
</head>
<header>   
    <div class="header-container"> 
        <div class="logo">
            <a href="Pagina_principal.php">
                <img src="/imagen_del_proyecto_final/image.png" alt="Logo" width="100" height="100">
            </a>
        </div>
        <h1>Reservas de Lugares</h1>
        <div class="user-actions">
    <?php if (isset($_SESSION['id_usuario'])): ?>
        <a href="ver_reservas.php" class="reservas-link">Mis Reservas</a>
        <a href="logout.php" class="logout-link">Cerrar Sesión</a>
    <?php endif; ?>
</div>
    </div>
</header>
<body>
    <h1><?php echo htmlspecialchars($lugar['Nombre']); ?></h1>
    <img src="<?php echo htmlspecialchars($lugar['Imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($lugar['Nombre']); ?>">
    <div class="ege"><p><?php echo htmlspecialchars($lugar['Descripcion']); ?></p>
    <p>Capacidad máxima: <?php echo $lugar['Capacidad_Maxima']; ?></p>
    <p>Horario: <?php echo $lugar['Horario_Apertura']; ?> - <?php echo $lugar['Horario_Cierre']; ?></p>
</div>
    <h2>Reservar</h2>
    <?php echo $mensaje; // Mostrar mensajes al usuario ?>
    <form method="POST">
        <label for="fecha_reserva">Fecha:</label>
        <input type="date" name="fecha_reserva" id="fecha_reserva" required>

        <label for="hora_reserva">Hora:</label>
        <input type="time" name="hora_reserva" id="hora_reserva" required>

        <label for="cantidad_personas">Cantidad de personas:</label>
        <input type="number" name="cantidad_personas" id="cantidad_personas" min="1" max="<?php echo $lugar['Capacidad_Maxima']; ?>" required>

        <button type="submit" name="reservar">Reservar</button>
    </form>

    <h2>Agregar comentario</h2>
    <form method="POST" action="agregar_comentario.php">
        <input type="hidden" name="id_lugar" value="<?php echo $id_lugar; ?>">
        <label for="comentario">Comentario (máximo 400 caracteres):</label>
        <textarea name="comentario" id="comentario" maxlength="400" required></textarea>
        <button type="submit">Enviar comentario</button>
    </form>
    <h2>Comentarios</h2>
    <?php if ($opiniones): ?>
        <ul>
            <?php foreach ($opiniones as $opinion): ?>
                <li>
                    <p><strong><?php echo htmlspecialchars($opinion['usuario']); ?>:</strong> <?php echo htmlspecialchars($opinion['comentario']); ?></p>
                    <p><small><?php echo htmlspecialchars($opinion['fecha']); ?></small></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay comentarios para este lugar.</p>
    <?php endif; ?>
</body>
</html>
