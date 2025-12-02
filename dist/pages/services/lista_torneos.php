<?php

require_once '../conexion.php';
$contenido = '';
$responseTorneo = $conexion->query("select * from torneo t where t.id_deporte = 1 and status != 2 order by id desc")->fetchAll();
$ganadores = '';

$listTorneos = '';
$i = 0;
foreach ($responseTorneo as $resTorneo) {
    $i++;
    $estado =  ($resTorneo['status'] == 1) ? 'activo' : 'finalizado';

    if ($resTorneo['status'] <> 1 ) {
        $ganadores = '<div class="ganadorestorneo" data-bs-toggle="modal" data-bs-target="#modalTorneoGanadores" style="cursor:pointer" onclick="verGanadores(' . $resTorneo['id'] . ')">
                        <i class="bi bi-trophy-fill text-warning me-2"></i>
                    </div>';
    }

    $fecha = date_create($resTorneo['fecha']);
    $urlImg = '../../dist/assets/img/torneo/' . $resTorneo['id'] . '.jpg';
    $listTorneos .= ' 
    <div class="col-lg-4 col-sm-12">
        <div class="card d-grid mb-3 ' . $estado . '" style="max-width: 540px; " >
            <div class="row g-0">
                <div class="col-md-4 align-items-center d-flex" style="cursor:pointer" onClick=" redireccion(`torneos`,{id_torneo:' . $resTorneo['id'] . '})">
                    <img style="    display: flex;" src="' . $urlImg . '" class="img-fluid  rounded ms-2 cardTorneo" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><b>' . $resTorneo['nombre'] . '</b></h5><br>
                    <p class="m-0" style="height: 50px">' . $resTorneo['descripcion'] . '</p>
                    <p class="card-text m-0">
                        <small class="text-muted">
                            Fecha: ' . date_format($fecha, 'Y-m-d') . '
                        </small>
                    </p>
                    <p class="card-text m-0">
                        <small class="text-muted">
                            Hora: ' . date_format($fecha, 'H:i') . '
                        </small>
                    </p>
                    <p class="card-text ">
                        <small class="text-muted">
                            Lugar: ' . $resTorneo['direccion'] . '
                        </small>
                    </p>
                    ' . $ganadores . '
                </div>
                </div>
            </div>
        </div>
    </div>';
}


if ($i == 0) {
    $listTorneos = '<div class="text-center d-flex justify-content-center align-items-center" style="position:absolute; height:80%; width:95%">No hay ningún torneo iniciado aún</div>';
}

$contenido .=
    '<div class="row m-0 p-0">
    ' . $listTorneos . '
</div>';


$contenido .= '


<!-- Modal -->
<div class="modal fade" id="modalTorneoGanadores" tabindex="-1" aria-labelledby="modalTorneoGanadoresLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered ganadoresList">
    <div class="modal-content" id="contenidoTorneoGanadores">
      
    </div>
  </div>
</div>

';


$data = [
    'titulo' => 'Torneos',
    'contenido' => $contenido
];


echo json_encode($data);
