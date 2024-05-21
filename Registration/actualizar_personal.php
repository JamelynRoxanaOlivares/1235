<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $numero_trabajador = $_POST['numero_trabajador'];
    $puesto = $_POST['puesto'];

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "catorcena";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para actualizar los datos del registro
    $sql = "UPDATE personal SET nombre='$nombre', apellidos='$apellidos', numero_trabajador='$numero_trabajador', puesto='$puesto' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Registro actualizado exitosamente";
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }

    $conn->close();

    // Redirigir de vuelta a la página principal
    header("Location: registration.php");
    exit();
}
?>
