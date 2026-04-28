<!DOCTYPE html>
<html lang="es">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Descarga App - DEPORTAZO</title>
    <link rel="icon" href="https://deportazo.com/dist/assets/img/logo2.png" type="image/x-icon">
    <meta name="theme-color" content="#000000">

    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Deportazo 1.0">
    <meta name="author" content="GeorkingWeb">
    <meta name="description"
        content="Plataforma interactiva para el registro de campeonatos, deportistas interesados en formar parte de la comunidad deportiva en Madrid - España.">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>

<body>
    <?php
    // Validar sesión y grupo
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Obtener id_grupo desde la sesión
    $id_grupo = isset($_SESSION['usuario']['nombre_grupo']) ? $_SESSION['usuario']['nombre_grupo'] : null;
    
    if (!$id_grupo) {
        // Si no hay grupo en sesión, intentar obtener de GET
        $id_grupo = isset($_GET['grupo']) ? $_GET['grupo'] : null;
    }
    
    if (!$id_grupo) {
        die('<div class="alert alert-danger" role="alert"><strong>Error:</strong> No autorizado. Grupo no identificado. Por favor, inicia sesión.</div>');
    }
    
    // Incluir datos del grupo
    include '../../grupos/datosGrupo.php';
    
    // Validar que el grupo existe en datosGrupo
    if (!isset($dataGrupo[$id_grupo])) {
        die('<div class="alert alert-danger" role="alert"><strong>Error:</strong> Grupo no válido.</div>');
    }
    
    $grupo_info = $dataGrupo[$id_grupo];
    $nombre_grupo = $grupo_info['nombre'] ?? 'Deportazo';
    $logo_grupo = $grupo_info['logo'] ?? '../../dist/assets/img/logo.png';
    $imagen_grupo = $grupo_info['imagenApp'] ?? '../../dist/assets/img/grupos/corazonlatino.png';
    $apk_grupo = $grupo_info['apk'] ?? '../../grupos/corazonlatino/appCorazonLatino.apk';
    $url_qr = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $url_qr .= $_SERVER['HTTP_HOST'] . '/dist/pages/app.php?grupo=' . $id_grupo;
    $color_primario = $grupo_info['colores']['primario'] ?? '#1c4354';
    ?>
    
    <div class="row m-0 justify-content-center text-center d-flex position-fixed w-100 h-100 align-items-center" 
         style="background: linear-gradient(135deg, <?= $color_primario ?>45 0%, <?= $color_primario ?>25 100%) !important">
        
        <div class="col-md-6 col-sm-12 px-3">
            <!-- Logo Deportazo -->
            <img width="70%" class="mx-5 mb-3" src="../assets/img/logo.png" alt="Deportazo Logo">

            <!-- QR Dinámico -->
            <div id="qrcode" class="mb-3" style="display: inline-block; background: white; padding: 10px; border-radius: 8px;"></div>
            
            <br><br>
            
            <!-- Botón de descarga -->
            <a class="btn btn-primary btn-lg" href="<?= $apk_grupo ?>" download style="background-color: <?= $color_primario ?>; border-color: <?= $color_primario ?>;">
                <i class="bi bi-phone display-4"></i><br>
                <small>Click aquí para descargar</small><br>
                <span class="pe-3 fw-bold" style="font-size: 1.1rem;"> APP <?= strtoupper($nombre_grupo) ?></span>
            </a>
            <br>
            <small class="text-muted">¡Válido solo para Android!</small>
        </div>
        
        <div class="col-md-6 col-sm-12 px-3">
            <!-- Imagen del grupo -->
            <img width="80%" src="<?= $imagen_grupo ?>" alt="<?= $nombre_grupo ?>" style="max-height: 500px; object-fit: contain;">
        </div>
    </div>

    <script>
        // Generar código QR dinámicamente
        document.addEventListener('DOMContentLoaded', function() {
            new QRCode(document.getElementById('qrcode'), {
                text: '<?= $url_qr ?>',
                width: 200,
                height: 200,
                colorDark: '#000000',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
        });
    </script>

</body>
</html>