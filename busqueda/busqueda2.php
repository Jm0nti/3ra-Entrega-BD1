<?php
include "../includes/header.php";
?>

<!-- TÍTULO -->
<h1 class="mt-3">Búsqueda 2</h1>

<p class="mt-3">
    Reservas revisadas por la recepcionista de mayor salario adscrita a un hotel determinado.
</p>

<!-- FORMULARIO -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="busqueda2.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="hotel_trabaja" class="form-label">Hotel</label>
            <select name="hotel_trabaja" id="hotel_trabaja" class="form-select" required>
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../hotel/hotel_select.php");
                
                // Verificar si llegan datos
                if ($resultadoHotel):
                    foreach ($resultadoHotel as $fila):
                ?>
                <option value="<?= $fila["nit"]; ?>"><?= $fila["nombre"]; ?> - NIT: <?= $fila["nit"]; ?></option>
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
// Dado que el action apunta a este mismo archivo, hacer esta verificación antes
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

    // Crear conexión con la BD
    require('../config/conexion.php');

    // Obtener el NIT del hotel seleccionado
    $nit_hotel = $_POST["hotel_trabaja"];

    // 1. Obtener el empleado con el mayor salario en el hotel seleccionado
    $queryEmpleado = "
        SELECT id, tipo_id, nombre
        FROM empleado
        WHERE hotel_trabaja = '$nit_hotel'
        ORDER BY salario DESC, nombre ASC
        LIMIT 1
    ";

    $resultadoEmpleado = mysqli_query($conn, $queryEmpleado) or die(mysqli_error($conn));

    // 2. Verificar si hay un empleado
    if ($resultadoEmpleado && $resultadoEmpleado->num_rows > 0):
        $empleado = mysqli_fetch_assoc($resultadoEmpleado);
        $id_empleado = $empleado['id'];
        $tipo_id_empleado = $empleado['tipo_id'];

        // 3. Obtener las reservas generadas por el empleado
        $queryReservas = "
            SELECT codigo, fecha_inicio, fecha_fin, fecha_expedicion, num_personas, estado_reserva, valor_reserva
            FROM reserva
            WHERE revisada_por_id = '$id_empleado'
            AND revisada_por_tipoid = '$tipo_id_empleado'
        ";

        $resultadoReservas = mysqli_query($conn, $queryReservas) or die(mysqli_error($conn));
    endif;

    mysqli_close($conn);

    // Verificar si hay reservas
    if ($resultadoReservas && $resultadoReservas->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Código</th>
                <th scope="col" class="text-center">Fecha Inicio</th>
                <th scope="col" class="text-center">Fecha Fin</th>
                <th scope="col" class="text-center">Fecha Expedición</th>
                <th scope="col" class="text-center">Num Personas</th>
                <th scope="col" class="text-center">Estado Reserva</th>
                <th scope="col" class="text-center">Valor Reserva</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Iterar sobre las reservas
            while ($fila = mysqli_fetch_assoc($resultadoReservas)):
            ?>
            <tr>
                <td class="text-center"><?= $fila["codigo"]; ?></td>
                <td class="text-center"><?= $fila["fecha_inicio"]; ?></td>
                <td class="text-center"><?= $fila["fecha_fin"]; ?></td>
                <td class="text-center"><?= $fila["fecha_expedicion"]; ?></td>
                <td class="text-center"><?= $fila["num_personas"]; ?></td>
                <td class="text-center"><?= $fila["estado_reserva"]; ?></td>
                <td class="text-center"><?= number_format($fila["valor_reserva"], 2); ?> (COP)</td>
            </tr>
            <?php
            endwhile;
            ?>
        </tbody>
    </table>
</div>

<!-- Mensaje de error si no hay reservas -->
<?php
    else:
?>
<div class="alert alert-danger text-center mt-5">
    No se encontraron reservas revisadas por la recepcionista de mayor salario en este hotel.
</div>
<?php
    endif; // Fin de la verificación de reservas
endif; // Fin de la verificación del método POST

include "../includes/footer.php";
?>