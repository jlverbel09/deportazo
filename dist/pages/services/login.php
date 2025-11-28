<?php

require_once '../conexion.php';
session_start();
$data = (object) [];

if (!empty($_GET['accion']) && $_GET['accion'] == 'iniciarSesion') {

    $usuario = $_POST['user'];
    $contraseña = $_POST['password'];

    $response = $conexion->query("select *  from usuario u where u.user = '$usuario' and u.password = '$contraseña'  ")->fetch();
    if ($response) {
        $data->response = $response;
        $data->status = 'success';
        

        $_SESSION['usuario'] = $response;;
    } else {
        $data->response = 'Error al iniciar session';
    }
}



if (!empty($_GET['accion']) && $_GET['accion'] == 'destruirSesion') {
  
    if(session_destroy()){
        $data->response = 1;
    }else{
        $data->response = 0;
    }
}

echo json_encode($data);
