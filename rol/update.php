<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['vendedor'])) {
    header("Location: ../login/login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rol - UPDATE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">

    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <?php require_once('../config/database.php');?>
    <?php include('../temp/header.php') ?>
    <?php include('../temp/contenido.php')?>

    <?php
      // Si viene el parámetro ACTUALIZAR desde select.php
      if (isset($_GET['ACTUALIZAR'])) {
          $editar_id = $_GET['ACTUALIZAR'];
          $consulta = "SELECT * FROM rol WHERE id_rol = '$editar_id'";
          $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
          $fila = mysqli_fetch_assoc($ejecutar);
          $id_rol = $fila['id_rol'];
          $nom = $fila['nombre_rol'];
      }
    ?>

    <form name="update" method="POST" action="">
      <fieldset>
        <legend id="titulo-form">
            <h2>Datos del Rol</h2>
            <a href="select.php" id="btn-insertar">
                <i class="fa-solid fa-arrow-left"></i>
                <p>Regresar</p>
            </a>
        </legend>

        <div class="inputs-formularios">
            <label for="txt_idrol">ID Rol:</label>
            <input type="text" name="txt_idrol" value="<?php echo $id_rol; ?>" readonly>
        </div>
        
        <div class="inputs-formularios">
            <label for="txt_nombre">Nombre del Rol:</label>
            <input type="text" name="txt_nombre" value="<?php echo $nom; ?>" required>
        </div>

        <div class="input-guardar-fomrularios">
            <input type="submit" name="actualizar" value="Actualizar Datos">
        </div>

        
      </fieldset>
    </form>

    <?php
      // Si el formulario se envía
      if (isset($_POST['actualizar'])) {
          $id = $_POST['txt_idrol'];
          $nom = trim($_POST['txt_nombre']);

          if (!empty($nom)) {
              $actualizar = "UPDATE ROL SET NOMBRE_ROL='$nom' WHERE ID_ROL='$id'";
              $ejecutar = mysqli_query($conexion, $actualizar) or die(mysqli_error($conexion));

              echo "<script>alert(' Rol actualizado correctamente');</script>";
              echo "<script>window.open('select.php','_self');</script>";
          } else {
              echo "<script>alert('Por favor, ingrese un nombre válido.');</script>";
          }
      }
    ?>



    </div>

    </div>

    <?php include('../temp/footer.php');?>
</body>
</html>