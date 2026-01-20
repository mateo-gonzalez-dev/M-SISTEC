<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['vendedor'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once("../config/database.php");

if (!isset($_POST['id_cliente'])) {
    die("ERROR: No se recibió cliente.");
}

$id_cliente = intval($_POST['id_cliente']);

if (empty($_SESSION['carrito'])) {
    die("ERROR: No hay productos en la factura.");
}

$fecha = date("Y-m-d");
$total = 0;

// ===============================
// INICIAR TRANSACCIÓN
// ===============================
mysqli_begin_transaction($conexion);

try {

    // 1. Crear factura
    $sqlFactura = "
        INSERT INTO compra (fecha_compra, valor_total, id_cliente, id_vendedor, id_empresa)
        VALUES ('$fecha', 0, $id_cliente, 1, 1)
    ";
    mysqli_query($conexion, $sqlFactura);

    $id_compra = mysqli_insert_id($conexion);

    // 2. Recorrer carrito
    foreach ($_SESSION['carrito'] as $prod) {

        $idp = intval($prod['id_producto']);
        $cant = intval($prod['cantidad']);

        // Obtener info y stock
        $q = mysqli_query($conexion, "
            SELECT precio_venta, stock 
            FROM producto 
            WHERE id_producto = $idp
            FOR UPDATE
        ");

        $data = mysqli_fetch_assoc($q);

        if (!$data) {
            throw new Exception("Producto no encontrado ($idp)");
        }

        $precio = $data['precio_venta'];
        $stock  = $data['stock'];

        if ($stock < $cant) {
            throw new Exception("No hay stock suficiente para el producto ID $idp");
        }

        $subtotal = $precio * $cant;
        $total += $subtotal;

        // INSERTAR detalle
        mysqli_query($conexion, "
            INSERT INTO compra_producto (id_compra, id_producto, cantidad, precio_unitario)
            VALUES ($id_compra, $idp, $cant, $precio)
        ");

        // RESTAR STOCK
        mysqli_query($conexion, "
            UPDATE producto SET stock = stock - $cant
            WHERE id_producto = $idp
        ");
    }

    // 3. Actualizar total de factura
    mysqli_query($conexion, "
        UPDATE compra
        SET valor_total = $total
        WHERE id_compra = $id_compra
    ");

    // 4. Todo bien → commit
    mysqli_commit($conexion);

    // Limpiar carrito
    unset($_SESSION['carrito']);

    echo "<script>alert('Factura generada correctamente');</script>";
    echo "<script>location.href='detalle.php?id=$id_compra';</script>";


    exit();

} catch (Exception $e) {

    // Error → deshacer todo
    mysqli_rollback($conexion);

    echo "<script>alert('ERROR: {$e->getMessage()}');</script>";
    echo "<script>location.href='insert.php?id=$id_cliente';</script>";
    exit();
}

?>
