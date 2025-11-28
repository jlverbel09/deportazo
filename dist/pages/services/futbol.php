<?php 

$contenido ='

    <div class="col-9 ">

    </div>
     <div class="col-3 justify-content-end d-flex  ">
        <div class="cancha shadow ">
            <div class="area"></div>
            <div class="circlemedio"></div>
            <div class="medio"></div>
            <div class="areacontraria"></div>
        </div>
    </div>

';
$data = [
    'titulo' => 'Futbol',
    'contenido' => $contenido
];


echo json_encode($data);