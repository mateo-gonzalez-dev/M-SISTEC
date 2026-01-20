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
    <title>Categoria - INSERT</title>
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

    <div id="contenido">
        <form action="insert.php" method="POST" name="insert">
            <fieldset>
                <legend id="titulo-form">
                    <h2>Insertar Categoria</h2>
                    <a href="select.php" id="btn-insertar">
                      <i class="fa-solid fa-arrow-left"></i>
                      <p>Regresar</p>
                    </a>
                </legend>
                <div class="inputs-formularios">
                    <label> Nombre de Categoria</label>
                    <input type="text" name="txtnombre"required>
                </div>
                
                <div class="input-guardar-fomrularios">
                    <input type="submit" value="Guardar" name="enviar">
                </div>
            </fieldset>
        </form>

        <?php

        if(isset($_POST['enviar'])) {
            $nom = $_POST['txtnombre'];
            if(!empty($nom)) {
                $verificar = mysqli_query($conexion,"SELECT COUNT(*)AS total FROM categoria WHERE tipo_categoria='$nom'");

                $existe = mysqli_fetch_assoc($verificar);

                if($existe['total']>0){
                    echo "<script>alert(' Esa categoria ya existe en la base de datos.');</script>";
                }else{
                    $sql = "INSERT INTO categoria (tipo_categoria) VALUES ('$nom')";

                    $result = mysqli_query($conexion, $sql) or die (mysqli_error($conexion));

                    echo "<script>alert('✅ Categoria registrada exitosamente.');</script>";
                    echo "<script>window.open('select.php','_self');</script>";
                }
            }else{
                echo "<script>alert('Por favor, ingrese un nombre válido.');</script>";
            }

        }

        ?>



    </div>

    </div>

    <?php include('../temp/footer.php');?>
</body>
</html>