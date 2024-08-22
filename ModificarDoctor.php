<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Datos de Doctor</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Modificar Datos de Doctor</h1>
        <form action="./base/ActualizarDoctor.php" method="post"> 
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="<?php echo isset($_GET['apellido_paterno']) ? htmlspecialchars($_GET['apellido_paterno']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellido_materno" class="form-label">Apellido Materno</label>
                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" value="<?php echo isset($_GET['apellido_materno']) ? htmlspecialchars($_GET['apellido_materno']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo isset($_GET['telefono']) ? htmlspecialchars($_GET['telefono']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="especialidad" class="form-label">Especialidad</label>
                <input type="text" class="form-control" id="especialidad" name="especialidad" value="<?php echo isset($_GET['especialidad']) ? htmlspecialchars($_GET['especialidad']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cp" class="form-label">Código Postal</label>
                <input type="text" class="form-control" id="cp" name="cp" value="<?php echo isset($_GET['cp']) ? htmlspecialchars($_GET['cp']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo isset($_GET['direccion']) ? htmlspecialchars($_GET['direccion']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="municipio" class="form-label">Municipio</label>
                <input type="text" class="form-control" id="municipio" name="municipio" value="<?php echo isset($_GET['municipio']) ? htmlspecialchars($_GET['municipio']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <input type="text" class="form-control" id="estado" name="estado" value="<?php echo isset($_GET['estado']) ? htmlspecialchars($_GET['estado']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Nueva Contraseña (dejar en blanco si no se desea cambiar)</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
