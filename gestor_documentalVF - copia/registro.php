<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <h1>Registro de Usuario</h1>
    <div class="form-container">
        <form action="procesar_registro.php" method="post">
            <label for="username">Nombre de usuario:</label>
            <input type="text" name="username" id="username" required><br><br>
            
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required><br><br>
            
            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
