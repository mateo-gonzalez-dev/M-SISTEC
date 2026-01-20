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
        <title>Persona - SELECT</title>
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
                    <p>Filtros</p>
                    <input type="text"  name="buscar"  placeholder="Nombre o documento..." value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>">
                        <a href="select.php?rol=1" class="btn-filtro">Administrador</a>
                        <a href="select.php?rol=2" class="btn-filtro">Vendedor</a>
                        <a href="select.php?rol=3" class="btn-filtro">Proveedor</a>
                        <a href="select.php?rol=4" class="btn-filtro">Cliente</a>
                        <a href="select.php" class="btn-filtro clear">Limpiar Filtros</a>
                    <button type="submit">Buscar</button>
                </div>
            </form>

            <form action="select.php" method="POST" name="select">
                <fieldset>
                    <legend id="titulo-form">
                        <h2>Seleccionar Usuario</h2>
                        <a href="insert.php" id="btn-insertar">
                        <i class="fa-solid fa-user-plus"></i>
                        <p>Añadir Usuario</p>
                        </a>
                    </legend>

                    <table class="tabla_roles">
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo de Identidad</th>
                            <th>Tipo de Documento</th>
                            <th>Numero de Documento</th>
                            <th>Correo Electronico</th>
                            <th>Rol</th>
                            <th>Direccion</th>
                            <th>Ciudad</th>
                            <th>Facturar</th>
                            <th>Actualizar</th>
                            <th>Eliminar</th>
                        </tr>
                    

                    <?php

                    $filtro_rol = "";
                    if (isset($_GET['rol'])) {
                        $rol = intval($_GET['rol']); 
                        $filtro_rol = " WHERE persona.id_rol = $rol ";
                    }

                    $filtro_busqueda = "";
                    if (isset($_GET['buscar']) && $_GET['buscar'] !== "") {
                        $buscar = mysqli_real_escape_string($conexion, $_GET['buscar']);
                        $filtro_busqueda = " AND (persona.nombre LIKE '%$buscar%' 
                                            OR persona.numero_documento LIKE '%$buscar%')";
                    }

                    $where = " WHERE 1 ";
                    if (!empty($filtro_rol)) {
                        $where .= " AND persona.id_rol = $rol";
                    }
                    if (!empty($filtro_busqueda)) {
                        $where .= $filtro_busqueda;
                    }

                    
                    $sql_registros = mysqli_query($conexion,"
                        SELECT COUNT(*) AS total 
                        FROM persona
                        INNER JOIN tipo_identidad ON persona.id_tipo_identidad = tipo_identidad.id_tipo_identidad
                        INNER JOIN tipo_documento ON persona.id_tipo_documento = tipo_documento.id_tipo_documento
                        INNER JOIN rol ON persona.id_rol = rol.id_rol
                        INNER JOIN ciudad ON persona.ciudad = ciudad.id_ciudad
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
                    persona.id_persona,
                    persona.nombre, 
                    tipo_identidad.tipo_identidad AS tipo_identidad, 
                    tipo_documento.tipo_documento AS tipo_documento, 
                    persona.numero_documento, 
                    persona.correo_electronico,
                    persona.id_rol AS id_rol,
                    rol.nombre_rol AS rol,
                    persona.direccion,
                    ciudad.nombre AS ciudad

                    FROM persona
                    INNER JOIN tipo_identidad ON persona.id_tipo_identidad = tipo_identidad.id_tipo_identidad
                    INNER JOIN tipo_documento ON persona.id_tipo_documento = tipo_documento.id_tipo_documento
                    INNER JOIN rol ON persona.id_rol = rol.id_rol
                    INNER JOIN ciudad ON persona.ciudad = ciudad.id_ciudad
                    $where
                    LIMIT $desde,$por_pagina";

                    $ejecutar = mysqli_query($conexion, $consulta);

                    if(mysqli_num_rows($ejecutar)>0){
                        while($fila = mysqli_fetch_assoc($ejecutar)){
                            $id_persona = $fila['id_persona'];
                            $nom = $fila['nombre'];
                            $tipo_identidad = $fila['tipo_identidad'];
                            $tipo_documento = $fila['tipo_documento'];
                            $numero_identificacion = $fila['numero_documento'];
                            $correo = $fila['correo_electronico'];
                            $rol = $fila['rol'];
                            $direccion = $fila['direccion'];
                            $ciudad = $fila['ciudad'];

                            echo "
                        <tr>
                        <td>$nom</td>
                        <td>$tipo_identidad</td>
                        <td>$tipo_documento</td>
                        <td>$numero_identificacion</td>
                        <td>$correo</td>
                        <td>$rol</td>
                        <td>$direccion</td>
                        <td>$ciudad</td>

                       
                            
                        <td>" .
                            (intval($fila['id_rol']) === 4 
                                ? "<a class='btn-detalles' href='../compra_producto/insert.php?id=$id_persona' title='detalle'>Facturar</a>"
                                : "-"
                            )
                        . "</td>

                            
                        <td>
                            <a class='btn-accion btn-actualizar' href='update.php?ACTUALIZAR=$id_persona' title='Actualizar'>
                            <i class='fa-solid fa-pen-to-square'></i>
                            </a>
                        </td>
                        <td>
                            <a class='btn-accion btn-eliminar' href='select.php?ELIMINAR=$id_persona' title='Eliminar' onclick=\"return confirm('¿Desea eliminar este Usuario?');\">
                            <i class='fa-solid fa-trash-can'></i>
                            </a>
                        </td>
                        </tr>
                    ";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay Usuarios registrados.</td></tr>";
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
                $eliminar = "DELETE FROM persona WHERE id_persona = '$borrar_id'";

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