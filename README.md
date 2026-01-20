# MG Suministros – Sistema de Gestión

Sistema web desarrollado en PHP para la gestión de un negocio de suministros tecnológicos.
Permite administrar compras, productos, clientes, usuarios y facturación básica mediante
operaciones CRUD y control de acceso por roles.

El proyecto fue desarrollado con fines académicos y como práctica de formación en el SENA.


## Funcionalidades principales

- Autenticación de usuarios
- Control de acceso por roles (Administrador, Vendedor)
- Gestión de personas y roles
- Gestión de productos, categorías y marcas
- Registro de compras y facturación básica
- Anulación de facturas
- Búsqueda y filtrado de información
- Paginación de registros
- Interfaz básica 

## Tecnologías utilizadas

- PHP (procedimental)
- MySQL / MariaDB
- HTML5
- CSS3
- JavaScript básico
- XAMPP (entorno de desarrollo local)

## Requisitos

- PHP 8.x
- MySQL o MariaDB
- Servidor Apache (XAMPP)
- Navegador web moderno

## Instalación y configuración

1. Clonar el repositorio:
   
   git clone https://github.com/mateo-gonzalez-dev/M-SISTEC.git

2. Copiar el proyecto en la carpeta htdocs de XAMPP.

3. Abrir phpMyAdmin e importar el archivo:

    database/mg_suministros.sql

4. Configurar la conexión a la base de datos en:

    config/database.php

5. Iniciar Apache y MySQL desde XAMPP.
6. Acceder al proyecto desde el navegador:

    http://localhost/mg_suministros/index.php




## Accesos de prueba

> Credenciales solo con fines académicos.

**Administrador**
- Usuario: mateog@gmail.com
- Contraseña: 123456

**Vendedor**
- Usuario: maria.rodriguez@empresa.com
- Contraseña: maria20




## Estructura del proyecto

El proyecto está organizado por módulos, donde cada carpeta representa
una entidad del sistema y contiene sus respectivas operaciones CRUD.


MG_SUMINISTROS/
├── index.php              # Página principal pública
├── config/                # Configuración del sistema
│   └── database.php       # Conexión a la base de datos
├── database/              # Base de datos
│   └── mg_suministros.sql
├── login/                 # Autenticación
├── persona/               # Gestión de personas
├── rol/                   # Gestión de roles
├── producto/              # Gestión de productos
├── categoria/             # Categorías de productos
├── marca/                 # Marcas
├── compra/                # Compras
├── compra_producto/       # Detalle de compras
├── empresa/               # Empresas
├── ciudad/
├── departamento/
├── pais/
├── tipo_documento/
├── tipo_identidad/
├── temp/                  # Plantillas (header, footer)
├── CSS/                   # Estilos
└── img/                   # Imágenes


## Notas

- El sistema no realiza integración con la DIAN.
- Proyecto desarrollado sin framework para afianzar fundamentos de PHP y SQL.

## Autor

**Mateo González**  
Practicante de Desarrollo de Software  
SENA