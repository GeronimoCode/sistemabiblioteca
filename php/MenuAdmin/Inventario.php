<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventario</title>
  <link rel="stylesheet" href="../../css/inicio.css"><!-- correcto -->
  <link rel="icon" href="../../img/LogoSanLuis.png"><!-- correcto -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<?php
session_start();
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $tipo = $_SESSION['tipo'];

    echo "<script>
        Swal.fire({
            icon: '$tipo',
            title: '$mensaje',
            showConfirmButton: true,
            confirmButtonText: 'Entrar',
            confirmButtonColor: '#3085d6'
        });
    </script>";

    unset($_SESSION['mensaje']);
    unset($_SESSION['tipo']);
}
?>

<header class="header">
  <div class="header-left">
    <img src="../../img/LogoSanLuis.png" class="logo">
  </div>
  <h1 class="titulo">Biblioteca digital S.L.G</h1>
  <div class="header-right">
    <a href="../../index.html" class="Cerrar"><button>Cerrar Sesion</button></a> <!-- corregido -->
    <img src="../../img/logosena.png" alt="Logo SENA" class="logo">
  </div>
</header>

<!-- ! NAV -->
<nav class="navbar">
  <?php 
    if (isset($_SESSION['Nombre'])) {
        echo "<span class='usuario'> 👋 Hola, " . $_SESSION['Nombre'] . "</span>";
    }
  ?>
  <div class="nav-links">
    <a href="../inicio.php"><button class="navbutton">Inicio</button></a> <!-- corregido -->

    <div class="dropdown">
      <button class="navbutton">Menú Administrativo</button>
      <div class="menu-admin">
        <a href="./Inventario.php"><button class="sub-button">Inventario</button></a> <!-- mismo nivel -->
        <a href="./Creargenero.php"><button class="sub-button">Crear Género</button></a>
        <a href="#"><button class="sub-button">Estudiantes</button></a>
      </div>
    </div>

    <div class="dropdown">
      <button class="navbutton">Géneros</button>
      <div class="contenido-generos">
        <a href="../Narrativo.php"><button class="sub-button">Narrativo</button></a>
        <a href="../Naturales.php"><button class="sub-button">Ciencias Naturales</button></a>
        <a href="../Sociales.php"><button class="sub-button">Ciencias Sociales</button></a>
        <a href="../Matematicas.php"><button class="sub-button">Matemática</button></a>
        <a href="../Psicologia.php"><button class="sub-button">Psicología</button></a>
      </div>
    </div>

    <a href="../prestamos.php"><button class="navbutton">Prestamos</button></a>

    <input type="text" placeholder="Buscar..." class="search-bar" />
  </div>
</nav>


<!--//! FORMULARIO CATEGORIAS -->
<section>

  <form>
    <div>

      <input class="input" type="text" name="titulo" placeholder="Título">
      <input class="input" type="text" name="clasificacion" placeholder="Clasificación">
      <input class="input" type="number" name="cantidad" placeholder="Cantidad">
      
    </div>
  </form>

</section>

</body>
</html>
