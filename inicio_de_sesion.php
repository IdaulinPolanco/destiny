<?php
// Iniciar la sesión
session_start();

// Configurar la conexión a la base de datos
$servername = "localhost";
$username = "root"; // Usualmente 'root' en XAMPP
$password = ""; // Sin contraseña por defecto en XAMPP
$dbname = "destiny"; // Nombre de  tu base de datos

// Conectar a MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'];
    $contrasena = $_POST['password'];

    // Consulta para verificar si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE Correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El usuario existe, ahora verificamos la contraseña
        $row = $result->fetch_assoc();

        // Comparamos la contraseña ingresada con la almacenada
        if (password_verify($contrasena, $row['Contraseña'])) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['id_usuario'] = $row['id_usuario']; // Guardar el ID del usuario en la sesión
            $_SESSION['Nombre'] = $row['Nombre']; // Guardar el nombre del usuario en la sesión
            $_SESSION['Correo'] = $row['Correo']; // Guardar el correo del usuario en la sesión

            // Redirigir a la página principal
            header("Location: index.php");
            exit();
        } else {
            // Contraseña incorrecta
            echo "<script>alert('Contraseña incorrecta'); window.location.href='inicio_de_sesion.html';</script>";
        }
    } else {
        // El usuario no existe
        echo "<script>alert('El usuario no existe'); window.location.href='inicio_de_sesion.html';</script>";
    }
}

// Cerrar la conexión
$conn->close();
?>
