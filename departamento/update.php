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
    <title>Departamento - UPDATE</title>
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
          $consulta = "SELECT departamento.id_departamento, departamento.nombre, pais.id_pais, pais.nombre AS pais
            FROM departamento 
            INNER JOIN pais ON departamento.id_pais = pais.id_pais
            WHERE id_departamento = '$editar_id'";
          $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
          $fila = mysqli_fetch_assoc($ejecutar);
          $id_departamento = $fila['id_departamento'];
          $nom = $fila['nombre'];
          $id_pais = $fila['id_pais'];
          $pais = $fila['pais'];
      }
    ?>

    <form name="update" method="POST" action="">
      <fieldset>
        <legend id="titulo-form">
            <h2>Datos del Departamento</h2>
            <a href="select.php" id="btn-insertar">
                <i class="fa-solid fa-arrow-left"></i>
                <p>Regresar</p>
            </a>
        </legend>

        <div class="inputs-formularios">
            <label for="txt_idrol">ID del Departamento:</label>
            <input type="text" name="txt_idrol" value="<?php echo $id_departamento; ?>" readonly>
        </div>
        
        <div class="inputs-formularios">
            <label for="txt_nombre">Nombre del Departamento:</label>
            <input type="text" name="txt_nombre" value="<?php echo $nom; ?>" required>
        </div>

        <div class="inputs-formularios">
                    <label>Pais:</label>
                    <select class="select-formularios" name="txtpais" required>
                        <option value="<?php echo $id_pais; ?>"><?php echo $pais; ?></option>
                        <?php
                        $paises = mysqli_query($conexion, "SELECT id_pais, nombre FROM pais ORDER BY nombre ASC");
                        while ($fila = mysqli_fetch_assoc($paises)) {
                            echo "<option value='" . $fila['id_pais'] . "'>" . strtoupper($fila['nombre']) . "</option>";
                        }
                        ?>
                    </select>
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
          $nuevo_pais = $_POST['txtpais'];

          if (!empty($nom)) {
              $actualizar = "UPDATE DEPARTAMENTO SET NOMBRE='$nom', ID_PAIS= '$nuevo_pais' WHERE ID_DEPARTAMENTO='$id'";
              $ejecutar = mysqli_query($conexion, $actualizar) or die(mysqli_error($conexion));

              echo "<script>alert(' Categoria actualizado correctamente');</script>";
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