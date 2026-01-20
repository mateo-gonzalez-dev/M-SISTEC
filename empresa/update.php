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
    <title>Empresa - UPDATE</title>
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
          $consulta = "SELECT empresa.id_empresa, empresa.nombre, tipo_identidad.tipo_identidad AS tipo_identidad, tipo_documento.tipo_documento AS tipo_documento, empresa.numero_identificacion, empresa.direccion, ciudad.nombre AS ciudad
                FROM empresa
                INNER JOIN tipo_identidad ON empresa.id_tipo_identidad = tipo_identidad.id_tipo_identidad
                INNER JOIN tipo_documento ON empresa.id_tipo_documento = tipo_documento.id_tipo_documento
                INNER JOIN ciudad ON empresa.id_ciudad = ciudad.id_ciudad
            WHERE id_empresa = '$editar_id'";
          $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
          $fila = mysqli_fetch_assoc($ejecutar);
          $id_empresa = $fila['id_empresa'];
          $nom = $fila['nombre'];
          $tipo_identidad = $fila['tipo_identidad'];
          $tipo_documento = $fila['tipo_documento'];
          $numero_identificacion = $fila['numero_identificacion'];
          $direccion= $fila['direccion'];
          $ciudad = $fila['ciudad'];
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
            <label for="txt_idrol">ID de la Empresa:</label>
            <input type="text" name="txt_idrol" value="<?php echo $id_empresa; ?>" readonly>
        </div>
        
        <div class="inputs-formularios">
            <label for="txt_nombre">Nombre de la Empresa</label>
            <input type="text" name="txt_nombre" value="<?php echo $nom; ?>" required>
        </div>

        <div class="inputs-formularios">
                    <label>Tipo de Identidad:</label>
                    <select class="select-formularios" name="txt_tipo_identidad" required>
                        <option><?php echo $tipo_identidad; ?></option>
                        <?php
                        $tipos_identidades = mysqli_query($conexion, "SELECT id_tipo_identidad, tipo_identidad FROM tipo_identidad ORDER BY tipo_identidad ASC");
                        while ($fila = mysqli_fetch_assoc($tipos_identidades)) {
                            echo "<option value='" . $fila['id_tipo_identidad'] . "'>" . strtoupper($fila['tipo_identidad']) . "</option>";
                        }
                        ?>
                    </select>
        </div>

        <div class="inputs-formularios">
                    <label>Tipo Documento:</label>
                    <select class="select-formularios" name="txt_tipo_documento" required>
                        <option><?php echo $tipo_documento; ?></option>
                        <?php
                        $tipos_documentos = mysqli_query($conexion, "SELECT id_tipo_documento, tipo_documento FROM tipo_documento ORDER BY tipo_documento ASC");
                        while ($fila = mysqli_fetch_assoc($tipos_documentos)) {
                            echo "<option value='" . $fila['id_tipo_documento'] . "'>" . strtoupper($fila['tipo_documento']) . "</option>";
                        }
                        ?>
                    </select>
        </div>

        <div class="inputs-formularios">
            <label for="txt_nombre">Numero de Identificacion:</label>
            <input type="text" name="txt_numero_identificacion" value="<?php echo $numero_identificacion; ?>" required>
        </div>

        <div class="inputs-formularios">
            <label for="txt_nombre">Direccion:</label>
            <input type="text" name="txt_direccion" value="<?php echo $direccion; ?>" required>
        </div>

        <div class="inputs-formularios">
                    <label>Ciudad:</label>
                    <select class="select-formularios" name="txt_ciudad" required>
                        <option><?php echo $ciudad; ?></option>
                        <?php
                        $ciudades = mysqli_query($conexion, "SELECT id_ciudad, nombre FROM ciudad ORDER BY nombre ASC");
                        while ($fila = mysqli_fetch_assoc($ciudades)) {
                            echo "<option value='" . $fila['id_ciudad'] . "'>" . strtoupper($fila['nombre']) . "</option>";
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
          $nuevo_tipo_identidad = $_POST['txt_tipo_identidad'];
          $nuevo_tipo_documento = $_POST['txt_tipo_documento'];
          $nuevo_numero_identificacion= $_POST['txt_numero_identificacion'];
          $nuevo_direccion= $_POST['txt_direccion'];
          $nuevo_ciudad= $_POST['txt_ciudad'];
          
          if (!empty($nom)) {
              $actualizar = "UPDATE EMPRESA SET NOMBRE='$nom', ID_TIPO_IDENTIDAD= '$nuevo_tipo_identidad',
              ID_TIPO_DOCUMENTO= '$nuevo_tipo_documento', NUMERO_IDENTIFICACION= '$nuevo_numero_identificacion'
              , DIRECCION= '$nuevo_direccion', ID_CIUDAD= '$nuevo_ciudad' WHERE ID_EMPRESA='$id'";
              $ejecutar = mysqli_query($conexion, $actualizar) or die(mysqli_error($conexion));

              echo "<script>alert('Empresa actualizada correctamente');</script>";
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