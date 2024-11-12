<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
include('api.php');

$api = new Api();
$data = []; // Inicializa la variable para la respuesta

$option = isset($_GET['option']) ? $_GET['option'] : null; // Asegúrate de que exista 'option'

if ($option == 'list') {
    $data = $api->list();
} elseif ($option == 'insert') {
    $data = $api->insert();
} elseif ($option == 'delete') {
    $data = $api->delete();
} elseif ($option == 'update') {
    $data = $api->update();
}
else {
    $data = [
        'status' => 400,
        'message' => 'Opción no válida.'
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>
