<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "paginaweb";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha iniciado sesión
if (!isset($_SESSION['CorreoElectronico'])) {
    // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: inicio_sesion.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido_paterno = htmlspecialchars($_POST['apellido_paterno']);
    $apellido_materno = htmlspecialchars($_POST['apellido_materno']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $especialidad = htmlspecialchars($_POST['especialidad']);
    $cp = htmlspecialchars($_POST['cp']);
    $direccion = htmlspecialchars($_POST['direccion']);
    $municipio = htmlspecialchars($_POST['municipio']);
    $estado = htmlspecialchars($_POST['estado']);
    $nueva_contraseña = $_POST['contraseña'];
    $correoUsuario = $_SESSION['CorreoElectronico']; // Asumiendo que el correo está almacenado en la sesión

    // Iniciar transacción
    $conn->begin_transaction();

    try {
       // Actualizar datos del doctor
       $sql_doctor = "UPDATE doctor 
       JOIN credenciales ON doctor.credenciales_id = credenciales.id 
       SET doctor.Nombre = ?, doctor.Ape_Pat = ?, doctor.Ape_Mat = ?, doctor.Telefono = ?, doctor.Especialidad = ?, doctor.CP = ?, doctor.Direccion = ?, doctor.Municipio = ?, doctor.Estado = ? 
       WHERE credenciales.CorreoElectronico = ?";
$stmt = $conn->prepare($sql_doctor);
$stmt->bind_param("ssssssssss", $nombre, $apellido_paterno, $apellido_materno, $telefono, $especialidad, $cp, $direccion, $municipio, $estado, $correoUsuario);
$stmt->execute();
$stmt->close();
        // Si se proporciona una nueva contraseña, actualizarla
        if (!empty($nueva_contraseña)) {
            $contraseñaEncriptada = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
            $sql_contraseña = "UPDATE credenciales SET Contraseña = ? WHERE CorreoElectronico = ?";
            $stmt = $conn->prepare($sql_contraseña);
            $stmt->bind_param("ss", $contraseñaEncriptada, $correoUsuario);
            $stmt->execute();
            $stmt->close();
        }

        // Confirmar transacción
        $conn->commit();

        // Mostrar mensaje de confirmación y redirigir
        echo "<script>
            alert('Datos actualizados correctamente.');
            window.location.href = '../seccion.html'; // Cambia esto a la URL de la página de perfil
        </script>";

    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conn->rollback();
        echo "<script>
            alert('Error al actualizar los datos: " . $e->getMessage() . "');
            window.history.back();
        </script>";
    }
}

$conn->close();
?>
