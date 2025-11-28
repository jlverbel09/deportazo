<?php
require_once '../conexion.php';

$res = $conexion->query("select * from equipos  where id_torneo  =  " . $_POST['id_torneo'] . " order by id ")->fetchAll();

$i = 0;
$a = 0;
foreach ($res as $r) {
    $a++;
    foreach ($res as $j) {
        if ($r['id'] != $j['id']) {
            $id_equipo_local = $r['id'];
            $id_equipo_visitante = $j['id'];
            $consulta = $conexion->query("select count(*) as cantidad from enfrentamientos2 e where id_torneo  = " . $_POST['id_torneo'] . "
                                    and fase = 0 and (id_equipo_local  = $id_equipo_local and id_equipo_visitante =$id_equipo_visitante) or 
                                    (id_equipo_local  = $id_equipo_visitante and id_equipo_visitante = $id_equipo_local);")->fetch();

            if ($consulta['cantidad'] == 0) {

                $sql = "INSERT INTO enfrentamientos2 (id_torneo, id_equipo_local, id_equipo_visitante, marcador_local, marcador_visitante)
                VALUES (?,?,?,?,?)";
                $stmt = $conexion->prepare($sql);
                $response = $stmt->execute([
                    $_POST['id_torneo'],
                    $id_equipo_local,
                    $id_equipo_visitante,
                    0,
                    0
                ]);
                $i++;
            }
        }
    }
}

$fase = $conexion->query('select (select tipo from torneo t where id= enfrentamientos2.id_torneo )as tipo , fase from enfrentamientos2 where id_torneo = ' . $_POST['id_torneo'] . '  group by fase order by fase desc limit 1')->fetch();


$res2 = $conexion->query("select count(id) as faltantes from enfrentamientos2 e  where (fase = 0 and ganador = 0 and perdedor = 0) or (fase = 1 and ganador = 0 and perdedor = 0) or (fase = 2 and ganador = 0 and perdedor = 0) or (fase = 3) and id_torneo = " . $_POST['id_torneo'])->fetch();

$tipo = $fase['tipo'];
$fase = $fase['fase'];

$data = [
    'tipo' => $tipo,
    'fase' => $fase,
    'faltantes' => $res2['faltantes']
];
echo json_encode($data);
