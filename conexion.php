<?php
// Datos de conexión
$host = 'localhost';      // Dirección del servidor MySQL
$user = 'u997453123_idaulin';           // Usuario de MySQL (por defecto en XAMPP es 'root')
$password = 'Mochigato03022006';           // Contraseña (en XAMPP está vacía por defecto)
$database = 'u997453123_destiny';    // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>