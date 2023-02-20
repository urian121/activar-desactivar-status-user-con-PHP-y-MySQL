<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activar y desactivar status || Web Developer</title>
    <link type="text/css" rel="shortcut icon" href="../assets/imgs/favicon.webp" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="./assets/css/notificacion.css">

    <!-- las tres siguientes líneas son un truco para obtener elementos semánticos de HTML5 que funcionan en versiones de Internet Explorer antiguas -->
    <!--[if lt IE 9]>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->

</head>

<body>
    <div class="container custom_Conteiner mt-100 mb-100" style="width:90% !important;">
        <div class="row">
            <div class="col-md-4">
                <h3 class="text-center">Registrar nuevo Usuario</h3>
            </div>
            <div class="col-md-8">
                <h3 class="text-center">Lista de Usuarios</h3>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        </div>

        <?php
        include('./nav_sala.php');

        require_once("./config/confiBD.php");
        $sqlQuery = "SELECT * FROM salas ORDER BY id_sala";
        $req = $auth->prepare($sqlQuery);
        $req->execute();
        $events = $req->fetchAll();

      
        ?>

        <div class="row">

            <div class="col-md-4">
                <?php include('./acciones/form.php'); ?>
            </div>


            <div class="col-md-8 mt-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Email</th>
                                <th scope="col">Edad</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conteo = 1;
                            foreach ($events as $event) : ?>
                                <tr>
                                    <td><?php echo  $conteo++ . ')'; ?></td>
                                    <td><?php echo $event['nombre_sala']; ?></td>
                                    <td><?php echo $event['edificio']; ?></td>
                                    <td><?php echo $event['elementos']; ?></td>
                                    <td style="display: flex; justify-content: space-between;">

                                        <a href="./?editSala&idSala=<?php echo $event['id_sala']; ?>" class="btn btn-light" title="Edtar Sala">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        <label class="toggle">
                                            <input class="toggle-checkbox" type="checkbox" data-id="<?php echo $event['id_sala']; ?>" data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo ($event['status'] == 1 ? 'checked' : '') ?>>
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label statusSala_<?php echo $event['id_sala']; ?>">
                                                <?php echo ($event['status'] == 1 ? 'Activa' : 'Inactiva') ?>
                                            </span>
                                        </label>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                    </table>
                </div>

            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        $('.toggle-checkbox').change(function() {
            let estatus = $(this).prop('checked') == true ? '1' : '0';
            let idSala = $(this).data('id');

            $.ajax({
                type: "POST",
                dataType: "json",
                url: './status_Sala.php',
                data: {
                    'estatus': estatus,
                    'idSala': idSala
                },
                success: function(data) {
                    console.log(data);
                    (data ? resp = 'Activa' : resp = 'Inactiva')
                    document.querySelector('.statusSala_' + idSala).innerHTML = resp;
                }
            });

        });
    </script>

</body>

</html>