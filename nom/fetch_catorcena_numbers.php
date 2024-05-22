<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "catorcena";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id, numero_catorcena, leyenda FROM catorcenas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["id"] . "'>" . $row["numero_catorcena"] . " - " . $row["leyenda"] . "</option>";
    }
} else {
    echo "<option value=''>No hay catorcenas disponibles</option>";
}

$conn->close();
?>
