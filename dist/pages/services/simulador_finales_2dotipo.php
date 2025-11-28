<?php 

require_once '../conexion.php';
$sql = "select count(*) as cantidad from enfrentamientos2  where id_torneo  =  " . $_POST['id_torneo'] . " and fase = 1 ";
$res = $conexion->query($sql)->fetch();


if ($res['cantidad'] == 0) {
    $primerEquipoFinal = $_POST['primerEquipoFinal'];
    $segundoEquipoFinal = $_POST['segundoEquipoFinal'];

    $sql = "INSERT INTO enfrentamientos2 (id_torneo, id_equipo_local, id_equipo_visitante, marcador_local, marcador_visitante, fase)
VALUES (?,?,?,?,?,?)";
    $stmt = $conexion->prepare($sql);
    $response = $stmt->execute([
        $_POST['id_torneo'],
        $primerEquipoFinal,
        $segundoEquipoFinal,
        0,
        0,
        3
    ]);
    if ($response) {
        $j++;
    }
}

echo  $j;
