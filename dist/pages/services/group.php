<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$grupo = $_SESSION['grupo'] ?? $_SESSION['usuario']['nombre_grupo'] ?? null;

if (empty($grupo) && !empty($_GET['grupo'])) {
    $grupo = $_GET['grupo'];
    $_SESSION['grupo'] = $grupo;
}

$dataGrupo = [];
if (!empty($grupo)) {
    include_once __DIR__ . '/../../../grupos/datosGrupo.php';
}

$botones = '#000';
$textobotones = '#ffffff';
$logoGrupo = '../../dist/assets/img/grupos/corazonlatino.png';
if (!empty($grupo) && isset($dataGrupo[$grupo])) {
    $botones = $dataGrupo[$grupo]['colores']['botones'] ?? $botones;
    $textobotones = $dataGrupo[$grupo]['colores']['textoBotones'] ?? $textobotones;
    $logoGrupo = $dataGrupo[$grupo]['ubicacion_logo2'] ?? $logoGrupo;
}
