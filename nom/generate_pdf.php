<?php
require_once('../tcpdf/tcpdf.php');

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "catorcena";

// Obtener el número de trabajador del formulario
$numero_trabajador = $_POST['numero_trabajador'] ?? '';

// Crear una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los datos del personal de la base de datos
$sql_personal = "SELECT nombre, apellidos, numero_trabajador, puesto FROM personal WHERE numero_trabajador = ?";
$stmt_personal = $conn->prepare($sql_personal);
$stmt_personal->bind_param("s", $numero_trabajador);
$stmt_personal->execute();
$result_personal = $stmt_personal->get_result();

if ($result_personal->num_rows > 0) {
    $row_personal = $result_personal->fetch_assoc();
    $nombre = $row_personal['nombre'];
    $apellidos = $row_personal['apellidos'];
    $numero_trabajador = $row_personal['numero_trabajador'];
    $puesto = $row_personal['puesto'];
} else {
    die("No se encontraron datos para el número de trabajador especificado.");
}

// Consultar la imagen de encabezado de la base de datos
$sql_image = "SELECT image_path FROM images WHERE category = 'encabezado'";
$result_image = $conn->query($sql_image);

// Ruta de la imagen predeterminada si no se encuentra ninguna imagen de encabezado en la base de datos
$imagePath = '../Simbolos/uploads/default_image.png';

if ($result_image->num_rows > 0) {
    $row_image = $result_image->fetch_assoc();
    $imagePath = '../Simbolos/' . $row_image['image_path'];
}

// Verificar la ruta de la imagen
if (!file_exists($imagePath)) {
    die("La imagen no existe en la ruta especificada: " . $imagePath);
}

// Crear una instancia de TCPDF
$pdf = new TCPDF();

// Establecer la información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre del Autor');
$pdf->SetTitle('Registro de Personal');
$pdf->SetSubject('Detalles del Personal');
$pdf->SetKeywords('TCPDF, PDF, personal, registro');

// Agregar una página
$pdf->AddPage();

// Establecer el margen izquierdo
$pdf->SetLeftMargin(10);

// Añadir la imagen al PDF
if (file_exists($imagePath)) {
    $pdf->Image($imagePath, 10, 10, 45); // Ajusta las coordenadas y el tamaño según sea necesario
}

// Agregar el título
$pdf->SetY(10);
$pdf->SetFont('helvetica', '', 18);
$pdf->Cell(180, 10, 'Aeropuerto Internacional ', 0, 1, 'C');
$pdf->Cell(175, 10, ' "Felipe Ángeles" S.A. de C.V.', 0, 1, 'C');

// Agregar la información de la Subdirección de Recursos Humanos en el lado derecho
$pdf->SetY(10);
$pdf->SetFont('helvetica', '', 10);
$pdf->SetX(-80);
$pdf->Cell(70, 5, 'Subdirección General Administrativa', 0, 1, 'R');
$pdf->SetX(-80);
$pdf->Cell(70, 5, 'Dirección de Administración', 0, 1, 'R');
$pdf->SetX(-80);
$pdf->Cell(70, 5, 'Subdirección de Recursos Humanos', 0, 1, 'R');
$pdf->SetX(-80);
$pdf->Cell(70, 5, 'Coordinación de Nóminas', 0, 1, 'R');

// Añadir un salto de línea para separar el encabezado del contenido
$pdf->Ln(20);

// Agregar la información de Dirección, Subdirección y Gerencia con etiquetas en negrita
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 5, 'Dirección:', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(120, 5, 'Dirección de Operación.', 0, 1, 'C');

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 5, 'Subdirección:', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(120, 5, 'Subdirección de Ingeniería.', 0, 1, 'C');

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 5, 'Gerencia:', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(120, 5, 'Gerencia de Ingeniería Electromecánica', 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 12); // Establecer la fuente en negrita
$pdf->Cell(205, 10, 'TARJETA DE ASISTENCIA CATORCENAL', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12); // Restaurar la fuente normal

// Añadir otro salto de línea antes de los detalles del personal
$pdf->Ln(10);

