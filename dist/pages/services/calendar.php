
<?php 


$contenido ='<iframe height="135%" style="position:absolute" src="./calendario/index.html" frameborder="0"></iframe>';
$data = [
    'titulo' => 'Calendario',
    'contenido' => $contenido
];


echo json_encode($data);