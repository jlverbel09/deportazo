<?php

require_once '../conexion.php';

session_start();
$listTorneos = '';
$selected = '';
$conten = '';
$contenJugadores = '';
$contentJugadoresGlobal = '';
$contentPosiciones = '';
$contenido = '';

$responseTorneo = $conexion->query("select * from torneo t where t.status != 2 order by t.id desc ")->fetchAll();

$listadoTorneos = '';
foreach ($responseTorneo as $resTorneo) {

    $estado =  ($resTorneo['status'] == 1) ? 'activo' : 'finalizado';

    $fecha = date_create($resTorneo['fecha']);
    $urlImg = '../../dist/assets/img/torneo/'.$resTorneo['id'].'.jpg';

    if (!empty($_GET['torneo']) && $_GET['torneo'] == $resTorneo['id']) {
        $torenoSeleccionado = 'torneoSeleccionado';
    } else {
        $torenoSeleccionado = "";
    }
    


    $listadoTorneos .= ' 
    
    <div class="col-md-6 col-sm-12 mx-2 mb-1">
        <div class="card d-grid h-100 mb-0 ' . $estado . '" style="max-width: 45  0px; cursor:pointer" onClick="redireccion(`voleybol`, `torneo=`+' . $resTorneo['id'] . ') ">
            <div class="d-flex g-0 cardemcabezado py-2 '.$torenoSeleccionado.'" >
                <div class="col-md-2 align-items-center d-flex">
                    <img src="'.$urlImg.'" class="img-fluid rounded-start imagen_torneo" alt="...">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title"><b>' . strtoupper($resTorneo['nombre']) . '</b></h5><br>
                    
                    
                        <p class="card-text ">
                            <small class="text-muted">
                                ' . $resTorneo['direccion'] . '
                            </small>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                 <p class="card-text m-0 mt-3">
                        <small class="text-muted">
                            ' . date_format($fecha, 'Y-m-d') . '
                        </small>
                    </p>
                    <p class="card-text m-0">
                        <small class="text-muted">
                            ' . date_format($fecha, 'H:i') . '
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>';
}


if ($listadoTorneos == '') {

    $listadoTorneos = '<div class="justify-content-center d-flex  w-100 align-items-center ">No hay ningún torneo aún</div>';
}








foreach ($responseTorneo as $resTorneo) {


    if (!empty($_GET['torneo']) && $_GET['torneo'] == $resTorneo['id']) {
        $selected = 'selected';
    } else {
        $selected = "";
    }

    $listTorneos .= ' <option value="' . $resTorneo['id'] . '"  ' . $selected . '>' . $resTorneo['nombre'] . '</option>';
}



$wheretorneo = "";

