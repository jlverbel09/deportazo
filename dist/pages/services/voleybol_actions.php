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
        $_POST['equipo_1'],
        $_POST['equipo_2'],
        $_POST['equipo_3'],
        $_POST['equipo_4'],
        $_POST['equipo_5'],
        $_POST['equipo_6'],
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
            end as visitante,estado
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
            $btnEstado = "btn-outline-light text-light";
            $estado = 'bg-success';
            $icono = 'check';
            if ($l['estado'] == 'A') {
                $estado = '';
                $btnEstado = "btn-outline-secondary text-secondary";
                $icono = 'square';
            }
            $td = '<td class="d-flex align-items-center ' . $estado . '">
                    <input type="text" readonly value="' . strtoupper($l['local']) . '" class="form-control" >
                    <b>&nbsp;&nbsp;VS&nbsp;&nbsp;</b>    
                    <input type="text" readonly value="' . strtoupper($visitante) . '" class="form-control" >
                </td>
                <td class="' . $estado . '">
                    <button class="btn ' . $btnEstado . '" onclick="cambiarEstado(' . $l['id'] . ')"><i class="fa fa-' . $icono . '"></i></button>
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
    $restms = $conexion->query("update guia_enfrentamiento_rapido  set estado = 'F' where id = ".$_GET['id']);
    if ($restms) {
        $data->estado = 'success';
        $data->mensaje = 'Enfrentamiento finalizado correctamente';
    }
}

if (isset($_GET['accion']) && $_GET['accion'] == 'restaurarReencuentros') {
    $restms = $conexion->query("update guia_enfrentamiento_rapido  set estado = 'A' ");
    if ($restms) {
        $data->estado = 'success';
        $data->mensaje = 'Enfrentamientos reestablecidos correctamente';
    }
}



echo json_encode($data);
