<?php
require_once '../conexion.php';
error_reporting(0);

?>

<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Deportazo</title>
    <link rel="icon" href="https://georkingweb.com/deportazo/dist/assets/img/logo2.png" type="image/x-icon">
    <meta name="theme-color" content="#AE0909">

    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Deportazo 1.0">
    <meta name="author" content="GeorkingWeb">
    <meta name="description"
        content="Plataforma interactiva para el registro de campeonatos, deportistas interesados en formar parte de la comunidad deportiva en Madrid - España.">

    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
        integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../../css/adminlte.css">
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/style-emergency.css">
    <!--  <link rel="stylesheet" href="../../css/canchas.css"> -->
    <link rel="stylesheet" href="../../css/esquema1.css">
    <link rel="stylesheet" href="../../css/responsive.css">
    <style>
        .row .row.grupos {
            border: 2px solid gainsboro;
            border-radius: 8px;
            margin: 5px 1% !important;
        }

        .row.principal {
            margin: 10px;
            justify-content: center;
        }

        .seccionEnfrentamientos {
            display: none;
        }

        .esquema2 {
            overflow-x: scroll;
            position: relative;
            top: -40px;
            padding: 0 !important;
            height: 407px;
            overflow-y: hidden;
        }

        .esquema1 {
            overflow-x: scroll;
            position: relative;
            top: -136px;
            padding: 0 !important;
            overflow-y: hidden;
            height: auto;
            padding-bottom: 51px !important;
        }
    </style>
</head>

<body>





    <?php
    $nombreTorneo = $conexion->query("select * from torneo t where t.id =  " . $_GET['torneo'])->fetch();
    $idtorneo = $_GET['torneo'];
    ?>
    <div class="row principal">
        <div class="col-3">
            
            <img class="bordered" src="https://georkingweb.com/deportazo/dist/assets/img/torneo/<?=$idtorneo?>.jpg" width="100%" alt="">
        </div>
       <div class="col-9">
         <h1 class="text-center"><?= $nombreTorneo['nombre'] ?></h1>
       </div>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active w-50" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">DETALLE</button>
                <button class="nav-link w-50" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">GANADORES</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">



                <!-- TABLA DE CLASIFICACION -->
                <?php $recarga = 1; include './torneos.php' ?>


                <!-- LISTADO DE EQUIPOS Y SUS PARTICIPANTES -->
                <div class="row justify-content-center d-flex mt-4 " style="    position: relative;
    top: -20px;
    margin: 0;  ">
                    <?php
                    $data = $conexion->query("select * from equipos e where e.id_deporte = 1 and e.id_torneo =  " . $_GET['torneo'])->fetchAll();
                    $i = 0;

                    foreach ($data as $d) {
                    ?>
                        <div class="row m-0 col-md-3 col-sm-12 grupos ">
                            <div class=" col-md-6 col-6 m-0 p-0">
                                <h5 class="mt-1">Equipos</h5>
                                <table class="table table-hover">
                                    <thead>
                                        <tr><!-- 
                            <th scope="col">#</th> -->
                                            <th scope="col">Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $responseEquipo = $conexion->query("select * from equipos e where e.id_deporte = 1 and e.id_torneo =  " . $_GET['torneo'])->fetchAll();
                                        $i = 0;
                                        foreach ($responseEquipo as $resEquipo) {
                                            $i++;
                                            if ($resEquipo['id'] == $d['id']) {
                                                $seleccionado = "seleccionado";
                                            } else {
                                                $seleccionado = "";
                                            }
                                        ?>
                                            <tr class="<?= $seleccionado ?>">
                                                <!--  <th scope="row"><?= $i ?></th> -->
                                                <td><i class="bi bi-shield-fill mt-1 me-1" style="color:<?= $resEquipo['color'] ?>"></i><?= $resEquipo['nombre'] ?></td>
                                            </tr>
                                        <?php  } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 col-6" id="listJugadores">
                                <h5 class="mt-1">Jugadores</h5>
                                <table class="table table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $responseJugadores = $conexion->query("select ej.*, u.nombre as nombre_jugador, e.nombre , pv.nombre as posicion_nombre, ej.seleccionado from equipo_jugador ej 
                                inner join usuario u on u.id = ej.id_jugador 
                                left join equipos e on e.id  = ej.id_equipo  
                                inner join posiciones_voley pv on pv.id =ej.posicion 
                                where id_equipo =" . $d['id'] . " order by  seleccionado desc , ej.posicion desc  ")->fetchAll();

                                        $j = 0;
                                        foreach ($responseJugadores as $resJugadores) {
                                            $j++
                                        ?>
                                            <tr>
                                                <th scope="row"><?= $j ?></th>
                                                <td><?= ucwords($resJugadores['nombre_jugador']) ?></td>
                                            </tr>

                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            </div>





            <div class="tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">


                <br>
                <?php include './triunfos.php' ?>


            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>


</body>