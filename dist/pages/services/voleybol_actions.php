<?php
require_once '../conexion.php';
$data =  (object) [];


if (isset($_POST['accion']) && $_POST['accion'] == 'crear_torneo') {

    $stm = $conexion->prepare("INSERT INTO torneo (nombre, id_deporte,  nro_equipos,tipo, descripcion, fecha, direccion, status,created_at)  
    VALUES (?,?,?,?,?,?,?,?,?)");

    $stm->execute([
        $_POST['torneo_nombre'],
        $_POST['torneo_deporte'],
        $_POST['torneo_nro_equipos'],
        $_POST['torneo_tipo_juego'],
        $_POST['torneo_descripcion'],
        $_POST['torneo_fecha'],
        $_POST['torneo_direccion'],
        1,
        date('Y-m-d')
    ]);

    if ($stm) {
        $data->estado = 'success';
        $data->mensaje = 'Torneo creado correctamente';
    }
}

if (isset($_POST['accion']) && $_POST['accion'] == 'crear_equipo') {
    $codTorneo = $_POST['id_torneo'];
    $respColor = $conexion->query("select codigo from colores where codigo not in (select color from equipos  where equipos.id_torneo = $codTorneo) order by colores.id asc limit 1 ")->fetch();


    $stm = $conexion->prepare("INSERT INTO equipos (nombre, id_deporte,  id_torneo, color)  
    VALUES (?,?,?,?)");

    $stm->execute([
        $_POST['nombre_equipo'],
        $_POST['deporte'],
        $_POST['id_torneo'],
        $respColor['codigo']
    ]);

    if ($stm) {
        $data->estado = 'success';
        $data->mensaje = 'Equipo registrado correctamente';
    }
}

if (isset($_POST['accion']) && $_POST['accion'] == 'asignar_jugador') {
    $stm = $conexion->prepare("INSERT INTO equipo_jugador (id_jugador, id_equipo, posicion, numero, seleccionado,id_torneo)  
    VALUES (?,?,?,?,?,?)");

    $stm->execute([
        $_POST['asig_jugador'],
        $_POST['id_equipo'],
        $_POST['asig_posicion'],
        $_POST['asig_numero'],
        1,
        $_POST['id_torneo']
    ]);

    if ($stm) {
        $data->estado = 'success';
        $data->mensaje = 'Jugador Asignado correctamente';
    }
}

if (isset($_POST['accion']) && $_POST['accion'] == 'ver_marcador') {

    $resMarcador = $conexion->query("select e.*, e2.nombre as equipo_local, e2.color as color_equipo_local, e3.nombre as equipo_visitante , e3.color as color_equipo_visitante from enfrentamientos2 e
    inner join equipos e2 on e2.id = e.id_equipo_local
    inner join equipos e3 on e3.id = e.id_equipo_visitante 
    where e.id  =  " . $_POST['id'])->fetch();

    if ($resMarcador) {
        $data->estado = 'success';
        $data->body = $resMarcador;
    }
}

if (isset($_POST['accion']) && $_POST['accion'] == 'guardarAnotacion') {
    $accionPunto = $_POST['accionPunto'];
    $equipoMarcador = $_POST['equipoMarcador'];
    $id_enfrentamiento = $_POST['id_enfrentamiento'];
    $m_equipoVisitante = $_POST['m_equipoVisitante'];
    $m_equipoLocal = $_POST['m_equipoLocal'];
    $id_equipoLocal = $_POST['id_equipoLocal'];
    $id_equipoVisitante = $_POST['id_equipoVisitante'];
    $subquery = "";
    if ($m_equipoLocal > $m_equipoVisitante) {
        $subquery = " , ganador=$id_equipoLocal, perdedor=$id_equipoVisitante ";
    } else if ($m_equipoVisitante > $m_equipoLocal) {
        $subquery = " , ganador=$id_equipoVisitante, perdedor=$id_equipoLocal ";
    }


    if ($equipoMarcador == 'local') {
        $query = "update enfrentamientos2 set marcador_local =  $m_equipoLocal $subquery where id = $id_enfrentamiento";
    } else if ($equipoMarcador == 'visitante') {
        $query = "update enfrentamientos2 set marcador_visitante = $m_equipoVisitante $subquery where id = $id_enfrentamiento";
    }


    $respuesta = $conexion->query($query);
    if ($respuesta) {
        $data->estado = 'success';
        $data->mensaje = 'Marcador Registrado';
    }
}


if (isset($_POST['accion']) && $_POST['accion'] == 'guardarEnfrentamiento') {

    $query = "insert into enfrentamiento_rapido (cantidad_equipos, estado, equipo1,equipo2,equipo3,equipo4,equipo5,equipo6,fecha_reg)
    values(?,?,?,?,?,?,?,?,?)";

    $stm = $conexion->prepare($query);

    $stm->execute([
        $_POST['cant_equipos'],
        'A',
        'A-' . $_POST['equipo_1'],
        'B-' . $_POST['equipo_2'],
        'C-' . $_POST['equipo_3'],
        'D-' . $_POST['equipo_4'],
        'E-' . $_POST['equipo_5'],
        'F-' . $_POST['equipo_6'],
        date('Y-m-d')
    ]);

    if ($stm) {
        $data->estado = 'success';
        $data->mensaje = 'Enfrentamientos generados';
    }
}


if (isset($_GET['accion']) && $_GET['accion'] == 'finalizarEnfrentamiento') {
    $restms = $conexion->query("update enfrentamiento_rapido er  set estado = 'I'");
    if ($restms) {
        $data->estado = 'success';
        $data->mensaje = 'Enfrentamiento finalizado correctamente';
    }
}
if (isset($_GET['accion']) && $_GET['accion'] == 'cargarEnfrentamiento') {
    $query = $conexion->query("select * from enfrentamiento_rapido er  where estado = 'A'");
    $restms = $query->fetch();

    if ($restms['cantidad_equipos'] <= 4) {
        $cantidad = 2;
    } else if ($restms['cantidad_equipos'] > 4) {
        $cantidad = 3;
    }
    $html = '<div>
                <br><b>Jornada 1</b>';
    $listEnfrentamientos = $conexion->query("select id,
        case when `local` = 'A' then
            (select equipo1 from enfrentamiento_rapido where estado = 'A')
            when `local` = 'B' then 
            (select equipo2 from enfrentamiento_rapido where estado = 'A')
            when `local` = 'C' then 
            (select equipo3 from enfrentamiento_rapido where estado = 'A')
            when `local` = 'D' then 
            (select equipo4 from enfrentamiento_rapido where estado = 'A')
            when `local` = 'E' then 
	        (select equipo5 from enfrentamiento_rapido where estado = 'A')
             when `local` = 'F' then 
	        (select equipo6 from enfrentamiento_rapido where estado = 'A')
            end as local, 
        case when `visitante` = 'A' then
            (select equipo1 from enfrentamiento_rapido where estado = 'A')
            when `visitante` = 'B' then 
            (select equipo2 from enfrentamiento_rapido where estado = 'A')
            when `visitante` = 'C' then 
            (select equipo3 from enfrentamiento_rapido where estado = 'A')
            when `visitante` = 'D' then 
            (select equipo4 from enfrentamiento_rapido where estado = 'A')
             when `visitante` = 'E' then 
            (select equipo5 from enfrentamiento_rapido where estado = 'A')
            when `visitante` = 'F' then 
            (select equipo6 from enfrentamiento_rapido where estado = 'A')
            end as visitante,estado,ganador
        from guia_enfrentamiento_rapido ger where cant_equipos = (select cantidad_equipos   from enfrentamiento_rapido er where estado = 'A' )")->fetchAll();

    $j = 0;
    $i = 1;
    foreach ($listEnfrentamientos as $l) {

        if ($j == $cantidad) {
            $i++;
            $html .= "<br><b>Jornada " . $i . "</b>";
            $j = 0;
        }
        if ($l['visitante'] <> '') {
            $visitante = strtoupper($l['visitante']);
        } else {
            $visitante = '';
        }



        if ($visitante == '') {
            $td = '<td class="d-flex align-items-center bg-info">
                    <input type="text" readonly value="' . strtoupper($l['local']) . '" class="form-control bg-info text-white" >
                   <b>&nbsp;&nbsp;Descansa<b>
                </td>';
        } else {

            if ($l['estado'] == 'A') {
            } else {


                
            }

            if (explode('-', $l['local'])[0] == $l['ganador']) {
                $estadoLocal = 'bg-success';
                $btnEstadoLocal = "btn-outline-secondary text-light";
                $iconolocal = 'check';
            } else {
                $estadoLocal = '';
                $btnEstadoLocal = "btn-outline-black text-dark";
                $iconolocal = 'square';
            }
            if (explode('-', $l['visitante'])[0] == $l['ganador']) {
                $estadoVisitante = 'bg-success';
                $btnEstadovisi = "btn-outline-secondary text-light";
                $iconovis = 'check';
            } else {
                $estadoVisitante = '';
                $btnEstadovisi = "btn-outline-dark text-dark";
                $iconovis = 'square';
            }
            $td = '<td class="d-flex align-items-center ' . $estadoLocal . '">
                        <button class=" border-white btn ' . $btnEstadoLocal . ' me-2" onclick="cambiarEstado(' . $l['id'] . ',\'' . $l['local'] . '\')"><i class="  fa fa-' . $iconolocal . '"></i></button>
                        <input type="text" readonly value="' . strtoupper($l['local']) . '" class="form-control" >
                    </td>

                    <td class=" text-center"><b>&nbsp;&nbsp;VS&nbsp;&nbsp;</b>  </td>  

                    <td class="d-flex align-items-center ' . $estadoVisitante . '">
                        <input type="text" readonly value="' . strtoupper($visitante) . '" class="form-control" >
                        <button class=" border-white btn ' . $btnEstadovisi . ' ms-2" onclick="cambiarEstado(' . $l['id'] . ',\'' . $l['visitante'] . '\')"><i class="fa fa-' . $iconovis . '"></i></button>
                    </td>';
        }

        $html .= '
            <table class="table table-bordered">
                <tr>
                    ' . $td . '
                </tr>
            </table>
                    
                ';
        $j++;
    }

    $html .= "</div>";

    if ($restms) {
        $data->estado = 'success';
        $data->mensaje = 'Carga de enfrentamiento';
        $data->body = $restms;
        $data->html = $html;
        $data->cantidad = $cantidad;
    }
}

if (isset($_GET['accion']) && $_GET['accion'] == 'cambiarEstado') {

    $equipo = $_GET['equipo'];
    $equipo = explode('-', $equipo);
    $equipo = $equipo[0];
    if ($equipo == 'A') {
        $campoPunt = "update  enfrentamiento_rapido set  punt_equipo1 = (select punt_equipo1 +3 from enfrentamiento_rapido er where estado = 'A') where estado = 'A'";
    } else if ($equipo == 'B') {
        $campoPunt = "update  enfrentamiento_rapido set  punt_equipo2 = (select punt_equipo2 +3 from enfrentamiento_rapido er where estado = 'A') where estado = 'A'";
    } else if ($equipo == 'C') {
        $campoPunt = "update  enfrentamiento_rapido set  punt_equipo3 = (select punt_equipo3 +3 from enfrentamiento_rapido er where estado = 'A') where estado = 'A'";
    } else if ($equipo == 'D') {
        $campoPunt = "update  enfrentamiento_rapido set  punt_equipo4 = (select punt_equipo4 +3 from enfrentamiento_rapido er where estado = 'A') where estado = 'A'";
    } else if ($equipo == 'E') {
        $campoPunt = "update  enfrentamiento_rapido set  punt_equipo5 = (select punt_equipo5 +3 from enfrentamiento_rapido er where estado = 'A') where estado = 'A'";
    } else if ($equipo == 'F') {
        $campoPunt = "update  enfrentamiento_rapido set  punt_equipo6 = (select punt_equipo6 +3 from enfrentamiento_rapido er where estado = 'A') where estado = 'A'";
    }

    $restms = $conexion->query("update guia_enfrentamiento_rapido  set estado = 'F', ganador = '$equipo' where id = " . $_GET['id']);
    if ($restms) {
        $puntaje = $conexion->query($campoPunt);
        $data->estado = 'success';
        $data->mensaje = 'Enfrentamiento finalizado correctamente';
    }
}

if (isset($_GET['accion']) && $_GET['accion'] == 'restaurarReencuentros') {
    $restms = $conexion->query("update guia_enfrentamiento_rapido  set estado = 'A' , ganador = null where cant_equipos = (select cantidad_equipos   from enfrentamiento_rapido er where estado = 'A' )");
    if ($restms) {
        $conexion->query("update  enfrentamiento_rapido set  punt_equipo1 = 0, punt_equipo2=0, punt_equipo3=0, punt_equipo4=0, punt_equipo5=0, punt_equipo6=0 where estado = 'A'");
        $data->estado = 'success';
        $data->mensaje = 'Enfrentamientos reestablecidos correctamente';
    }
}

if (isset($_GET['accion']) && $_GET['accion'] == 'cargarTablaEnfrentamientosRapidos') {

    $cantidad_equipos = $_GET['cantidad_equipos'];
    $resEnfRapidos = $conexion->query("select * from (
select 1 as posicion, equipo1 as equipo , punt_equipo1 as puntos  from enfrentamiento_rapido where estado  = 'A'
union
select 2 as posicion, equipo2 as equipo , punt_equipo2  as puntos from enfrentamiento_rapido where estado  = 'A'
union 
select 3 as posicion,equipo3 as equipo , punt_equipo3  as puntos from enfrentamiento_rapido where estado  = 'A'
union
select 4 as posicion,equipo4 as equipo , punt_equipo4  as puntos from enfrentamiento_rapido where estado  = 'A'
union 
select 5 as posicion,equipo5 as equipo , punt_equipo5  as puntos from enfrentamiento_rapido where estado  = 'A'
union 
select 6 as posicion,equipo6 as equipo , punt_equipo6  as puntos from enfrentamiento_rapido where estado  = 'A'
) j order by 3 desc,1 limit " . $cantidad_equipos)->fetchAll();

    $tablaRapida = [];



    $tablaHtml = '<table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th colspan="3">JUEGO RÁPIDO</th>
                        </tr>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Equipo</th>
                            <th scope="col"class="text-center">Pts</th>
                        </tr>
                    </thead>
                    <tbody>';


    foreach ($resEnfRapidos as $r) {
        static $i = 0;
        if ($i == 0) {
            $estado = 'bg-success text-white';
        } else {
            $estado = '';
        }
        $i++;


        $tablaHtml .= '
              <tr >
                            <th class="' . $estado . '" scope="row" >' . $i . '</th>
                            <td class="nombreEquipoTabla  ' . $estado . '">
                                ' . strtoupper($r['equipo']) . '
                            </td>
                            <td class="text-center ' . $estado . '">' . $r['puntos'] . '</td>
                        </tr>';
    }

    $tablaHtml .= '
                     
                    </tbody>
                </table>';

    $data->estado = 'success';
    $data->mensaje = 'Tabla de enfrentamientos rapidos';
    $data->tabla = $tablaHtml;
    $data->body = $tablaRapida;
}

echo json_encode($data);
