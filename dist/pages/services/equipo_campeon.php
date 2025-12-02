<?php
$id_torneo = $_GET['idTorneo'];
if (isset($_GET['torneo'])) {
    $link = '../';
} else {
    $link = '';
}

require_once '../conexion.php';

$sql = "select * from torneo t where id = ".$id_torneo;
$nombreTorneo = $conexion->query($sql)->fetch();
$tituloTorneo = $nombreTorneo['nombre'];

$response = $conexion->query("select * from  (select  u.id, u.nombre, count(j.id) as triunfos, u.foto, u.numero from usuario u  
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
group by 1,2 order by triunfos desc,u.nombre ) k  where k.id in (

select ej.id_jugador  from enfrentamientos2 e
inner join torneo t on t.id = e.id_torneo
inner join equipo_jugador ej on ej.id_equipo = e.ganador 
where e.id_torneo = $id_torneo and   
	case 
		when t.tipo = 1 or t.tipo = 2 then fase = 3 
		when t.tipo not in (1,2) then fase = 2 
	end )
	
	
	")->fetchAll();

$contenido = '
<div class="modal-header">
        <h5 class="modal-title" id="modalTorneoGanadoresLabel"><b>CAMPEONES</b> '.$tituloTorneo.'</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" >
        


   


<div class="row p-0 m-0 justify-content-center list_triunfos">

    <div class=" col-sm-12 row m-0 p-0" style="display: flex;align-self: flex-start;justify-content: center">
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

    


        $contenido .= '<div class="col-md-2 mb-2" style="    padding: 5px;"><div class="card m-0 px-2" style="height: auto">
  <div class="cardfoto" style="height:160px"><img src="' . $urlfoto . '' . $foto . '" class="card-img-top mt-2 w-100"  ></div>
  <div class="card-body " >
   <div class="justify-content-between d-flex card-title w-100">
    <h6 class=" text-center ">' . $miembro['nombre'] . '</h6>
    <h6><b>' . $miembro['numero'] . '</b></h6>
   </div>
    <br>
      <div class="w-100 text-center">';

        for ($i = 0; $i < $miembro['triunfos']; $i++) {
            $contenido .= '
            <i class="bi bi-trophy-fill text-warning me-2"></i>
            ';
        }



        $contenido .= '
    </div>
  </div>
</div>
</div>


';
    
}

$contenido .= '  
      </div>';
      
echo $contenido;
?>
<!-- 

<div class="row p-0">

    <div class="col-md-2 mb-2" style="    padding: 5px;">
        <div class="card m-0 px-2" style="height: auto">
            <div class="cardfoto" style="height:150px"><img src="./..//assets/img/miembros/10.jpg" class="card-img-top mt-2 w-100"></div>
            <div class="card-body ">
                <div class="justify-content-between d-flex card-title w-100">
                    <h6 class=" text-center ">ABEL</h6>
                    <h6><b>09</b></h6>
                </div>
                <br>
                <div class="w-100 text-center">
                    <i class="bi bi-trophy-fill text-warning me-2"></i>

                    <i class="bi bi-trophy-fill text-warning me-2"></i>

                    <i class="bi bi-trophy-fill text-warning me-2"></i>

                </div>
            </div>
        </div>
    </div>
</div> -->