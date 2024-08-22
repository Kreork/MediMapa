<?php
include './base/doctor.php'; // Incluye el archivo con la conexión y la consulta a la base de datos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediMapa</title>
    <link rel="shortcut icon" href="./imagenes/corazon.png" type="image/x-icon">
    <link rel="stylesheet" href="./estilos/normalize.css">
    <link rel="stylesheet" href="./estilos/estilos.css">
    <link rel="stylesheet" href="./estilos/tabla.css">
    <style>
        /* Estilo para el scroll view */
        #resultadoBusqueda {
            max-height: 300px; /* Altura máxima del scroll view */
            overflow-y: auto; /* Habilitar el scroll vertical */
        }
    </style>
</head>
<body>

<header class="hero">
    <nav class="nav container">
        <div class="nav__logo"> 
            <h2 class="nav__title">MediMapa</h2>
        </div>
        <ul class="nav__link nav__link--menu">
            <li class="nav__items">
                <a href="index.html" class="nav__links">Inicio</a>
            </li>
            <li class="nav__items">
                <a href="seccion.html" class="nav__links">Iniciar Sesión</a>
            </li>            
            <li class="nav__items">
                <a href="#preguntas_frecuentes" class="nav__links">Preguntas</a>
            </li>                
            <img src="./imagenes/close.svg" class="nav__close">
        </ul>
        <div class="nav__menu">
            <img src="./imagenes/menu.svg" class="nav__img">
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Busca tu Doctor de confianza</h1>
        <input type="text" id="busqueda" placeholder="Buscar Código Postal">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Doctor</th>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Código Postal</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody id="resultadoBusqueda">
                <?php
                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr onclick=\"showDetails('" . $fila['Nombre'] . "', '" . $fila['Ape_Pat'] . "', '" . $fila['Ape_Mat'] . "', '" . $fila['Telefono'] . "', '" . $fila['Especialidad'] . "', '" . $fila['CP'] . "', '" . $fila['Direccion'] . "', '" . $fila['Municipio'] . "', '" . $fila['Estado'] . "', '" . $fila['Id_Doc'] . "')\">";
                        echo "<td>" . $fila['Id_Doc'] . "</td>"; // Mostrar el Id_Doc
                        echo "<td>" . $fila['Nombre'] . "</td>";
                        echo "<td>" . $fila['Especialidad'] . "</td>";
                        echo "<td>" . $fila['CP'] . "</td>";
                        echo "<td>" . $fila['Direccion'] . "</td>";
                        echo "<td>" . $fila['Telefono'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron resultados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</header>

<script>
function showDetails(nombre, ape_pat, ape_mat, telefono, especialidad, cp, direccion, municipio, estado, Id_Doc) {
    const url = `DetallesMedico.php?nombre=${encodeURIComponent(nombre)}&ape_pat=${encodeURIComponent(ape_pat)}&ape_mat=${encodeURIComponent(ape_mat)}&telefono=${encodeURIComponent(telefono)}&especialidad=${encodeURIComponent(especialidad)}&cp=${encodeURIComponent(cp)}&direccion=${encodeURIComponent(direccion)}&municipio=${encodeURIComponent(municipio)}&estado=${encodeURIComponent(estado)}&Id_Doc=${encodeURIComponent(Id_Doc)}`;
    window.open(url, '_self');
}

document.getElementById('busqueda').addEventListener('input', function() {
    let filtro = this.value.trim().toLowerCase();
    let filas = document.querySelectorAll('tbody tr');

    filas.forEach(function(fila) {
        let cp = fila.querySelector('td:nth-child(4)').textContent.trim().toLowerCase();
        if (cp.includes(filtro)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
});
</script>

</body>
</html>
