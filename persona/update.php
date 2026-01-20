<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['vendedor'])) {
    // Nadie logueado
    header("Location: ../login/login.php");
    exit();
}

// Si es vendedor, NO tiene permiso
if (isset($_SESSION['vendedor'])) {
    echo "<script>
        alert('No estás autorizado para ingresar a esta página.');
        window.location.href = '../persona/select.php';
    </script>";
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario - UPDATE</title>
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
          $consulta = "
          SELECT persona.id_persona,
                persona.nombre, 
                tipo_identidad.tipo_identidad AS tipo_identidad, 
                tipo_documento.tipo_documento AS tipo_documento, 
                persona.numero_documento, 
                persona.correo_electronico, 
                rol.nombre_rol AS rol,
                persona.direccion,
                ciudad.nombre AS ciudad

                FROM persona
                INNER JOIN tipo_identidad ON persona.id_tipo_identidad = tipo_identidad.id_tipo_identidad
                INNER JOIN tipo_documento ON persona.id_tipo_documento = tipo_documento.id_tipo_documento
                INNER JOIN rol ON persona.id_rol = rol.id_rol
                INNER JOIN ciudad ON persona.ciudad = ciudad.id_ciudad
            WHERE id_persona = '$editar_id'";
            $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
            $fila = mysqli_fetch_assoc($ejecutar);
            $id_persona = $fila['id_persona'];
            $nom = $fila['nombre'];
            $tipo_identidad = $fila['tipo_identidad'];
            $tipo_documento = $fila['tipo_documento'];
            $numero_documento = $fila['numero_documento'];
            $correo = $fila['correo_electronico'];
            $rol = $fila['rol'];
            $direccion = $fila['direccion'];
            $ciudad = $fila['ciudad'];
      }
    ?>

    <form name="update" method="POST" action="">
      <fieldset>
        <legend id="titulo-form">
            <h2>Datos de la Persona</h2>
            <a href="select.php" id="btn-insertar">
                <i class="fa-solid fa-arrow-left"></i>
                <p>Regresar</p>
            </a>
        </legend>

        <div class="inputs-formularios">
            <label for="txt_nombre">Id del Usuario</label>
            <input type="text" name="txt_id_persona" value="<?php echo $id_persona; ?>" required>
        </div>
        
        <div class="inputs-formularios">
            <label for="txt_nombre">Nombre del Usuario</label>
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
            <label for="txt_nombre">Numero de Documento:</label>
            <input type="text" name="txt_numero_documento" value="<?php echo $numero_documento; ?>" required>
        </div>

        <div class="inputs-formularios">
            <label for="txt_nombre">Correo Electronico:</label>
            <input type="text" name="txt_correo" value="<?php echo $correo; ?>" required>
        </div>

        <div class="inputs-formularios">
                    <label>Rol:</label>
                    <select class="select-formularios" name="txt_rol" required>
                        <option><?php echo $rol; ?></option>
                        <?php
                        $roles = mysqli_query($conexion, "SELECT id_rol, nombre_rol FROM rol ORDER BY nombre_rol ASC");
                        while ($fila = mysqli_fetch_assoc($roles)) {
                            echo "<option value='" . $fila['id_rol'] . "'>" . strtoupper($fila['nombre_rol']) . "</option>";
                        }
                        ?>
                    </select>
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
          $id = $_POST['txt_id_persona'];
          $nom = trim($_POST['txt_nombre']);
          $nuevo_tipo_identidad = $_POST['txt_tipo_identidad'];
          $nuevo_tipo_documento = $_POST['txt_tipo_documento'];
          $nuevo_numero_documento= $_POST['txt_numero_documento'];
          $nuevo_correo = $_POST['txt_correo'];
          $nuevo_rol = $_POST['txt_rol'];
          $nuevo_direccion= $_POST['txt_direccion'];
          $nuevo_ciudad= $_POST['txt_ciudad'];
          
          if (!empty($nom)) {
              $actualizar = "UPDATE PERSONA SET 
              NOMBRE='$nom', 
              ID_TIPO_IDENTIDAD= '$nuevo_tipo_identidad',
              ID_TIPO_DOCUMENTO= '$nuevo_tipo_documento', 
              NUMERO_DOCUMENTO= '$nuevo_numero_documento',
              CORREO_ELECTRONICO='$nuevo_correo',
              ID_ROL='$nuevo_rol',
              DIRECCION= '$nuevo_direccion', 
              CIUDAD= '$nuevo_ciudad' 
              WHERE ID_PERSONA='$id'";
              $ejecutar = mysqli_query($conexion, $actualizar) or die(mysqli_error($conexion));

              echo "<script>alert('Usuario actualizada correctamente');</script>";
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