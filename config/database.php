<?php
$usuario ="root";
$contrasena = "";
$servidor = "localhost";
$base = "mg_suministros";

$conexion = mysqli_connect($servidor,$usuario, $contrasena) 
    or die("Error de Conexion");

$db = mysqli_select_db($conexion, $base) 
    or die("Error de Base de Datos");