<?php

require_once '../conexion.php';
session_start();
$grupo = $_GET['grupo'] ?? $_SESSION['grupo'] ?? null;
$data = (object) [];

if (!empty($_GET['accion']) && $_GET['accion'] == 'iniciarSesion') {

    $usuario = trim($_POST['user']);
    $contraseña = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE user = ?");
    $stmt->execute([$usuario]);
    $response = $stmt->fetch();

    if ($response) {
        // Check password using password_verify
        if (password_verify($contraseña, $response['password'])) {
            $data->response = $response;
            $data->status = 'success';
            $_SESSION['usuario'] = $response;
        } else {
            $data->response = 'Contraseña incorrecta';
        }
        $data->grupo = $grupo;
    } else {
        $data->response = 'Usuario no encontrado';
        $data->grupo = $grupo;
    }
}

if (!empty($_GET['accion']) && $_GET['accion'] == 'destruirSesion') {
    if (session_destroy()) {
        $data->response = 1;
    } else {
        $data->response = 0;
    }
    $data->grupo = $grupo;
}

echo json_encode($data);
