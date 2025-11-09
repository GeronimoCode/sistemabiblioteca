<!--//! CODIGO DE EJEMPLO -->

<?php
$conexion = new mysqli("localhost", "root", "", "sistemabiblioteca");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Cambia "consulta" por el mismo name del input en tu formulario
if (isset($_GET['consulta'])) {
    $busqueda = $conexion->real_escape_string($_GET['consulta']);

    $sql = "SELECT * FROM libros 
            WHERE Titulo LIKE '%$busqueda%' 
            OR generos LIKE '%$busqueda%' 
            OR nomautor LIKE '%$busqueda%'";

    $resultado = $conexion->query($sql);

    echo "<link rel='stylesheet' href='../css/inicio.css'>";
    echo "<style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
            }
            .contenedor-resultados {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
                margin-top: 30px;
            }
            .tarjeta-libro {
                width: 180px;
                text-align: center;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                padding: 10px;
                transition: transform 0.2s;
            }
            .tarjeta-libro:hover {
                transform: scale(1.05);
            }
            .tarjeta-libro img {
                width: 100%;
                height: 250px;
                border-radius: 10px;
                object-fit: cover;
            }
            .tarjeta-libro h3 {
                font-size: 16px;
                margin: 10px 0 5px;
            }
            .tarjeta-libro p {
                margin: 0;
                color: #555;
                font-size: 14px;
            }
          </style>";

    echo "<h2 style='text-align:center;'>Resultados para '<span style='color:#007bff;'>$busqueda</span>'</h2>";

    if ($resultado->num_rows > 0) {
        echo "<div class='contenedor-resultados'>";
        while ($fila = $resultado->fetch_assoc()) {
            $titulo = htmlspecialchars($fila['Titulo']);
            $autor = htmlspecialchars($fila['nomautor']);
            $imagen = htmlspecialchars($fila['imglibros']);
            $url = htmlspecialchars($fila['enlace'] ?? "#"); // si tienes un campo PDF o enlace

            echo "
            <div class='tarjeta-libro'>
                <a href='$url' target='_blank'>
                    <img src='$imagen' alt='$titulo'>
                </a>
                <h3>$titulo</h3>
                <p>$autor</p>
            </div>";
        }
        echo "</div>";
    } else {
        echo "<p style='text-align:center; color:red;'>❌ No se encontraron resultados para '<b>$busqueda</b>'.</p>";
    }
}

echo "<div style='text-align:center; margin-top:20px;'>
        <a href='inicio.php' style='text-decoration:none; color:#007bff;'>🔙 Volver al Inicio</a>
      </div>";

$conexion->close();
?>
