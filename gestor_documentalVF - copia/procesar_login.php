<?php
require 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        die('Por favor, complete todos los campos.');
    }

    try {
        $stmt = $conn->prepare('SELECT id, password FROM usuarios WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            die('Nombre de usuario o contraseña incorrectos.');
        }

        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit();

    } catch (PDOException $e) {
        die('Error en la consulta: ' . $e->getMessage());
    }
} else {
    die('Método no permitido.');
}
?>
