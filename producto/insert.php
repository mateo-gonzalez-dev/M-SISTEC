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
    <title>Producto - INSERT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet">
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
                    <h2>Insertar Producto</h2>
                    <a href="select.php" id="btn-insertar">
                      <i class="fa-solid fa-arrow-left"></i>
                      <p>Regresar</p>
                    </a>
                </legend>

                <div class="inputs-formularios">
                    <label>Categoria:</label>
                    <select class="select-formularios" name="txt_categoria" required>
                        <option value="">Seleccione...</option>
                        <?php
                        $categoria = mysqli_query($conexion, "SELECT id_categoria, tipo_categoria FROM categoria ORDER BY tipo_categoria ASC");
                        while ($fila = mysqli_fetch_assoc($categoria)) {
                            echo "<option value='" . $fila['id_categoria'] . "'>" . strtoupper($fila['tipo_categoria']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="inputs-formularios">
                    <label>Marca:</label>
                    <select class="select-formularios" name="txt_marca" required>
                        <option value="">Seleccione...</option>
                        <?php
                        $marca = mysqli_query($conexion, "SELECT id_marca, nombre_marca FROM marca ORDER BY nombre_marca ASC");
                        while ($fila = mysqli_fetch_assoc($marca)) {
                            echo "<option value='" . $fila['id_marca'] . "'>" . strtoupper($fila['nombre_marca']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="inputs-formularios">
                    <label>Referencia:</label>
                    <input type="text" name="txt_referencia" required>
                </div>

                <div class="inputs-formularios">
                    <label>Stock:</label>
                    <input type="number" name="txt_stock" required>
                </div>

                <div class="inputs-formularios">
                    <label>Precio Compra:</label>
                    <input type="number" step="0.01" name="txt_precio_compra" required>
                </div>

                <div class="inputs-formularios">
                    <label>Precio Venta:</label>
                    <input type="number" step="0.01" name="txt_precio_venta" required>
                </div>

                <div class="inputs-formularios">
                    <label>Proveedor:</label>
                    <select class="select-formularios" name="txt_proveedor" required>
                        <option value="">Seleccione...</option>
                        <?php
                        $proveedor = mysqli_query($conexion, "SELECT id_persona, nombre FROM persona WHERE id_rol = 3 ORDER BY nombre ASC");
                        while ($fila = mysqli_fetch_assoc($proveedor)) {
                            echo "<option value='" . $fila['id_persona'] . "'>" . strtoupper($fila['nombre']) . "</option>";
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

            $post_categoria = $_POST['txt_categoria'];
            $post_marca = $_POST['txt_marca'];
            $post_referencia = $_POST['txt_referencia'];
            $post_stock = $_POST['txt_stock'];
            $post_precio_compra = $_POST['txt_precio_compra'];
            $post_precio_venta = $_POST['txt_precio_venta'];
            $post_proveedor = $_POST['txt_proveedor'];

            if(!empty($post_referencia)) {
                $verificar = mysqli_query($conexion,"SELECT COUNT(*)AS total FROM producto WHERE referencia='$post_referencia'");
                $existe = mysqli_fetch_assoc($verificar);

                if($existe['total']>0){
                    echo "<script>alert('Este Producto ya existe en la base de datos.');</script>";
                }else{

                    $sql = "INSERT INTO producto (id_categoria, id_marca, referencia, stock, precio_compra, precio_venta, id_proveedor) 
                    VALUES ('$post_categoria','$post_marca','$post_referencia','$post_stock','$post_precio_compra','$post_precio_venta','$post_proveedor')";

                    $result = mysqli_query($conexion, $sql) or die (mysqli_error($conexion));

                    echo "<script>alert('✅ Producto registrado exitosamente.');</script>";
                    echo "<script>window.open('select.php','_self');</script>";
                }
            }else{
                echo "<script>alert('Por favor, ingrese una referencia válida.');</script>";
            }
        }
        ?>
    </div>

    <?php include('../temp/footer.php');?>
</body>
</html>
