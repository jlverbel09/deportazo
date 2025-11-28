<?php 
require_once '../conexion.php';
$enfrentamiento = '';
$clasificacionEquipo = '';
$responseTorneo = $conexion->query("select * from torneo t where id  =  ".$_GET['id_torneo'])->fetch();
$listTorneos = '';
$fecha=date_create($responseTorneo['fecha']);

$resEnfrentamiento = $conexion->query("select e.*, e2.nombre as nombreequipo from enfrentamientos e
inner join equipos e2  on e2.id  = e.id_equipo 
where e.id_torneo  =  ".$_GET['id_torneo']." order by ubicacion ASC")->fetchAll();

$list_enfrentamientos  = $conexion->query("select local , e2.nombre as equipo_local ,e.marcador as m_local , e3.marcador as m_visitante , e4.nombre as equipo_visitante, visitante  from guia_enfrentamientos ge  
left join enfrentamientos e on e.ubicacion = ge.`local` 
left join enfrentamientos e3 on e3.ubicacion = ge.visitante 
inner join equipos e2 on e2.id =e.id_equipo 
inner join equipos e4 on e4.id =e3.id_equipo
where e2.id_torneo  =  ".$_GET['id_torneo']." and id_tipo =2")->fetchAll();

$clasificacion = $conexion->query("select  * from tabla_posiciones where id_torneo  = ".$_GET['id_torneo'] );

foreach ($clasificacion as $cEquipo){
    
$clasificacionEquipo .= '<tr>
                            <th scope="row">1</th>
                            <td>'.$cEquipo['id'].'</td>
                            <td>'.$cEquipo['id'].'</td>
                            <td>'.$cEquipo['id'].'</td>
                            <td>'.$cEquipo['id'].'</td>
                            <td>'.$cEquipo['id'].'</td>
                        </tr>';
}

foreach($list_enfrentamientos as $listEnfrentamientos){

    $local = $listEnfrentamientos['local'];
    $visitante = $listEnfrentamientos['visitante'];
    $enfrentamiento .= '<div class="col-sm-12 col-md-4 d-flex align-items-center justify-content-center m-0">
        <div class="card mb-3 w-100" >
            <div class="row g-0 align-items-center d-flex">
                <div class="col-md-3 text-center">
                <i class="bi bi-shield-fill escudo"></i>
                </div>
                <div class="col-md-9 ">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title p-0 " style="font-size: 15px;width: 100%" >'.$listEnfrentamientos['equipo_local'].'</h5><br>
                        <h5 class="p-0 m-0 text-center">'.$listEnfrentamientos['m_local'].'</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2">Vs</div>
        <div class="card mb-3 w-100" >
            <div class="row g-0 align-items-center d-flex">
            
                <div class="col-md-9">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title p-0" style="font-size: 15px;width: 100%">'.str_replace(" ","&nbsp;",$listEnfrentamientos['equipo_visitante']).'</h5><br>
                        <h5 class="p-0 m-0 text-center">'.$listEnfrentamientos['m_visitante'].'</h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-shield-fill escudo"></i>
                </div>
            </div>
        </div>
    </div>';
}


$contenido = '

    <!-- Modal -->
    <div class="modal fade p-0" id="enfrentamiento" tabindex="-1" aria-labelledby="enfrentamientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="enfrentamientoLabel">Enfrentamientos - '.$responseTorneo['nombre'].'</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="row">
                '.$enfrentamiento.'
            </div>


            

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>';


$contenido .= ' 
        <div class="torneo_descripcion row m-0 mb-2 ">
        
            <div class="col-sm-12 col-md-3">
                    <h5>Descripcion</h5>
                    <p class="m-0">'.$responseTorneo['descripcion'].'</p>
                  
            </div>
            <div class="col-sm-12 col-md-3">
               <p class="card-text m-0">
                    <small class="text-muted">
                        Fecha: '.date_format($fecha,'Y-m-d h:i:s').'
                    </small>
                </p>
                <p class="card-text m-0">
                    <small class="text-muted">
                        Hora: '.date_format($fecha,'h:i').'
                    </small>
                </p>
                <p class="card-text mb-2 ">
                    <small class="text-muted">
                        Lugar: '.$responseTorneo['direccion'].'
                    </small>
                </p>
            </div>
           
            <div  class="col-sm-12 col-md-3 border border-1  text-white p-0 mb-2" data-bs-toggle="modal" data-bs-target="#enfrentamiento"> 
                <button class="btn btn-primary w-100">ENFRENTAMIENTOS</button>
                <div class="text-center mt-1   "><i class="bi bi-shield-fill h2 text-primary"></i></div>
            </div>
             <div class="col-sm-12 col-md-1 ">
                <button class="btn btn-info w-100 " onclick="simuladorEnfrentamiento('.$_GET['id_torneo'].')">
                    <i class="bi bi-eye h5"></i><br> Enfrentar Equipos
                </button>
            </div>  

             <div class="col-sm-12 col-md-2 ">
                 <button class="btn btn-info w-100 " onclick="simuladorEnfrentamientoGrupo('.$_GET['id_torneo'].')">
                    <i class="bi bi-eye h5"></i><br> Enfrentar Equipos en Grupo
                </button>
            </div>  
                
        </div>';

switch ($responseTorneo['tipo']) {
    case 1:

        /* GRUPOS */
        $contenido .='
        <div class="row p-0 m-0 mt-4 text-center justify-content-center">';
        $letras = ['A','B','C','D','E','F','G','H'];
       /*  for ($i=0; $i < 8; $i++) {  */
        $contenido .='
            <div class="col-sm-12 col-md-5 ">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="6">CLASIFICACIÓN</th>
                        </tr>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Equipo</th>
                            <th scope="col">PJ</th>
                            <th scope="col">G</th>
                            <th scope="col">P</th>
                            <th scope="col">Puntos</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$clasificacionEquipo.'
                       
                       
                    </tbody>
                </table>
            </div>
        ';
        /* } */
        $contenido .= '</div>';
        break;
    
    case 5:
        /* ELIMINATORIA DIRECTA 8 */


        $equiA = isset($resEnfrentamiento[0]['nombreequipo'])? $resEnfrentamiento[0]['nombreequipo']  : 'Equipo A' ;
        $equiB = isset($resEnfrentamiento[1]['nombreequipo'])? $resEnfrentamiento[1]['nombreequipo']  : 'Equipo B' ;
        $equiC = isset($resEnfrentamiento[2]['nombreequipo'])? $resEnfrentamiento[2]['nombreequipo']  : 'Equipo C' ;
        $equiD = isset($resEnfrentamiento[3]['nombreequipo'])? $resEnfrentamiento[3]['nombreequipo']  : 'Equipo D' ;
        $equiE = isset($resEnfrentamiento[4]['nombreequipo'])? $resEnfrentamiento[4]['nombreequipo']  : 'Equipo E' ;
        $equiF = isset($resEnfrentamiento[5]['nombreequipo'])? $resEnfrentamiento[5]['nombreequipo']  : 'Equipo F' ;
        $equiG = isset($resEnfrentamiento[6]['nombreequipo'])? $resEnfrentamiento[6]['nombreequipo']  : 'Equipo G' ;
        $equiH = isset($resEnfrentamiento[7]['nombreequipo'])? $resEnfrentamiento[7]['nombreequipo']  : 'Equipo H' ;

        $contenido .= '<div class="row p-0 m-0">
        
       

        <p class="team equipoA equipo1" id="equipoA">'.$equiA.'</p>
        <p class="team equipoA equipo2" id="equipoB">'.$equiB.'</p>
        <p class="team equipoA equipo3" id="equipoC">'.$equiC.'</p>
        <p class="team equipoA equipo4" id="equipoD">'.$equiD.'</p>
        <p class="team equipoB equipo1" id="equipoE">'.$equiE.'</p>
        <p class="team equipoB equipo2" id="equipoF">'.$equiF.'</p>
        <p class="team equipoB equipo3" id="equipoG">'.$equiG.'</p>
        <p class="team equipoB equipo4" id="equipoH">'.$equiH.'</p>

        <p class="team equipoA equipoA1 ">AB</p>
        <p class="team equipoA equipoA2 ">CD</p>

        <p class="team equipoB equipoB1">EF</p>
        <p class="team equipoB equipoB2">GH</p>

        <p class="team equipoA equipoA3">ABCD</p>
        <p class="team equipoB equipoB3">EFGH</p>

        <p class="team equipoB equipofinal">Campeón</p>




        <div class="tablero col-6">
            <div class="casilla">
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
            <div class="casilla">
                <div class="lineaH"></div>
            </div>
            <div class="casilla">
                <div class="lineaH"></div>
                <div class="lineaV"></div>
                <div class="lineaH2"></div>
                <div class="casilla c2">
                <div class="lineaH"></div>   
                </div>

            </div>
            <div class="casilla">
                <div class="lineaH"></div>
            </div>
        </div>

        <div class="tablero col-6 tablero-invertido">
            <div class="casilla">
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
            <div class="casilla">
                <div class="lineaH"></div>
            </div>
            <div class="casilla">
                <div class="lineaH"></div>
                <div class="lineaV"></div>
                <div class="lineaH2"></div>
                <div class="casilla c2">
                    <div class="lineaH"></div>   
                    <div class="casilla c4"></div>

                </div>

            </div>
            <div class="casilla">
                <div class="lineaH"></div>
            </div>
        </div>
        </div>';
        break;


    case 6 :
        /* ELIMINATORIA DIRECTA 4 */
        $contenido .= '<div class="row p-0 m-0">

                <p class="equipoA equipo1">Equipo 1</p>
                <p class="equipoA equipo2">Equipo 1</p>
                <p class="equipoA equipo3">Equipo 1</p>
                <p class="equipoA equipo4">Equipo 1</p>

                

                <p class="equipoA equipoA1">Equipo 1</p>
                <p class="equipoA equipoA2">Equipo 1</p>
            
                
                <p class="equipoB equipofinalCuarto">Final</p>


                

                <div class="tablero col-6">
                    <div class="casilla">
                        <div class="lineaH"></div>
                        <div class="lineaV"></div>
                        <div class="lineaH2"></div>
                        <div class="casilla c2">
                        <div class="lineaH"></div>
                            <div class="lineaV2"></div>
                            <div class="lineaH3"></div>

                            <div class="casilla c5"></div>
                        </div>
                    </div>
                    <div class="casilla">
                        <div class="lineaH"></div>
                    </div>
                    <div class="casilla">
                        <div class="lineaH"></div>
                        <div class="lineaV"></div>
                        <div class="lineaH2"></div>
                        <div class="casilla c2">
                        <div class="lineaH"></div>   
                        </div>

                    </div>
                    <div class="casilla">
                        <div class="lineaH"></div>
                    </div>
                </div>

            </div>';
    break;
} 










$data = [
    'titulo' => '<i class="bi bi-arrow-left-circle" style="cursor:pointer" onclick="redireccion(`lista_torneos`)"></i> '. $responseTorneo['nombre'],
    'contenido' => $contenido
];


echo json_encode($data);