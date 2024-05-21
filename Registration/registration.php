<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y CRUD de Personal</title>
    <link rel="stylesheet" href="/rcourses/css/registration.css">
    <link rel="stylesheet" href="/Registration/mostrar_personal.php">
</head>
<body>
    <div class="container">
        <div class="left-column">
            <h2>Registro de Personal</h2>
            <form action="/Registration/registrar_personal.php" method="post">
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" required><br>

                <label for="apellidos">Apellidos:</label><br>
                <input type="text" id="apellidos" name="apellidos" required><br>

                <label for="numero_trabajador">Número de Trabajador:</label><br>
                <input type="number" id="numero_trabajador" name="numero_trabajador" required><br>

                <label for="puesto">Puesto:</label><br>
                <select id="puesto" name="puesto" required>
                    <option value="Supervisor de INgieneria ">Supervisor de Ingeniería Electromecánica</option>
                    <option value="Sin determinar">Sin determinar</option>
                </select><br><br>

                <input type="submit" value="Registrar">
            </form>
        </div>
        <div class="right-column">
            <h2>Lista de Personal</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Número de Trabajador</th>
                    <th>Puesto</th>
                </tr>
                <?php include 'mostrar_personal.php'; ?>
            </table>
        </div>
    </div>
</body>
</html>
