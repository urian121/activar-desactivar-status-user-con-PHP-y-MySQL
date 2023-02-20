<?php
if (($_SERVER["REQUEST_METHOD"] == "POST")) {
require_once("../config/confiBD.php");

header('Content-type: application/json; charset=utf-8');
$jsondata = [];


function respuesta($resp = '')
{
    if ($resp != 0) {
        return $jsondata['msj'] = true;
    } else {
        return $jsondata['msj'] = false;
    }
}



$status      = $_POST['estatus'];
$idSala      = $_POST['idSala'];


$sql = "UPDATE salas 
        SET 
            status          = '$status'
        WHERE id_sala       = $idSala ";

$prepareQuery = $auth->prepare($sql);
$executeQuery = $prepareQuery->execute();
$jsondata = respuesta($executeQuery);


echo json_encode($status ==1 ? 1 : 0);
exit();
}