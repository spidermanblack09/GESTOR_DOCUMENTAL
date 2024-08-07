<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Solicitud</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <h1>Solicitud de Préstamo de Documentos</h1>
    <div class="form-container">
        <form action="procesar_solicitud.php" method="POST">
            <label for="num_solicitud">Número de Solicitud:</label>
            <input type="text" id="num_solicitud" name="num_solicitud" required>
            
            <label for="unidad">Unidad:</label>
            <input type="text" id="unidad" name="unidad" required>
            
            <label for="grado">Grado:</label>
            <input type="text" id="grado" name="grado" required>
            
            <label for="nombre">Apellidos y nombres:</label>
            <input type="text" id="nombre" name="nombre" required>
            
            <label for="identificacion">Número de Identificación:</label>
            <input type="text" id="identificacion" name="identificacion" required>
            
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>
            
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>
            
            <div id="documentos">
                <div class="documento">
                    <label for="tipo_documento">Tipo de Documento:</label>
                    <select name="tipo_documento[]" required>
                        <option value="FICHA KARDEX">FICHA KARDEX</option>
                        <option value="HISTORIAS LABORALES">HISTORIAS LABORALES</option>
                        <option value="LIBROS">LIBROS</option>
                        <option value="NOMINAS">NOMINAS</option>
                        <option value="ORDENES ADMINISTRATIVAS DE PERSONAL OAP">ORDENES ADMINISTRATIVAS DE PERSONAL OAP</option>
                        <option value="ORDENES ADMINISTRATIVAS DE PERSONAL OGP">ORDENES ADMINISTRATIVAS DE PERSONAL OGP</option>
                        <option value="RESOLUCIONES">RESOLUCIONES</option>
                        <option value="ROLLO MICROFILMADO">ROLLO MICROFILMADO</option>
                    </select>
                    <input type="text" name="fecha_documento[]" placeholder="Número y año del documento que requiere" required>
                </div>
            </div>
            <button type="button" onclick="agregarDocumento()">Agregar otro documento</button><br><br>
            <button type="submit">Enviar</button>
        </form>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="logout-button">Cerrar sesión</a>
    </div>
    <script>
        function agregarDocumento() {
            const documentos = document.getElementById('documentos');
            const nuevoDocumento = document.createElement('div');
            nuevoDocumento.classList.add('documento');
            nuevoDocumento.innerHTML = `
                <select name="tipo_documento[]" required>
                    <option value="FICHA KARDEX">FICHA KARDEX</option>
                    <option value="HISTORIAS LABORALES">HISTORIAS LABORALES</option>
                    <option value="LIBROS">LIBROS</option>
                    <option value="NOMINAS">NOMINAS</option>
                    <option value="ORDENES ADMINISTRATIVAS DE PERSONAL OAP">ORDENES ADMINISTRATIVAS DE PERSONAL OAP</option>
                    <option value="ORDENES ADMINISTRATIVAS DE PERSONAL OGP">ORDENES ADMINISTRATIVAS DE PERSONAL OGP</option>
                    <option value="RESOLUCIONES">RESOLUCIONES</option>
                    <option value="ROLLO MICROFILMADO">ROLLO MICROFILMADO</option>
                </select>
                <input type="text" name="fecha_documento[]" placeholder="Número y año del documento que requiere" required>
            `;
            documentos.appendChild(nuevoDocumento);
        }
    </script>
</body>
</html>
