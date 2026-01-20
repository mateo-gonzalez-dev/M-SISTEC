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
    <title>Usuario - INSERT</title>
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

    <div id="contenido">
        <form action="insert.php" method="POST" name="insert">
            <fieldset>
                <legend id="titulo-form">
                    <h2>Insertar Usuario</h2>
                    <a href="select.php" id="btn-insertar">
                      <i class="fa-solid fa-arrow-left"></i>
                      <p>Regresar</p>
                    </a>
                </legend>
                <div class="inputs-formularios">
                    <label> Nombre del Usuario</label>
                    <input type="text" name="txtnombre"required>
                </div>

                <div class="inputs-formularios">
                    <label>Tipo de Identidad:</label>
                    <select class="select-formularios" name="txt_tipo_identidad" required>
                        <option value="">Seleccione...</option>
                        <?php
                        $tipo_identidad = mysqli_query($conexion, "SELECT id_tipo_identidad, tipo_identidad FROM tipo_identidad ORDER BY tipo_identidad ASC");
                        while ($fila = mysqli_fetch_assoc($tipo_identidad)) {
                            echo "<option value='" . $fila['id_tipo_identidad'] . "'>" . strtoupper($fila['tipo_identidad']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="inputs-formularios">
                    <label>Tipo de documento:</label>
                    <select class="select-formularios" name="txt_tipo_documento" required>
                        <option value="">Seleccione...</option>
                        <?php
                        $tipo_documento = mysqli_query($conexion, "SELECT id_tipo_documento, tipo_documento FROM tipo_documento ORDER BY tipo_documento ASC");
                        while ($fila = mysqli_fetch_assoc($tipo_documento)) {
                            echo "<option value='" . $fila['id_tipo_documento'] . "'>" . strtoupper($fila['tipo_documento']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="inputs-formularios">
                    <label> Numero de Documento:</label>
                    <input type="text" name="txt_numero_documento"required>
                </div>

                <div class="inputs-formularios">
                    <label> Correo Electronico:</label>
                    <input type="text" name="txt_correo"required>
                </div>

                <div class="inputs-formularios">
                    <label> Contraseña:</label>
                    <input type="password" name="txt_contrasena">
                </div>

                <div class="inputs-formularios">
                    <label>Rol:</label>
                    <select class="select-formularios" name="txt_rol" required>
                        <option value="">Seleccione...</option>
                        <?php
                        $rol = mysqli_query($conexion, "SELECT id_rol, nombre_rol FROM rol ORDER BY nombre_rol ASC");
                        while ($fila = mysqli_fetch_assoc($rol)) {
                            echo "<option value='" . $fila['id_rol'] . "'>" . strtoupper($fila['nombre_rol']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="inputs-formularios">
                    <label> Direccion:</label>
                    <input type="text" name="txt_direccion"required>
                </div>

                <div class="inputs-formularios">
                    <label>Ciudad:</label>
                    <select class="select-formularios" name="txt_ciudad" required>
                        <option value="">Seleccione...</option>
                        <?php
                        $ciudad = mysqli_query($conexion, "SELECT id_ciudad, nombre FROM ciudad ORDER BY nombre ASC");
                        while ($fila = mysqli_fetch_assoc($ciudad)) {
                            echo "<option value='" . $fila['id_ciudad'] . "'>" . strtoupper($fila['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input-guardar-fomrularios">
                    <input type="submit" value="Guardar" name="enviar">
                </div>
            </fieldset>
        </form>

        <?php

        if(isset($_POST['enviar'])) {
            $nom = $_POST['txtnombre'];
            $post_tipo_identidad = $_POST['txt_tipo_identidad'];
            $post_tipo_documento = $_POST['txt_tipo_documento'];
            $post_numero_documento = $_POST['txt_numero_documento'];
            $post_correo = $_POST['txt_correo'];
            $post_contrasena = md5($_POST['txt_contrasena']);
            $post_rol = $_POST['txt_rol'];
            $post_direccion = $_POST['txt_direccion'];
            $post_ciudad = $_POST['txt_ciudad'];

            if(!empty($post_numero_documento)) {
                $verificar = mysqli_query($conexion,"SELECT COUNT(*)AS total FROM persona WHERE numero_documento='$post_numero_documento'");

                $existe = mysqli_fetch_assoc($verificar);

                if($existe['total']>0){
                    echo "<script>alert('Este Usuario ya existe en la base de datos.');</script>";
                }else{
                    $sql = "INSERT INTO persona (nombre, id_tipo_identidad, id_tipo_documento, numero_documento, correo_electronico, contrasena, id_rol, direccion, ciudad) 
                    VALUES ('$nom','$post_tipo_identidad', '$post_tipo_documento','$post_numero_documento', '$post_correo', '$post_contrasena', '$post_rol', '$post_direccion','$post_ciudad')";

                    $result = mysqli_query($conexion, $sql) or die (mysqli_error($conexion));

                    echo "<script>alert('✅ Usuario registrado exitosamente.');</script>";
                    echo "<script>window.open('select.php','_self');</script>";
                }
            }else{
                echo "<script>alert('Por favor, ingrese un nombre válido.');</script>";
            }

        }

        ?>



    </div>

    </div>

    <?php include('../temp/footer.php');?>
</body>
</html>