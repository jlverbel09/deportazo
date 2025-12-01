<?php

require_once '../dist/pages/conexion.php';


$response = $conexion->query("SELECT * FROM fotos f 
inner join torneo t on t.id  = f.id_torneo
 ORDER BY  f.id=14 desc, f.id=1 desc, id_torneo , campeon desc")->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">

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
  <link rel="stylesheet" href="assets/css/main.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
  <!-- Import Mediaelement CSS -->
  <link href="https://cdn.jsdelivr.net/npm/mediaelement@latest/build/mediaelementplayer.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement-plugins@latest/dist/quality/quality.min.css">


</head>


<body class="is-preload-0 is-preload-1 is-preload-2">

  <!-- Main -->
  <div id="main">

    <!-- Header -->
    <header id="header" class="pb-1">
      <div class="row">
        <div class="col-md-12">
          <img width="50%" class="rounded" src="../dist//assets/img//grupos//corazonlatino.png" alt="">
        </div>
        <div class="col-md-12">
          <p>🏐CORAZÓN LATINO, PASIÓN POR EL VOLEIBOL, ESPÍRITUD DE EQUIPO QUE LO DA TODO!!🏐</p>
        </div>

      </div>


      <ul class="icons">
        <li><a target="_blank" href="https://www.tiktok.com/@corazon__latino" style="border: 1px solid;" class=" btn btn-outline-dark btn-sm icon brands fa-tiktok"><span class="label">Twitter</span> TIK TOK</a></li>
        <!--   <li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
        <li><a href="#" class="icon brands fa-github"><span class="label">Github</span></a></li>
        <li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li> -->
      </ul>
    </header>

    <div class="row m-0 p-0 text-center mb-2">



      <div class="col-6 m-0 mb-1" title="Redireccionamiento a la aplicacion, puedes iniciar sesión y consultar mas detalles sobre el contenido del grupo.">
        <a href="../corazonlatino" target="_blank" class="btn btn-outline-info w-100"><i class="fa fa-globe"></i> APP</a>
      </div>

      <div class="col-6 m-0 mb-1" title="Videos grabados durante los enfrentamientos ya sean amistoso o de campeonatos del grupo.">
        <a id="videos" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-outline-secondary w-100"><i class="fa fa-video"></i> Videos</a>
      </div>
      <div class="col-6 m-0 mb-1" title="Listado de miembros del grupo donde se destaca los triunfos que ha tenido cada participante.">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modaltriunfos" class="btn btn-outline-secondary w-100 "><i class="bi bi-trophy-fill"></i> Triunfos</a>
      </div>

      <div class="col-6 m-0 mb-2" title="Redirección a torneo que se esta jugando actualmente, tabla de posiciones">
        <a href="../dist/pages/services/visualizador_general.php?torneo=6" target="_blank" class="btn btn-outline-success w-100"><i class="fa fa-users"></i> Torneo</a>
      </div>
    </div>

    <!-- Thumbnail -->
    <section id="thumbnails">



      <?php

      foreach ($response as $fotos) {

        $url = "../dist/assets/img/galeria/" . $fotos['foto'];
      ?>

        <article>
          <a class="thumbnail" href="<?= $url ?>" data-position="left center"><img src="<?= $url ?>" alt="" /></a>
          <h2><?= $fotos['nombre'] ?></h2>
          <p></p>
        </article>
      <?php

      }

      ?>



    </section>

    <!-- Footer -->
    <footer id="footer">
      <ul class="copyright">
        <li>&copy;GeorkingWeb</a>.</li>
      </ul>
    </footer>

  </div>




  <link href="https://vjs.zencdn.net/8.23.3/video-js.css" rel="stylesheet" />


  <!-- Modal -->
  <div class="modal fade " style="    z-index: 999999;
" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">VIDEOS - CORAZÓN LATINO</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row justify-content-center  d-flex">




          <?php
          for ($i = 1; $i <= 14; $i++) {
          ?>

            <!--  <video
              id="my-video1"
              class="video-js col-md-2 m-1 bg-dark "
              controls
              preload="auto"
              width="100%"
              height="180"
              poster="videos/<?= $i ?>.jpg" 
              data-setup="{}">
              <source src="./videos/<?= $i ?>.mp4" type="video/mp4" />
              <source src="./videos/<?= $i ?>.mp4" type="video/webm" />
            </video> -->

            <video id="player-demo" width="100%" height="180" preload="none" class="video-js col-md-2 m-1 bg-dark " style="max-width: 100%" controls="" poster="videos/<?= $i ?>.jpg">
              <!-- Add multiple <source>-tags and set text per `data-quality`-attribute -->
              <source type="video/mp4" src="./videos/<?= $i ?>.mp4" data-quality="HD">
              <source type="video/mp4" src="./videos/<?= $i ?>.mp4" data-quality="SD">
              <source type="video/mp4" src="./videos/<?= $i ?>.mp4" data-quality="LD">
              <!-- Just add multiple <track> files, they get integrated automatically -->
              <track src="dist/mediaelement.vtt" srclang="en" label="English" kind="captions" type="text/vtt">
              <track src="dist/mediaelement_german.vtt" srclang="de" label="Deutsch" kind="subtitles" type="text/vtt">
            </video>

          <?php
          }
          ?>






        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>







  <!-- Modal -->
  <div class="modal fade " style="    z-index: 999999;
" id="modaltriunfos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">TRIUNFOS - CORAZÓN LATINO</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">






          <?php


          $response = $conexion->query("select u.id, u.nombre, count(j.id) as triunfos from usuario u  
left join (select u.* from enfrentamientos2 en
inner join equipos e  on e.id = en.ganador 
inner join equipo_jugador ej  on ej.id_torneo = en.id_torneo and ej.id_equipo = e.id 
inner join usuario u on u.id = ej.id_jugador  
inner join torneo t on t.id = e.id_torneo 
where  
	case 
		when t.tipo = 1 or t.tipo = 2 then fase = 3 
		when t.tipo not in (1,2) then fase = 2 
	end 
	) j on j.id = u.id
where u.id_rol  = 3 and u.id <> 3 and u.oficial = 1
group by 1,2 order by triunfos desc,u.nombre")->fetchAll();
          $list_usuarios = '';
          $i = 0;
          foreach ($response as $res) {
            $i++;
            $trofeos = '';
            for ($j = 1; $j <= $res['triunfos']; $j++) {
              $trofeos .= '<i class="bi bi-trophy-fill text-warning me-2"></i>';
            }
            $list_usuarios .= '<tr>
        <td class="border">' . $i . '</td>
        <td class="border">' . $res['nombre'] . '</td>
        <td class="border">' . $trofeos . '</td>
    </tr>';
          }
          ?>

          <div class="row p-0 m-0 justify-content-center ">
            <div class="col-sm-12 tablausuarios">

              <table class="table table-responsive border">
                <thead>
                  <tr>
                    <th class="border">#</th>
                    <th class="border" width="50px">Nombre&nbsp;Jugador&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th class="text-center border">Torneos&nbsp;Ganados</th>

                  </tr>
                </thead>
                <tbody>
                  <?= $list_usuarios ?>
                </tbody>
              </table>
            </div>
          </div>






        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>








  <script src="https://vjs.zencdn.net/8.23.3/video.min.js"></script>




  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/browser.min.js"></script>
  <script src="assets/js/breakpoints.min.js"></script>
  <script src="assets/js/main.js"></script>


  <script src="https://kit.fontawesome.com/c54258ed61.js" crossorigin="anonymous"></script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>




</html>
<script>
  /*   $(document).ready(function() {
    $('#exampleModal').modal('show')
  }) */
</script>

<!-- Import Mediaelement JS -->
<script src="https://cdn.jsdelivr.net/npm/mediaelement@latest/build/mediaelement-and-player.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mediaelement-plugins@latest/dist/quality/quality.min.js"></script>


<script>
  // You can use either a string for the player ID (i.e., `player`), 
  // or `document.querySelector()` for any selector
  const playerQuality = new MediaElementPlayer('player', {
    iconSprite: '/images/mejs-controls.svg', // path to svg-spritemap for all icons
    features: ['playpause', 'current', 'progress', 'duration', 'volume', 'tracks', 'quality', 'fullscreen'], // add 'quality' feature
  });
</script>