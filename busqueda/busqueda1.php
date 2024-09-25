<?php
include "../includes/header.php";
?>

<!-- TÍTULO -->
<h1 class="mt-3">Búsqueda 1</h1>

<p class="mt-3">
    Total recaudado por recepcionista entre fechas f1 y f2 (f2>=f1) a partir de las reservas que ha revisado
    entre esas 2 fechas.
</p>

<!-- FORMULARIO -->
<div class="formulario p-4 m-3 border rounded-3">
    <form action="busqueda1.php" method="post" class="form-group">
        <div class="mb-3">
            <label for="fecha1" class="form-label">Fecha 1</label>
            <input type="date" class="form-control" id="fecha1" name="fecha1" required>
        </div>

        <div class="mb-3">
            <label for="fecha2" class="form-label">Fecha 2</label>
            <input type="date" class="form-control" id="fecha2" name="fecha2" required>
        </div>

        <div class="mb-3">
            <label for="recepcionista_genera" class="form-label">Recepcionista</label>
            <select name="recepcionista_genera" id="recepcionista_genera" class="form-select" onchange="updateGeneradaPor()" required>
                <option value="" selected disabled hidden></option>
                <?php
                require("../empleado/empleado_select.php");
                if ($resultadoEmpleado):
                    foreach ($resultadoEmpleado as $fila):                        
                ?>
                <option value="<?= $fila["id"]; ?>-<?= $fila["tipo_id"]; ?>">
                    <?= $fila["nombre"]; ?> - ID: <?= $fila["id"]; ?>, Tipo ID: <?= $fila["tipo_id"]; ?>
                </option> 
                <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
</div>

<?php
// Verificación para manejar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    // Crear conexión con la BD
    require('../config/conexion.php');

    $fecha1 = $_POST["fecha1"];
    $fecha2 = $_POST["fecha2"];
    $recepcionista = explode('-', $_POST["recepcionista_genera"]); // Dividir el valor en id y tipo_id
    $id_recepcionista = $recepcionista[0];
    $tipo_id_recepcionista = $recepcionista[1];

    // Query SQL para obtener el total recaudado y el nombre de la recepcionista
    $query = "
        SELECT e.nombre, SUM(r.valor_reserva) AS total_recaudado
        FROM reserva r
        JOIN empleado e ON r.revisada_por_id = e.id AND r.revisada_por_tipoid = e.tipo_id
        WHERE r.revisada_por_id = '$id_recepcionista'
        AND r.revisada_por_tipoid = '$tipo_id_recepcionista'
        AND r.fecha_expedicion BETWEEN '$fecha1' AND '$fecha2'
        GROUP BY e.nombre
    ";

    // Ejecutar la consulta
    $resultadoB1 = mysqli_query($conn, $query) or die(mysqli_error($conn));
    mysqli_close($conn);

    // Verificar si llegan datos
    if ($resultadoB1 && $resultadoB1->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Recepcionista</th>
                <th scope="col" class="text-center">Total Recaudado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Iterar sobre los registros que llegaron
            while ($fila = mysqli_fetch_assoc($resultadoB1)):
            ?>
            <tr>
                <td class="text-center"><?= htmlspecialchars($fila["nombre"]); ?></td>
                <td class="text-center"><?= number_format($fila["total_recaudado"], 2); ?> (COP)</td>
            </tr>
            <?php
            endwhile;
            ?>
        </tbody>
    </table>
</div>

<!-- Mensaje de error si no hay resultados -->
<?php
    else:
?>
<div class="alert alert-danger text-center mt-5">
    No se encontraron reservas revisadas por la recepcionista en este rango de fechas.
</div>
<?php
    endif;
endif;

include "../includes/footer.php";
?>
