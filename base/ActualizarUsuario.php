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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $nueva_contraseña = $_POST['contraseña'];
    $correoUsuario = $_SESSION['CorreoElectronico']; // Asumiendo que el correo está almacenado en la sesión

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Actualizar datos del usuario
        $sql_cliente = "UPDATE cliente JOIN credenciales ON cliente.credenciales_id = credenciales.id 
                        SET cliente.Nombre = ?, cliente.Ape_Pat = ?, cliente.Ape_Mat = ? 
                        WHERE credenciales.CorreoElectronico = ?";
        $stmt = $conn->prepare($sql_cliente);
        $stmt->bind_param("ssss", $nombre, $apellido_paterno, $apellido_materno, $correoUsuario);
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
