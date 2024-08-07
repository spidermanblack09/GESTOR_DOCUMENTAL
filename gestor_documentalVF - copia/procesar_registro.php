<?php
require 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        die('Por favor, complete todos los campos.');
    }

    try {
        $stmt = $conn->prepare('SELECT id FROM usuarios WHERE username = :username');
        $stmt->execute(['username' => $username]);

        if ($stmt->rowCount() > 0) {
            die('El nombre de usuario ya está en uso.');
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO usuarios (username, password) VALUES (:username, :password)');
        $stmt->execute([
            'username' => $username,
            'password' => $hashed_password
        ]);

        header('Location: login.php');
        exit();

    } catch (PDOException $e) {
        die('Error en la consulta: ' . $e->getMessage());
    }
} else {
    die('Método no permitido.');
}
?>