// Agregar la información del personal
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(60, 7, 'Nombre del trabajador:', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 12);
$pdf->MultiCell(0, 7, htmlspecialchars($nombre . ' ' . $apellidos, ENT_QUOTES, 'UTF-8'), 0, 'L');

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(60, 7, 'Número de Trabajador:', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 12);
$pdf->MultiCell(0, 7, htmlspecialchars($numero_trabajador, ENT_QUOTES, 'UTF-8'), 0, 'L');

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(60, 7, 'Puesto:', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 12);
$pdf->MultiCell(0, 7, htmlspecialchars($puesto, ENT_QUOTES, 'UTF-8'), 0, 'L');

// Añadir un salto de línea antes de la tabla de asistencia
$pdf->Ln(10);

// Añadir la tabla de asistencia
// Configurar los márgenes. Supongamos que el ancho de la página es el estándar de 210mm para un A4
$anchoTotal = 8 + 28 + 35 + 35 + 35 + 35; // Este es el ancho total de tu tabla sumando el ancho de todas las celdas
$margenIzquierdo = (210 - $anchoTotal) / 2; // Calculamos el margen izquierdo para centrar la tabla

$pdf->SetFont('helvetica', 'B', 9);

// Ajustar la posición X para centrar la tabla
$pdf->SetX($margenIzquierdo);

// Encabezados de tabla
$pdf->Cell(8, 7, '', 1, 0, 'C');
$pdf->Cell(28, 7, 'A', 1, 0, 'C');
$pdf->Cell(35, 7, 'B', 1, 0, 'C');
$pdf->Cell(35, 7, 'C', 1, 0, 'C');
$pdf->Cell(35, 7, 'D', 1, 0, 'C');
$pdf->Cell(35, 7, 'E', 1, 1, 'C');

// Ajustar la posición X para cada fila de la tabla
$pdf->SetFont('helvetica', 'B', 9); // Fuente para el encabezado de la tabla
$pdf->SetX($margenIzquierdo);
$pdf->Cell(8, 7, '#', 1, 0, 'C');
$pdf->Cell(28, 7, 'Fecha', 1, 0, 'C');
$pdf->Cell(35, 7, 'Hora Entrada', 1, 0, 'C');
$pdf->Cell(35, 7, 'Firma Entrada', 1, 0, 'C');
$pdf->Cell(35, 7, 'Hora Salida', 1, 0, 'C');
$pdf->Cell(35, 7, 'Firma Salida', 1, 1, 'C');

// Obtener la fecha actual
$fecha_actual = date("Y-m-d");

// Consultar la catorcena actual basada en la fecha actual
$sql_catorcena_actual = "SELECT inicio_catorcena, termino_catorcena FROM catorcenas WHERE inicio_catorcena <= '$fecha_actual' AND termino_catorcena >= '$fecha_actual'";
$result_catorcena_actual = $conn->query($sql_catorcena_actual);

// Verificar si se encontraron datos de la catorcena actual
if ($result_catorcena_actual->num_rows > 0) {
    // Obtener los datos de inicio y término de la catorcena actual
    $row_catorcena_actual = $result_catorcena_actual->fetch_assoc();
    $inicio_catorcena_actual = $row_catorcena_actual['inicio_catorcena'];
    $termino_catorcena_actual = $row_catorcena_actual['termino_catorcena'];
} else {
    // Si no se encontraron datos de la catorcena actual, puedes manejarlo según sea necesario
    $inicio_catorcena_actual = "Fecha de inicio no disponible";
    $termino_catorcena_actual = "Fecha de término no disponible";
}

// Luego, en tu bucle for para la tabla de asistencia, puedes usar las variables $inicio_catorcena_actual y $termino_catorcena_actual
for ($i = 1; $i <= 14; $i++) {
    $pdf->SetX($margenIzquierdo); // Establecer el margen izquierdo calculado antes de cada fila
    $pdf->Cell(8, 6, $i, 1, 0, 'C');
    $pdf->Cell(28, 6, $inicio_catorcena_actual . ' al ' . $termino_catorcena_actual, 1, 0, 'C'); // Mostrar el periodo de la catorcena actual
    $pdf->Cell(35, 6, '', 1, 0, 'C'); // Hora de entrada vacía
    $pdf->Cell(35, 6, '', 1, 0, 'C'); // Firma de entrada vacía
    $pdf->Cell(35, 6, '', 1, 0, 'C'); // Hora de salida vacía
    $pdf->Cell(35, 6, '', 1, 1, 'C'); // Firma de salida vacía
}


// Cerrar la conexión a la base de datos
$conn->close();

// Generar el PDF
$pdf->Output('registro_personal.pdf', 'I');
?>
