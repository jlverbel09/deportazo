

<?php


require_once '../conexion.php';
$response = $conexion->query("select u.*, r.rol from usuario u 
inner join rol r on r.id = u.id_rol  order by u.id   desc")->fetchAll();
$list_usuarios = '';
$i = 0;
foreach($response as $res){
    $i++;
    $list_usuarios .= '<tr>
        <td>'.$res['id'].'</td>
        <td>'.$res['nombre'].'</td>
        <td>'.$res['correo'].'</td>
        <td>'.$res['user'].'</td>
        <td>'.$res['rol'].'</td>
        <td>
            <button class="btn btn-sm btn-info" onClick="load_usuario('.$res['id'].')"><i class="bi bi-pencil-square"></i></button>
            <button class="btn btn-sm btn-danger" onClick="delete_usuario('.$res['id'].')"><i class="bi bi-trash"></i></button>
        </td>
    </tr>';
    
}
if($i==0){
    $list_usuarios .='<tr><td colspan="6">Ningún usuario registrado</td></tr>';
}


$contenido = '
<div class="row p-0 m-0">
    <div class="col-md-3 col-sm-10">
            
        <form>
        <input type="hidden"  id="id_user">
         <div class="mb-1">
            <label for="nombre" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="nombre">
        </div>
        <div class="mb-1    ">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="email" class="form-control" id="usuario" >

        </div>
        <div class="mb-1">
            <label for="contraseña" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="contraseña">
        </div>
       
        <div class="mb-1">
            <label for="correo" class="form-label">Whatsapp</label>
            <input type="number" class="form-control" id="correo">
        </div>

       <!-- <div class="mb-1">
            <label for="avatar" class="form-label">Enlace Avatar</label>
            <input type="text" class="form-control" id="avatar">
        </div>-->
        
        <button type="button" class="btn btn-primary mt-1 mb-4" onClick="save_usuarios()">Guardar</button>
        </form>

    </div>
    <div class="col-lg-9 col-sm-12 tablausuarios" >

        <table class="table table-responsive" >
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th>Whatsapp</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acciones&nbsp;&nbsp;&nbsp;&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                '.$list_usuarios.'
            </tbody>
        </table>
    </div>
</div>
';
$data = [
    'titulo' => 'Usuarios',
    'contenido' => $contenido
];


echo json_encode($data);
