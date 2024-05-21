<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "catorcena";

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$numeroTrabajador = $_POST['numero_trabajador'];
$puesto = $_POST['puesto'];

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Insertar un nuevo registro
$sql = "INSERT INTO personal (nombre, apellidos, numero_trabajador, puesto) VALUES ('$nombre', '$apellidos', '$numeroTrabajador', '$puesto')";

if ($conn->query($sql) === TRUE) {
    header("Location: registration.php"); // Redireccionar a la página principal
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
