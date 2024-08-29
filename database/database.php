<?php
// Configuración de conexión a la base de datos
$servername = "localhost"; 
$username = "root";
$password = "admin";
$dbname = "serenity_space";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
