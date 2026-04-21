<?php
require_once '../conexion.php';
session_start();

// Get all matches with dates
$query = "SELECT e.*, t.nombre as torneo_nombre, t.fecha as torneo_fecha,
          e2.nombre as equipo_local, e3.nombre as equipo_visitante,
          DATE_FORMAT(e.fecha, '%Y-%m-%d') as fecha_formateada,
          DATE_FORMAT(e.fecha, '%W %d %M %Y') as fecha_legible
          FROM enfrentamientos2 e
          INNER JOIN torneo t ON t.id = e.id_torneo
          INNER JOIN equipos e2 ON e2.id = e.id_equipo_local
          INNER JOIN equipos e3 ON e3.id = e.id_equipo_visitante
          WHERE e.fecha IS NOT NULL AND e.fecha != '0000-00-00'
          ORDER BY e.fecha ASC, e.hora ASC";
print_r($query);
$result = $conexion->query($query)->fetchAll();

$contenido = '
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendario de Enfrentamientos</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Torneo</th>
                                    <th>Local</th>
                                    <th>Visitante</th>
                                    <th>Resultado</th>
                                    <th>Fase</th>
                                </tr>
                            </thead>
                            <tbody>';

if (count($result) > 0) {
    foreach ($result as $match) {
        $resultado = '';
        if ($match['ganador'] > 0) {
            if ($match['ganador'] == $match['id_equipo_local']) {
                $resultado = '<span class="badge bg-success">' . $match['puntos_local'] . '-' . $match['puntos_visitante'] . '</span>';
            } else {
                $resultado = '<span class="badge bg-success">' . $match['puntos_visitante'] . '-' . $match['puntos_local'] . '</span>';
            }
        } else {
            $resultado = 'Pendiente';
        }

        $fase_texto = '';
        switch ($match['fase']) {
            case 0: $fase_texto = 'Grupos'; break;
            case 1: $fase_texto = 'Semifinal'; break;
            case 2: $fase_texto = 'Final'; break;
            case 3: $fase_texto = 'Tercer Puesto'; break;
            default: $fase_texto = 'Fase ' . $match['fase'];
        }

        $contenido .= '
                                <tr>
                                    <td>' . $match['fecha_legible'] . '</td>
                                    <td>' . ($match['hora'] ? $match['hora'] : 'Por definir') . '</td>
                                    <td>' . $match['torneo_nombre'] . '</td>
                                    <td>' . $match['equipo_local'] . '</td>
                                    <td>' . $match['equipo_visitante'] . '</td>
                                    <td>' . $resultado . '</td>
                                    <td>' . $fase_texto . '</td>
                                </tr>';
    }
} else {
    $contenido .= '
                                <tr>
                                    <td colspan="7" class="text-center">No hay enfrentamientos programados</td>
                                </tr>';
}

$contenido .= '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';

$data = [
    'titulo' => 'Calendario de Enfrentamientos',
    'contenido' => $contenido
];

echo json_encode($data);
?>