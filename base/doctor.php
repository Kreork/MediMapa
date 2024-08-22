<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "paginaweb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT Id_Doc, Nombre, Ape_Pat, Ape_Mat, Telefono, Especialidad, CP, Direccion, Municipio, Estado FROM doctor";
$resultado = $conn->query($sql);

$conn->close();
?>
