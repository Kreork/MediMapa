<?php
session_start();

// Configuración de la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto si es necesario
$password = ""; // Cambia esto si es necesario
$dbname = "paginaweb"; // Cambia esto si es necesario

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    
    // Consulta para obtener la contraseña cifrada y el tipo de usuario
    $sql = "SELECT Contraseña, TipoUsuario 
            FROM credenciales 
            WHERE CorreoElectronico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $tipo_usuario);
        $stmt->fetch();
        
        // Verificar la contraseña
        if (password_verify($contraseña, $hashed_password)) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['CorreoElectronico'] = $correo;
            
            // Mostrar mensaje de bienvenida según el tipo de usuario
            if ($tipo_usuario == 'cliente') {
                echo "<script>
                    alert('Bienvenido cliente');
                    window.location.href = '../ModificarUsuario.php';
                </script>";
            } elseif ($tipo_usuario == 'doctor') {
                echo "<script>
                    alert('Bienvenido doctor');
                    window.location.href = '../ModificarDoctor.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Correo o Contraseña no son correctos');
                window.history.back();
            </script>";
        }
    } else {
        echo "<script>
            alert('Correo o Contraseña no son correctos');
            window.history.back();
        </script>";
    }
    $stmt->close();
}

$conn->close();
?>
