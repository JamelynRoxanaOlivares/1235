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

$id = intval($_GET['id']);
$sql = "SELECT numero_catorcena, leyenda, inicio_catorcena, termino_catorcena FROM catorcenas WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
    <tr>
    <th>No Catorcena</th>
    <th>Denominación</th>
    <th>Periodo</th>
    </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["numero_catorcena"] . "</td>";
        echo "<td>" . $row["leyenda"] . "</td>";
        $inicio = date("d F Y", strtotime($row["inicio_catorcena"]));
        $termino = date("d F Y", strtotime($row["termino_catorcena"]));
        echo "<td>" . $inicio . " al " . $termino . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados";
}

$conn->close();
?>
