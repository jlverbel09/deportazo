<?php


require_once '../conexion.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <style>
        .photo-gallery {
            color: #313437;
            background-color: #fff;
        }

        .photo-gallery p {
            color: #7d8285;
        }

        .photo-gallery h2 {
            font-weight: bold;
            margin-bottom: 0px;
            padding-top: 0px;
            color: inherit;
        }

        @media (max-width:767px) {
            .photo-gallery h2 {
                margin-bottom: 25px;
                padding-top: 25px;
                font-size: 24px;
            }
        }

        .photo-gallery .intro {
            font-size: 16px;
            max-width: 500px;
            margin: 0 auto 10px;
        }

        .photo-gallery .intro p {
            margin-bottom: 0;
        }

        .photo-gallery .photos {
            padding-bottom: 20px;
        }

        .photo-gallery .item {
            padding-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="mt-2 ms-3">
        <?php
        session_start();
        if ($_SESSION['usuario']['id_rol'] == 1 or $_SESSION['usuario']['id_rol'] == 2) {
        ?>
            <button class="btn btn-info text-white " title="Guardar Foto" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-camera"></i> Crear Foto</button>
        <?php
        }
        ?>

    </div>
    <div class="photo-gallery">
        <?php
        $response1 = $conexion->query("SELECT * FROM torneo WHERE status != 2 order by id desc")->fetchAll();


        $i=0;
        foreach ($response1 as $t) {
            $i++;
            $id_torneo = $t['id'];
            $nombre_torneo = $t['nombre'];
        ?>
            <div class="container p-0">
                <div class="intro">
                    <h2 class="text-center"><?= ucwords($nombre_torneo) ?></h2>
                    <p class="text-center"><?= ucwords($t['direccion']) ?> </p>
                </div>
                <div class="row p-0 m-0 photos">

                    <?php
                    $i = 0;
                    $response = $conexion->query("SELECT * FROM fotos f WHERE f.id_torneo = $id_torneo  ORDER BY id_torneo desc, campeon desc")->fetchAll();
                    foreach ($response as $fotos) {
                        $i++;
                        $url = "../../assets/img/galeria/" . $fotos['foto'];
                    ?>
                        <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?= $url ?>" data-lightbox="photos"><img class="img-fluid" src="<?= $url ?>"></a></div>

                    <?php
                    }
                    if ($i == 0) {
                    ?>
                        <div class="text-center mb-4">No existen fotos para este torneo</div>
                    <?php
                    }
                    ?>


                </div>
            </div>

        <?php
        }

      /*   if($i==0){
            ?>
<div class="justify-content-center d-flex  w-100 align-items-center " >No hay ninguna foto aún</div>
            <?php
        } */
        ?>
    </div>



    <?php

    if (isset($_POST['formulario'])) {
        $foto = $_FILES['foto'];
        $id_torneo = $_POST['id_torneo'];

        $stm = $conexion->prepare("INSERT INTO fotos (foto, id_torneo)  
        VALUES (?,?)");

        $nombrefoto = $_FILES['foto']['name'];

        $stm->execute([
            $nombrefoto,
            $id_torneo,
        ]);

        $target_Path = "../../assets/img/galeria/";
        $target_Path = $target_Path . basename($nombrefoto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_Path);

        header('location: content_galeria.php');
    }

    ?>

    <!-- Modal -->

    <form action="./content_galeria.php"
        method="POST"
        enctype="multipart/form-data">

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de fotos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="">Torneo</label>
                                <select name="id_torneo" required id="id_torneo" class="form-select">
                                    <?php
                                    foreach ($response1 as $t) {
                                        echo '<option value="' . $t['id'] . '">' . $t['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="">Foto</label>
                                <input type="file" required class="form-control" name="foto" accept="image/*" onchange="previewImage(event, '#imgPreview')">
                            </div>
                            <div class="col-12">
                                <img id="imgPreview" class="w-100">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" name="formulario">Guardar</button>
                    </div>
                </div>
            </div>
        </div>



    </form>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        function previewImage(event, querySelector) {

            //Recuperamos el input que desencadeno la acción
            const input = event.target;

            //Recuperamos la etiqueta img donde cargaremos la imagen
            $imgPreview = document.querySelector(querySelector);

            // Verificamos si existe una imagen seleccionada
            if (!input.files.length) return

            //Recuperamos el archivo subido
            file = input.files[0];

            //Creamos la url
            objectURL = URL.createObjectURL(file);

            //Modificamos el atributo src de la etiqueta img
            $imgPreview.src = objectURL;

        }
    </script>
</body>

</html>