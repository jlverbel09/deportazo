        
        <?php

        require_once '../conexion.php';
        session_start();
        $miembros = $conexion->query("select count(1) from usuario where id_rol in (3) and oficial = 1")->fetch();
        $torneos = $conexion->query("select count(*) from torneo where status != 2")->fetch();
        $fotos = $conexion->query("select count(*) from fotos f inner join torneo t on t.id  = f.id_torneo  where t.status  != 2")->fetch();
        $triunfos = $conexion->query("select count(u.id) from enfrentamientos2 en
inner join equipos e  on e.id = en.ganador 
inner join equipo_jugador ej  on ej.id_torneo = en.id_torneo and ej.id_equipo = e.id 
inner join usuario u on u.id = ej.id_jugador  
inner join torneo t on t.id = e.id_torneo 
where  
	case 
		when t.tipo = 1 or t.tipo = 2 then fase = 3 
		when t.tipo = 3 then fase = 2 
	end 
	")->fetch();

        $accionUsuario = '';
        if ($_SESSION['usuario']['id_rol'] == 1) {
            $accionUsuario = 'onclick="redireccion(`usuarios`)"';
        }else{
            $accionUsuario = 'onclick="redireccion(`miembros`)"';
        }


        $contenido = '

<div class="row p-0 m-0">
    <div class="col-12 pb-5">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-3 pointer " onclick="redireccion(`lista_torneos`)" >
                <div class="info-box"> <span class="info-box-icon text-bg-info shadow-sm"> <i class="bi bi-bar-chart-line"></i> </span>
                    <div class="info-box-content"> <span class="info-box-text">Torneos  </span> <span class="info-box-number">
                            ' . $torneos[0] . '
                     </div>
                </div>
            </div>
            <!--<div class="col-6 col-sm-6 col-md-3 pointer">
                <div class="info-box"> <span class="info-box-icon text-bg-info shadow-sm"> <i class="bi bi-hand-thumbs-up-fill"></i> </span>
                    <div class="info-box-content"> <span class="info-box-text">Likes</span> <span class="info-box-number">525</span> </div>
                    
                </div>
            </div>-->
            <div class="col-6 col-sm-6 col-md-3 pointer" onclick="redireccion(`galeria`)">
                <div class="info-box"> <span class="info-box-icon text-bg-info shadow-sm"> <i class="bi bi-card-image"></i> </span>
                    <div class="info-box-content"> <span class="info-box-text">Fotos</span> <span class="info-box-number">
                    ' . $fotos[0] . '
                    </span> </div>
                </div>
            </div>
            <div class="col-6 offset-md-0 col-sm-6 col-md-3 pointer" ' . $accionUsuario . '>
                <div class="info-box"> <span class="info-box-icon text-bg-info shadow-sm"> <i class="bi bi-people-fill"></i> </span>
                    <div class="info-box-content"> <span class="info-box-text">Miembros</span> <span class="info-box-number">' . $miembros[0] . '</span> </div>
                </div>
            </div>
            <div class="col-6  offset-md-0 col-sm-6 col-md-3 pointer" onclick="redireccion(`triunfos`)">
                <div class="info-box"> <span class="info-box-icon text-bg-info shadow-sm"> <i class="bi bi-award"></i> </span>
                    <div class="info-box-content"> <span class="info-box-text">Triunfos</span> <span class="info-box-number">' . $triunfos[0] . '</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
    
    </div>
    <div class="col-lg-8 col-sm-10 my-sm-1 my-auto p-auto h4">
        
        <p class="mx-2 text-justify ">
            Esta es una plataforma interactiva para el registro de campenonatos, visitantes y deportistas interesados en formar parte de la comunidad deportiva en Madrid - España.
        </p>
        <p class="mx-2 text-justify ">
            Fomentando el deporte de tu mano en nuestra app
        </p>

        <!--<div class="mt-5 pt-5">
        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprofile.php%3Fid%3D61568196323522&tabs=timeline&width=340&height=270&small_header=true&adapt_container_width=false&hide_cover=true&show_facepile=false&appId" width="340" height="70" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="false" allow="autoplay; clipboard-write; encrypted-media;  web-share"></iframe>
        </div>-->
    </div>
    <div class="col-lg-4 col-sm-10">
        <img width="100%" src="../../dist/assets/img/imagenes/icono-home.png" alt="">
    </div>
</div>';
        $data = [
            'titulo' => 'Inicio',
            'contenido' => $contenido
        ];


        echo json_encode($data);
