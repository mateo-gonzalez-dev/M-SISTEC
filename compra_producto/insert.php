<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['vendedor'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once("../config/database.php");

if (!isset($_GET['id'])) {
    die("ERROR: No se recibió el ID del Usuario.");
}

$id_cliente = intval($_GET['id']);

// =========================================
// LIMPIAR CARRITO EN LA PRIMERA VISITA
// =========================================
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// =========================================
// SI SE PRESIONA "AGREGAR" PRODUCTO
// =========================================
if (isset($_POST['agregar'])) {

    $id_prod = intval($_POST['id_producto']);
    $cant = intval($_POST['cantidad']);

    $_SESSION['carrito'][] = [
        "id_producto" => $id_prod,
        "cantidad" => $cant
    ];

    header("Location: insert.php?id=$id_cliente");
    exit();
}

// =========================================
// CONSULTA CLIENTE
// =========================================
$sqlCliente = "
SELECT id_persona, nombre, numero_documento, correo_electronico
FROM persona
WHERE id_persona = $id_cliente
";
$resCliente = mysqli_query($conexion, $sqlCliente);
$cliente = mysqli_fetch_assoc($resCliente);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Factura</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>

<?php include("../temp/header.php"); ?>
<?php include("../temp/contenido.php"); ?>

<div id="contenido">

<!-- ========================================================= -->
<!-- DATOS DEL CLIENTE -->
<!-- ========================================================= -->
<div class="form-box">
<form id="info_cliente">
<fieldset>
    <legend id="titulo-form">
        <h2>Generar Nueva Factura</h2>
        <a class="btn-filtro" href="../persona/select.php">← Regresar</a>
    </legend>

    <legend id="titulo-form"><h3>- Datos del Cliente -</h3></legend>

    <div class="inputs-formularios">
        <label>ID Usuario:</label>
        <input type="text" value="<?php echo $cliente['id_persona']; ?>" readonly>
    </div>

    <div class="inputs-formularios">
        <label>Nombre:</label>
        <input type="text" value="<?php echo $cliente['nombre']; ?>" readonly>
    </div>

    <div class="inputs-formularios">
        <label>Documento:</label>
        <input type="text" value="<?php echo $cliente['numero_documento']; ?>" readonly>
    </div>

    <div class="inputs-formularios">
        <label>Correo:</label>
        <input type="text" value="<?php echo $cliente['correo_electronico']; ?>" readonly>
    </div>
</fieldset>
</form>
</div>



<!-- ========================================================= -->
<!-- FORMULARIO DE FILTROS (GET) -->
<!-- ========================================================= -->
<form method="GET" action="insert.php#filtros">
    <input type="hidden" name="id" value="<?php echo $id_cliente; ?>">

    <div class="buscador" id="filtros">
        <p>Filtro de Productos</p>

        <input type="text" name="buscar" placeholder="Referencia..."
               value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>">

        <select name="categoria" class="select-formularios-pequeño">
            <option value="">Todas las categorías...</option>
            <?php
            $cats = mysqli_query($conexion, "SELECT * FROM categoria ORDER BY tipo_categoria ASC");
            while ($c = mysqli_fetch_assoc($cats)) {
                $s = (isset($_GET['categoria']) && $_GET['categoria'] == $c['id_categoria']) ? "selected" : "";
                echo "<option value='{$c['id_categoria']}' $s>{$c['tipo_categoria']}</option>";
            }
            ?>
        </select>

        <select name="marca" class="select-formularios-pequeño">
            <option value="">Todas las marcas...</option>
            <?php
            $marcas = mysqli_query($conexion, "SELECT * FROM marca ORDER BY nombre_marca ASC");
            while ($m = mysqli_fetch_assoc($marcas)) {
                $s = (isset($_GET['marca']) && $_GET['marca'] == $m['id_marca']) ? "selected" : "";
                echo "<option value='{$m['id_marca']}' $s>{$m['nombre_marca']}</option>";
            }
            ?>
        </select>

        <button type="submit">Buscar</button>

        <a href="insert.php?id=<?php echo $id_cliente; ?>" class="btn-filtro clear">Limpiar</a>
    </div>
</form>



<!-- ========================================================= -->
<!-- LISTA DE PRODUCTOS DISPONIBLES -->
<!-- ========================================================= -->
 <fieldset>
<table class="tabla_roles">
<tr>
    <th>Categoría</th>
    <th>Marca</th>
    <th>Referencia</th>
    <th>Stock</th>
    <th>Precio</th>
    <th>Cantidad</th>
    <th>Agregar</th>
</tr>



<?php
// Construcción dinámica del WHERE
$where = "WHERE 1";

if (!empty($_GET['buscar'])) {
    $b = mysqli_real_escape_string($conexion, $_GET['buscar']);
    $where .= " AND producto.referencia LIKE '%$b%'";
}
if (!empty($_GET['categoria'])) {
    $cat = intval($_GET['categoria']);
    $where .= " AND producto.id_categoria = $cat";
}
if (!empty($_GET['marca'])) {
    $marca = intval($_GET['marca']);
    $where .= " AND producto.id_marca = $marca";
}

$q = "
SELECT 
    producto.id_producto,
    producto.referencia,
    producto.stock,
    producto.precio_venta,
    categoria.tipo_categoria,
    marca.nombre_marca
FROM producto
INNER JOIN categoria ON producto.id_categoria = categoria.id_categoria
INNER JOIN marca ON producto.id_marca = marca.id_marca
$where
";

$r = mysqli_query($conexion, $q);

while ($p = mysqli_fetch_assoc($r)) {
?>
<tr>
    <td><?php echo $p['tipo_categoria']; ?></td>
    <td><?php echo $p['nombre_marca']; ?></td>
    <td><?php echo $p['referencia']; ?></td>
    <td><?php echo $p['stock']; ?></td>
    <td><?php echo $p['precio_venta']; ?></td>

    <td>
        <!-- FORMULARIO INDIVIDUAL (POST) -->
        <form method="POST" style="display:flex;" action="insert.php?id=<?php echo $id_cliente; ?>#carrito">
            <input type="hidden" name="id_producto" value="<?php echo $p['id_producto']; ?>">
            <input class="input-numeros-factura" type="number" name="cantidad" min="1" max="<?php echo $p['stock']; ?>" required>
    </td>
    <td>
            <button class="agregar-producto-factura" name="agregar">Agregar</button>
        </form>
    </td>

</tr>
<?php } ?>
</table>
</fieldset>



<!-- ========================================================= -->
<!-- PRODUCTOS AÑADIDOS (CARRITO) -->
<!-- ========================================================= -->

<h3 id="separador-factura">- Productos Añadidos -</h3>

<fieldset>
<table class="tabla_roles" id="carrito">
<tr>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Precio Unitario</th>
    <th>Subtotal</th>
    <th>Eliminar</th>
</tr>

<?php
foreach ($_SESSION['carrito'] as $i => $prodTemp) {

    $idp = $prodTemp['id_producto'];
    $cantidad = $prodTemp['cantidad'];

    $info = mysqli_fetch_assoc(mysqli_query($conexion,
        "SELECT 
            CONCAT(
                categoria.tipo_categoria, ' - ',
                producto.referencia, ' - ',
                marca.nombre_marca
            ) AS producto_completo,
            producto.precio_venta AS precio_unitario
        FROM producto
        INNER JOIN categoria ON producto.id_categoria = categoria.id_categoria
        INNER JOIN marca ON producto.id_marca = marca.id_marca
        WHERE producto.id_producto = $idp"
    ));

    $subtotal = $cantidad * $info['precio_unitario'];

    echo "
    <tr>
        <td>{$info['producto_completo']}</td>
        <td>$cantidad</td>
        <td>{$info['precio_unitario']}</td>
        <td>$subtotal</td>
        <td><a class='btn-eliminar-factura' href='quitar.php?i=$i&id=$id_cliente#carrito'>X</a></td>
    </tr>";
}
?>
</table>
</fieldset>



<!-- ========================================================= -->
<!-- FINALIZAR FACTURA -->
<!-- ========================================================= -->

<?php if (!empty($_SESSION['carrito'])) { ?>
<form id="form-boton-finalizar-factura" action="finalizar.php" method="POST">
    <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
    <button class="btn-filtro" type="submit">Finalizar Factura</button>
</form>
<?php } ?>


</div>

<?php include("../temp/footer.php"); ?>
</body>
</html>
