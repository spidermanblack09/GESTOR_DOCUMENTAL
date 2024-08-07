<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="css/estilos1.css">
</head>
<body>
    <h1>Inicio de Sesión</h1>
    <div class="form-container">
        <form action="procesar_login.php" method="post">
            <label for="username">Nombre de usuario:</label>
            <input type="text" name="username" id="username" required><br><br>
            
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required><br><br>
            
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
