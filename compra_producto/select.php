<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['vendedor'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once("../config/database.php");

if (!isset($_GET['id'])) {
    die("ERROR: No se recibió el ID de la compra.");
}

$id_compra = intval($_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Compra</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>

<?php include('../temp/header.php'); ?>
<?php include('../temp/contenido.php'); ?>

<div id="contenido">

    <form action="select.php" method="POST" name="select">
        <fieldset>

            <legend id="titulo-form">
                <h2>Detalle de Compra </h2>
            </legend>


    <a href="../compra/select.php" class="btn-filtro">← Regresar</a>

    <table class="tabla_roles">
        <tr>
            <th>ID Producto</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>

        <?php
        $sql = "
            SELECT 
            producto.id_producto,
            CONCAT(
                categoria.tipo_categoria, ' - ',
                producto.referencia, ' - ',
                marca.nombre_marca
            ) AS producto_completo,
            compra_producto.cantidad,
            compra_producto.precio_unitario,

            (compra_producto.cantidad * compra_producto.precio_unitario) AS subtotal
            FROM compra_producto

            INNER JOIN producto 
                ON compra_producto.id_producto = producto.id_producto
            INNER JOIN categoria 
                ON producto.id_categoria = categoria.id_categoria
            INNER JOIN marca 
                ON producto.id_marca = marca.id_marca

            WHERE compra_producto.id_compra = $id_compra

           
        ";

        $result = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($fila = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$fila['id_producto']}</td>
                        <td>{$fila['producto_completo']}</td>
                        <td>{$fila['cantidad']}</td>
                        <td>{$fila['precio_unitario']}</td>
                        <td>{$fila['subtotal']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay productos en esta compra.</td></tr>";
        }
        ?>
    </table>

    </fieldset>
</form>

</div>

<?php include('../temp/footer.php'); ?>

</body>
</html>
