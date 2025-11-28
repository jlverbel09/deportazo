
<?php 


$contenido ='<iframe class="m-0 p-0" style="position: absolute;
    height: 87%;
    width: 98%;" src="./services/content_galeria.php" frameborder="0"></iframe>';
$data = [
    'titulo' => 'Galeria',
    'contenido' => $contenido
];


echo json_encode($data);