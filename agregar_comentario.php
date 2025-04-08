<?php
session_start();
require_once 'conexion.php'; // Asegúrate de tener tu archivo de conexión a la base de datos.

// Verificar si hay un inicio de sesión activo
if (!isset($_SESSION['id_usuario'])) {
    header('Location: inicio_de_sesion.html');
    exit();
}

// Verificar si se ha enviado un comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lugar = isset($_POST['id_lugar']) ? (int)$_POST['id_lugar'] : 0;
    $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : '';

    if (empty($comentario)) {
        echo "El comentario no puede estar vacío.";
        exit();
    }

    if (strlen($comentario) > 400) {
        echo "El comentario supera el límite de 400 caracteres.";
        exit();
    }

    // Obtener el id del usuario desde la sesión
    $id_usuario = $_SESSION['id_usuario'];

    // Insertar el comentario en la base de datos
    $query_comentario = "INSERT INTO opiniones (id_usuario, id_lugar, comentario, fecha) VALUES (?, ?, ?, NOW())";
    $stmt_comentario = $conn->prepare($query_comentario);
    $stmt_comentario->bind_param('iis', $id_usuario, $id_lugar, $comentario);

    if ($stmt_comentario->execute()) {
        echo "<script>
        alert('Comentario enviado con éxito.');
        window.location.href = 'detalles_lugar.php?id_lugar=$id_lugar';
    </script>";
    } else {
        echo "<script>
            alert('Error al enviar el comentario. Inténtalo de nuevo más tarde.');
            window.history.back();
        </script>";
    }
}
?>