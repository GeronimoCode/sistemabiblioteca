<!--//! CODIGO DE EJEMPLO -->

<?php
if (isset($_GET['q'])) {
    $busqueda = $_GET['q'];

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "biblioteca");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Buscar libros en la tabla (ejemplo: 'libros')
    $sql = "SELECT * FROM libros WHERE titulo LIKE '%$busqueda%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Resultados de: $busqueda</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<p>" . $row["titulo"] . " - " . $row["clasificacion"] . "</p>";
        }
    } else {
        echo "No se encontraron resultados.";
    }

    $conn->close();
}
?>
