<?php
// Establece la conexión con la base de datos
$servername = "localhost"; // Cambia localhost por tu servidor si es diferente
$username = "root";
$password = "";
$database = "paginaweb";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$email = $_POST['email'];
$contraseña = $_POST['contraseña']; // Contraseña sin encriptar
$especialidad = $_POST['especialidad'];
$cp = $_POST['cp'];
$estado = $_POST['estado'];
$municipio = $_POST['municipio'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$tipoUsuario = "doctor"; // o "cliente" según corresponda

// Encriptar la contraseña
$contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);

// Insertar datos en la tabla 'credenciales'
$sql_credenciales = "INSERT INTO credenciales (TipoUsuario, CorreoElectronico, Contraseña) 
                    VALUES ('$tipoUsuario', '$email', '$contraseña_encriptada')";

if ($conn->query($sql_credenciales) === TRUE) {
    $last_id = $conn->insert_id; // Obtener el ID de la última inserción

    // Insertar datos en la tabla 'doctor' usando el ID de la tabla 'credenciales'
    $sql_doctor = "INSERT INTO doctor (Nombre, Ape_Pat, Ape_Mat, Telefono, Especialidad, CP, Direccion, Municipio, Estado, credenciales_id) 
                    VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$telefono', '$especialidad', '$cp', '$direccion', '$municipio', '$estado', '$last_id')";

    if ($conn->query($sql_doctor) === TRUE) {
        echo "<script>
                alert('Registro exitoso');
                window.location.href = '../seccion.html';
              </script>";
    } else {
        echo "<script>
                alert('Error al registrar en la tabla doctor: " . $conn->error . "');
              </script>";
    }
} else {
    echo "<script>
            alert('Error al registrar en la tabla credenciales: " . $conn->error . "');
          </script>";
}

// Cerrar conexión
$conn->close();
?>
