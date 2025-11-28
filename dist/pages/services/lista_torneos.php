<?php 

require_once '../conexion.php';
$contenido = '';
$responseTorneo = $conexion->query("select * from torneo t where t.id_deporte = 1 and status != 2 order by id desc")->fetchAll();

$listTorneos = '';
$i=0;
foreach ($responseTorneo as $resTorneo) {
    $i++;
    $estado =  ($resTorneo['status'] == 1) ? 'activo' : 'finalizado';

    $fecha=date_create($resTorneo['fecha']);
    $urlImg = '../../dist/assets/img/torneo/'.$resTorneo['id'].'.jpg';
    $listTorneos .= ' 
    <div class="col-lg-4 col-sm-12">
        <div class="card d-grid mb-3 '.$estado.'" style="max-width: 540px; cursor:pointer" onClick=" redireccion(`torneos`,{id_torneo:'.$resTorneo['id'].'})">
            <div class="row g-0">
                <div class="col-md-4 align-items-center d-flex">
                    <img style="    display: flex;" src="'.$urlImg.'" class="img-fluid  rounded ms-2 cardTorneo" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><b>'.$resTorneo['nombre'].'</b></h5><br>
                    <p class="m-0" style="height: 50px">'.$resTorneo['descripcion'].'</p>
                    <p class="card-text m-0">
                        <small class="text-muted">
                            Fecha: '. date_format($fecha,'Y-m-d').'
                        </small>
                    </p>
                    <p class="card-text m-0">
                        <small class="text-muted">
                            Hora: '. date_format($fecha,'H:i').'
                        </small>
                    </p>
                    <p class="card-text ">
                        <small class="text-muted">
                            Lugar: '.$resTorneo['direccion'].'
                        </small>
                    </p>
                </div>
                </div>
            </div>
        </div>
    </div>';
}


if($i==0){
    $listTorneos = '<div class="text-center d-flex justify-content-center align-items-center" style="position:absolute; height:80%; width:95%">No hay ningún torneo iniciado aún</div>';
}

$contenido .= 
'<div class="row m-0 p-0">
    '.$listTorneos.'
</div>';




$data = [
    'titulo' => 'Torneos',
    'contenido' => $contenido
];


echo json_encode($data);