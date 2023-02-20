<?php
// if (isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     require_once("../config/confiBD.php");
     print_r($_POST);
     $accion = $_POST['accionForm'];
     if($accion == 'addSala'):
          
          $nombre_sala     = $_POST['nombre_sala'];
          $edificio        = $_POST['edificio'];
          $piso            = trim($_POST['piso']);
          $capacidad       = trim($_POST['capacidad']);
          $elementos       = $_POST['elementos'];

  
          $sqlInsert = "INSERT INTO salas(nombre_sala, edificio, piso, capacidad, elementos) 
                      values ('{$nombre_sala}', '{$edificio}', '{$piso}', '{$capacidad}', '{$elementos}')";
          $prepareQuery = $auth->prepare($sqlInsert);
          $executeQuery = $prepareQuery->execute();
          header('Location: '.$_SERVER['HTTP_REFERER']);

          elseif($accion == 'editSala'):
               $id_sala         = trim($_POST['idSala']);
               $nombre_sala     = $_POST['nombre_sala'];
               $edificio        = trim($_POST['edificio']);
               $piso            = trim($_POST['piso']);
               $capacidad       = trim($_POST['capacidad']);
               $elementos       = $_POST['elementos'];
       
               $sql = "UPDATE salas 
                    SET 
                         nombre_sala    = '$nombre_sala', 
                         edificio       = '$edificio',
                         piso           = '$piso',
                         capacidad      = '$capacidad',
                         elementos      = '$elementos' 
               WHERE id_sala    = $id_sala ";
       
               $prepareQuery = $auth->prepare($sql);
               $executeQuery = $prepareQuery->execute();
               header('Location: '.$_SERVER['HTTP_REFERER']);

          endif;
     }
