<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "paginaweb";
$conexion = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el Id_Doc desde la solicitud GET
$Id_Doc = $_GET['Id_Doc'];

// Consulta SQL para obtener las opiniones del doctor específico
$query = "SELECT Nombre_Cliente, Comentario, Calificacion, Fecha FROM opinion WHERE Id_Doc = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $Id_Doc);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Crear un array para almacenar los comentarios
    $opiniones = [];
    while ($fila = $result->fetch_assoc()) {
        $opiniones[] = $fila;
    }
    // Devolver los comentarios en formato JSON
    echo json_encode($opiniones);
} else {
    echo json_encode([]);
}

// Cerrar la conexión
$conexion->close();
?>
