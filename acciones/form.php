
<?php
if(isset($_REQUEST['editSala'])):
     $idSala = $_REQUEST['idSala'];
     $sqlQuery = "SELECT * FROM salas WHERE id_sala='{$idSala}' LIMIT 1";
        $req = $auth->prepare($sqlQuery);
        $req->execute(); 
        $data = $req->fetch();
 ?>
<form method="POST" action="./accionSala.php">
     <input type="text" name="accionForm" value="editSala" hidden>
     <input type="text" name="idSala" value="<?php echo $_REQUEST['idSala']; ?>" hidden>
     <div class="mb-3">
          <label for="nombre_sala" class="form-label">Nombre del Usuario</label>
          <input type="text" name="nombre_sala" class="form-control" value="<?php echo $data['nombre_sala']; ?>">
     </div>
     <div class="mb-3">
          <label for="capacidad" class="form-label">Email del usuario</label>
          <input type="email" class="form-control" name="email">
     </div>
     <div class="mb-3">
          <label for="edad" class="form-label">Edad</label>
          <select name="edad" class="form-control">
               <?php
               $edad = $data['edad'];
               for ($p = 18; $p <= 50; $p++) {
                    if($edad == $p):
                         echo '<option  value=' . $p . ' selected>' . $p . '</option>';
                    else:
                         echo '<option value=' . $p . '> ' . $p . '</option>';
                    endif;
               } ?>
          </select>
     </div>

   

     <div class="form-group">
          <label for="elementos">Observación</label>
          <textarea class="form-control" name="elementos" rows="3"><?php echo $data['elementos']; ?></textarea>
     </div>
     <button type="submit" name="submit" class="btn btn-primary btn-block">Actualizar Sala</button>
</form>


<?php else: ?>

<form method="POST" action="./accionSala.php">
<input type="text" name="accionForm" value="addSala" hidden>
     <div class="mb-3">
          <label for="nombre_sala" class="form-label">Nombre de la Sala</label>
          <input type="text" name="nombre_sala" class="form-control">
     </div>
     <div class="mb-3">
          <label for="Edificio" class="form-label">Edificio</label>
          <select name="edificio" class="form-control">
               <option value="Administrativo">Administrativo</option>
               <option value="Producción">Producción</option>
          </select>
     </div>
     <div class="mb-3">
          <label for="edad" class="form-label">edad</label>
          <select name="edad" class="form-control">
               <?php
               for ($p = 18; $p <= 50; $p++) {
                    echo '<option value=' . $p . '> ' . $p . '</option>';
               } ?>
          </select>
     </div>

     <div class="mb-3">
          <label for="capacidad" class="form-label">Capacidad de personas</label>
          <select name="capacidad" class="form-control">
               <?php
               for ($p = 3; $p <= 20; $p++) {
                    echo '<option value=' . $p . '>' . $p . '</option>';
               } ?>
          </select>
     </div>

     <div class="form-group">
          <label for="elementos">Nombre los elementos que pose la sala</label>
          <textarea class="form-control" name="elementos" rows="3"></textarea>
     </div>

     <button type="submit" name="submit" class="btn btn-primary btn-block">Registrar Sala</button>
</form>

<?php endif; ?>