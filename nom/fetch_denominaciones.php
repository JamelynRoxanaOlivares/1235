<?php
// Conexión a la base de datos (reemplaza los valores según tu configuración)
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

// Consulta SQL para obtener las denominaciones únicas
$sql = "SELECT DISTINCT leyenda FROM catorcenas";
$result = $conn->query($sql);

$denominaciones = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $denominaciones[] = $row['leyenda'];
    }
}

$conn->close();

// Devolver las denominaciones como una respuesta JSON
echo json_encode($denominaciones);
?>
