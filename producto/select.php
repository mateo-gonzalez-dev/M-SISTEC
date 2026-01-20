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
    <title>Producto - SELECT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">

    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <?php require_once('../config/database.php');?>
    <?php include('../temp/header.php') ?>
    <?php include('../temp/contenido.php') ?>

    <div id="contenido">


        <form method="GET" action="select.php">
            <div class="buscador">
                <p>Filtro por Referencia</p>
                <input type="text"  name="buscar"  placeholder="Buscar por referencia" value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>">

                 <select name="categoria" class="select-filtros">
                    <option value="">Todas las categorias...</option>
                    <?php
                    $marcas = mysqli_query($conexion, "SELECT id_categoria, tipo_categoria FROM categoria ORDER BY tipo_categoria ASC");
                    $marcaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : '';

                    while ($fila = mysqli_fetch_assoc($marcas)) {
                        $selected = ($marcaSeleccionada == $fila['id_categoria']) ? "selected" : "";
                        echo "<option value='".$fila['id_categoria']."' $selected>".strtoupper($fila['tipo_categoria'])."</option>";
                    }
                    ?>
                </select>

                <select name="marca" class="select-filtros">
                    <option value="">Todas las marcas...</option>
                    <?php
                    $marcas = mysqli_query($conexion, "SELECT id_marca, nombre_marca FROM marca ORDER BY nombre_marca ASC");
                    $marcaSeleccionada = isset($_GET['marca']) ? $_GET['marca'] : '';

                    while ($fila = mysqli_fetch_assoc($marcas)) {
                        $selected = ($marcaSeleccionada == $fila['id_marca']) ? "selected" : "";
                        echo "<option value='".$fila['id_marca']."' $selected>".strtoupper($fila['nombre_marca'])."</option>";
                    }
                    ?>
                </select>

                <a href="select.php" class="btn-filtro clear">Limpiar</a>

                <button type="submit">Buscar</button>

                
            </div>
        </form>

        <form action="select.php" method="POST" name="select">
            <fieldset>
                <legend id="titulo-form">
                    <h2>Seleccionar Producto</h2>
                    <a href="insert.php" id="btn-insertar">
                      <i class="fa-solid fa-user-plus"></i>
                      <p>Añadir Producto</p>
                    </a>
                </legend>
                

                <table class="tabla_roles">
                    <tr>
                        <th>Categoria</th>
                        <th>Marca</th>
                        <th>Referencia</th>
                        <th>Stock</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Proveedor</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                

                <?php

                $where = " WHERE 1 ";


                if (isset($_GET['categoria']) && $_GET['categoria'] !== "") {
                    $categoria = intval($_GET['categoria']);
                    $where .= " AND producto.id_categoria = $categoria";
                }

                if (isset($_GET['marca']) && $_GET['marca'] !== "") {
                    $marca = intval($_GET['marca']);
                    $where .= " AND producto.id_marca = $marca";
                }

                if (isset($_GET['buscar']) && $_GET['buscar'] !== "") {
                    $buscar = mysqli_real_escape_string($conexion, $_GET['buscar']);
                    $where .= " AND producto.referencia LIKE '%$buscar%'";
}

                
                $sql_registros = mysqli_query($conexion,"
                    SELECT COUNT(*) AS total 
                    FROM producto
                    INNER JOIN categoria ON producto.id_categoria = categoria.id_categoria
                    INNER JOIN marca ON producto.id_marca = marca.id_marca
                    INNER JOIN persona ON producto.id_proveedor = persona.id_persona
                    $where
                ");

                $result_registros = mysqli_fetch_array($sql_registros);

                $total = $result_registros['total'];

                $por_pagina = 10;
                $pagina = empty($_GET['PAGINA'])?1:$_GET['PAGINA'];

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = ceil($total / $por_pagina);

                
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
                $where
                LIMIT $desde,$por_pagina";

                $ejecutar = mysqli_query($conexion, $consulta);

                if(mysqli_num_rows($ejecutar)>0){
                    while($fila = mysqli_fetch_assoc($ejecutar)){
                        $id_producto = $fila['id_producto'];
                        $categoria = $fila['categoria'];
                        $marca = $fila['marca'];
                        $referencia = $fila['referencia'];
                        $stock = $fila['stock'];
                        $p_compra = $fila['precio_compra'];
                        $p_venta = $fila['precio_venta'];
                        $proveedor = $fila['proveedor'];

                        echo "
                    <tr>
                      <td>$categoria</td>
                      <td>$marca</td>
                      <td>$referencia</td>
                      <td>$stock</td>
                      <td>$p_compra</td>
                      <td>$p_venta</td>
                      <td>$proveedor</td>
                        
                      <td>
                        <a class='btn-accion btn-actualizar' href='update.php?ACTUALIZAR=$id_producto' title='Actualizar'>
                          <i class='fa-solid fa-pen-to-square'></i>
                        </a>
                      </td>
                      <td>
                        <a class='btn-accion btn-eliminar' href='select.php?ELIMINAR=$id_producto' title='Eliminar' onclick=\"return confirm('¿Desea eliminar este producto?');\">
                          <i class='fa-solid fa-trash-can'></i>
                        </a>
                      </td>
                      
                    </tr>
                  ";
                }
              } else {
                echo "<tr><td colspan='4'>No hay Productos registrados.</td></tr>";
              }
                ?>
            </table>
            </fieldset>
        </form>

        <div class="paginador">
            <?php
                echo "<a href='select.php?PAGINA=1' class='link-pagina'>Primera</a>";
                for ($i = 1; $i <= $total_paginas; $i++) {
                $pagina = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
                $clase_activa = ($i == $pagina) ? "link-activa" : "link-pagina";
                echo "<a href='select.php?PAGINA=$i' class='$clase_activa'>$i</a>";
                }
                echo "<a href='select.php?PAGINA=$total_paginas' class='link-pagina'>Última</a>";
                echo "<br>";
                echo "<p class='info_pagina'>Pagina $pagina de $total_paginas</p>"
            ?>
        </div>

        <?php
        
        if(isset($_GET["ELIMINAR"])){
            $borrar_id = $_GET["ELIMINAR"];
            $eliminar = "DELETE FROM producto WHERE id_producto = '$borrar_id'";

            $ejecutar = mysqli_query($conexion, $eliminar);

            if($ejecutar){
                echo "<script>alert('Registro eliminado correctamente');</script>";
                echo "<script>window.open('select.php','_self');</script>";
            }

        }

        ?>

        
    </div>


    </div>


    <?php include('../temp/footer.php') ?>
    
</body>
</html>