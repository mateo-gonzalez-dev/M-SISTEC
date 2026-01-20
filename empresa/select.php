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
    <title>Empresa - SELECT</title>
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
        <form action="select.php" method="POST" name="select">
            <fieldset>
                <legend id="titulo-form">
                    <h2>Seleccionar Empresa</h2>
                    <a href="insert.php" id="btn-insertar">
                      <i class="fa-solid fa-user-plus"></i>
                      <p>Añadir Empresa</p>
                    </a>
                </legend>

                <table class="tabla_roles">
                    <tr>
                        <th>Id Empresa</th>
                        <th>Nombre</th>
                        <th>Tipo de Identidad</th>
                        <th>Tipo de Documento</th>
                        <th>Numero de Identificacion</th>
                        <th>Direccion</th>
                        <th>Ciudad</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                

                <?php
                $sql_registros = mysqli_query($conexion,'SELECT COUNT(*) AS total FROM empresa');

                $result_registros = mysqli_fetch_array($sql_registros);

                $total = $result_registros['total'];

                $por_pagina = 5;
                $pagina = empty($_GET['PAGINA'])?1:$_GET['PAGINA'];

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = ceil($total / $por_pagina);

                $consulta = "
                SELECT empresa.id_empresa, empresa.nombre, tipo_identidad.tipo_identidad AS tipo_identidad, tipo_documento.tipo_documento AS tipo_documento, empresa.numero_identificacion, empresa.direccion, ciudad.nombre AS ciudad
                FROM empresa
                INNER JOIN tipo_identidad ON empresa.id_tipo_identidad = tipo_identidad.id_tipo_identidad
                INNER JOIN tipo_documento ON empresa.id_tipo_documento = tipo_documento.id_tipo_documento
                INNER JOIN ciudad ON empresa.id_ciudad = ciudad.id_ciudad
                LIMIT $desde,$por_pagina";

                $ejecutar = mysqli_query($conexion, $consulta);

                if(mysqli_num_rows($ejecutar)>0){
                    while($fila = mysqli_fetch_assoc($ejecutar)){
                        $id_empresa = $fila['id_empresa'];
                        $nom = $fila['nombre'];
                        $tipo_identidad = $fila['tipo_identidad'];
                        $tipo_documento = $fila['tipo_documento'];
                        $numero_identificacion = $fila['numero_identificacion'];
                        $direccion = $fila['direccion'];
                        $ciudad = $fila['ciudad'];

                        echo "
                    <tr>
                      <td>$id_empresa</td>
                      <td>$nom</td>
                      <td>$tipo_identidad</td>
                      <td>$tipo_documento</td>
                      <td>$numero_identificacion</td>
                      <td>$direccion</td>
                      <td>$ciudad</td>
                        
                      <td>
                        <a class='btn-accion btn-actualizar' href='update.php?ACTUALIZAR=$id_empresa' title='Actualizar'>
                          <i class='fa-solid fa-pen-to-square'></i>
                        </a>
                      </td>
                      <td>
                        <a class='btn-accion btn-eliminar' href='select.php?ELIMINAR=$id_empresa' title='Eliminar' onclick=\"return confirm('¿Desea eliminar este rol?');\">
                          <i class='fa-solid fa-trash-can'></i>
                        </a>
                      </td>
                    </tr>
                  ";
                }
              } else {
                echo "<tr><td colspan='4'>No hay Empresas registradas.</td></tr>";
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
            $eliminar = "DELETE FROM empresa WHERE id_empresa = '$borrar_id'";

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