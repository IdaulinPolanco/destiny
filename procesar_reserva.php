<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "destiny";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Validar que se usó el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $cantidad_personas = $_POST['cantidad_personas'];
    $fecha_reserva = $_POST['fecha_reserva'];
    $hora_reserva = $_POST['hora_reserva'];

    // Asociar la reserva al usuario actual
    $id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : NULL;

    // ID del lugar (puedes cambiar este valor según sea necesario)
    $id_lugar = 1; // Ejemplo: ID del restaurante específico

    // Crear consulta SQL
    $sql = "INSERT INTO reserva (id_usuario, id_lugar, fecha_reserva, hora_reserva, cantidad_personas, creacion) 
            VALUES (?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $id_usuario, $id_lugar, $fecha_reserva, $hora_reserva, $cantidad_personas);

    // Ejecutar consulta
    if ($stmt->execute()) {
        echo "<script>
                alert('Reserva guardada exitosamente.');
                window.location.href = document.referrer; // Volver a la página anterior
              </script>";
    } else {
        echo "<script>
                alert('Error al guardar la reserva: " . $conn->error . "');
                window.location.href = document.referrer; // Volver a la página anterior
              </script>";
    }

    // Cerrar declaración y conexión
    $stmt->close();
    $conn->close();
} else {
    echo "<script>
            alert('Acceso no permitido.');
            window.location.href = document.referrer; // Volver a la página anterior
          </script>";
}
?>
