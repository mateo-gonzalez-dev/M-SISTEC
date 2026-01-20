<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MG Suministros - Sitio</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">

    <link rel="stylesheet" href="../CSS/styles.css">

    

    <script src="https://kit.fontawesome.com/40fa6fff5b.js" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <div id="divHEADER">
            <input type="checkbox" id="check">

            <!-- Ícono para abrir el menú -->
            <label for="check" class="mostrar-menu">
                <i class="fa-solid fa-bars"></i>
            </label>

            <!-- Menú desplegable -->
            <div class="menu">
                <label for="check" class="esconder-menu">&#215;</label>

                <div class="cajas-HAMBUR">
                    <div class="logos_hambur">
                        <i class="fa-solid fa-qrcode"></i>
                        <p>Información para Productos</p>
                    </div>
                    <button class="botones"><a href="../marca/select.php">Marca</a></button>
                    <button class="botones"><a href="../categoria/select.php">Categoría</a></button>
                </div>
                
                <div class="cajas-HAMBUR">
                    <div class="logos_hambur">
                        <i class="fa-solid fa-person"></i>
                        <p>Información de Persona</p>
                    </div>
                    <button class="botones"><a href="../tipo_documento/select.php">Tipo Documento</a></button>
                    <button class="botones"><a href="../tipo_identidad/select.php">Tipo Identidad</a></button>
                    <button class="botones"><a href="../rol/select.php">Rol</a></button>
                    <button class="botones"><a href="../empresa/select.php">Empresa</a></button>
                </div>

                <div class="cajas-HAMBUR">
                    <div class="logos_hambur">
                        <i class="fa-solid fa-location-dot"></i>
                        <p>Ubicación</p>
                    </div>
                    <button class="botones"><a href="../ciudad/select.php">Ciudad</a></button>
                    <button class="botones"><a href="../departamento/select.php">Departamento</a></button>
                    <button class="botones"><a href="../pais/select.php">País</a></button>
                </div>
            </div>


            
            
            <img src="../img/header/logoPRO.png">

            
             <a class="btnOUT" href="../login/logout.php">
                <i class="fa-solid fa-circle-user"></i>
                <p style="font-size: 15px;">Log Out</p>
            </a>
            
        </div>
    </header>

    <nav>
        <div id="divNAV">
            <div id="listaNAV">
                <p><a href="../inicio/inicio.php"><b>Inicio</b></a></p>
                <p><a href="../compra/select.php"><b>Facturas</b></a></p>
                <p><a href="../producto/select.php"><b>Productos</b></a></p>
                <p><a href="../persona/select.php"><b>Usuarios</b></a></p>
            </div>
        </div>
    </nav>  