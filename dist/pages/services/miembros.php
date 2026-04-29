<?php

require_once '../conexion.php';
require_once 'group.php';

// Validar que existe el grupo en la sesión
$id_grupo = isset($_SESSION['usuario']['id_grupo']) ? $_SESSION['usuario']['id_grupo'] : null;
if (!$id_grupo) {
    die('Error: No autorizado. Grupo no identificado.');
}

$listMiembros = $conexion->query(" select * from usuario where id_rol = 3 and id <> 3 and convocado = 1 and id IN (select id_jugador from equipo_jugador where id_grupo = '$id_grupo')")->fetchAll();

$contenido = "";

$urlfoto = "./../assets/img/miembros/";
$j = 0;
if (!empty($listMiembros)) {
    $contenido = "<div class='row justify-content-center d-flex'>
    <div class='col-12 text-center'><h2> <img width='100px' src='" . $logoGrupo . "' /> CONVOCADOS</h2></div>";

    foreach ($listMiembros as $miembro) {
        $j++;
        if ($miembro['foto'] == 1) {
            $foto = $miembro['id'] . '.jpg';
        } else {
            $foto = 'default.png';
        }

        $contenido .= '<div class="card col-md-3 mx-4 my-1" >
  <img src="' . $urlfoto . '' . $foto . '" class="card-img-top mt-2" >
  <div class="card-body">
    <h5 class="card-title text-center w-100">' . $miembro['nombre'] . '</h5><br>
  
        <!--<ul>
            <li class="mt-2">Matador</li>
        </ul>-->
 
        
  </div>
</div>';
    }

    $contenido .= '</div>';
}

$listMiembros = $conexion->query(" select * from usuario where id_rol = 3 and id <> 3 and oficial = 1 and id IN (select id_jugador from equipo_jugador where id_grupo = '$id_grupo') order by foto desc, nombre ")->fetchAll();
if ($j > 0) {
    $contenido .= "</div><div class='row justify-content-center d-flex mt-5'>";
} else {
    $contenido .= "</div><div class='row justify-content-center d-flex'>";
}
$contenido .= "<div class='col-12 text-center'><h2> <img width='100px' class='rounded' src='" . $logoGrupo . "' /> MIEMBROS </h2></div>";
$urlfoto = "./../assets/img/miembros/";

foreach ($listMiembros as $miembro) {

    if ($miembro['foto'] == 1) {
        $foto = $miembro['id'] . '.jpg';
    } else {
        $foto = 'default.png';
    }

    $contenido .= '<div class="card col-md-2 m-2" >
    <div style="height: 200px">
  <img src="' . $urlfoto . '' . $foto . '" class="card-img-top mt-2" >
  </div>
  <div class="card-body">
    <h5 class="card-title text-center w-100">' . $miembro['nombre'] . '</h5>

    <h5 class="card-title text-center w-100"><b>' . $miembro['numero'] . '</b></h5>
  
        <!--<ul>
            <li class="mt-2">Matador</li>
        </ul>-->
 
        
  </div>
</div>

';
}

if (empty($listMiembros)) {
    $contenido .= '<div class="col-12 text-center mb-4">No existen miembros para mostrar.</div>';
}

$contenido .= '</div> ';


$data = [
    'titulo' => 'Miembros',
    'contenido' => $contenido
];


echo json_encode($data);
