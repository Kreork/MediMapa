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
        .comentarios-container {
            max-height: 300px; /* Altura máxima del contenedor */
            overflow-y: auto; /* Permitir el desplazamiento vertical */
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
            <h1>Detalles del Doctor</h1>
            <div id="doctorDetails">
                <p><strong>Nombre:</strong> <span id="doctorName"></span></p>
                <p><strong>Especialidad:</strong> <span id="especialidad"></span></p>
                <p><strong>Teléfono:</strong> <span id="telefono"></span></p>
                <p><strong>Código Postal:</strong> <span id="cp"></span></p>
                <p><strong>Dirección:</strong> <span id="direccion"></span></p>
                <p><strong>Municipio:</strong> <span id="municipio"></span></p>
                <p><strong>Estado:</strong> <span id="estado"></span></p>
                <p><strong>ID del Doctor:</strong> <span id="Id_Doc"></span></p>
                
                <button id="nuevoComentarioBtn">Nuevo Comentario</button>
                
                <h2>Comentarios</h2>
                <!-- Envuelve la tabla en un contenedor con scroll view -->
                <div class="comentarios-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Comentario</th>
                                <th>Calificación</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody id="comentariosTable">
                            <!-- Aquí se incluirán los comentarios -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal para nuevo comentario -->
        <div id="nuevoComentarioModal" style="display:none;">
            <div>
                <h2>Nuevo Comentario</h2>
                <form id="nuevoComentarioForm">
                    <label for="nombreCliente">Nombre:</label>
                    <input type="text" id="nombreCliente" name="nombreCliente" required><br>
                    <label for="comentario">Comentario:</label>
                    <textarea id="comentario" name="comentario" required></textarea><br>
                    <label for="calificacion">Calificación:</label>
                    <input type="number" id="calificacion" name="calificacion" min="1" max="5" required><br>
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" required><br>
                    <button type="submit">Guardar</button>
                    <button type="button" id="cancelarBtn">Cancelar</button>
                </form>
            </div>
        </div>
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function getParameterByName(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }
    
            document.addEventListener('DOMContentLoaded', function() {
                const nombre = getParameterByName('nombre');
                const ape_pat = getParameterByName('ape_pat');
                const ape_mat = getParameterByName('ape_mat');
                const telefono = getParameterByName('telefono');
                const especialidad = getParameterByName('especialidad');
                const cp = getParameterByName('cp');
                const direccion = getParameterByName('direccion');
                const municipio = getParameterByName('municipio');
                const estado = getParameterByName('estado');
                const Id_Doc = getParameterByName('Id_Doc'); // Obtener el Id_Doc
    
                document.getElementById('doctorName').innerText = nombre + ' ' + ape_pat + ' ' + ape_mat;
                document.getElementById('especialidad').innerText = especialidad;
                document.getElementById('telefono').innerText = telefono;
                document.getElementById('cp').innerText = cp;
                document.getElementById('direccion').innerText = direccion;
                document.getElementById('municipio').innerText = municipio;
                document.getElementById('estado').innerText = estado;
                document.getElementById('Id_Doc').innerText = Id_Doc; // Asignar el Id_Doc

                // Obtener las opiniones del servidor filtradas por Id_Doc
                $.ajax({
                    url: './base/Comentarios.php', // Ruta a tu script PHP que obtiene las opiniones
                    type: 'GET',
                    data: { Id_Doc: Id_Doc }, // Enviar Id_Doc como parámetro
                    dataType: 'json',
                    success: function(opiniones) {
                        const comentariosTable = document.getElementById('comentariosTable');
                        // Limpiar la tabla antes de agregar las nuevas fila
                                                // Limpiar la tabla antes de agregar las nuevas filas
                                                comentariosTable.innerHTML = '';
                        // Iterar sobre cada opinión y agregarla a la tabla
                        opiniones.forEach(function(opinion) {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${opinion.Nombre_Cliente}</td>
                                <td>${opinion.Comentario}</td>
                                <td>${opinion.Calificacion}</td>
                                <td>${opinion.Fecha}</td>
                            `;
                            comentariosTable.appendChild(row);
                        });
                    },
                    error: function() {
                        console.error('Error al obtener las opiniones desde el servidor.');
                    }
                });

                // Mostrar el formulario modal para nuevo comentario
                document.getElementById('nuevoComentarioBtn').addEventListener('click', function() {
                    document.getElementById('nuevoComentarioModal').style.display = 'block';
                });

                // Ocultar el formulario modal
                document.getElementById('cancelarBtn').addEventListener('click', function() {
                    document.getElementById('nuevoComentarioModal').style.display = 'none';
                });

                // Manejar el envío del formulario de nuevo comentario
                document.getElementById('nuevoComentarioForm').addEventListener('submit', function(event) {
                    event.preventDefault();
                    const nombreCliente = document.getElementById('nombreCliente').value;
                    const comentario = document.getElementById('comentario').value;
                    const calificacion = document.getElementById('calificacion').value;
                    const fecha = document.getElementById('fecha').value;
                    
                    $.ajax({
                        url: './base/NuevoComentario.php', // Ruta a tu script PHP que guarda los comentarios
                        type: 'POST',
                        data: {
                            Id_Doc: Id_Doc,
                            nombreCliente: nombreCliente,
                            comentario: comentario,
                            calificacion: calificacion,
                            fecha: fecha
                        },
                        success: function(response) {
                            // Actualizar la tabla de comentarios después de guardar el nuevo comentario
                            location.reload();
                        },
                        error: function() {
                            console.error('Error al guardar el comentario.');
                        }
                    });
                });
            });
        </script>
    </header>
</body>
</html>

