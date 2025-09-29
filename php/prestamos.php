<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página principal</title>
  <link rel="stylesheet" href="../css/inicio.css">
  <link rel="icon" href="../img/LogoSanLuis.png">
  <!-- SweetAlert2 -->
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
      <img src="../img/LogoSanLuis.png" class="logo">
    </div>
    <h1 class="titulo">Biblioteca digital S.L.G</h1>
    <div class="header-right">
      <a href="../index.html" class="Cerrar"><button>Cerrar Sesion</button></a>
      <img src="../img/logosena.png" alt="Logo SENA" class="logo">

    </div>
  </header>
  
 <!-- //! NAV -->
  <nav class="navbar">

    <?php 
          // 👇 Mostrar el nombre del usuario si existe
          if (isset($_SESSION['Nombre'])) {
              echo "<span class='usuario'> 👋 Hola, " . $_SESSION['Nombre'] . "</span>";
          }
        ?>


   <div class="nav-links">
    <a href="../php/inicio.php"><button class="navbutton">Inicio</button></a>

    <div class="dropdown">
      <button class="navbutton">Menú Administrativo</button>
      <div class="menu-admin">
       <a href="../php/MenuAdmin/Inventario.php"> <button class="sub-button">Inventario</button></a>
       <a href="../php/Creargenero.php"><button class="sub-button">Crear Género</button></a>
       <a href="../php/MenuAdmin/Registrolibros.php"><button class="sub-button">Registro de libros</button></a>
       <a href=""><button class="sub-button">Estudiantes</button></a>
      </div>
    </div>

    <!-- //! Dropdown de géneros -->
    <div class="dropdown">

      <button class="navbutton">Géneros</button>
      <div class="contenido-generos">
       <a href="../php/Narrativo.php"> <button class="sub-button">Narrativo</button></a>
       <a href="../php/Naturales.php"><button class="sub-button">Ciencias Naturales</button></a>
       <a href="../php/Sociales.php"><button class="sub-button">Ciencias Sociales</button></a>
       <a href="../php/Matematicas.php"><button class="sub-button">Matemática</button></a> 
       <a href="../php/Psicologia.php"><button class="sub-button">Psicología</button></a>

      </div>

    </div>

    <a href="#libro"><button class="navbutton">Libros</button></a>
    <a href="../php/prestamos.php"><button class="navbutton">Prestamos</button></a>


    <!--//! BUSCADOR -->
     <div class="nav-links">
      <nav class="navbar">

       <form action="../php/buscar.php" method="GET">
         <input type="text" name="q" placeholder="Buscar..." class="search-bar" />
         <button type="submit">🔍</button>

        </form>

     </nav>
    </div>


    <br>


  </nav>

  <div>
    <script>
    // IDs REQUERIDOS:
    // - toggleSearchBtn (botón)
    // - searchDrawer (cajón desplegable)
    // - searchInput (barra de búsqueda)

    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggleSearchBtn');
        const searchDrawer = document.getElementById('searchDrawer');
        const searchInput = document.getElementById('searchInput');

        // Función toggle para mostrar/ocultar el cajón
        toggleBtn.addEventListener('click', function() {
            if (searchDrawer.style.display === 'block') {
                // Ocultar el cajón
                searchDrawer.style.display = 'none';
            } else {
                // Mostrar el cajón con animación
                searchDrawer.style.display = 'block';
                searchDrawer.classList.add('slide-down');
                
                // Enfocar la barra de búsqueda automáticamente
                setTimeout(() => {
                    searchInput.focus();
                }, 100);
            }
        });

        // Cerrar el cajón si se hace clic fuera de él
        document.addEventListener('click', function(event) {
            if (!searchDrawer.contains(event.target) && 
                event.target !== toggleBtn && 
                !toggleBtn.contains(event.target)) {
                searchDrawer.style.display = 'none';
            }
        });

        // Prevenir que el clic dentro del cajón lo cierre
        searchDrawer.addEventListener('click', function(event) {
            event.stopPropagation();
        });

        // Función de búsqueda (ejemplo)
        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                alert('Buscando: ' + this.value);
                // Aquí puedes agregar tu lógica de búsqueda
            }
        });
    });
</script>
  </div>

</body>
</html>