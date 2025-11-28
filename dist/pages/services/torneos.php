<?php

require_once '../conexion.php';

session_start();
if (isset($_GET['torneo'])) {
    $_GET['id_torneo'] = $_GET['torneo'];
    $link = '';
} else {
    $link = 'dist';
}
$enfrentamiento = '';
$clasificacionEquipo = '';
$responseTorneo = $conexion->query("select * from torneo t where id  =  " . $_GET['id_torneo'])->fetch();
$listTorneos = '';
$fecha = date_create($responseTorneo['fecha']);

$list_enfrentamientos  = $conexion->query("select e.*, e2.nombre  as equipo_local, e2.color as color_equipo_local, e3.nombre as equipo_visitante,e3.color as color_equipo_visitante from enfrentamientos2 e 
inner join equipos e2 on e2.id = e.id_equipo_local
inner join equipos e3 on e3.id = e.id_equipo_visitante 
where e.id_torneo  =  " . $_GET['id_torneo'] . " order by fase desc, orden, rand(1)")->fetchAll();
$query = "
select id, nombre, PJ,  coalesce(p.G,0) as G,
coalesce(p.P,0) as P,coalesce(p.AF,0) as AF,coalesce(p.AC,0) as AC,
color, coalesce(p.PUNTOS,0) as PUNTOS,
(coalesce(p.AF,0) - coalesce(p.AC,0) ) as DA from (select k.*, e4.color, (g * 3 ) as PUNTOS from (

select eq.id, eq.nombre,
(
select count(id) from (
select id,  id_equipo_local as equipo , marcador_local as marcador , ganador from enfrentamientos2 e1  where e1.fase = 0 
union 
select id,  id_equipo_visitante  as equipo , marcador_visitante  as marcador, ganador  from enfrentamientos2 e2 where e2.fase = 0 
) 
j 
where j.equipo = eq.id and ganador <> 0) as PJ,

(select  count(ee.ganador) from enfrentamientos2 ee where ee.fase = 0 and ee.ganador <> 0 and  ee.ganador = eq.id  group by ee.ganador ) as G,

(select  count(ee.perdedor) from enfrentamientos2 ee where ee.fase = 0 and ee.perdedor <> 0 and  ee.perdedor = eq.id  group by ee.perdedor ) as P,


coalesce (
    (select  sum(case 
            when ee.ganador = ee.id_equipo_local then (ee.marcador_local) 
            when ee.ganador = ee.id_equipo_visitante  then (ee.marcador_visitante)
        end)
    
    from enfrentamientos2 ee where ee.fase = 0 and ee.ganador <> 0 and  ee.ganador = eq.id  ),0) +
    coalesce ((select  sum(case 
            when ee.perdedor = ee.id_equipo_local then (ee.marcador_local) 
            when ee.perdedor = ee.id_equipo_visitante  then (ee.marcador_visitante)
        end)
    
    from enfrentamientos2 ee where ee.fase = 0 and ee.ganador <> 0 and  ee.perdedor = eq.id  ),0) as AF,
    
    
     
     coalesce( (select  sum(case 
            when ee.perdedor = ee.id_equipo_local then (ee.marcador_local) 
            when ee.perdedor = ee.id_equipo_visitante  then (ee.marcador_visitante)
        end)
    
    from enfrentamientos2 ee where ee.fase = 0 and ee.perdedor <> 0 and  ee.ganador = eq.id   ),0)+
    
    coalesce( (select  sum(case 
            when ee.ganador = ee.id_equipo_local then (ee.marcador_local) 
            when ee.ganador = ee.id_equipo_visitante  then (ee.marcador_visitante)
        end)
    
    from enfrentamientos2 ee where ee.fase = 0 and ee.perdedor <> 0 and  ee.perdedor = eq.id ),0)  as AC
    

from equipos eq  
where id_torneo  = " . $_GET['id_torneo'] . "  ) k 
inner join equipos e4 on e4.id = k.id
) p order by PUNTOS desc, DA desc, AF desc";

/* print_r('<pre>'.$query.'</pre>');
die(); */
$clasificacion = $conexion->query($query)->fetchAll();
/* TABLA DE CLASIFICACION */
$i = 1;
$cantClasificado = 1;
$cantRepechaje = 2;
$clasificado = '';
$repechaje = '';
$arrayTabla = [];

$tipo = $responseTorneo['tipo'];

if ($tipo == 1 or $tipo == 2) {
    $inicioPJ = 0;
    foreach ($clasificacion as $cEquipo) {

        array_push($arrayTabla, $cEquipo);

        $inicioPJ = $cEquipo['PJ'] + $inicioPJ;

        if ($i <=    $cantClasificado) {
            $clasificado = 'class="clasificado"';
        } else {
            $clasificado = '';
        }
        if ($i ==    $cantRepechaje) {
            $repechaje = 'class="repechaje"';
        } else {
            $repechaje = 'class="noclasificado"';
        }
        if (empty($cEquipo['G'])) {
            $cEquipo['G'] = 0;
        }
        if (empty($cEquipo['P'])) {
            $cEquipo['P'] = 0;
        }
        if (empty($cEquipo['PUNTOS'])) {
            $cEquipo['PUNTOS'] = 0;
        }

        $nombreEquipo = '';
        if (strpos($cEquipo['nombre'], 'EQUIPO') !== false) {
            $nombreEquipo = substr($cEquipo['nombre'], 0, 2) . '.&nbsp;' . substr($cEquipo['nombre'], -1);
        }

        $clasificacionEquipo .= '<tr ' . $clasificado . ' ' . $repechaje . '>
                            <th scope="row">' . $i . '</th>
                            <td class="nombreEquipoTabla nt1 " style="font-size: 15px; text-align: left"><i class="bi bi-shield-fill mt-1 me-1" style="color:' . $cEquipo['color'] . '"></i>' . $nombreEquipo . '</td>
                            <td class="nombreEquipoTabla nt2" style="font-size: 15px; text-align: left"><i class="bi bi-shield-fill mt-1 me-1" style="color:' . $cEquipo['color'] . '"></i>' . $cEquipo['nombre'] . '</td>
                            <td>' . $cEquipo['PJ'] . '</td>
                            <td>' . $cEquipo['G'] . '</td>
                            <td>' . $cEquipo['P'] . '</td>
                            <td>' . $cEquipo['AF'] . '</td>
                            <td>' . $cEquipo['AC'] . '</td>
                            <td class="text-center">' . $cEquipo['DA'] . '</td>
                            <td class="text-center"><b>' . $cEquipo['PUNTOS'] . '</b></td>
                        </tr>';
        $i++;
    }
    if (empty($list_enfrentamientos)) {
        $msjEnfrentamiento = '<div class="mensajeEnf">NO HAY ENFRENTAMIENTOS AUN</div>';
        $enfrentamiento = $msjEnfrentamiento;
    } else {
        $msjEnfrentamiento = '';
    }

    foreach ($list_enfrentamientos as $listEnfrentamientos) {

        if ($listEnfrentamientos['ganador'] == 0) {
            $listEnfrentamientos['marcador_local'] = "-";
            $listEnfrentamientos['marcador_visitante'] = "-";
        }

        $fase = $listEnfrentamientos['fase'];
        $espacioCol = '';
        $col = '';
        $colorbtn = '';
        $style = '';
        if ($tipo == 1) {
            if ($fase == 1) {
                $col = 5;
                $espacioCol = '<div class="col-12"></div>';
                $colorbtn = "info";
                $style = "    background-color: #0dcaf082;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 0) {
                $col = 3;
                $colorbtn = "primary";
                $style = "    background-color: #0d6efd6e;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 2) {
                $col = 5;
                $colorbtn = "warning";
                $style = "    background-color: #ffc1077d;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 3) {
                $col = 7;
                $colorbtn = "success";
                $style = "    background-color: #1987549e;border: 1px solid;border-radius: 5px;";
            }
        } else if ($tipo == 2) {

            if ($fase == 3) {
                $col = 7;
                $espacioCol = '<div class="col-12"></div>';
                $colorbtn = "success";
                $style = "    background-color: #1987549e;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 0) {
                $col = 3;
                $colorbtn = "primary";
                $style = "    background-color: #0d6efd6e;border: 1px solid;border-radius: 5px;";
            }
        }


        if ($_SESSION['usuario']['id_rol'] == 1 or $_SESSION['usuario']['id_rol'] == 2) {
            $enfrentamientoResult = ' <button class="btn btn-' . $colorbtn . ' w-100" data-bs-toggle="modal" data-bs-target="#finalizar" onclick="vermarcador(' . $listEnfrentamientos['id'] . ')">
            <i class="bi bi-pencil-square"></i>
            ANOTAR
         </button>';
        } else {
            $enfrentamientoResult = '';
        }


        $enfrentamiento .=  '
    
    <div style="' . $style . '" class=" row col-sm-12  col-md-' . $col . '  d-flex align-items-center justify-content-center m-1 mb-3 p-0 cardsenfrentamientos" >
    <div class="d-flex col-12 m-0 p-0">
        <div class="card mb-0 w-100" >
            <div class="row g-0 align-items-center d-flex p-0">
                <div class="col-md-3 text-center">
                <i class="bi bi-shield-fill escudo" style="color:' . $listEnfrentamientos['color_equipo_local'] . '"></i>
                </div>
                <div class="col-md-9 ">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title p-0 " style="font-size: 15px;width: 100%" >' . $listEnfrentamientos['equipo_local'] . '</h5><br>
                        <h5 class="p-0 m-0 text-center">' . $listEnfrentamientos['marcador_local'] . '</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 align-items-center d-flex">Vs</div>
        <div class="card mb-0 w-100" >
            <div class="row g-0 align-items-center d-flex cuadrovisitante">
            
                <div class="col-md-9">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title p-0" style="font-size: 15px;width: 100%">' . str_replace(" ", "&nbsp;", $listEnfrentamientos['equipo_visitante']) . '</h5><br>
                        <h5 class="p-0 m-0 text-center">' . $listEnfrentamientos['marcador_visitante'] . '</h5>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <i class="bi bi-shield-fill escudo" style="color:' . $listEnfrentamientos['color_equipo_visitante'] . '"></i>
                </div>
            </div>
        </div>
        </div>

          <div class="col-12 m-0 p-0">
            ' . $enfrentamientoResult . '
        </div>
    </div>' . $espacioCol;
    }





    $contenido = '
    <link rel="stylesheet" href="./../../' . $link . '/css/style.css">

    <!-- Modal -->
    <div class="modal fade p-0" id="enfrentamiento" tabindex="-1" aria-labelledby="enfrentamientoLabel" aria-hidden="false">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
            <div class="modal-header bg-principal text-white">
                <h5 class="modal-title" id="enfrentamientoLabel">ENFRENTAMIENTOS </h5>
                <button type="button" class="btn-close btn-close-white text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row justify-content-center d-flex">
                    ' . $enfrentamiento . '
                </div>
            </div>
            <div class="modal-footer bg-principal">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
        </div>
        
        
        
        <!-- Modal -->
        <div class="modal fade p-0" id="finalizar" tabindex="-1" aria-labelledby="finalizarLabel" aria-hidden="false">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizarLabel">Marcador </h5>
            </div>
            <div class="modal-body">

            <input type="hidden" value="" id="id_enfrentamiento">
            <input type="hidden" value="" id="id_equipoLocal">
            <input type="hidden" value="" id="id_equipoVisitante">

            <div class="d-flex col-12 m-0 p-0">
                <div class="card mb-0 w-100">
                    <div class="row g-0 align-items-center d-flex p-0" >
                        <div class="col-md-12 text-center">
                        <i class="bi bi-shield-fill escudo" id="color_equipo_local"></i>
                        </div>
                        <div class="col-md-12 ">
                            <div class="card-body text-center p-2">
                                <h5 class="card-title p-0 " style="font-size: 13px;width: 100%" id="marcador_equipo_local"></h5><br>
                            <div class="justify-content-center d-flex inputpuntos ">
                                    <button class="btn btn-danger mb-2 w-100" onclick="marcar(`restar`,`local`)"><i class="bi bi-dash h2"></i></button>
                                        <input type="text" readonly id="m_equipoLocal" value="0" class="form-control w-100 mb-2  " style="height: 120px;font-size: 42px;text-align: center;" >
                                    <button class="btn btn-success mb-2 w-100" onclick="marcar(`sumar`,`local`)"><i class="bi bi-plus h2"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 align-items-center d-flex">Vs</div>
                <div class="card mb-0 w-100">
                    <div class="row g-0 align-items-center d-flex cuadrovisitante" style="flex-direction: column-reverse;">
                    
                        <div class="col-md-12">
                            <div class="card-body text-center p-2">
                                <h5 class="card-title p-0" style="font-size: 13px;width: 100%" id="marcador_equipo_visitante"></h5><br>
                            <div class="justify-content-center d-flex inputpuntos ">
                                    <button class="btn btn-danger mb-2 w-100" onclick="marcar(`restar`,`visitante`)"><i class="bi bi-dash h2"></i></button>
                                        <input type="text" readonly id="m_equipoVisitante" value="0" class="form-control w-100 mb-2  " style="height: 120px;font-size: 42px;text-align: center;" >
                                    <button class="btn btn-success mb-2 w-100" onclick="marcar(`sumar`,`visitante`)"><i class="bi bi-plus h2"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <i class="bi bi-shield-fill escudo" id="color_equipo_visitante"></i>
                        </div>
                    </div>
                </div>
            </div>



            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="actualizarEnfrentamientos(' . $_GET['id_torneo'] . ')" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>';

    if (!isset($_GET['torneo'])) {
        if ($_SESSION['usuario']['id_rol'] == 1) {

            $enfrentarEquipos = ' <div class="col-6 col-md-6 "> <button class="btn btn-info w-100 text-white h-100" onclick="simuladorEnfrentamientoGrupo(' . $_GET['id_torneo'] . ')">
                    <i class="bi bi-shuffle h5"></i><br> ENFRENTAR EQUIPOS
                </button></div>';
        } else {
            $enfrentarEquipos = '';
        }
    } else {
        $enfrentarEquipos = '';
    }



    $contenido .= ' 
    <div class="row">
        <div class="torneo_descripcion  m-0 mb-2 justify-content-center col-md-6 ">
        
              <!--<div class="col-sm-12 col-md-3">
                  <h5>Descripcion</h5>
                    <p class="m-0">' . $responseTorneo['descripcion'] . '</p>
                  
            </div>-->
            <div class="col-sm-12 col-md-6 p-0">
               <p class="card-text m-0">
                    <small class="text-muted">
                        Fecha: ' . date_format($fecha, 'Y-m-d') . '
                    </small>
                </p>
                <p class="card-text m-0 p-0">
                    <small class="text-muted">
                        Hora: ' . date_format($fecha, 'H:i') . '
                    </small>
                </p>
                <p class="card-text mb-2 p-0">
                    <small class="text-muted">
                        Lugar: ' . $responseTorneo['direccion'] . '
                    </small>
                </p>
            </div>
           
            <div class="row col-sm-12 col-md-12 justify-content-center seccionEnfrentamientos">
                
                <div  class="col-6 col-md-6 border border-1  text-white p-0 mb-0" data-bs-toggle="modal" data-bs-target="#enfrentamiento"> 
                    <button class="btn btn-primary w-100">ENFRENTAMIENTOS</button>
                    <div class="text-center mt-1   "><i class="bi bi-shield-fill h2 text-primary"></i></div>
                </div>

                
                ' . $enfrentarEquipos . '
                 

            </div>

            <!--<div class="col-sm-6 col-md-1 d-flex justify-content-center">
                 <button class="btn btn-info w-75 h-75 m-1" onclick="actualizarEnfrentamientosAuto(' . $_GET['id_torneo'] . ')">
                    <i class="bi bi-arrow-clockwise h3 m-0"></i>
                </button>
            </div>  -->
                
    </div>';


    /* GRUPOS */
    $contenido .= '
        ';
    $letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];



    $res = $conexion->query("select e.* , e2.nombre  as equipo, e2.color  from enfrentamientos2 e 
                            inner join equipos e2 on e2.id = e.ganador
                            where (fase = 1 or fase = 2) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_GET['id_torneo'])->fetchAll();

    if (isset($res)) {
        if (!empty($res[0])) {

            $primerFinalista = '
        <input type="hidden" id="primerEquipoFinal" value="' . $res[0]['ganador'] . '">
        <i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res[0]['color'] . '"></i>' . $res[0]['equipo'];
        } else {
            $primerFinalista = '';
        }
        if (!empty($res[1])) {
            $segundoFinalista = '
        <input type="hidden" id="segundoEquipoFinal" value="' . $res[1]['ganador'] . '">
        <i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res[1]['color'] . '"></i>' . $res[1]['equipo'];
        } else {
            $segundoFinalista = '';
        }
    } else {
        $primerFinalista = '3roVS4to';
        $segundoFinalista = '2doVS?';
    }


    $sql = "select * from enfrentamientos2 e
                inner join equipos e2 on e2.id = e.ganador
                where e.id_torneo = " . $_GET['id_torneo'] . " and fase = 3 ";

    $res = $conexion->query($sql)->fetch();

    if ($res) {
        $finalista = '<i class="bi bi-shield-fill mt-1 me-1 h1" style="color: ' . ($res['color']) . '"  ></i><br>' . $res['nombre'];
    } else {
        $finalista = '<i class="bi bi-shield-fill mt-1 me-1 h1" style="color: #e8bb48"  ></i><br>CAMPEÓN';
    }


    $esquemaClasificatorio = '';
    if ($tipo == 1) {

        if ($inicioPJ < 3) {
            $inicioPJ = ' 
                <p class="equipoA equipo1">1ER</p>
                <p class="equipoA equipo2">2DO</p>
                <p class="equipoA equipo3">3RO</p>
                <p class="equipoA equipo4">4TO</p>
                ';
        } else {
            $inicioPJ = ' <p class="equipoA equipo1"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[0]['color']) . '"  ></i>' . ($arrayTabla[0]['nombre']) . '</p>
                <p class="equipoA equipo2"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[1]['color']) . '"  ></i>' . ($arrayTabla[1]['nombre']) . '</p>
                <p class="equipoA equipo3"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[2]['color']) . '"  ></i>' . ($arrayTabla[2]['nombre']) . '</p>
                <p class="equipoA equipo4"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[3]['color']) . '"  ></i>' . ($arrayTabla[3]['nombre']) . '</p>
        ';
        }

        $esquemaClasificatorio = '

            <div class="row p-0 m-0 mt-4 text-center justify-content-center">
                <div class="col-sm-12 col-md-12 esquema esquema1">
                    <input type="hidden" id="id_torneo" value="' . $_GET['id_torneo'] . '" >
                    <input type="hidden" id="primerEquipo" value="' . $arrayTabla[0]['id'] . '">
                    <input type="hidden" id="segundoEquipo" value="' . $arrayTabla[1]['id'] . '">
                    <input type="hidden" id="tercerEquipo" value="' . $arrayTabla[2]['id'] . '">
                    <input type="hidden" id="cuartoEquipo" value="' . $arrayTabla[3]['id'] . '">
                    <div class="row p-0 m-0">


                    <div class="titulosdiagrama">
                    ' . $inicioPJ . '
                        <p class="equipoA equipoA1">' . $primerFinalista . '</p>
                        <p class="equipoA equipoA2">' . $segundoFinalista . '</p>
                        <p class="equipoB equipofinalCuarto ">' . $finalista . '</p>
                    </div>

                        

                    <div class="tablero col-12">
                        <div class="casilla casilla1ro">
                            <div class="lineaH lh1"></div>
                            <div class="lineaV lv1"></div>
                            <div class="lineaH2 lh3"></div>
                            <div class="casilla c2 lh2  ">
                            <div class="lineaH"></div>
                                <div class="lineaV2 lv4"></div>
                                    <div class="lineaV lv5"></div>
                                <div class="lineaH3 lh5"></div>
                                <div class="lineaH3 lh6"></div>

                                <div class="casilla c5"></div>
                            </div>
                        </div>
                        <div class="casilla casilla2do">
                            <div class="lineaH "></div>
                        </div>
                        <div class="casilla casilla3ro4to">
                            <div class="lineaH"></div>
                            <div class="lineaV"></div>
                            <div class="lineaH2"></div>
                            <div class="casilla c2">
                            <div class="lineaH lh7"></div>   
                        </div>

                        </div>
                            <div class="casilla casilla3ro4to">
                                <div class="lineaH"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
   ';
    }
    if ($tipo == 2) {

        if ($inicioPJ < 3) {
            $inicioPJ = ' 
                <p class="equipoA equipo1">1RO</p>
                <p class="equipoA equipo4">2DO</p>
                ';
        } else {
            $inicioPJ = ' <p class="equipoA equipo1"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[0]['color']) . '"  ></i>' . ($arrayTabla[0]['nombre']) . '</p>
                <p class="equipoA equipo4"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[1]['color']) . '"  ></i>' . ($arrayTabla[1]['nombre']) . '</p>
        ';
        }
        $esquemaClasificatorio = '
            <div class="row p-0 m-0 mt-4 text-center justify-content-center">
                <div class="col-sm-12 col-md-12 esquema esquema1">
                    <input type="hidden" id="id_torneo" value="' . $_GET['id_torneo'] . '" >
                    <input type="hidden" id="primerEquipo" value="' . $arrayTabla[0]['id'] . '">
                    <input type="hidden" id="segundoEquipo" value="' . $arrayTabla[1]['id'] . '">
                    <input type="hidden" id="tercerEquipo" value="' . $arrayTabla[2]['id'] . '">
                    <input type="hidden" id="cuartoEquipo" value="' . $arrayTabla[3]['id'] . '">
                    <div class="row p-0 m-0">


                    <div class="titulosdiagrama">
                    ' . $inicioPJ . '
                        <p class="equipoA equipoA1 invisible">' . $primerFinalista . '</p>
                        <p class="equipoA equipoA2 invisible">' . $segundoFinalista . '</p>
                        <p class="equipoB equipofinalCuarto ef2">' . $finalista . '</p>
                    </div>

                        

                    <div class="tablero col-12">
                        <div class="casilla casilla1ro">
                            <div class="lineaH lh1"></div>
                            <div class="lineaH lh1 lh1-2"></div>
                            <div class="lineaV lv1 invisible"></div>
                            <div class="lineaH2 lh3 invisible"></div>
                            <div class="casilla casilla-trans c2 lh2  ">
                            <div class="lineaH invisible"></div>
                                <div class="lineaV2 lv4"></div>
                                <div class="lineaV2 lv4 lv4-2"></div>
                                    <div class="lineaV lv5 lv5-2"></div>
                                <div class="lineaH3 lh5 lh52 "></div>
                                <div class="lineaH3 lh5 lh5-2"></div>
                                <div class="lineaH3 lh6"></div>

                                <div class="casilla c5 "></div>
                            </div>
                        </div>
                        <div class="casilla casilla2do invisible">
                            <div class="lineaH "></div>
                        </div>
                        <div class="casilla casilla3ro4to invisible  ">
                            <div class="lineaH"></div>
                            <div class="lineaV"></div>
                            <div class="lineaH2"></div>
                            <div class="casilla c2">
                            <div class="lineaH lh7"></div>   
                        </div>

                        </div>
                            <div class="casilla casilla3ro4to casilla2do2">
                                <div class="lineaH invisible"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
   ';
    }


    $contenido .= '
            <div class="col-sm-12 col-md-6 p-0 mt-3" id="tablaClasificacion" style="z-index: 1000">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="6">CLASIFICACIÓN</th>
                            <th colspan="3" class="text-end">
                                 <button class="btn btn-info m-1" onclick="actualizarEnfrentamientosAuto(' . $_GET['id_torneo'] . ')">
                                    <i class="bi bi-arrow-clockwise m-0"></i>
                                </button>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Equipo</th>
                            <th scope="col">PJ</th>
                            <th scope="col">G</th>
                            <th scope="col">P</th>
                            <th scope="col">AF</th>
                            <th scope="col">AC</th>
                            <th scope="col" class="text-center">DIF</th>
                            <th scope="col" class="text-center">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $clasificacionEquipo . '
                       
                       
                    </tbody>
                </table>
            </div>



            ' . $esquemaClasificatorio . '
        </div>';

    $data = [
        'titulo' => '<i class="bi bi-arrow-left-circle" style="cursor:pointer" onclick="redireccion(`lista_torneos`)"></i> ' . $responseTorneo['nombre'],
        'contenido' => $contenido
    ];

    if (!isset($_GET['torneo'])) {
        echo json_encode($data);
    } else {
        echo ($contenido);
    }
} else if ($tipo == 3) {

    /* PANTALLA PARA TIPO 3 */
    $inicioPJ = 0;
    foreach ($clasificacion as $cEquipo) {

        array_push($arrayTabla, $cEquipo);

        $inicioPJ = $cEquipo['PJ'] + $inicioPJ;
        $clasicado_color = 'style="background: ' . $cEquipo['color'] . 'a1 !important"';
        if ($i ==   1) {
            $clasificado = 'class="clasificado"';
        } else if ($i ==  2) {
            $clasificado = 'class="repechaje"';
        } else if ($i ==  3) {
            $clasificado = 'class="tercerClasificado"';
        } else if ($i ==  4) {
            $clasificado = 'class="cuartoClasificado"';
        } else if ($i > 4) {
            $clasificado = 'class="noclasificado"';
            $clasicado_color = '';
        }


        if (empty($cEquipo['G'])) {
            $cEquipo['G'] = 0;
        }
        if (empty($cEquipo['P'])) {
            $cEquipo['P'] = 0;
        }
        if (empty($cEquipo['PUNTOS'])) {
            $cEquipo['PUNTOS'] = 0;
        }

        $nombreEquipo = '';
        if (strpos($cEquipo['nombre'], 'EQUIPO') !== false) {
            $nombreEquipo = substr($cEquipo['nombre'], 0, 2) . '.&nbsp;' . substr($cEquipo['nombre'], -1);
        }

        $clasificacionEquipo .= '<tr ' . $clasificado . '>
                            <th scope="row" ' . $clasicado_color . '>' . $i . '</th>
                            <td class="nombreEquipoTabla nt1" ><i class="bi bi-shield-fill mt-1 me-1" style="color:' . $cEquipo['color'] . '"></i>' . $nombreEquipo . '</td>
                            <td class="nombreEquipoTabla nt2" ><i class="bi bi-shield-fill mt-1 me-1" style="color:' . $cEquipo['color'] . '"></i>' . $cEquipo['nombre'] . '</td>
                            <td ' . $clasicado_color . '>' . $cEquipo['PJ'] . '</td>
                            <td ' . $clasicado_color . '>' . $cEquipo['P'] . '</td>
                            <td ' . $clasicado_color . '>' . $cEquipo['G'] . '</td>
                            <td ' . $clasicado_color . '>' . $cEquipo['AF'] . '</td>
                            <td ' . $clasicado_color . '>' . $cEquipo['AC'] . '</td>
                            <td class="text-center" ' . $clasicado_color . '>' . $cEquipo['DA'] . '</td>
                            <td class="text-center" ' . $clasicado_color . '><b>' . $cEquipo['PUNTOS'] . '</b></td>
                        </tr>';
        $i++;
    }
    if (empty($list_enfrentamientos)) {
        $msjEnfrentamiento = '<div class="mensajeEnf">NO HAY ENFRENTAMIENTOS AUN</div>';
        $enfrentamiento = $msjEnfrentamiento;
    } else {
        $msjEnfrentamiento = '';
    }

    foreach ($list_enfrentamientos as $listEnfrentamientos) {

        if ($listEnfrentamientos['ganador'] == 0) {
            $listEnfrentamientos['marcador_local'] = "-";
            $listEnfrentamientos['marcador_visitante'] = "-";
        }

        $fase = $listEnfrentamientos['fase'];
        $espacioCol = '';
        $style = '';



        if ($tipo == 3) {
            if ($fase == 1) {
                $col = 5;
                $espacioCol = '';
                $colorbtn = "info";
                $style = "    background-color: #0dcaf082;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 0) {
                $col = 3;
                $colorbtn = "primary";
                $style = "    background-color: #0d6efd6e;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 2) {
                $col = 8;
                $colorbtn = "success";
                $style = "    background-color: #1987549e;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 3) {
                $col = 7;
                $colorbtn = "warning";
                $style = "    background-color: #ffc1077d;border: 1px solid;border-radius: 5px;";
            }
        }


        if ($_SESSION['usuario']['id_rol'] == 1 or $_SESSION['usuario']['id_rol'] == 2) {
            $enfrentamientoResult = ' <button class="btn btn-' . $colorbtn . ' w-100" data-bs-toggle="modal" data-bs-target="#finalizar" onclick="vermarcador(' . $listEnfrentamientos['id'] . ')">
            <i class="bi bi-pencil-square"></i>
            ANOTAR
         </button>';
        } else {
            $enfrentamientoResult = '';
        }


        $enfrentamiento .=  '
    
    <div style="' . $style . '" class=" row col-sm-12  col-md-' . $col . '  d-flex align-items-center justify-content-center m-1 mb-3 p-0 cardsenfrentamientos" >
    <div class="d-flex col-12 m-0 p-0">
        <div class="card mb-0 w-100" >
            <div class="row g-0 align-items-center d-flex p-0">
                <div class="col-md-3 text-center">
                <i class="bi bi-shield-fill escudo" style="color:' . $listEnfrentamientos['color_equipo_local'] . '"></i>
                </div>
                <div class="col-md-9 ">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title p-0 " style="font-size: 15px;width: 100%" >' . $listEnfrentamientos['equipo_local'] . '</h5><br>
                        <h5 class="p-0 m-0 text-center">' . $listEnfrentamientos['marcador_local'] . '</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 align-items-center d-flex">Vs</div>
        <div class="card mb-0 w-100" >
            <div class="row g-0 align-items-center d-flex cuadrovisitante">
            
                <div class="col-md-9">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title p-0" style="font-size: 15px;width: 100%">' . str_replace(" ", "&nbsp;", $listEnfrentamientos['equipo_visitante']) . '</h5><br>
                        <h5 class="p-0 m-0 text-center">' . $listEnfrentamientos['marcador_visitante'] . '</h5>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <i class="bi bi-shield-fill escudo" style="color:' . $listEnfrentamientos['color_equipo_visitante'] . '"></i>
                </div>
            </div>
        </div>
        </div>

          <div class="col-12 m-0 p-0">
            ' . $enfrentamientoResult . '
        </div>
    </div>' . $espacioCol;
    }





    $contenido = ' 
    <link rel="stylesheet" href="./../../' . $link . '/css/esquema2.css">
    <link rel="stylesheet" href="./../../' . $link . '/css/style2.css">

    <!-- Modal -->
    <div class="modal fade p-0" id="enfrentamiento" tabindex="-1" aria-labelledby="enfrentamientoLabel" aria-hidden="false">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
            <div class="modal-header bg-principal text-white">
                <h5 class="modal-title" id="enfrentamientoLabel">ENFRENTAMIENTOS </h5>
                <button type="button" class="btn-close btn-close-white text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row justify-content-center d-flex">
                    ' . $enfrentamiento . '
                </div>
            </div>
            <div class="modal-footer bg-principal">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
        </div>
        
        
        
        <!-- Modal -->
        <div class="modal fade p-0" id="finalizar" tabindex="-1" aria-labelledby="finalizarLabel" aria-hidden="false">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizarLabel">Marcador </h5>
            </div>
            <div class="modal-body">

            <input type="hidden" value="" id="id_enfrentamiento">
            <input type="hidden" value="" id="id_equipoLocal">
            <input type="hidden" value="" id="id_equipoVisitante">

            <div class="d-flex col-12 m-0 p-0">
                <div class="card mb-0 w-100">
                    <div class="row g-0 align-items-center d-flex p-0" >
                        <div class="col-md-12 text-center">
                        <i class="bi bi-shield-fill escudo" id="color_equipo_local"></i>
                        </div>
                        <div class="col-md-12 ">
                            <div class="card-body text-center p-2">
                                <h5 class="card-title p-0 " style="font-size: 13px;width: 100%" id="marcador_equipo_local"></h5><br>
                            <div class="justify-content-center d-flex inputpuntos ">
                                    <button class="btn btn-danger mb-2 w-100" onclick="marcar(`restar`,`local`)"><i class="bi bi-dash h2"></i></button>
                                        <input type="text" readonly id="m_equipoLocal" value="0" class="form-control w-100 mb-2  " style="height: 120px;font-size: 42px;text-align: center;" >
                                    <button class="btn btn-success mb-2 w-100" onclick="marcar(`sumar`,`local`)"><i class="bi bi-plus h2"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 align-items-center d-flex">Vs</div>
                <div class="card mb-0 w-100">
                    <div class="row g-0 align-items-center d-flex cuadrovisitante" style="flex-direction: column-reverse;">
                    
                        <div class="col-md-12">
                            <div class="card-body text-center p-2">
                                <h5 class="card-title p-0" style="font-size: 13px;width: 100%" id="marcador_equipo_visitante"></h5><br>
                            <div class="justify-content-center d-flex inputpuntos ">
                                    <button class="btn btn-danger mb-2 w-100" onclick="marcar(`restar`,`visitante`)"><i class="bi bi-dash h2"></i></button>
                                        <input type="text" readonly id="m_equipoVisitante" value="0" class="form-control w-100 mb-2  " style="height: 120px;font-size: 42px;text-align: center;" >
                                    <button class="btn btn-success mb-2 w-100" onclick="marcar(`sumar`,`visitante`)"><i class="bi bi-plus h2"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <i class="bi bi-shield-fill escudo" id="color_equipo_visitante"></i>
                        </div>
                    </div>
                </div>
            </div>



            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="actualizarEnfrentamientos(' . $_GET['id_torneo'] . ')" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>';


    if (!isset($_GET['torneo'])) {
        if ($_SESSION['usuario']['id_rol'] == 1) {

            $enfrentarEquipos = ' <div class="col-6 col-md-6 "> <button class="btn btn-info w-100 text-white h-100" onclick="simuladorEnfrentamientoGrupo(' . $_GET['id_torneo'] . ')">
                    <i class="bi bi-shuffle h5"></i><br> ENFRENTAR EQUIPOS
                </button></div>';
        } else {
            $enfrentarEquipos = '';
        }
    } else {
        $enfrentarEquipos = '';
    }


    $contenido .= ' 
    <div class="row">
        <div class="torneo_descripcion  m-0 mb-2 justify-content-center col-md-6 ">
        
              <!--<div class="col-sm-12 col-md-3">
                  <h5>Descripcion</h5>
                    <p class="m-0">' . $responseTorneo['descripcion'] . '</p>
                  
            </div>-->
            <div class="col-sm-12 col-md-6 p-0">
               <p class="card-text m-0">
                    <small class="text-muted">
                        Fecha: ' . date_format($fecha, 'Y-m-d') . '
                    </small>
                </p>
                <p class="card-text m-0 p-0">
                    <small class="text-muted">
                        Hora: ' . date_format($fecha, 'H:i') . '
                    </small>
                </p>
                <p class="card-text mb-2 p-0">
                    <small class="text-muted">
                        Lugar: ' . $responseTorneo['direccion'] . '
                    </small>
                </p>
            </div>
           
            <div class="row col-sm-12 col-md-12 justify-content-center seccionEnfrentamientos">
                
                <div  class="col-6 col-md-6 border border-1  text-white p-0 mb-0" data-bs-toggle="modal" data-bs-target="#enfrentamiento"> 
                    <button class="btn btn-primary w-100">ENFRENTAMIENTOS</button>
                    <div class="text-center mt-1   "><i class="bi bi-shield-fill h2 text-primary"></i></div>
                </div>

                
                ' . $enfrentarEquipos . '
                 

            </div>

            <!--<div class="col-sm-6 col-md-1 d-flex justify-content-center">
                 <button class="btn btn-info w-75 h-75 m-1" onclick="actualizarEnfrentamientosAuto(' . $_GET['id_torneo'] . ')">
                    <i class="bi bi-arrow-clockwise h3 m-0"></i>
                </button>
            </div>  -->
                
    </div>';


    /* GRUPOS */
    $contenido .= '
        ';
    $letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];



    $res = $conexion->query("select e.* , e2.nombre  as equipo, e2.color  from enfrentamientos2 e 
                            inner join equipos e2 on e2.id = e.ganador
                            where (fase = 1 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_GET['id_torneo'])->fetchAll();

    if (isset($res)) {
        if (!empty($res[0]) && !empty($res[1])) {

            $primerFinalista = '
        <input type="hidden" id="primerEquipoFinal" value="' . $res[0]['ganador'] . '">
        <i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res[0]['color'] . '"></i>' . $res[0]['equipo'];

            $segundoFinalista = '
        <input type="hidden" id="segundoEquipoFinal" value="' . $res[1]['ganador'] . '">
        <i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res[1]['color'] . '"></i>' . $res[1]['equipo'];
        } else {
            $primerFinalista = '1roVS4to';
            $segundoFinalista = '2doVS3ro';
        }
    } else {
        $primerFinalista = '1roVS4to';
        $segundoFinalista = '2doVS3ro';
    }


    $sql = "select * from enfrentamientos2 e
                inner join equipos e2 on e2.id = e.ganador
                where e.id_torneo = " . $_GET['id_torneo'] . " and fase = 2 ";

    $res = $conexion->query($sql)->fetch();

    if ($res) {
        $finalista = '<i class="bi bi-shield-fill mt-1 me-1 h1" style="color: ' . ($res['color']) . '"  ></i><br>' . $res['nombre'];
    } else {
        $finalista = '<i class="bi bi-shield-fill mt-1 me-1 h1" style="color: #e8bb48"  ></i><br>CAMPEÓN';
    }


    $esquemaClasificatorio = '';
    if ($tipo == 3) {

        if ($inicioPJ < 3) {
            $Equipo1 = '<p class="pt-3">Equipo 1</p>';
            $Equipo2 = '<p class="pt-3">Equipo 2</p>';
            $Equipo3 = '<p class="pt-3">Equipo 3</p>';
            $Equipo4 = '<p class="pt-3">Equipo 4</p>';
        } else {
            $Equipo1 = '<p class="pt-3"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[0]['color']) . '"  ></i>' . ($arrayTabla[0]['nombre']) . '</p>';
            $Equipo2 = '<p class="pt-3"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[1]['color']) . '"  ></i>' . ($arrayTabla[1]['nombre']) . '</p>';
            $Equipo3 = '<p class="pt-3"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[2]['color']) . '"  ></i>' . ($arrayTabla[2]['nombre']) . '</p>';
            $Equipo4 = '<p class="pt-3"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[3]['color']) . '"  ></i>' . ($arrayTabla[3]['nombre']) . '</p>';
        }

        $esquemaClasificatorio = '

            <div class="row p-0  m-0 mt-4 text-center justify-content-center esquema2">
                <div class="col-sm-12 col-md-12 esquema esquema2"><br>
                    <input type="hidden" id="id_torneo" value="' . $_GET['id_torneo'] . '" >
                    <input type="hidden" id="primerEquipo" value="' . $arrayTabla[0]['id'] . '">
                    <input type="hidden" id="segundoEquipo" value="' . $arrayTabla[1]['id'] . '">
                    <input type="hidden" id="tercerEquipo" value="' . $arrayTabla[2]['id'] . '">
                    <input type="hidden" id="cuartoEquipo" value="' . $arrayTabla[3]['id'] . '">
                    <div class="row p-0 m-0">


                  
                        

                    <div class="tablero col-12">
                        <div class="lineas">
                            <div class="lh lhl1"></div>
                            <div class="lh lhl2"></div>
                            <div class="lh lhl3"></div>
                            <div class="lh lhl4"></div>
                            <div class="lh lhl5"></div>
                            <div class="lh lhl6"></div>
                            <div class="lh lhl7"></div>
                            <div class="lh lhl8"></div>
                            <div class="lh lhl9"></div>

                            <div class="lv lvl1"></div>
                            <div class="lv lvl2"></div>
                            <div class="lv lvl3"></div>
                        </div>
                        <div class="casillas">
                            <div class="casilla casi_1ro" style="border-left: 5px solid  ' . ($arrayTabla[0]['color']) . '" >' . $Equipo1 . '</div>
                            <div class="casilla casi_4to" style="border-left: 5px solid  ' . ($arrayTabla[3]['color']) . '">' . $Equipo4 . '</div>
                            <div class="casilla casi_2do" style="border-left: 5px solid  ' . ($arrayTabla[1]['color']) . '">' . $Equipo2 . '</div>
                            <div class="casilla casi_3ro" style="border-left: 5px solid  ' . ($arrayTabla[2]['color']) . '">' . $Equipo3 . '</div>
                        </div>
                        <div class="casillas_2da_ronda">
                            <div class="casilla casi_1ro4to pt-3">' . $primerFinalista . '</div>
                            <div class="casilla casi_2do3ro pt-3">' . $segundoFinalista . '</div>
                        </div>
                        <div class="casilla casi_final c5 pt-3">' . $finalista . '</div>
                        <div class="lineas"></div>
                    </div>
                    </div>

                </div>
            </div>
   ';
    }



    $contenido .= '
            <div class="col-sm-12 col-md-6 p-0 mt-3" id="tablaClasificacion" style="z-index: 1000">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="6">CLASIFICACIÓN</th>
                            <th colspan="3" class="text-end">
                                 <button class="btn btn-info m-1" onclick="actualizarEnfrentamientosAuto(' . $_GET['id_torneo'] . ')">
                                    <i class="bi bi-arrow-clockwise m-0"></i>
                                </button>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Equipo</th>
                            <th scope="col">PJ</th>
                            <th scope="col">G</th>
                            <th scope="col">P</th>
                            <th scope="col">AF</th>
                            <th scope="col">AC</th>
                            <th scope="col" class="text-center">DIF</th>
                            <th scope="col" class="text-center">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $clasificacionEquipo . '
                       
                       
                    </tbody>
                </table>
            </div>



            ' . $esquemaClasificatorio . '
        </div>';
    $data = [
        'titulo' => '<i class="bi bi-arrow-left-circle" style="cursor:pointer" onclick="redireccion(`lista_torneos`)"></i> ' . $responseTorneo['nombre'],
        'contenido' => $contenido
    ];

    if (!isset($_GET['torneo'])) {
        echo json_encode($data);
    } else {
        echo ($contenido);
    }
} else if ($tipo == 4) {
    /* PANTALLA PARA TIPO 4 */
    $inicioPJ = 0;
    foreach ($clasificacion as $cEquipo) {

        array_push($arrayTabla, $cEquipo);

        $inicioPJ = $cEquipo['PJ'] + $inicioPJ;
        $clasicado_color = 'style="background: ' . $cEquipo['color'] . 'a1 !important"';
        if ($i ==   1) {
            $clasificado = 'class="clasificado"';
        } else if ($i ==  2) {
            $clasificado = 'class="repechaje"';
        } else if ($i ==  3) {
            $clasificado = 'class="tercerClasificado"';
        } /* else if ($i ==  4) {
            $clasificado = 'class="cuartoClasificado"';
        } */ else if ($i > 3) {
            $clasificado = 'class="noclasificado"';
            $clasicado_color = '';
        }


        if (empty($cEquipo['G'])) {
            $cEquipo['G'] = 0;
        }
        if (empty($cEquipo['P'])) {
            $cEquipo['P'] = 0;
        }
        if (empty($cEquipo['PUNTOS'])) {
            $cEquipo['PUNTOS'] = 0;
        }

        $nombreEquipo = '';
        if (strpos($cEquipo['nombre'], 'EQUIPO') !== false) {
            $nombreEquipo = substr($cEquipo['nombre'], 0, 2) . '.&nbsp;' . substr($cEquipo['nombre'], -1);
        }

        $clasificacionEquipo .= '<tr ' . $clasificado . '>
                            <th scope="row" ' . $clasicado_color . '>' . $i . '</th>
                            <td class="nombreEquipoTabla nt1" ><i class="bi bi-shield-fill mt-1 me-1" style="color:' . $cEquipo['color'] . '"></i>' . $nombreEquipo . '</td>
                            <td class="nombreEquipoTabla nt2" ><i class="bi bi-shield-fill mt-1 me-1" style="color:' . $cEquipo['color'] . '"></i>' . $cEquipo['nombre'] . '</td>
                            <td ' . $clasicado_color . '>' . $cEquipo['PJ'] . '</td>
                            <td ' . $clasicado_color . '>' . $cEquipo['G'] . '</td>
                            <td ' . $clasicado_color . '>' . $cEquipo['P'] . '</td>
                            <td ' . $clasicado_color . '>' . $cEquipo['AF'] . '</td>
                            <td ' . $clasicado_color . '>' . $cEquipo['AC'] . '</td>
                            <td class="text-center" ' . $clasicado_color . '>' . $cEquipo['DA'] . '</td>
                            <td class="text-center" ' . $clasicado_color . '><b>' . $cEquipo['PUNTOS'] . '</b></td>
                        </tr>';
        $i++;
    }
    if (empty($list_enfrentamientos)) {
        $msjEnfrentamiento = '<div class="mensajeEnf">NO HAY ENFRENTAMIENTOS AUN</div>';
        $enfrentamiento = $msjEnfrentamiento;
    } else {
        $msjEnfrentamiento = '';
    }

    foreach ($list_enfrentamientos as $listEnfrentamientos) {

        if ($listEnfrentamientos['ganador'] == 0) {
            $listEnfrentamientos['marcador_local'] = "-";
            $listEnfrentamientos['marcador_visitante'] = "-";
        }

        $fase = $listEnfrentamientos['fase'];
        $espacioCol = '';
        $style = '';



        if ($tipo == 4) {
            if ($fase == 1) {
                $col = 5;
                $espacioCol = '';
                $colorbtn = "info";
                $style = "    background-color: #0dcaf082;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 0) {
                $col = 3;
                $colorbtn = "primary";
                $style = "    background-color: #0d6efd6e;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 2) {
                $col = 8;
                $colorbtn = "success";
                $style = "    background-color: #1987549e;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 3) {
                $col = 7;
                $colorbtn = "warning";
                $style = "    background-color: #ffc1077d;border: 1px solid;border-radius: 5px;";
            }
        }


        if ($_SESSION['usuario']['id_rol'] == 1 or $_SESSION['usuario']['id_rol'] == 2) {
            $enfrentamientoResult = ' <button class="btn btn-' . $colorbtn . ' w-100" data-bs-toggle="modal" data-bs-target="#finalizar" onclick="vermarcador(' . $listEnfrentamientos['id'] . ')">
            <i class="bi bi-pencil-square"></i>
            ANOTAR
         </button>';
        } else {
            $enfrentamientoResult = '';
        }


        $enfrentamiento .=  '
    
    <div style="' . $style . '" class=" row col-sm-12  col-md-' . $col . '  d-flex align-items-center justify-content-center m-1 mb-3 p-0 cardsenfrentamientos" >
    <div class="d-flex col-12 m-0 p-0">
        <div class="card mb-0 w-100" >
            <div class="row g-0 align-items-center d-flex p-0">
                <div class="col-md-3 text-center">
                <i class="bi bi-shield-fill escudo" style="color:' . $listEnfrentamientos['color_equipo_local'] . '"></i>
                </div>
                <div class="col-md-9 ">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title p-0 " style="font-size: 15px;width: 100%" >' . $listEnfrentamientos['equipo_local'] . '</h5><br>
                        <h5 class="p-0 m-0 text-center">' . $listEnfrentamientos['marcador_local'] . '</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 align-items-center d-flex">Vs</div>
        <div class="card mb-0 w-100" >
            <div class="row g-0 align-items-center d-flex cuadrovisitante">
            
                <div class="col-md-9">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title p-0" style="font-size: 15px;width: 100%">' . str_replace(" ", "&nbsp;", $listEnfrentamientos['equipo_visitante']) . '</h5><br>
                        <h5 class="p-0 m-0 text-center">' . $listEnfrentamientos['marcador_visitante'] . '</h5>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <i class="bi bi-shield-fill escudo" style="color:' . $listEnfrentamientos['color_equipo_visitante'] . '"></i>
                </div>
            </div>
        </div>
        </div>

          <div class="col-12 m-0 p-0">
            ' . $enfrentamientoResult . '
        </div>
    </div>' . $espacioCol;
    }





    $contenido = ' 
    <link rel="stylesheet" href="./../../' . $link . '/css/esquema2.css">
    <link rel="stylesheet" href="./../../' . $link . '/css/style2.css">

    <!-- Modal -->
    <div class="modal fade p-0" id="enfrentamiento" tabindex="-1" aria-labelledby="enfrentamientoLabel" aria-hidden="false">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
            <div class="modal-header bg-principal text-white">
                <h5 class="modal-title" id="enfrentamientoLabel">ENFRENTAMIENTOS </h5>
                <button type="button" class="btn-close btn-close-white text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row justify-content-center d-flex">
                    ' . $enfrentamiento . '
                </div>
            </div>
            <div class="modal-footer bg-principal">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
        </div>
        
        
        
        <!-- Modal -->
        <div class="modal fade p-0" id="finalizar" tabindex="-1" aria-labelledby="finalizarLabel" aria-hidden="false">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizarLabel">Marcador </h5>
            </div>
            <div class="modal-body">

            <input type="hidden" value="" id="id_enfrentamiento">
            <input type="hidden" value="" id="id_equipoLocal">
            <input type="hidden" value="" id="id_equipoVisitante">

            <div class="d-flex col-12 m-0 p-0">
                <div class="card mb-0 w-100">
                    <div class="row g-0 align-items-center d-flex p-0" >
                        <div class="col-md-12 text-center">
                        <i class="bi bi-shield-fill escudo" id="color_equipo_local"></i>
                        </div>
                        <div class="col-md-12 ">
                            <div class="card-body text-center p-2">
                                <h5 class="card-title p-0 " style="font-size: 13px;width: 100%" id="marcador_equipo_local"></h5><br>
                            <div class="justify-content-center d-flex inputpuntos ">
                                    <button class="btn btn-danger mb-2 w-100" onclick="marcar(`restar`,`local`)"><i class="bi bi-dash h2"></i></button>
                                        <input type="text" readonly id="m_equipoLocal" value="0" class="form-control w-100 mb-2  " style="height: 120px;font-size: 42px;text-align: center;" >
                                    <button class="btn btn-success mb-2 w-100" onclick="marcar(`sumar`,`local`)"><i class="bi bi-plus h2"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 align-items-center d-flex">Vs</div>
                <div class="card mb-0 w-100">
                    <div class="row g-0 align-items-center d-flex cuadrovisitante" style="flex-direction: column-reverse;">
                    
                        <div class="col-md-12">
                            <div class="card-body text-center p-2">
                                <h5 class="card-title p-0" style="font-size: 13px;width: 100%" id="marcador_equipo_visitante"></h5><br>
                            <div class="justify-content-center d-flex inputpuntos ">
                                    <button class="btn btn-danger mb-2 w-100" onclick="marcar(`restar`,`visitante`)"><i class="bi bi-dash h2"></i></button>
                                        <input type="text" readonly id="m_equipoVisitante" value="0" class="form-control w-100 mb-2  " style="height: 120px;font-size: 42px;text-align: center;" >
                                    <button class="btn btn-success mb-2 w-100" onclick="marcar(`sumar`,`visitante`)"><i class="bi bi-plus h2"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <i class="bi bi-shield-fill escudo" id="color_equipo_visitante"></i>
                        </div>
                    </div>
                </div>
            </div>



            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="actualizarEnfrentamientos(' . $_GET['id_torneo'] . ')" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>';


    if (!isset($_GET['torneo'])) {
        if ($_SESSION['usuario']['id_rol'] == 1) {

            $enfrentarEquipos = ' <div class="col-6 col-md-6 "> <button class="btn btn-info w-100 text-white h-100" onclick="simuladorEnfrentamientoGrupo(' . $_GET['id_torneo'] . ')">
                    <i class="bi bi-shuffle h5"></i><br> ENFRENTAR EQUIPOS
                </button></div>';
        } else {
            $enfrentarEquipos = '';
        }
    } else {
        $enfrentarEquipos = '';
    }


    $contenido .= ' 
    <div class="row">
        <div class="torneo_descripcion  m-0 mb-2 justify-content-center col-md-6 ">
        
              <!--<div class="col-sm-12 col-md-3">
                  <h5>Descripcion</h5>
                    <p class="m-0">' . $responseTorneo['descripcion'] . '</p>
                  
            </div>-->
            <div class="col-sm-12 col-md-6 p-0">
               <p class="card-text m-0">
                    <small class="text-muted">
                        Fecha: ' . date_format($fecha, 'Y-m-d') . '
                    </small>
                </p>
                <p class="card-text m-0 p-0">
                    <small class="text-muted">
                        Hora: ' . date_format($fecha, 'H:i') . '
                    </small>
                </p>
                <p class="card-text mb-2 p-0">
                    <small class="text-muted">
                        Lugar: ' . $responseTorneo['direccion'] . '
                    </small>
                </p>
            </div>
           
            <div class="row col-sm-12 col-md-12 justify-content-center seccionEnfrentamientos">
                
                <div  class="col-6 col-md-6 border border-1  text-white p-0 mb-0" data-bs-toggle="modal" data-bs-target="#enfrentamiento"> 
                    <button class="btn btn-primary w-100">ENFRENTAMIENTOS</button>
                    <div class="text-center mt-1   "><i class="bi bi-shield-fill h2 text-primary"></i></div>
                </div>

                
                ' . $enfrentarEquipos . '
                 

            </div>

            <!--<div class="col-sm-6 col-md-1 d-flex justify-content-center">
                 <button class="btn btn-info w-75 h-75 m-1" onclick="actualizarEnfrentamientosAuto(' . $_GET['id_torneo'] . ')">
                    <i class="bi bi-arrow-clockwise h3 m-0"></i>
                </button>
            </div>  -->
                
    </div>';


    /* GRUPOS */
    $contenido .= '
        ';
    $letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];



    $res = $conexion->query("select e.* , e2.nombre  as equipo, e2.color  from enfrentamientos2 e 
                            inner join equipos e2 on e2.id = e.ganador
                            where (fase = 1 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_GET['id_torneo'])->fetchAll();

    if (isset($res)) {
        if (!empty($res[0]) && !empty($res[1])) {

            $primerFinalista = '
        <input type="hidden" id="primerEquipoFinal" value="' . $res[0]['ganador'] . '">
        <i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res[0]['color'] . '"></i>' . $res[0]['equipo'];

            $segundoFinalista = '
        <input type="hidden" id="segundoEquipoFinal" value="' . $res[1]['ganador'] . '">
        <i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res[1]['color'] . '"></i>' . $res[1]['equipo'];
        } else {
            $primerFinalista = '1roVS4to';
            $segundoFinalista = '2doVS3ro';
        }
    } else {
        $primerFinalista = '1roVS4to';
        $segundoFinalista = '2doVS3ro';
    }


    $sql = "select * from enfrentamientos2 e
                inner join equipos e2 on e2.id = e.ganador
                where e.id_torneo = " . $_GET['id_torneo'] . " and fase = 2 ";

    $res = $conexion->query($sql)->fetch();

    if ($res) {
        $finalista = '<i class="bi bi-shield-fill mt-1 me-1 h1" style="color: ' . ($res['color']) . '"  ></i><br>' . $res['nombre'];
    } else {
        $finalista = '<i class="bi bi-shield-fill mt-1 me-1 h1" style="color: #e8bb48"  ></i><br>CAMPEÓN';
    }


    $esquemaClasificatorio = '';
    if ($tipo == 4) {

        if ($inicioPJ < 3) {
            $Equipo1 = '<p class="pt-3">Equipo 1</p>';
            $Equipo2 = '<p class="pt-3">Equipo 2</p>';
            $Equipo3 = '<p class="pt-3">Equipo 3</p>';
            $Equipo4 = '<p class="pt-3">Equipo 4</p>';
        } else {
            $Equipo1 = '<p class="pt-3"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[0]['color']) . '"  ></i>' . ($arrayTabla[0]['nombre']) . '</p>';
            $Equipo2 = '<p class="pt-3"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[1]['color']) . '"  ></i>' . ($arrayTabla[1]['nombre']) . '</p>';
            $Equipo3 = '<p class="pt-3"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[2]['color']) . '"  ></i>' . ($arrayTabla[2]['nombre']) . '</p>';
            $Equipo4 = '<p class="pt-3"><i class="bi bi-shield-fill mt-1 me-1" style="color: ' . ($arrayTabla[3]['color']) . '"  ></i>' . ($arrayTabla[3]['nombre']) . '</p>';
        }

        $esquemaClasificatorio = '

            <div class="row p-0  m-0 mt-4 text-center justify-content-center esquema2">
                <div class="col-sm-12 col-md-12 esquema esquema2"><br>
                    <input type="hidden" id="id_torneo" value="' . $_GET['id_torneo'] . '" >
                    <input type="hidden" id="primerEquipo" value="' . $arrayTabla[0]['id'] . '">
                    <input type="hidden" id="segundoEquipo" value="' . $arrayTabla[1]['id'] . '">
                    <input type="hidden" id="tercerEquipo" value="' . $arrayTabla[2]['id'] . '">
                    <input type="hidden" id="cuartoEquipo" value="' . $arrayTabla[3]['id'] . '">
                    <div class="row p-0 m-0">


                  
                        

                    <div class="tablero col-12">
                        <div class="lineas">
                            <div class="lh lhl1"></div>
                            <div class="lh lhl2 "style="visibility: hidden"></div>
                            <div class="lh lhl3"></div>
                            <div class="lh lhl4"></div>
                            <div class="lh lhl5" style="visibility: hidden"></div>
                            <div class="lh lhl6"></div>
                            <div class="lh lhl7" style="visibility:hidden"></div>
                            <div class="lh lhl8"></div>
                            <div class="lh lhl9"></div>

                            <div class="lv lvl1" style="visibility:hidden"></div>
                            <div class="lv lvl2"></div>
                            <div class="lv lvl3"></div>
                        </div>
                        <div class="casillas">
                            <div class="casilla casi_1ro" style="border-left: 5px solid  ' . ($arrayTabla[0]['color']) . '" >' . $Equipo1 . '</div>
                            <div class="casilla casi_4to" style="visibility:hidden;   border-left: 5px solid  ' . ($arrayTabla[3]['color']) . '">' . $Equipo4 . '</div>
                            <div class="casilla casi_2do" style="border-left: 5px solid  ' . ($arrayTabla[1]['color']) . '">' . $Equipo2 . '</div>
                            <div class="casilla casi_3ro" style="border-left: 5px solid  ' . ($arrayTabla[2]['color']) . '">' . $Equipo3 . '</div>
                        </div>
                        <div class="casillas_2da_ronda">
                            <div class="casilla casi_1ro4to pt-3" style="visibility:hidden">' . $primerFinalista . '</div>
                            <div class="casilla casi_2do3ro pt-3">' . $segundoFinalista . '</div>
                        </div>
                        <div class="casilla casi_final c5 pt-3">' . $finalista . '</div>
                        <div class="lineas"></div>
                    </div>
                    </div>

                </div>
            </div>

            <style>
                .lhl1{
                    width:387px;
                }
                .lvl3{
                    top: -137px;
                    width: 1px;
                    height: 228px;
                }
            </style>
   ';
    }

    $contRecarga = '';

    if (!isset($recarga)) {
        $contRecarga = '  <button class="btn btn-info m-1" onclick="actualizarEnfrentamientosAuto(' . $_GET['id_torneo'] . ')">
                                    <i class="bi bi-arrow-clockwise m-0"></i>
                                </button>';
    }
    $contenido .= '
            <div class="col-sm-12 col-md-6 p-0 mt-3" id="tablaClasificacion" style="z-index: 1000">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="6">CLASIFICACIÓN</th>
                            <th colspan="3" class="text-end">
                               ' . $contRecarga . '
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Equipo</th>
                            <th scope="col">PJ</th>
                            <th scope="col">G</th>
                            <th scope="col">P</th>
                            <th scope="col">AF</th>
                            <th scope="col">AC</th>
                            <th scope="col" class="text-center">DIF</th>
                            <th scope="col" class="text-center">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $clasificacionEquipo . '
                       
                       
                    </tbody>
                </table>
            </div>



            ' . $esquemaClasificatorio . '
        </div>';
    $data = [
        'titulo' => '<i class="bi bi-arrow-left-circle" style="cursor:pointer" onclick="redireccion(`lista_torneos`)"></i> ' . $responseTorneo['nombre'],
        'contenido' => $contenido
    ];

    if (!isset($_GET['torneo'])) {
        echo json_encode($data);
    } else {
        echo ($contenido);
    }
} else if ($tipo == 5) {



    /* PANTALLA PARA TIPO 5 */
    $inicioPJ = 0;
    foreach ($clasificacion as $cEquipo) {
        array_push($arrayTabla, $cEquipo);
        $i++;
    }


    if (empty($list_enfrentamientos)) {
        $msjEnfrentamiento = '<div class="mensajeEnf">NO HAY ENFRENTAMIENTOS AUN</div>';
        $enfrentamiento = $msjEnfrentamiento;
    } else {
        $msjEnfrentamiento = '';
    }

    foreach ($list_enfrentamientos as $listEnfrentamientos) {

        if ($listEnfrentamientos['ganador'] == 0) {
            $listEnfrentamientos['marcador_local'] = "-";
            $listEnfrentamientos['marcador_visitante'] = "-";
        }

        $fase = $listEnfrentamientos['fase'];
        $espacioCol = '';
        $style = '';



        if ($tipo == 5) {
            if ($fase == 1) {
                $col = 3;
                $espacioCol = '';
                $colorbtn = "info";
                $style = "    background-color: #0dcaf082;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 2) {
                $col = 5;
                $colorbtn = "warning";
                $style = "    background-color: #ffc1077d;border: 1px solid;border-radius: 5px;";
            } else if ($fase == 3) {
                $col = 7;
                $colorbtn = "success";
                $style = "    background-color: #1987549e;border: 1px solid;border-radius: 5px;";
            }
        }


        if ($_SESSION['usuario']['id_rol'] == 1 or $_SESSION['usuario']['id_rol'] == 2) {
            $enfrentamientoResult = ' <button class="btn btn-' . $colorbtn . ' w-100" data-bs-toggle="modal" data-bs-target="#finalizar" onclick="vermarcador(' . $listEnfrentamientos['id'] . ')">
            <i class="bi bi-pencil-square"></i>
            ANOTAR
         </button>';
        } else {
            $enfrentamientoResult = '';
        }


        $enfrentamiento .=  '
    
    <div style="' . $style . '" class=" row col-sm-12  col-md-' . $col . '  d-flex align-items-center justify-content-center m-1 mb-3 p-0 cardsenfrentamientos" >
    <div class="d-flex col-12 m-0 p-0">
        <div class="card mb-0 w-100" >
            <div class="row g-0 align-items-center d-flex p-0">
                <div class="col-md-3 text-center">
                <i class="bi bi-shield-fill escudo" style="color:' . $listEnfrentamientos['color_equipo_local'] . '"></i>
                </div>
                <div class="col-md-9 ">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title p-0 " style="font-size: 15px;width: 100%" >' . $listEnfrentamientos['equipo_local'] . '</h5><br>
                        <h5 class="p-0 m-0 text-center">' . $listEnfrentamientos['marcador_local'] . '</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 align-items-center d-flex">Vs</div>
        <div class="card mb-0 w-100" >
            <div class="row g-0 align-items-center d-flex cuadrovisitante">
            
                <div class="col-md-9">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title p-0" style="font-size: 15px;width: 100%">' . str_replace(" ", "&nbsp;", $listEnfrentamientos['equipo_visitante']) . '</h5><br>
                        <h5 class="p-0 m-0 text-center">' . $listEnfrentamientos['marcador_visitante'] . '</h5>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <i class="bi bi-shield-fill escudo" style="color:' . $listEnfrentamientos['color_equipo_visitante'] . '"></i>
                </div>
            </div>
        </div>
        </div>

          <div class="col-12 m-0 p-0">
            ' . $enfrentamientoResult . '
        </div>
    </div>' . $espacioCol;
    }





    $contenido = ' 
    <link rel="stylesheet" href="./../../' . $link . '/css/esquema2.css">
    <link rel="stylesheet" href="./../../' . $link . '/css/style2.css">
    <link rel="stylesheet" href="./../../' . $link . '/css/responsive_esquema.css">

    <!-- Modal -->
    <div class="modal fade p-0" id="enfrentamiento" tabindex="-1" aria-labelledby="enfrentamientoLabel" aria-hidden="false">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
            <div class="modal-header bg-principal text-white">
                <h5 class="modal-title" id="enfrentamientoLabel">ENFRENTAMIENTOS </h5>
                <button type="button" class="btn-close btn-close-white text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row justify-content-center d-flex">
                    ' . $enfrentamiento . '
                </div>
            </div>
            <div class="modal-footer bg-principal">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
        </div>
        
        
        
        <!-- Modal -->
        <div class="modal fade p-0" id="finalizar" tabindex="-1" aria-labelledby="finalizarLabel" aria-hidden="false">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizarLabel">Marcador </h5>
            </div>
            <div class="modal-body">

            <input type="hidden" value="" id="id_enfrentamiento">
            <input type="hidden" value="" id="id_equipoLocal">
            <input type="hidden" value="" id="id_equipoVisitante">

            <div class="d-flex col-12 m-0 p-0">
                <div class="card mb-0 w-100">
                    <div class="row g-0 align-items-center d-flex p-0" >
                        <div class="col-md-12 text-center">
                        <i class="bi bi-shield-fill escudo" id="color_equipo_local"></i>
                        </div>
                        <div class="col-md-12 ">
                            <div class="card-body text-center p-2">
                                <h5 class="card-title p-0 " style="font-size: 13px;width: 100%" id="marcador_equipo_local"></h5><br>
                            <div class="justify-content-center d-flex inputpuntos ">
                                    <button class="btn btn-danger mb-2 w-100" onclick="marcar(`restar`,`local`)"><i class="bi bi-dash h2"></i></button>
                                        <input type="text" readonly id="m_equipoLocal" value="0" class="form-control w-100 mb-2  " style="height: 120px;font-size: 42px;text-align: center;" >
                                    <button class="btn btn-success mb-2 w-100" onclick="marcar(`sumar`,`local`)"><i class="bi bi-plus h2"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 align-items-center d-flex">Vs</div>
                <div class="card mb-0 w-100">
                    <div class="row g-0 align-items-center d-flex cuadrovisitante" style="flex-direction: column-reverse;">
                    
                        <div class="col-md-12">
                            <div class="card-body text-center p-2">
                                <h5 class="card-title p-0" style="font-size: 13px;width: 100%" id="marcador_equipo_visitante"></h5><br>
                            <div class="justify-content-center d-flex inputpuntos ">
                                    <button class="btn btn-danger mb-2 w-100" onclick="marcar(`restar`,`visitante`)"><i class="bi bi-dash h2"></i></button>
                                        <input type="text" readonly id="m_equipoVisitante" value="0" class="form-control w-100 mb-2  " style="height: 120px;font-size: 42px;text-align: center;" >
                                    <button class="btn btn-success mb-2 w-100" onclick="marcar(`sumar`,`visitante`)"><i class="bi bi-plus h2"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <i class="bi bi-shield-fill escudo" id="color_equipo_visitante"></i>
                        </div>
                    </div>
                </div>
            </div>



            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="actualizarEnfrentamientos(' . $_GET['id_torneo'] . ')" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>';


    if (!isset($_GET['torneo'])) {
        if ($_SESSION['usuario']['id_rol'] == 1) {

            $enfrentarEquipos = ' <div class="col-12 col-md-4 "> <button class="btn btn-info w-100 text-white h-100" onclick="simuladorEnfrentamiento(' . $_GET['id_torneo'] . ')">
                    <i class="bi bi-shuffle h5"></i><br> ENFRENTAR EQUIPOS
                </button></div>';
        } else {
            $enfrentarEquipos = '';
        }
    } else {
        $enfrentarEquipos = '';
    }


    $contenido .= ' 
    <div class="row">
        <div class="torneo_descripcion  m-0 mb-2 justify-content-center row   ">

            <div class="col-sm-12 col-md-4 p-0">
               <p class="card-text m-0">
                    <small class="text-muted">
                        Fecha: ' . date_format($fecha, 'Y-m-d') . '
                    </small>
                </p>
                <p class="card-text m-0 p-0">
                    <small class="text-muted">
                        Hora: ' . date_format($fecha, 'H:i') . '
                    </small>
                </p>
                <p class="card-text mb-2 p-0">
                    <small class="text-muted">
                        Lugar: ' . $responseTorneo['direccion'] . '
                    </small>
                </p>
            </div>
           
            <div class="row col-sm-12 col-md-8 justify-content-center seccionEnfrentamientos">
                
                <div  class="col-12 col-md-6 border border-1  text-white p-0 mb-0" data-bs-toggle="modal" data-bs-target="#enfrentamiento"> 
                    <button class="btn btn-primary w-100">ENFRENTAMIENTOS</button>
                    <div class="text-center mt-1   "><i class="bi bi-shield-fill h2 text-primary"></i></div>
                </div>

                
                ' . $enfrentarEquipos . '
                 

            </div>

            <!--<div class="col-sm-6 col-md-1 d-flex justify-content-center">
                 <button class="btn btn-info w-75 h-75 m-1" onclick="actualizarEnfrentamientosAuto(' . $_GET['id_torneo'] . ')">
                    <i class="bi bi-arrow-clockwise h3 m-0"></i>
                </button>
            </div>  -->
                
    </div>';


    /* GRUPOS */
  
    $esquemaClasificatorio = '';
    if ($tipo == 5) {






        $resEnfrentamiento = $conexion->query("select e.*, e2.color,  e2.nombre as nombreequipo from enfrentamientos e
            inner join equipos e2  on e2.id  = e.id_equipo 
            where e.id_torneo  =  " . $_GET['id_torneo'] . " order by ubicacion ASC")->fetchAll();




        $equiA = isset($resEnfrentamiento[0]['nombreequipo']) ? '<i class="bi bi-shield-fill mt-1 me-1" style="color:' . $resEnfrentamiento[0]['color'] . '"></i>' . $resEnfrentamiento[0]['nombreequipo']  : 'A';
        $equiB = isset($resEnfrentamiento[1]['nombreequipo']) ? '<i class="bi bi-shield-fill mt-1 me-1" style="color:' . $resEnfrentamiento[1]['color'] . '"></i>' . $resEnfrentamiento[1]['nombreequipo']  : 'B';
        $equiC = isset($resEnfrentamiento[2]['nombreequipo']) ? '<i class="bi bi-shield-fill mt-1 me-1" style="color:' . $resEnfrentamiento[2]['color'] . '"></i>' . $resEnfrentamiento[2]['nombreequipo']  : 'C';
        $equiD = isset($resEnfrentamiento[3]['nombreequipo']) ? '<i class="bi bi-shield-fill mt-1 me-1" style="color:' . $resEnfrentamiento[3]['color'] . '"></i>' . $resEnfrentamiento[3]['nombreequipo']  : 'D';
        $equiE = isset($resEnfrentamiento[4]['nombreequipo']) ? $resEnfrentamiento[4]['nombreequipo'] . ' <i class="bi bi-shield-fill mt-1 me-1" style="color:' . $resEnfrentamiento[4]['color'] . '"></i>' : 'E';
        $equiF = isset($resEnfrentamiento[5]['nombreequipo']) ? $resEnfrentamiento[5]['nombreequipo'] . ' <i class="bi bi-shield-fill mt-1 me-1" style="color:' . $resEnfrentamiento[5]['color'] . '"></i>'  : 'F';
        $equiG = isset($resEnfrentamiento[6]['nombreequipo']) ? $resEnfrentamiento[6]['nombreequipo'] . ' <i class="bi bi-shield-fill mt-1 me-1" style="color:' . $resEnfrentamiento[6]['color'] . '"></i>'  : 'G';
        $equiH = isset($resEnfrentamiento[7]['nombreequipo']) ? $resEnfrentamiento[7]['nombreequipo'] . ' <i class="bi bi-shield-fill mt-1 me-1" style="color:' . $resEnfrentamiento[7]['color'] . '"></i>'  : 'H';


        $colorEquiA = isset($resEnfrentamiento[0]['nombreequipo']) ? 'style="border-left-color: ' . $resEnfrentamiento[0]['color'] . ' "' : 'style="border-left-color: transparent "';
        $colorEquiB = isset($resEnfrentamiento[0]['nombreequipo']) ? 'style="border-left-color: ' . $resEnfrentamiento[1]['color'] . ' "' : 'style="border-left-color: transparent "';
        $colorEquiC = isset($resEnfrentamiento[0]['nombreequipo']) ? 'style="border-left-color: ' . $resEnfrentamiento[2]['color'] . ' "' : 'style="border-left-color: transparent "';
        $colorEquiD = isset($resEnfrentamiento[0]['nombreequipo']) ? 'style="border-left-color: ' . $resEnfrentamiento[3]['color'] . ' "' : 'style="border-left-color: transparent "';
        $colorEquiE = isset($resEnfrentamiento[0]['nombreequipo']) ? 'style="border-left-color: ' . $resEnfrentamiento[4]['color'] . ' "' : 'style="border-left-color: transparent "';
        $colorEquiF = isset($resEnfrentamiento[0]['nombreequipo']) ? 'style="border-left-color: ' . $resEnfrentamiento[5]['color'] . ' "' : 'style="border-left-color: transparent "';
        $colorEquiG = isset($resEnfrentamiento[0]['nombreequipo']) ? 'style="border-left-color: ' . $resEnfrentamiento[6]['color'] . ' "' : 'style="border-left-color: transparent "';
        $colorEquiH = isset($resEnfrentamiento[0]['nombreequipo']) ? 'style="border-left-color: ' . $resEnfrentamiento[7]['color'] . ' "' : 'style="border-left-color: transparent "';

        $AB = 'A/B';
        $CD = 'C/D';
        $EF = 'E/F';
        $GH = 'G/H';

        $ABCD = 'AB/CD';
        $EFGH = 'EF/GH';

        $campeon = '<i class="bi bi-shield-fill mt-1 me-1 h1" style="color: #e8bb48"  ></i>CAMPEÓN';



        if (isset($resEnfrentamiento)) {

            $sqlAB = "select * from (
                    select (select  e3.ubicacion from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.*
                    from enfrentamientos2 e 
                        inner join equipos e2 on e2.id = e.ganador    
                        where (fase = 1 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_GET['id_torneo'] . ") a where a.ubicacion = 'A' or a.ubicacion = 'B'";
            $res = $conexion->query($sqlAB)->fetch();
            if (!empty($res)) {
                $AB = '<i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res['color'] . '"></i>' . $res['nombre'];
            }

            $sqlCD = "select * from (
                    select (select  e3.ubicacion from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.*
                    from enfrentamientos2 e 
                        inner join equipos e2 on e2.id = e.ganador    
                        where (fase = 1 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_GET['id_torneo'] . ") a where a.ubicacion = 'C' or a.ubicacion = 'D'";
            $res = $conexion->query($sqlCD)->fetch();
            if (!empty($res)) {
                $CD = '<i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res['color'] . '"></i>' . $res['nombre'];
            }

            $sqlEF = "select * from (
                    select (select  e3.ubicacion from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.*
                    from enfrentamientos2 e 
                        inner join equipos e2 on e2.id = e.ganador    
                        where (fase = 1 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_GET['id_torneo'] . ") a where a.ubicacion = 'E' or a.ubicacion = 'F'";
            $res = $conexion->query($sqlEF)->fetch();
            if (!empty($res)) {
                $EF = '<i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res['color'] . '"></i>' . $res['nombre'];
            }

            $sqlGH = "select * from (
                    select (select  e3.ubicacion from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.*
                    from enfrentamientos2 e 
                        inner join equipos e2 on e2.id = e.ganador    
                        where (fase = 1 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_GET['id_torneo'] . ") a where a.ubicacion = 'G' or a.ubicacion = 'H'";
            $res = $conexion->query($sqlGH)->fetch();
            if (!empty($res)) {
                $GH = '<i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res['color'] . '"></i>' . $res['nombre'];
            }


            /* ------------ */

            $sqlABCD = "select * from (
                    select (select  e3.ubicacion from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.*
                    from enfrentamientos2 e 
                        inner join equipos e2 on e2.id = e.ganador    
                        where (fase = 2 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_GET['id_torneo'] . ") a where a.ubicacion = 'A' or a.ubicacion = 'B'  or a.ubicacion = 'C' or a.ubicacion = 'D'";
            $res = $conexion->query($sqlABCD)->fetch();
            if (!empty($res)) {
                $ABCD = '<i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res['color'] . '"></i>' . $res['nombre'];
            }

            $sqlEFGH = "select * from (
                    select (select  e3.ubicacion from enfrentamientos e3 where e2.id  = e3.id_equipo ) as ubicacion, e2.*
                    from enfrentamientos2 e 
                        inner join equipos e2 on e2.id = e.ganador    
                        where (fase = 2 ) and ganador <> 0 and perdedor  <> 0  and e.id_torneo  = " . $_GET['id_torneo'] . ") a where a.ubicacion = 'E' or a.ubicacion = 'F'  or a.ubicacion = 'G' or a.ubicacion = 'H'";
            $res = $conexion->query($sqlEFGH)->fetch();
            if (!empty($res)) {
                $EFGH = '<i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res['color'] . '"></i>' . $res['nombre'];
            }

            /* ----------------------------- */
            $sqlCampeon = "select e2.* from enfrentamientos2 e  
                            inner join equipos e2 on e2.id  = e.ganador
                            where e.id_torneo  = " . $_GET['id_torneo'] . " and fase = 3";
            $res = $conexion->query($sqlCampeon)->fetch();
            if (!empty($res)) {
                $campeon = '<div class="campeon"><i class="bi bi-trophy-fill  mt-1 me-1" style="color: #ffc107"></i><br><i class="bi bi-shield-fill mt-1 me-1" style="color:' . $res['color'] . '"></i>' . $res['nombre'].'</div>';
               
                
            }
        }


        

        $esquemaClasificatorio .= '<div class="row p-0 m-0 esquema_enfrentamiento">
        
        <div class="tablero col-6">
            <div class="casilla" ' . $colorEquiA . '>
                <div class="lineaH"></div>
                <div class="lineaV"></div>
                <div class="lineaH2"></div>
                <div class="casilla c2" >
                <div class="lineaH"></div>
                    <div class="lineaV2"></div>
                    <div class="lineaH3"></div>

                    <div class="casilla c3"></div>
                </div>
            </div>
            <div class="casilla" ' . $colorEquiB . '>
                <div class="lineaH"></div>
            </div>
            <div class="casilla" ' . $colorEquiC . '>
                <div class="lineaH"></div>
                <div class="lineaV"></div>
                <div class="lineaH2"></div>
                <div class="casilla c2">
                <div class="lineaH"></div>   
                </div>

            </div>
            <div class="casilla" ' . $colorEquiD . '>
                <div class="lineaH"></div>
            </div>
        </div>

        <div class="tablero col-6 tablero-invertido">
            <div class="casilla" ' . $colorEquiH . '>
                <div class="lineaH"></div>
                <div class="lineaV"></div>
                <div class="lineaH2"></div>
                <div class="casilla c2">
                <div class="lineaH"></div>
                    <div class="lineaV2"></div>
                    <div class="lineaH3"></div>

                    <div class="casilla c3"></div>
                </div>
            </div>
            <div class="casilla" ' . $colorEquiG . '>
                <div class="lineaH"></div>
            </div>
            <div class="casilla" ' . $colorEquiF . '>
                <div class="lineaH"></div>
                <div class="lineaV"></div>
                <div class="lineaH2"></div>
                <div class="casilla c2">
                    <div class="lineaH"></div>   
                    <div class="casilla c4"></div>

                </div>

            </div>
            <div class="casilla" ' . $colorEquiE . '>
                <div class="lineaH"></div>
            </div>
        </div>
        
        


         <p style="border-color: black" class="team equipoA equipo1" id="equipoA">' . $equiA . '</p>
        <p class="team equipoA equipo2" id="equipoB">' . $equiB . '</p>
        <p class="team equipoA equipo3" id="equipoC">' . $equiC . '</p>
        <p class="team equipoA equipo4" id="equipoD">' . $equiD . '</p>
        <p class="team equipoB equipo1" id="equipoE">' . $equiE . '</p>
        <p class="team equipoB equipo2" id="equipoF">' . $equiF . '</p>
        <p class="team equipoB equipo3" id="equipoG">' . $equiG . '</p>
        <p class="team equipoB equipo4" id="equipoH">' . $equiH . '</p>

        <p class="team equipoA equipoA1 ">' . $AB . '</p>
        <p class="team equipoA equipoA2 ">' . $CD . '</p>

        <p class="team equipoB equipoB1">' . $EF . '</p>
        <p class="team equipoB equipoB2">' . $GH . '</p>

        <p class="team equipoA equipoA3">' . $ABCD . '</p>
        <p class="team equipoB equipoB3">' . $EFGH . '</p>

        <p class="team equipoB equipofinal">' . $campeon . '</p>

</div>

        <style>
        
            .team{margin: 25px 13px 19px;}

            .lineaV2{    
                width: 1px;
                margin-left: 208px;
            }
            .lineaH3{
                top: -111px;
            }
            .c4{
                left: 236px;
                border: 1px solid;
            }

            .equipo2{
                left: initial
            }

            .equipoA1 {
                top: 232px;
                left: 280px;
            }
            .equipoA2 {
                top: 411px;
                left: 279px;
            }
            .equipoB2 {
                top: 412px;
                right: 280px;
            }
            .equipoB1 {
                top: 230px;
                right: 281px;
                display: initial;
            }
            .equipoA3{
                top: 273px;
                left: 514px;
                display: initial;
            }
            .equipoB3{
                top: 369px;
                right: 515px;
                display: initial;
            }
            .equipofinal {
                top: 474px;
                right: 514px;
                width: 232px;
                font-size: 34px;
                text-align: center;
            }
            .campeon  {
                top: 474px;
                right: 528px;
                width: 232px;
                font-size: 30px;
                text-align: center;
                position: absolute;
            }
        </style>
        
        
        ';
    }

    $contRecarga = '';

    if (!isset($recarga)) {
        $contRecarga = '  <button class="btn btn-info m-1" onclick="actualizarEnfrentamientosAuto(' . $_GET['id_torneo'] . ')">
                                    <i class="bi bi-arrow-clockwise m-0"></i>
                                </button>';
    }
    $contenido .= $esquemaClasificatorio;
    $data = [
        'titulo' => '<i class="bi bi-arrow-left-circle" style="cursor:pointer" onclick="redireccion(`lista_torneos`)"></i> ' . $responseTorneo['nombre'],
        'contenido' => $contenido
    ];

    if (!isset($_GET['torneo'])) {
        echo json_encode($data);
    } else {
        echo ($contenido);
    }
}
