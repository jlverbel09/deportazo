<?php

require_once '../conexion.php';


session_start();

$listMiembros = $conexion->query(" select * from usuario where id_rol = 3 and id <> 3 and convocado = 1")->fetchAll();

$contenido = "<div class='row justify-content-center d-flex'>
<div class='col-12 text-center'><h2> <img width='100px' src='../../dist/assets/img/grupos/corazonlatino2.png' /> CONVOCADOS</h2></div>
";

$urlfoto = "./../assets/img/miembros/";
$j = 1;
foreach ($listMiembros as $miembro) {
    $j++;
    if ($miembro['foto'] == 1) {
        $foto = $miembro['id'] . '.jpg';
    } else {
        $foto = 'default.png';
    }

    $contenido .= '<div class="card col-md-2 mx-4 my-1" >
  <img src="' . $urlfoto . '' . $foto . '" class="card-img-top mt-2" >
  <div class="card-body">
    <h5 class="card-title text-center w-100">' . $miembro['nombre'] . '</h5><br>
  
        <!--<ul>
            <li class="mt-2">Matador</li>
        </ul>-->
 
        
  </div>
</div>';
}



$listMiembros = $conexion->query(" select * from usuario where id_rol = 3 and id <> 3 and oficial = 1 order by foto desc, nombre ")->fetchAll();
if ($j > 1) {

    $contenido .= "<div class='row justify-content-center d-flex mt-5'>";
} else {

    $contenido = "<div class='row justify-content-center d-flex'>";
}
$contenido .= "<div class='col-12 text-center'><h2> <img width='100px' src='../../dist/assets/img/grupos/corazonlatino2.png' /> MIEMBROS </h2></div>";
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

$contenido .= '</div> ';


$data = [
    'titulo' => 'Miembros',
    'contenido' => $contenido
];


echo json_encode($data);
