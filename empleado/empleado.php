<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiado para reflejar la analogía con el empleado -->
<h1 class="mt-3">Entidad EMPLEADO (Análoga a MECÁNICO)</h1>

<!-- FORMULARIO para agregar un empleado -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="empleado_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input type="number" class="form-control" id="id" name="id" required>
        </div>

        <!-- Seleccionable para Tipo ID -->
        <div class="mb-3">
            <label for="tipo_id" class="form-label">Tipo ID</label>
            <select class="form-select" id="tipo_id" name="tipo_id" required>
                <option value="CC">Cédula de Ciudadanía (CC)</option>
                <option value="EX">Extranjero (EX)</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="number" class="form-control" id="telefono" name="telefono" required>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>

        <div class="mb-3">
            <label for="salario" class="form-label">Salario</label>
            <input type="number" class="form-control" id="salario" name="salario" required>
        </div>

        <!-- Seleccionable para entrada (Principal/Secundaria) -->
        <div class="mb-3">
            <label for="entrada" class="form-label">Entrada</label>
            <select class="form-select" id="entrada" name="entrada" required>
                <option value="Principal">Principal</option>
                <option value="Secundaria">Secundaria</option>
            </select>
        </div>

        <!-- Seleccionable para el hotel en el que trabaja -->
        <div class="mb-3">
            <label for="hotel_trabaja" class="form-label">Hotel Trabaja</label>
            <select name="hotel_trabaja" id="hotel_trabaja" class="form-select" required>
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../hotel/hotel_select.php");
                
                // Verificar si llegan datos
                if ($resultadoHotel):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoHotel as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["nit"]; ?>"><?= $fila["nombre"]; ?> - NIT: <?= $fila["nit"]; ?></option>

                <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>        

        <button type="submit" class="btn btn-primary">Agregar</button>

    </form>
    
</div>

<?php
// Importar el código del otro archivo
require("empleado_select.php");

// Verificar si llegan datos
if ($resultadoEmpleado and $resultadoEmpleado->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">ID</th>
                <th scope="col" class="text-center">Tipo ID</th>
                <th scope="col" class="text-center">Nombre</th>
                <th scope="col" class="text-center">Teléfono</th>
                <th scope="col" class="text-center">Correo</th>
                <th scope="col" class="text-center">Salario</th>
                <th scope="col" class="text-center">Entrada</th>
                <th scope="col" class="text-center">Hotel Trabaja</th>
                <th scope="col" class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoEmpleado as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["id"]; ?></td>
                <td class="text-center"><?= $fila["tipo_id"]; ?></td>
                <td class="text-center"><?= $fila["nombre"]; ?></td>
                <td class="text-center"><?= $fila["telefono"]; ?></td>
                <td class="text-center"><?= $fila["correo"]; ?></td>
                <td class="text-center"><?= $fila["salario"]; ?></td>
                <td class="text-center"><?= $fila["entrada"]; ?></td>
                <td class="text-center"><?= $fila["hotel_trabaja"]; ?></td>
                
                <!-- Botón de eliminar. Debe incluir la ID y tipo ID del empleado para identificarlo -->
                <td class="text-center">
                    <form action="empleado_delete.php" method="post">
                        <input hidden type="text" name="idEliminar" value="<?= $fila["id"]; ?>">
                        <input hidden type="text" name="tipoIdEliminar" value="<?= $fila["tipo_id"]; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>

            </tr>

            <?php
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<?php
endif;

include "../includes/footer.php";
?>
