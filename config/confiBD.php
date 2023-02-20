<?php

  $servidor = "localhost";
  $usuario  = "root";
  $bdServer = "calendario";
  $password = "";
 
  try {
        $auth = new PDO("mysql:host=$servidor;dbname=$bdServer;charset=utf8", $usuario, $password);      
        $auth->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $auth->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        //echo "Conexion realizada Satisfactoriamente";
      }
    catch(PDOException $e)
      {
      echo "La conexion ha fallado: " . $e->getMessage();
      echo '<pre>';
      printf((int)$e->getCode(). "\n");
      echo '</pre>';
      }

  //$auth = null;

  ?>