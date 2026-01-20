<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['vendedor'])) {
    header("Location: ../login/login.php");
    exit();
}

if (!isset($_GET['i']) || !isset($_GET['id'])) {
    die("ERROR: Datos incompletos");
}

$index = $_GET['i']; 
$id_cliente = intval($_GET['id']);

unset($_SESSION['carrito'][$index]);

// Reindexar el array para evitar errores
$_SESSION['carrito'] = array_values($_SESSION['carrito']);

header("Location: insert.php?id=$id_cliente");
exit();
?>
