<?php
// Configuración de la conexión a la base de datos
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

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$CorreoElectronico = $_POST['email'];
$Contraseña = $_POST['contraseña'];
$tipoUsuario = 'cliente'; // Establecer siempre como 'cliente'

// Encriptar la contraseña
$contraseñaEncriptada = password_hash($Contraseña, PASSWORD_DEFAULT);

// Insertar datos en la tabla "credenciales"
$sql_credenciales = "INSERT INTO credenciales (CorreoElectronico, Contraseña, TipoUsuario) VALUES ('$CorreoElectronico', '$contraseñaEncriptada', '$tipoUsuario')";

if ($conn->query($sql_credenciales) === TRUE) {
    // Obtener el ID recién insertado
    $credenciales_id = $conn->insert_id;

    // Insertar datos en la tabla "cliente"
    $sql_cliente = "INSERT INTO cliente (credenciales_id, Nombre, Ape_Pat, Ape_Mat) VALUES ('$credenciales_id', '$nombre', '$apellido_paterno', '$apellido_materno')";

    if ($conn->query($sql_cliente) === TRUE) {
        // Mostrar mensaje de confirmación y redirigir
        echo "<script>
            alert('Registro exitoso. Redirigiendo a la pantalla de inicio de sesión.');
            window.location.href = '../seccion.html'; // Cambia esto a la URL de tu pantalla de inicio de sesión
        </script>";
    } else {
        echo "<script>
            alert('Error al insertar datos en la tabla cliente: " . $conn->error . "');
            window.history.back();
        </script>";
    }
} else {
    echo "<script>
        alert('Error al insertar datos en la tabla credenciales: " . $conn->error . "');
        window.history.back();
    </script>";
}

// Cerrar conexión
$conn->close();
?>
