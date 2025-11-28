<?php
require_once '../conexion.php';



$sql = "select count(*) as cantidad from enfrentamientos2  where id_torneo  =  " . $_POST['id_torneo'] . " and fase = 1 ";

$res = $conexion->query($sql)->fetch();
$j = 0;
if ($res['cantidad'] == 0) {

    /*   $sqlTruncate = "delete from enfrentamientos e where id_torneo =  " . $_POST['id_torneo'];
    $conexion->query($sqlTruncate);
 */

    $ids_equipos = [];
    $res = $conexion->query("select * from equipos  where id_torneo  =  " . $_POST['id_torneo'])->fetchAll();

    shuffle($res);

    $ubicacion = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
    $i = 0;
    foreach ($res as $r) {
        $sql = "INSERT INTO enfrentamientos (id_torneo, ubicacion, id_equipo, marcador) VALUES (?,?,?,?)";
        $stmt = $conexion->prepare($sql);
        $response = $stmt->execute([$_POST['id_torneo'], $ubicacion[$i], $r['id'], 0]);
        $i++;
    }


    $sql = "INSERT INTO enfrentamientos2 (id_torneo, id_equipo_local, id_equipo_visitante, marcador_local, marcador_visitante, fase )
    (select " . $_POST['id_torneo'] . "  , e1.id_equipo , e2.id_equipo , 0 ,0 ,1  from guia_enfrentamientos ge 
    inner join enfrentamientos e1 on e1.ubicacion = ge.`local` and e1.id_torneo = " . $_POST['id_torneo'] . "
    inner join enfrentamientos e2 on e2.ubicacion = ge.`visitante` and e2.id_torneo = " . $_POST['id_torneo'] . "
    where ge.id_tipo  = 1 limit 4 )";
    $conexion->query($sql);

    if ($res) {
        $j++;
    }
}




$sql = "select count(*) as cantidad from enfrentamientos2  where id_torneo  =  " . $_POST['id_torneo'] . " and fase = 2 ";

$res = $conexion->query($sql)->fetch();


if ($res['cantidad'] == 0 && $j == 0) {


    $sql = "INSERT INTO enfrentamientos2 (id_torneo, id_equipo_local, id_equipo_visitante, marcador_local, marcador_visitante, fase )
    (select  " . $_POST['id_torneo'] . " , (
select id from (
select (select  e3.ubicacion  from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.* from enfrentamientos2 e 
                            inner join equipos e2 on e2.id = e.ganador
                            where (fase = 1 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  =  " . $_POST['id_torneo'] . " ) a where a.ubicacion = 'A' or a.ubicacion = 'B'
)  ,(
select id  from (
select (select  e3.ubicacion  from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.* from enfrentamientos2 e 
                            inner join equipos e2 on e2.id = e.ganador
                            where (fase = 1 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  =  " . $_POST['id_torneo'] . " ) a where a.ubicacion = 'C' or a.ubicacion = 'D'
                            ) , 0, 0 , 2 )";




    $conexion->query($sql);



    $sql = "INSERT INTO enfrentamientos2 (id_torneo, id_equipo_local, id_equipo_visitante, marcador_local, marcador_visitante, fase )
    (select  " . $_POST['id_torneo'] . " , (
select id from (
select (select  e3.ubicacion  from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.* from enfrentamientos2 e 
                            inner join equipos e2 on e2.id = e.ganador
                            where (fase = 1 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  =  " . $_POST['id_torneo'] . " ) a where a.ubicacion = 'E' or a.ubicacion = 'F'
)  ,(
select id  from (
select (select  e3.ubicacion  from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.* from enfrentamientos2 e 
                            inner join equipos e2 on e2.id = e.ganador
                            where (fase = 1 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  =  " . $_POST['id_torneo'] . " ) a where a.ubicacion = 'G' or a.ubicacion = 'H'
                            ) , 0, 0 , 2 )";

    $conexion->query($sql);



    if ($res) {
        $j++;
    }
}


$sql = "select count(*) as cantidad from enfrentamientos2  where id_torneo  =  " . $_POST['id_torneo'] . " and fase = 3 ";

$res = $conexion->query($sql)->fetch();


if ($res['cantidad'] == 0 && $j == 0) {

    $sql = "INSERT INTO enfrentamientos2 (id_torneo, id_equipo_local, id_equipo_visitante, marcador_local, marcador_visitante, fase )
    (select  " . $_POST['id_torneo'] . " , (
select id from (
select (select  e3.ubicacion  from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.* from enfrentamientos2 e 
                            inner join equipos e2 on e2.id = e.ganador
                            where (fase = 2 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_POST['id_torneo'] . ") a where a.ubicacion = 'A' or a.ubicacion = 'B'  or a.ubicacion = 'C'  or a.ubicacion = 'D'
)  ,(
select id  from (
select (select  e3.ubicacion  from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.* from enfrentamientos2 e 
                            inner join equipos e2 on e2.id = e.ganador
                            where (fase = 2 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_POST['id_torneo'] . ") a where a.ubicacion = 'E' or a.ubicacion = 'F'  or a.ubicacion = 'G'  or a.ubicacion = 'H'
                            ) , 0, 0 , 3 )";


    $conexion->query($sql);



    if ($res) {
        $j++;
    }
}

echo json_encode($j);
