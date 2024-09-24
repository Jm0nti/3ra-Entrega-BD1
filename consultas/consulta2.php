<?php
include "../includes/header.php";
?>

<h1 class="mt-3">Consulta 2</h1>

<p class="mt-3">
    El segundo botón debe mostrar el código y el nombre de los tres hoteles que mayor dinero han recaudado a raíz de las reservas que han generado sus correspondientes recepcionistas.
</p>

<?php
// Crear conexión con la BD
require('../config/conexion.php');

// Query SQL para mostrar los tres hoteles que más dinero han recaudado
$query = "
    SELECT h.nit, h.nombre, SUM(r.valor_reserva) AS total_recaudado
    FROM hotel h
    JOIN empleado e ON h.nit = e.hotel_trabaja
    JOIN reserva r ON e.id = r.generada_por_id AND e.tipo_id = r.generada_por_tipoid
    WHERE e.entrada IS NOT NULL -- Solo recepcionistas
    GROUP BY h.nit, h.nombre
    ORDER BY total_recaudado DESC, h.nombre ASC
    LIMIT 3
";


// Ejecutar la consulta
$resultadoC2 = mysqli_query($conn, $query) or die(mysqli_error($conn));

mysqli_close($conn);
?>

<?php
// Verificar si llegan datos
if($resultadoC2 and $resultadoC2->num_rows > 0):
?>

<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Código del Hotel (NIT)</th>
                <th scope="col" class="text-center">Nombre del Hotel</th>
                <th scope="col" class="text-center">Total Recaudado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultadoC2 as $fila): ?>
            <tr>
                <td class="text-center"><?= $fila["nit"]; ?></td>
                <td class="text-center"><?= $fila["nombre"]; ?></td>
                <td class="text-center"><?= $fila["total_recaudado"]; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php else: ?>
<div class="alert alert-danger text-center mt-5">
    No se encontraron resultados para esta consulta
</div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>
