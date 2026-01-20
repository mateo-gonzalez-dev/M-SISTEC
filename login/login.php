<?php
session_start();
    require_once('../config/database.php');

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    $consulta = "SELECT * FROM persona 
                WHERE correo_electronico = '$email' 
                AND contrasena = '$password'";

    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) == 1) {

        $usuario = mysqli_fetch_assoc($resultado);

        // Verificar el rol
        if ($usuario['id_rol'] == 1) {
            $_SESSION['admin'] = $email;
            header("Location: ../inicio/inicio.php");
            exit();

        } elseif ($usuario['id_rol'] == 2) {
            $_SESSION['vendedor'] = $email;
            header("Location: ../inicio/inicio.php");
            exit();

        } else {
            $mensaje = "Rol no autorizado.";
        }

    } else {
        $mensaje = "Credenciales incorrectas.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://kit.fontawesome.com/40fa6fff5b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../CSS/login.css">
</head>



<body>

    <header>
        <div class="logo-login">
            <a href="../index.php">
                <img src="../img/header/logoPRO.png" alt="Logo Tienda Virtual">
            </a>
        </div>
    </header>

    <section id="login-SECTION">

            <form id="login" method="POST" action="login.php">

                <div class="contenedor-formulario">

                    <div class="titulo-login">
                        <h2>Ingresar Plataforma</h2>  
                        
                        <a class="regresar_login" href="../index.php">
                            <i class="fa-solid fa-arrow-left"></i>
                            <p>Regresar</p>
                        </a> 
                    </div>

                    

                    <div class="texto-inputs">
                        <label>Email</label>
                    </div>  
                    <div class="formulario">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" placeholder="Ingresa tu Email" name="email" class="input" required>
                    </div>
                </div>

                <div class="contenedor-formulario">
                    <div class="texto-inputs">
                        <label>Contraseña</label>
                    </div>
                    <div class="formulario">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" placeholder="Recuerdame" name="password" class="input" required>
                    </div>
                </div>

                <div id="remember">
                    
                    <a class="span" href="update.php">¿Olvidaste la Contraseña?</a>
                </div>

                <div id="boton">
                    <button>Ingresar</button>
                </div>

                <?php if (!empty($mensaje)) { ?>
                    <p style="color:red; text-align:center;"><?php echo $mensaje; ?></p>
                <?php } ?>

            </form>
    </section>

    <footer> 
        <div id="contenido-FOOTER">
            <article class="artFOOTER">
                <h4><b>Sobre Nosotros</b></h4>
                <p><b>NIT : </b><br>###.###.###</p>
            </article>
            <article id="footerMITAD" class="artFOOTER">
                <h4><b>Email</b></h4>
                <p>mgsuministrostunja0809@gmail.com</p>
            </article>

            <article class="artFOOTER">
                <h4><b>Contacto</b></h4>
                <p><b>Telefono : </b><br>3202684017</p>
            </article>
        </div>
    </footer>
</body>
</html>