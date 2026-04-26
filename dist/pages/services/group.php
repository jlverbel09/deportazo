<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$grupo = $_SESSION['grupo'] ?? null;

if (empty($grupo) && !empty($_GET['grupo'])) {
    $grupo = $_GET['grupo'];
    $_SESSION['grupo'] = $grupo;
}

$dataGrupo = [];
if (!empty($grupo)) {
    include_once __DIR__ . '/../../../grupos/datosGrupo.php';
}
