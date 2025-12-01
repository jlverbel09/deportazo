<?php
require_once './conexion.php';
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();


if (empty($_SESSION['usuario']) && $_GET['public'] == 0) {
    header('Location: login.php');
 
}
$responseTorneo = $conexion->query("select id from torneo t where status !=2  order by id desc limit 1")->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Deportazo</title>
    <link rel="icon" href="https://georkingweb.com/deportazo/dist/assets/img/logo2.png" type="image/x-icon">
    <meta name="theme-color" content="#000000">

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
    <link rel="stylesheet" href="../../dist/css/adminlte.css">
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
    <link rel="stylesheet" href="../../dist/css/style.css">
    <link rel="stylesheet" href="../../dist/css/style-emergency.css">

    <!--  <link rel="stylesheet" href="../../dist/css/canchas.css"> -->
    <link rel="stylesheet" href="../../dist/css/esquema1.css">
    <link rel="stylesheet" href="../../dist/css/responsive.css">
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg ">
    <?php include './layouts/header-title.php' ?>
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->


        <div class="loading"><img class="balon" src="../../dist/assets/img/logo2.png"><img src="https://media.tenor.com/On7kvXhzml4AAAAi/loading-gif.gif" alt=""></div>


        <?php include './layouts/nav.php' ?>

        <?php include './layouts/main.php' ?>

        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0 tituloprincipal"></h3>
                        </div>


                        <?php if ((isset($_GET['public']) && $_GET['public'] == 0) || !isset($_GET['public'])): ?>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-end">
                                    <li class="breadcrumb-item"><a href="#" onclick="redireccion('inicio')">Inicio</a></li>
                                    <li class="breadcrumb-item active tituloprincipal" aria-current="page">

                                    </li>
                                </ol>
                            </div>
                        <?php endif ?>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->