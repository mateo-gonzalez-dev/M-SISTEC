<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <script src="https://kit.fontawesome.com/40fa6fff5b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../CSS/login.css">
</head>



<body>

    <?php require_once('../config/database.php');?>

    <section id="login-SECTION">

        <form id="login" method="POST" action="update.php">

            <div class="titulo-login">
                    <h2>Recuperar Contraseña</h2>
                    <a class="regresar_login" href="login.php">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Regresar</p>
                    </a>   
            </div>

            <div class="contenedor-formulario">
                <div class="texto-inputs">
                    <label>Ingresa tu Correo</label>
                </div>  
                <div class="formulario">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" placeholder="Ingresa tu Email" name="email" class="input" required>
                </div>
            </div>

            <div class="contenedor-formulario">
                <div class="texto-inputs">
                    <label>Nueva Contraseña</label>
                </div>
                <div class="formulario">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" placeholder="Recuerdame" name="nueva_password" class="input" required>
                </div>
            </div>

            <div id="boton" >
                <button name="recuperar">Recuperar</button>
            </div>


        </form>

        <?php

        if(isset($_POST['recuperar'])) {

            $correo = mysqli_real_escape_string($conexion, $_POST['email']);
            $nueva_password = mysqli_real_escape_string($conexion, $_POST['nueva_password']);

            if(!empty($nueva_password)) {
                $verificar = mysqli_query($conexion,"SELECT COUNT(*)AS total FROM persona WHERE correo_electronico = '$correo' ");

                $existe = mysqli_fetch_assoc($verificar);

                if($existe['total']==1){

                    $sql = "UPDATE persona SET contrasena = '$nueva_password'  WHERE correo_electronico = '$correo'";

                    $result = mysqli_query($conexion, $sql) or die (mysqli_error($conexion));

                    echo "<script>alert(' Contraseña actualizada exitosamente.');</script>";
                    echo "<script>window.open('login.php','_self');</script>";

                }else{
                   echo "<script>alert('El correo NO esta registrado.');</script>";
                }
            }else{
                echo "<script>alert('Debes completar todos los campos.');</script>";
            }

        }

        ?>


    </section>

</body>
</html>