<?php

require_once '../conexion.php';/* 
$res = $conexion->query("")->fetch(); */

$contenido = '<div class="row m-0 p-0">
                <div class="col-8  mx-0 px-0  ">
                    <label>Cantidad Equipos</label>
                    <select onchange="cargarInputsEquipos(this.value)" class="form-select" name="cant_equipos" id="cant_equipos" required>
                        <option value="">Seleccionar</option>
                        <option value="3">3 Equipos</option>
                        <option value="4">4 Equipos</option>
                        <option value="5">5 Equipos</option>
                        <option value="6">6 Equipos</option>
                    </select>
                </div>
                 <div class="col-2 mt-4 mx-0 px-1" id="restaurarReencuentros" style="visibility:hidden">
                    <button class="w-100 btn btn-warning" onclick="restaurarReencuentros()"><i class="fa fa-rotate-right"></i></button>
                </div>
                <div class="col-2 mt-4 mx-0 px-1" id="cuadroCrearEnfrentamiento">
                    <button class="w-100 btn btn-info" onclick="crearEnfrentamiento()"><i class="fa fa-save"></i></button>
                </div>
                <div class="col-2 mt-4 mx-0 px-0 " style="display:none" id="cuadroPararEnfrentamientos">
                    <button class="w-100 btn btn-danger" onclick="finalizarEnfrentamiento()"><i class="fa fa-stop"></i></button>
                </div>
                <div class="col-md-12 mt-1" id="listInputs"></div>
            </div>';

$data = [
    'titulo' => 'Enfrentamiento Rapido <i class="fa fa-users "></i>',
    'contenido' => $contenido
];


echo json_encode($data);
