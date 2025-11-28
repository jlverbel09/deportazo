

<?php

if(isset($_GET['torneo'])){
    $link = '../';
}else{
    $link = '';
}

require_once '../conexion.php';

$response = $conexion->query("select u.id, u.nombre, count(j.id) as triunfos, u.foto from usuario u  
left join (select u.* from enfrentamientos2 en
inner join equipos e  on e.id = en.ganador 
inner join equipo_jugador ej  on ej.id_torneo = en.id_torneo and ej.id_equipo = e.id 
inner join usuario u on u.id = ej.id_jugador  
inner join torneo t on t.id = e.id_torneo 
where  
	case 
		when t.tipo = 1 or t.tipo = 2 then fase = 3 
		when t.tipo not in (1,2) then fase = 2 
	end 
	) j on j.id = u.id
where u.id_rol  = 3 and u.id <> 3 and u.oficial = 1
group by 1,2 order by triunfos desc,u.nombre")->fetchAll();







$list_usuarios = '';
$i = 0;
foreach ($response as $res) {
    $i++;
    $trofeos = '';
    for ($j = 1; $j <= $res['triunfos']; $j++) {
        $trofeos .= '<i class="bi bi-trophy-fill text-warning me-2"></i>';
    }
    $list_usuarios .= '<tr>
        <td>' . $i . '</td>
        <td >' . $res['nombre'] . '</td>
        <td>' . $trofeos . '</td>
    </tr>';
}
if ($i == 0) {
    $list_usuarios .= '<tr><td colspan="6">No existe ningún ganador aún</td></tr>';
}




$contenido = '
<div class="row p-0 m-0 justify-content-center list_triunfos">

    <div class="col-lg-7 col-sm-12 row m-0 p-0" style="display: flex;align-self: flex-start;">
    ';


$urlfoto = "./../$link/assets/img/miembros/";
$j = 1;
foreach ($response as $miembro) {
    $j++;
    if ($miembro['foto'] == 1) {
        $foto = $miembro['id'] . '.jpg';
    } else {
        $foto = 'default.png';
    }

    if ($miembro['triunfos'] > 0) {


        $contenido .= '<div class="col-md-3 mb-2" style="    padding: 5px;"><div class="card m-0 px-2" style="height: auto">
  <div class="cardfoto" style="height:150px"><img src="' . $urlfoto . '' . $foto . '" class="card-img-top mt-2 w-100"  ></div>
  <div class="card-body " >
    <h5 class="card-title text-center w-100">' . $miembro['nombre'] . '</h5><br>
      <div class="w-100 text-center">';

        for ($i=0; $i < $miembro['triunfos']; $i++) { 
             $contenido .= '
            <i class="bi bi-trophy-fill text-warning me-2"></i>
            ';
        }



    $contenido .= '
    </div>
  </div>
</div></div>';
    }
}



$contenido .= '</div>

    <div class="col-lg-5 col-sm-12 tablausuarios p-0" >

        <table class="table table-responsive table-bordered" >
            <thead>
                <tr>
                    <th>#</th>
                    <th width="50px">Nombre&nbsp;Jugador&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th class="text-center">Torneos&nbsp;Ganados</th>
                   
                </tr>
            </thead>
            <tbody>
                ' . $list_usuarios . '
            </tbody>
        </table>
    </div>
</div>
';
$data = [
    'titulo' => 'Triunfos <i class="bi bi-trophy-fill "></i>',
    'contenido' => $contenido
];


if (!isset($_GET['torneo'])) {
    echo json_encode($data);
} else {
    echo ($contenido);
}
