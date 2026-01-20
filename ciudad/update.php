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
    <title>Ciudad - UPDATE</title>
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
          $consulta = "SELECT ciudad.id_ciudad, ciudad.nombre, departamento.id_departamento, departamento.nombre AS departamento
            FROM ciudad
            INNER JOIN departamento ON ciudad.id_departamento = departamento.id_departamento
            WHERE id_ciudad = '$editar_id'";
          $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
          $fila = mysqli_fetch_assoc($ejecutar);
          $id_ciudad = $fila['id_ciudad'];
          $nom = $fila['nombre'];
          $id_departamento = $fila['id_departamento'];
          $departamento = $fila['departamento'];
      }
    ?>

    <form name="update" method="POST" action="">
      <fieldset>
        <legend id="titulo-form">
            <h2>Datos de la Ciudad</h2>
            <a href="select.php" id="btn-insertar">
                <i class="fa-solid fa-arrow-left"></i>
                <p>Regresar</p>
            </a>
        </legend>

        <div class="inputs-formularios">
            <label for="txt_idrol">ID de la Ciudad:</label>
            <input type="text" name="txt_idrol" value="<?php echo $id_ciudad; ?>" readonly>
        </div>
        
        <div class="inputs-formularios">
            <label for="txt_nombre">Nombre de la Ciduad:</label>
            <input type="text" name="txt_nombre" value="<?php echo $nom; ?>" required>
        </div>

        <div class="inputs-formularios">
                    <label>Departamento:</label>
                    <select class="select-formularios" name="txtdepartamento" required>
                        <option value="<?php echo $id_pais; ?>"><?php echo $departamento; ?></option>
                        <?php
                        $departamentos = mysqli_query($conexion, "SELECT id_departamento, nombre FROM departamento ORDER BY nombre ASC");
                        while ($fila = mysqli_fetch_assoc($departamentos)) {
                            echo "<option value='" . $fila['id_departamento'] . "'>" . strtoupper($fila['nombre']) . "</option>";
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
          $nuevo_departamento = $_POST['txtdepartamento'];

          if (!empty($nom)) {
              $actualizar = "UPDATE CIUDAD SET NOMBRE='$nom', ID_DEPARTAMENTO= '$nuevo_departamento' WHERE ID_CIUDAD='$id'";
              $ejecutar = mysqli_query($conexion, $actualizar) or die(mysqli_error($conexion));

              echo "<script>alert('Ciudad actualizada correctamente');</script>";
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