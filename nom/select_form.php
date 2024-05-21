<form id="searchForm" method="post" action="generate_pdf.php">
    <label for="selectName">Seleccionar Nombre:</label><br>
    <select id="selectName" name="selectName" required onchange="fetchDetails(this.value)">
        <option value="">Seleccione un nombre</option>
        <?php include 'fetch_options.php'; ?>
    </select>
    <div id="details">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" readonly><br>

        <label for="apellidos">Apellidos:</label><br>
        <input type="text" id="apellidos" name="apellidos" readonly><br>

        <label for="numero_trabajador">Número de Trabajador:</label><br>
        <input type="text" id="numero_trabajador" name="numero_trabajador" readonly><br>

        <label for="puesto">Puesto:</label><br>
        <input type="text" id="puesto" name="puesto" readonly><br><br>

        <input type="submit" value="Generar PDF">
    </div>
</form>
