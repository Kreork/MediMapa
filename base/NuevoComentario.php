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

// Obtener los datos enviados desde el formulario
$Id_Doc = $_POST['Id_Doc'];
$nombreCliente = $_POST['nombreCliente'];
$comentario = $_POST['comentario'];
$calificacion = $_POST['calificacion'];
$fecha = $_POST['fecha'];

// Insertar el nuevo comentario en la base de datos
$query = "INSERT INTO opinion (Id_Doc, Nombre_Cliente, Comentario, Calificacion, Fecha) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($query);

// Verificar si la consulta preparada fue exitosa
if ($stmt) {
    // Vincular parámetros e insertar el nuevo comentario
    $stmt->bind_param("isiss", $Id_Doc, $nombreCliente, $comentario, $calificacion, $fecha);
    $stmt->execute();

    // Verificar si la inserción fue exitosa
    if ($stmt->affected_rows > 0) {
        // Mostrar una ventana emergente
        echo "<script>alert('Comentario guardado exitosamente.');</script>";
    } else {
        echo "<script>alert('Error al guardar el comentario.');</script>";
    }
} else {
    echo "<script>alert('Error en la preparación de la consulta.');</script>";
}

// Cerrar la conexión y liberar los recursos
$stmt->close();
$conexion->close();
?>
