<?php
require_once '../conexion.php';
$data =  (object) [];

if (isset($_POST['accion']) && $_POST['accion'] == 'crear'){

    $stm = $conexion->prepare("INSERT INTO usuario (nombre, `user`, password, correo, avatar, id_rol, created_at)  
    VALUES (?,?,?,?,?,?,?)");
    
    /* 
    print_r($_POST);
    die(); */
    $stm->execute([
        $_POST['nombre'],
        $_POST['usuario'],
        $_POST['contraseña'],
        $_POST['correo'],
        'default.png',
        3,
        date('Y-m-d')
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


    

    if(empty($_POST['contraseña'])){
        $password = "";
        $array = [
            $_POST['nombre'],
            $_POST['usuario'],
            $_POST['correo'],
            date('Y-m-d')
        ];
    }else {
        $password = "password = ?, ";
        $array = [
            $_POST['nombre'],
            $_POST['usuario'],
            $_POST['contraseña'],
            $_POST['correo'],
            date('Y-m-d')
        ];
    }
    $sql = "UPDATE usuario SET 
       nombre = ?, 
       `user` = ?, 
       ".$password."
       correo = ?, 
       updated_at = ?
       
        WHERE id = ".$_POST['id'];

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
