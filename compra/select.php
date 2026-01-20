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
        window.location.href = '../inicio/inicio.php';
    </script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra - SELECT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>

<?php require_once('../config/database.php');?>
<?php include('../temp/header.php'); ?>
<?php include('../temp/contenido.php'); ?>

<div id="contenido">

    <!-- BUSCADOR Y FILTROS -->
    <form method="GET" action="select.php">
        <div class="buscador">

            <p>Filtro por Cliente</p>
            <input type="text" name="buscar" placeholder="Nombre o documento"
                   value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>">


            <!-- FILTRO POR VALOR -->
            <p>Filtro por Valor</p>
            <input type="text" name="valor" placeholder="Buscar por Valor Total"
                   value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>">
            

            <a href="select.php" class="btn-filtro clear">Limpiar</a>
            <button type="submit">Buscar</button>

        </div>
    </form>

    <form action="select.php" method="POST" name="select">
        <fieldset>

            <legend id="titulo-form">
                <h2>Facturas</h2>
                <a href="../persona/select.php?rol=4" id="btn-insertar">
                    <i class="fa-solid fa-user-plus"></i>
                    <p>Añadir Factura</p>
                </a>
            </legend>

            <!-- TABLA -->
            <table class="tabla_roles">
                <tr>
                    <th>Id Compra</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Valor Total</th>
                    <th>Vendedor</th>
                    <th>Empresa</th>
                    <th>Estado</th>
                    <th>Detalles</th>
                    <th>Anular</th>
                </tr>

                <?php
                /* =====================================================
                   CONSTRUCCIÓN DEL WHERE
                ===================================================== */

                $where = " WHERE 1 ";

               if (!empty($_GET['buscar'])) {
                    $buscar = mysqli_real_escape_string($conexion, $_GET['buscar']);
                    $where .= " AND (
                                    cliente.numero_documento LIKE '%$buscar%' 
                                    OR cliente.nombre LIKE '%$buscar%'
                                ) ";
                }

                if (!empty($_GET['valor'])) {
                    $valor = intval($_GET['valor']);
                    $where .= " AND compra.valor_total LIKE '%$valor%' ";
                }


                /* =====================================================
                   PAGINACIÓN
                ===================================================== */

                $sql_registros = "
                     SELECT COUNT(DISTINCT compra.id_compra) AS total
                        FROM compra
                        INNER JOIN persona AS cliente ON compra.id_cliente = cliente.id_persona AND cliente.id_rol = 4 
                        INNER JOIN persona AS vendedor ON compra.id_vendedor = vendedor.id_persona AND (vendedor.id_rol = 1 OR vendedor.id_rol = 2)
                        INNER JOIN empresa ON compra.id_empresa = empresa.id_empresa
                        INNER JOIN compra_producto ON compra.id_compra = compra_producto.id_compra 
                    $where
                ";

                $result = mysqli_fetch_assoc(mysqli_query($conexion, $sql_registros));
                $total = $result['total'];

                $por_pagina = 10;
                $pagina = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = ceil($total / $por_pagina);


                /* =====================================================
                   CONSULTA PRINCIPAL
                ===================================================== */

                $consulta = "
                    SELECT compra.id_compra,
                           compra.fecha_compra,
                           compra.valor_total,
                           cliente.nombre AS cliente,
                           vendedor.nombre AS vendedor,
                           empresa.nombre AS empresa,
                           compra.id_estado_factura,
                           estado_factura.nombre_estado AS estado
                    FROM compra
                    INNER JOIN persona AS cliente ON compra.id_cliente = cliente.id_persona AND cliente.id_rol = 4
                    INNER JOIN persona AS vendedor ON compra.id_vendedor = vendedor.id_persona AND (vendedor.id_rol = 1 OR vendedor.id_rol = 2)
                    INNER JOIN empresa ON compra.id_empresa = empresa.id_empresa
                    INNER JOIN compra_producto ON compra.id_compra = compra_producto.id_compra 
                    INNER JOIN estado_factura ON compra.id_estado_factura = estado_factura.id_estado
                    $where
                    GROUP BY compra.id_compra
                    ORDER BY id_compra DESC
                    LIMIT $desde, $por_pagina
                ";

                $ejecutar = mysqli_query($conexion, $consulta);

                if (mysqli_num_rows($ejecutar) > 0) {
                    while ($fila = mysqli_fetch_assoc($ejecutar)) {
                        $id_compra = $fila['id_compra'];
                        $fecha = $fila['fecha_compra'];
                        $valor_total = $fila['valor_total'];
                        $cliente = $fila['cliente'];
                        $vendedor = $fila['vendedor'];
                        $empresa = $fila['empresa'];
                        $estado = $fila['estado'];

                        echo "
                        <tr>
                            <td>$id_compra</td>
                            <td>$fecha</td>
                            <td>$cliente</td>
                            <td>$valor_total</td>
                            <td>$vendedor</td>
                            <td>$empresa</td>
                            <td style='color: " . ($estado == 'Anulada' ? "red" : "green") . "; font-weight:bold;'>
                                $estado
                            </td>

                            <td>
                                 <a class='btn-detalles' href='../compra_producto/detalle.php?id=$id_compra' title='detalle'>
                                    Más detalles
                                </a>
                            </td>

                            
                            <td>
                                <a class='btn-accion btn-eliminar'
                                    href='select.php?ANULAR=$id_compra'
                                    title='Anular'
                                    onclick=\"return confirm('¿Desea ANULAR esta factura?');\">
                                    <i class=\"fa-solid fa-ban\"></i>
                                </a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No hay Compras registradas.</td></tr>";
                }
                ?>

            </table>
        </fieldset>
    </form>

    <!-- PAGINACIÓN -->
    <div class="paginador">
        <?php
        echo "<a href='select.php?PAGINA=1' class='link-pagina'>Primera</a>";

        for ($i = 1; $i <= $total_paginas; $i++) {
            $clase = ($i == $pagina) ? "link-activa" : "link-pagina";
            echo "<a href='select.php?PAGINA=$i' class='$clase'>$i</a>";
        }

        echo "<a href='select.php?PAGINA=$total_paginas' class='link-pagina'>Última</a>";
        echo "<br><p class='info_pagina'>Página $pagina de $total_paginas</p>";
        ?>
    </div>

    <!-- ELIMINAR PRODUCTO -->
    <?php
    if (isset($_GET['ANULAR'])) {
        $id = $_GET['ANULAR'];

        $anular = "UPDATE compra SET id_estado_factura = 2 WHERE id_compra = $id";
        if (mysqli_query($conexion, $anular)) {
            echo "<script>alert('Factura ANULADA correctamente'); 
              window.location='select.php';</script>";
        }else{
            echo "<script>alert('Error al anular la factura');</script>";
        }
    }
    ?>

</div>

<?php include('../temp/footer.php'); ?>

</body>
</html>
