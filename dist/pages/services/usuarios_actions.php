<?php
require_once 'group.php';
require_once '../conexion.php';
$data =  (object) [];

if (isset($_POST['accion']) && $_POST['accion'] == 'crear'){
    session_start();
    $hashedPassword = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    
    $stm = $conexion->prepare("INSERT INTO usuario (nombre, `user`, password, correo, avatar, id_rol, created_at, id_grupo)  
    VALUES (?,?,?,?,?,?,?,?)");
    
    /* 
    print_r($_POST);
    die(); */
    $stm->execute([
        $_POST['nombre'],
        $_POST['usuario'],
        $hashedPassword,
        $_POST['correo'],
        'default.png',
        3,
        date('Y-m-d'),
        $_SESSION['usuario']['id_grupo'] ?? 0
    ]);
    
    $data = [
        'estado' => 'success',
        'mensaje' => 'Usuario Registrado correctamente'
    ];
    
}



if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar'){
    $response = $conexion->query("DELETE FROM usuario u where u.id = ".$_POST['id'])->execute();

    if($response){
        $data->estado = 'success';
        $data->mensaje = 'Usuario eliminado correctamente';
    }
}




if (isset($_POST['accion']) && $_POST['accion'] == 'editar'){

    $array = [
        $_POST['nombre'],
        $_POST['usuario'],
        $_POST['correo'],
        date('Y-m-d'),
        $_POST['id']
    ];

    if(empty($_POST['contraseña'])){
        $sql = "UPDATE usuario SET 
           nombre = ?, 
           `user` = ?, 
           correo = ?, 
           updated_at = ?
           WHERE id = ?";
    }else {
        $hashedPassword = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET 
           nombre = ?, 
           `user` = ?, 
           password = ?,
           correo = ?, 
           updated_at = ?
           WHERE id = ?";
        array_splice($array, 2, 0, $hashedPassword); // Insert hashed password at position 2
    }

    $stmt = $conexion->prepare($sql);
    $response = $stmt->execute($array);
    if($response){
        $data->status = 'success';
        $data->sql = $stmt;
    }

    $data->estado = 'success';
    $data->mensaje = 'Usuario editado correctamente'; 
}


if (isset($_POST['accion']) && $_POST['accion'] == 'cargar'){
    $response = $conexion->query("SELECT * FROM usuario u where u.id = ".$_POST['id'])->fetch();

    if($response){
        $data->estado = 'success';
        $data->body = $response;
    }
   
}


echo json_encode($data);
