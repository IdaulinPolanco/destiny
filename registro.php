<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "destiny";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $correo = $conn->real_escape_string($_POST['email']);
    $contraseña = $conn->real_escape_string($_POST['password']);
    $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);

    // Validar que las contraseñas coincidan
    if ($contraseña !== $confirmPassword) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.location.href='registrate.html';</script>";
        
        exit();
    }

    // Encriptar contraseña
    $hashedPassword = password_hash($contraseña, PASSWORD_DEFAULT);

    // Verificar que el correo no esté registrado
    $checkEmail = "SELECT * FROM usuarios WHERE Correo = '$correo'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "<script>alert('El correo ya está registrado.'); window.location.href='registrate.html';</script>";
        exit();
    }

    // Insertar datos en la base de datos
    $sql = "INSERT INTO usuarios (Nombre, Correo, Contraseña) VALUES ('$nombre', '$correo', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href='inicio_de_sesion.html';</script>";
    } else {
        echo "<script>alert('Error:  . $sql . <br> . $conn->error'); window.location.href='registrate.html';</script>";
    }

}

$conn->close();
?>