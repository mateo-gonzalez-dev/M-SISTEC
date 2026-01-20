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
    <title>Producto - UPDATE</title>
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
            SELECT 
                producto.id_producto,
                categoria.tipo_categoria AS categoria,
                marca.nombre_marca AS marca,
                producto.referencia, 
                producto.stock, 
                producto.precio_compra,
                producto.precio_venta,
                persona.nombre AS proveedor 

                FROM producto
                INNER JOIN categoria ON producto.id_categoria = categoria.id_categoria
                INNER JOIN marca ON producto.id_marca = marca.id_marca
                INNER JOIN persona ON producto.id_proveedor = persona.id_persona 
            WHERE id_producto = '$editar_id'";
            $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
            $fila = mysqli_fetch_assoc($ejecutar);
            $id_producto = $fila['id_producto'];
            $categoria = $fila['categoria'];
            $marca = $fila['marca'];
            $referencia = $fila['referencia'];
            $stock = $fila['stock'];
            $p_compra = $fila['precio_compra'];
            $p_venta = $fila['precio_venta'];
            $proveedor = $fila['proveedor'];
      }
    ?>

    <form name="update" method="POST" action="">
      <fieldset>
        <legend id="titulo-form">
            <h2>Datos del Producto</h2>
            <a href="select.php" id="btn-insertar">
                <i class="fa-solid fa-arrow-left"></i>
                <p>Regresar</p>
            </a>
        </legend>

        <div class="inputs-formularios">
            <label for="txt_nombre">Id del Producto</label>
            <input type="text" name="txt_id_producto" value="<?php echo $id_producto; ?>" required>
        </div>

        <div class="inputs-formularios">
                    <label>Categoria</label>
                    <select class="select-formularios" name="txt_categoria" required>
                        <option><?php echo $categoria; ?></option>
                        <?php
                        $tipos_categorias = mysqli_query($conexion, "SELECT id_categoria, tipo_categoria FROM categoria ORDER BY tipo_categoria ASC");
                        while ($fila = mysqli_fetch_assoc($tipos_categorias)) {
                            echo "<option value='" . $fila['id_categoria'] . "'>" . strtoupper($fila['tipo_categoria']) . "</option>";
                        }
                        ?>
                    </select>
        </div>
        
        <div class="inputs-formularios">
                    <label>Marca:</label>
                    <select class="select-formularios" name="txt_marca" required>
                        <option><?php echo $marca; ?></option>
                        <?php
                        $marcas = mysqli_query($conexion, "SELECT id_marca, nombre_marca FROM marca ORDER BY nombre_marca ASC");
                        while ($fila = mysqli_fetch_assoc($marcas)) {
                            echo "<option value='" . $fila['id_marca'] . "'>" . strtoupper($fila['nombre_marca']) . "</option>";
                        }
                        ?>
                    </select>
        </div>

        <div class="inputs-formularios">
            <label for="txt_nombre">Referencia:</label>
            <input type="text" name="txt_referencia" value="<?php echo $referencia; ?>" required>
        </div>

        <div class="inputs-formularios">
            <label for="txt_nombre">Stock:</label>
            <input type="number" name="txt_stock" value="<?php echo $stock; ?>" required>
        </div>

        <div class="inputs-formularios">
            <label for="txt_nombre">Precio de Compra:</label>
            <input type="number" name="txt_p_compra" value="<?php echo $p_compra; ?>" required>
        </div>

        <div class="inputs-formularios">
            <label for="txt_nombre">Precio de Venta:</label>
            <input type="number" name="txt_p_venta" value="<?php echo $p_venta; ?>" required>
        </div>

        <div class="inputs-formularios">
                    <label>Proveedor:</label>
                    <select class="select-formularios" name="txt_proveedor" required>
                        <option><?php echo $proveedor; ?></option>
                        <?php
                        $proveedores = mysqli_query($conexion, "SELECT id_persona, nombre FROM persona WHERE id_rol = 3 ORDER BY nombre ASC");
                        while ($fila = mysqli_fetch_assoc(result: $proveedores)) {
                            echo "<option value='" . $fila['id_persona'] . "'>" . strtoupper($fila['nombre']) . "</option>";
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
          $id = $_POST['txt_id_producto'];
          $nuevo_categoria = trim($_POST['txt_categoria']);
          $nuevo_marca = $_POST['txt_marca'];
          $nuevo_referencia = $_POST['txt_referencia'];
          $nuevo_stock = $_POST['txt_stock'];
          $nuevo_p_compra = $_POST['txt_p_compra'];
          $nuevo_p_venta = $_POST['txt_p_venta'];
          $nuevo_proveedor= $_POST['txt_proveedor'];
          
          if (!empty($nuevo_categoria)) {
              $actualizar = "UPDATE PRODUCTO SET 
              ID_CATEGORIA ='$nuevo_categoria', 
              ID_MARCA = '$nuevo_marca',
              REFERENCIA= '$nuevo_referencia', 
              STOCK= '$nuevo_stock',
              PRECIO_COMPRA='$nuevo_p_compra',
              PRECIO_VENTA='$nuevo_p_venta',
              ID_PROVEEDOR= '$nuevo_proveedor'

              WHERE ID_PRODUCTO='$id'";
              $ejecutar = mysqli_query($conexion, $actualizar) or die(mysqli_error($conexion));

              echo "<script>alert('Producto actualizado correctamente');</script>";
              echo "<script>window.open('select.php','_self');</script>";
          } else {
              echo "<script>alert('Por favor, ingrese los datos válido.');</script>";
          }
      }
    ?>
    </div>

    </div>

    <?php include('../temp/footer.php');?>
</body>
</html>