<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['vendedor'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once("../config/database.php");

// Safety: comprobar conexión
if (!$conexion) {
    die("Error conexión DB: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    die("ERROR: No se recibió el ID de compra (GET id).");
}

$id_compra = intval($_GET['id']);
if ($id_compra <= 0) {
    die("ERROR: ID de compra inválido.");
}

/* ===================================================
   CONSULTA DATOS FACTURA (con comprobación de errores)
   =================================================== */
$sqlFacturaQ = "
    SELECT 
        compra.id_compra,
        compra.fecha_compra,
        compra.valor_total,
        compra.id_estado_factura,
        estado_factura.nombre_estado AS estado,
        persona.nombre AS cliente,
        persona.numero_documento,
        persona.correo_electronico
    FROM compra
    INNER JOIN persona ON compra.id_cliente = persona.id_persona
    INNER JOIN estado_factura ON compra.id_estado_factura = estado_factura.id_estado
    WHERE compra.id_compra = $id_compra
    LIMIT 1
";

$sqlFactura = mysqli_query($conexion, $sqlFacturaQ);
if ($sqlFactura === false) {
    die("Error en consulta factura: " . mysqli_error($conexion) . "\nConsulta: " . $sqlFacturaQ);
}

$factura = mysqli_fetch_assoc($sqlFactura);
if (!$factura) {
    die("No se encontró la compra con id = $id_compra");
}

/* ===================================================
   CONSULTA PRODUCTOS DETALLE (con comprobación)
   =================================================== */
$sqlDetalleQ = "
    SELECT 
        producto.referencia,
        categoria.tipo_categoria,
        marca.nombre_marca,
        compra_producto.cantidad,
        compra_producto.precio_unitario,
        (compra_producto.cantidad * compra_producto.precio_unitario) AS subtotal
    FROM compra_producto
    INNER JOIN producto ON compra_producto.id_producto = producto.id_producto
    INNER JOIN categoria ON producto.id_categoria = categoria.id_categoria
    INNER JOIN marca ON producto.id_marca = marca.id_marca
    WHERE compra_producto.id_compra = $id_compra
";

$sqlDetalle = mysqli_query($conexion, $sqlDetalleQ);
if ($sqlDetalle === false) {
    die("Error en consulta detalle: " . mysqli_error($conexion) . "\nConsulta: " . $sqlDetalleQ);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Factura #<?php echo htmlspecialchars($id_compra); ?></title>
    <link rel="stylesheet" href="../CSS/styles.css">
    
</head>
<body>

<?php include("../temp/header.php"); ?>
<?php include("../temp/contenido.php"); ?>

<div class="box" id="contenido">

  <div class="texto-detalle-factura">
    <div>
      <h2 id="titulo-factura">Detalle de Factura</h2>
      <?php if ($factura['id_estado_factura'] == 2) { ?>
    <div class="sello-anular-factura">
        FACTURA ANULADA
    </div>
<?php } ?>
      <br>
      <p><strong>No. Factura: </strong> <?php echo htmlspecialchars($factura['id_compra']); ?></p>
      <p><strong>Fecha: </strong> <?php echo htmlspecialchars($factura['fecha_compra']); ?></p>
    </div>
    <div class="texto-cliente-factura" >
      <p><strong>Cliente:</strong> <?php echo htmlspecialchars($factura['cliente']); ?></p>
      <p><strong>Documento:</strong> <?php echo htmlspecialchars($factura['numero_documento']); ?></p>
      <p><strong>Correo:</strong> <?php echo htmlspecialchars($factura['correo_electronico']); ?></p>
    </div>
  </div>

  <hr>

  <h4>Productos</h4>

  <fieldset>
  <table class="tabla_roles">
    <tr>
        <th>Categoría</th>
        <th>Marca</th>
        <th>Referencia</th>
        <th>Precio unitario</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
    </tr>

    <?php
    $total_calc = 0;
    while ($item = mysqli_fetch_assoc($sqlDetalle)) {
        // seguridad: fallback si hay campos nulos
        $cantidad = (int)($item['cantidad'] ?? 0);
        $precio_unit = (float)($item['precio_unitario'] ?? 0);
        $subtotal = (float)($item['subtotal'] ?? ($cantidad * $precio_unit));
        $total_calc += $subtotal;
        echo "<tr>
                <td>" . htmlspecialchars($item['tipo_categoria']) . "</td>
                <td>" . htmlspecialchars($item['nombre_marca']) . "</td>
                <td>" . htmlspecialchars($item['referencia']) . "</td>
                <td>" . number_format($precio_unit,2,',','.') . "</td>
                <td>$cantidad</td>
                <td>" . number_format($subtotal,2,',','.') . "</td>
              </tr>";
    }
    ?>

  </table>
    </fieldset>

  <div class="total">
    <!-- mostramos total guardado en DB y el calculado (por si difieren) -->
    <p><strong>Total (guardado):</strong> $<?php echo number_format((float)$factura['valor_total'],2,',','.'); ?></p>
    <br>
    <p><strong>Total (calculado):</strong> $<?php echo number_format($total_calc,2,',','.'); ?></p>
  </div>

  <div style="margin-top:18px; display:flex; gap:12px;">
      <a class="btn-filtro" href="../compra/select.php">Volver a Facturas</a>
  </div>

</div>

<?php include("../temp/footer.php"); ?>

</body>
</html>
