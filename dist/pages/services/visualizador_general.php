<?php
$idtorneo = $_GET['torneo'];
?>


<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏐CORAZÓN LATINO🏐</title>
    <link rel="icon" href="https://georkingweb.com/deportazo/dist/assets/img/grupos/corazonlatino.ico" type="image/x-icon">
    <meta name="theme-color" content="#c7e0ff">

    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta property="og:title" content="CORAZÓN LATINO">
    <meta property="og:description" content="🏐CORAZÓN LATINO, PASIÓN POR EL VOLEIBOL, ESPÍRITUD DE EQUIPO QUE LO DA TODO!!🏐">
    <meta property="og:image" content="https://georkingweb.com/deportazo/dist/assets/img/grupos/corazonlatino.ico">
    <meta property="og:url" content="https://georkingweb.com/deportazo/web/index">
    <meta property="og:type" content="website">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body class="row  justify-content-center d-flex m-0 p-0 " style="height: 100%;">



    <iframe class="col-md-6 col-lg-3 p-0" src="./visualizador_torneo.php?torneo=<?= $idtorneo ?>" frameborder="0"></iframe>



</body>

</html>