if (!empty($_GET['torneo'])) {
    $seleccionado = "";
    $wheretorneo = " where id_torneo = " . $_GET['torneo'];
    $responseEquipo = $conexion->query("select * from equipos e where e.id_deporte = 1 and e.id_torneo =  " . $_GET['torneo'])->fetchAll();
    $i = 0;
    if ($responseEquipo) {

        foreach ($responseEquipo as $resEquipo) {
            $i++;
            if (!empty($_GET['equipo'])) {
                if ($resEquipo['id'] == $_GET['equipo'] && !empty($_GET['equipo'])) {
                    $seleccionado = "seleccionado";
                } else {
                    $seleccionado = "";
                }
            }


            if ($_SESSION['usuario']['id_rol'] == 1 or $_SESSION['usuario']['id_rol'] == 2) {
                $dataAsignar = '<td><button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#asignarJugador" onclick="buscarEquipo(' . $resEquipo['id'] . ')">Asignar</button></td>';
            } else {
                $dataAsignar = '';
            }

            $conten .= '
                    <tr class="' . $seleccionado . '">
                    <th scope="row">' . $i . '</th>
                    <td><i class="bi bi-shield-fill mt-1 me-1" style="color:' . $resEquipo['color'] . '"></i>' . $resEquipo['nombre'] . '</td>
                    ' . $dataAsignar . '
                    <td><button class="btn btn-primary btn-sm "  onClick="redireccion(`voleybol`, `torneo=' . $_GET['torneo'] . '&equipo=`+' . $resEquipo['id'] . ')"><i class="bi bi-eye"></i></button></td>
                    </tr>';
        }
    }
    if ($i == 0) {
        $conten = '<tr><td colspan="4"><div class="justify-content-center d-flex  w-100 align-items-center ">No hay ningún equipo aún</div></td></tr>';
    }
}
if (!empty($_GET['equipo'])) {


    $responseJugadores = $conexion->query("select ej.*, u.nombre as nombre_jugador, e.nombre , pv.nombre as posicion_nombre, ej.seleccionado from equipo_jugador ej 
            inner join usuario u on u.id = ej.id_jugador 
            left join equipos e on e.id  = ej.id_equipo  
            inner join posiciones_voley pv on pv.id =ej.posicion 
            where id_equipo =" . $_GET['equipo'] . " and e.id_torneo =" . $_GET['torneo'] . " order by  seleccionado desc , ej.posicion desc ")->fetchAll();

    $j = 0;
    if ($responseJugadores) {

        foreach ($responseJugadores as $resJugadores) {
            $j++;
            if ($resJugadores['seleccionado']  == 1) {
                $checked = 'checked';
            } else {
                $checked = '';
            }

            $contenJugadores .= '
            
            <tr>
            <th scope="row">' . $j . '</th>
            <td>' . ucwords($resJugadores['nombre_jugador']) . '</td>
            <td>' . $resJugadores['posicion_nombre'] . '</td>
            <td class="text-center">' . $resJugadores['numero'] . '</td>
            <!--<td class="ps-4 pt-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"  ' . $checked . '  value="' . $resJugadores['seleccionado'] . '" class="seleccionado">
                </div>
            </td>-->
            <!--<td><button class="btn btn-primary btn-sm mb-1">Ver</button></td>-->
            </tr>';
        }
    }
    if ($j == 0) {
        $contenJugadores = '<tr><td colspan="4"><div class="justify-content-center d-flex  w-100 align-items-center ">No hay ningún jugador aún</div></td></tr>';
    }
}



$responseUsuarios = $conexion->query("select * from usuario where id_rol = 3 and id not in (select id_jugador from equipo_jugador ej $wheretorneo )")->fetchAll();

foreach ($responseUsuarios as $resUsuarios) {
    $contentJugadoresGlobal .= "<option value=" . $resUsuarios['id'] . ">" . $resUsuarios['nombre'] . "</option>";
}



$responsePosiciones = $conexion->query("select * from posiciones_voley")->fetchAll();

foreach ($responsePosiciones as $resPosiciones) {
    $contentPosiciones .= "<option value=" . $resPosiciones['id'] . ">" . $resPosiciones['nombre'] . "</option>";
}

if ($_SESSION['usuario']['id_rol'] == 1) {
    $nuevoTorneo = ' <div class="col-md-2 col-sm-12">
            
                <button class="btn btn-primary  mb-1 h-100 w-100"  data-bs-toggle="modal" data-bs-target="#nuevoTorneo"><i class="bi bi-plus-square h3"></i><br>Nuevo Torneo</button>
            </div>';
    $altNuevoTorneo = 'col-md-10';
    $crearEquipo = '<button class="btn btn-primary  mb-1" data-bs-toggle="modal"    data-bs-target="#nuevoEquipo">Crear Equipo</button>';
    $jugador = '<th scope="col">Jugador </th>';
} else {
    $altNuevoTorneo = '';
    $nuevoTorneo = '';
    $crearEquipo = '';
    $jugador = '';
}


/* --------------------------------------------------------- */




$contenido .= '

<!-- Modal -->
<div class="modal fade" id="nuevoTorneo" tabindex="-1" aria-labelledby="nuevoTorneolabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nuevoTorneolabel">Nuevo Torneo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
        

        <form>
            <div class="mb-1">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="torneo_nombre">
                <input type="hidden" value="1" class="form-control" id="torneo_deporte">
            </div>
            <div class="mb-1    ">
                <label for="nro_equipos" class="form-label">Nro Equipos</label>
                <input type="number" value="2" class="form-control" id="torneo_nro_equipos" >
            </div>

            <div class="mb-1    ">
                <label for="nro_equipos" class="form-label">Tipo de juego</label>
                <select class="form-select" name="torneo_tipo_juego" id="torneo_tipo_juego">
                    <option>Seleccionar</option>
                    <option value="1">Todos contra todos/Eliminación Uno a Uno</option>
                    <option value="2">Todos contra todos/Final Directa</option>
                    <option value="3">Todos contra todos/Eliminacion/Semifinal/final</option>
                    <option value="4">Todos contra todos/Semifinal/final</option>
                    <option value="5">Eliminaciones Directas - 8 Equipos</option>
                </select>
            </div>

            <div class="mb-1">
                <label>Descripción</label>
                <textarea class="form-control" id="torneo_descripcion" placeholder="Descripción breve del campeonato" name="torneo_descripcion"></textarea>
            </div>


            <div class="mb-1">
                <label>Fecha</label>
                <input type="datetime-local" class="form-control" value="' . date('Y-m-d H:00') . '" name="torneo_fecha" id="torneo_fecha">
            </div>

            <div class="mb-1">
                <label>Dirección</label>
                <input type="text" class="form-control"  name="torneo_direccion" id="torneo_direccion">
            </div>
        
    



        
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onClick="save_torneo()">Crear</button>
      </div>
    </div>
  </div>
</div>






<!-- Modal -->
<div class="modal fade" id="nuevoEquipo" tabindex="-1" aria-labelledby="nuevoEquipoLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nuevoEquipoLabel">Nuevo Equipo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        

        <form>
            <div class="mb-1">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" autofocus class="form-control" id="nombre_equipo">
                <input type="hidden" value="1" class="form-control" id="deporte">
                
            </div>
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="save_equipo()">Crear</button>
      </div>
    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade" id="asignarJugador" tabindex="-1" aria-labelledby="asignarJugadorLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="asignarJugadorLabel">Asignación de Jugador  </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        

        <form>
        <input type="hidden" id="id_equipo" >
            <div class="mb-1">
                <label>Jugador</label>
                <select class="form-select" id="asig_jugador">
                    <option value="">Seleccionar</option>
                    ' . $contentJugadoresGlobal . '
                </select>
            </div>
            <div class="mb-1">
                <label>Posición</label>
                <select class="form-select" id="asig_posicion">
                    <option value="">Seleccionar</option>
                    ' . $contentPosiciones . '
                </select>
            </div>
              <div class="mb-1">
                <label for="numero" class="form-label">Numero del jugador</label>
                <input type="number" class="form-control" id="asig_numero">
            </div>
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="save_jugador()">Crear</button>
      </div>
    </div>
  </div>
</div>




    <div class="col-md-9  listadoAlineacionEquipos" > 

        <div class="col-sm-12 row"> 
           ' . $nuevoTorneo . '

            <div class="col-6 d-none">
                <select class="form-select col-4 " onchange="redireccion(`voleybol`, `torneo=`+this.value)" > 
                    <option>Seleccionar Torneo</option>
                    ' . $listTorneos . '
                </select>
            </div>


            <div class="'.$altNuevoTorneo.' col-sm-12 torneosVoley m-0 p-0">
                ' . $listadoTorneos . '
            </div>


            <hr class="mt-2">
        </div>
            
';
if (!empty($_GET['torneo'])) {

    $contenido .= '
    <input type="hidden" value="' . $_GET['torneo'] . '"  id="id_torneo">
        <div class="row">
        <div class="col-sm-12 col-md-6">
             ' . $crearEquipo . '
             <a class="btn btn-outline-primary" target="_blank" href="./services/visualizador_general.php?torneo='.$_GET['torneo'].'"><i class="fa fa-share"></i></a>
            <h5 class="mt-1">Equipos</h5>
            <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
               <!-- <th scope="col">Nro.Jugadores</th>-->
                ' . $jugador . '
                <th scope="col">Ver </th>
                </tr>
            </thead>
            <tbody>
                ' . $conten . '
            </tbody>
            </table>
        </div>



        <div class="col-sm-12 col-md-6" id="listJugadores">
            
            <h5 class="mt-1">Jugadores</h5>
            
            <table class="table table-hover table-responsive">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Posición</th>
                <th scope="col">Detalle</th>
                <!--<th scope="col">Anotado</th>-->
                </tr>
            </thead>
            <tbody>
                ' . $contenJugadores . '
            </tbody>
            </table>
        </div>


        </div>
    </div>

    <div class="col-md-3 col-sm-12 justify-content-end d-flex  ">
  <div class="w-100 cancha canchavoley shadow  ">
            <div class="areavoley1">
    ';




    if (!empty($_GET['equipo']) && $responseJugadores) {

        foreach ($responseJugadores as $resJugadores) {



            if ($resJugadores['posicion'] == 1 && $resJugadores['seleccionado']) {
                $contenido .= ' <div class="jugador jugador1 jugadorSeleccionado">' . $resJugadores['numero'] . '</div>';
            } else {
                $contenido .= ' <div class="jugador jugador1 "></div>';
            }
            if ($resJugadores['posicion'] == 2 && $resJugadores['seleccionado']) {
                $contenido .= ' <div class="jugador jugador2 jugadorSeleccionado">' . $resJugadores['numero'] . '</div>';
            } else {
                $contenido .= ' <div class="jugador jugador2 "></div>';
            }
            if ($resJugadores['posicion'] == 3 && $resJugadores['seleccionado']) {
                $contenido .= ' <div class="jugador jugador3 jugadorSeleccionado">' . $resJugadores['numero'] . '</div>';
            } else {
                $contenido .= ' <div class="jugador jugador3 "></div>';
            }
            if ($resJugadores['posicion'] == 4 && $resJugadores['seleccionado']) {
                $contenido .= ' <div class="jugador jugador4 jugadorSeleccionado">' . $resJugadores['numero'] . '</div>';
            } else {
                $contenido .= ' <div class="jugador jugador4 "></div>';
            }
            if ($resJugadores['posicion'] == 5 && $resJugadores['seleccionado']) {
                $contenido .= ' <div class="jugador jugador5 jugadorSeleccionado">' . $resJugadores['numero'] . '</div>';
            } else {
                $contenido .= ' <div class="jugador jugador5 "></div>';
            }
            if ($resJugadores['posicion'] == 6 && $resJugadores['seleccionado']) {
                $contenido .= ' <div class="jugador jugador6 jugadorSeleccionado">' . $resJugadores['numero'] . '</div>';
            } else {
                $contenido .= ' <div class="jugador jugador6 "></div>';
            }
        }
    }

    $contenido .= '
      
               
            </div>
            
            <div class=" mediovoley"></div>
        </div>
    </div>';
}
$data = [
    'titulo' => 'Voleibol',
    'contenido' => $contenido
];


echo json_encode($data);
