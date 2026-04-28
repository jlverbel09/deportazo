<?php

require_once '../conexion.php';
session_start();

$data = (object) [];

if (!empty($_GET['accion']) && $_GET['accion'] == 'iniciarSesion') {

    $usuario = trim($_POST['user']);
    $contraseña = $_POST['password'];
    $grupo = $_POST['grupo'];
    // Use prepared statement to prevent SQL injection
    $sql = "SELECT u.*, g.nombre as nombre_grupo FROM usuario u JOIN grupos g ON u.id_grupo = g.id WHERE u.user = '$usuario' AND g.url = '$grupo'";
    $response = $conexion->query($sql)->fetch();
    if ($response) {
        // Check password using password_verify
        if (password_verify($contraseña, $response['password'])) {
            $data->response = $response;
            $data->status = 'success';
            $_SESSION['usuario'] = $response;
        } else {
            $data->response = 'Contraseña incorrecta';
        }
        $data->grupo =  $_SESSION['usuario']['nombre_grupo'] ?? null;
    } else {
        $data->response = 'Usuario no encontrado';
        $data->grupo =  $_SESSION['usuario']['nombre_grupo'] ?? null;
    }
}

if (!empty($_GET['accion']) && $_GET['accion'] == 'destruirSesion') {
    if (session_destroy()) {
        $data->response = 1;
    } else {
        $data->response = 0;
    }
    $data->grupo =  $_SESSION['usuario']['nombre_grupo'] ?? null;
}

echo json_encode($data);
