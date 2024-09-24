<!-- Consultar la lista de empleados y desplegarlos -->
<div class="mb-3">
    <label for="empleado" class="form-label">Empleado</label>
    <select name="empleado" id="empelado" class="form-select">
        
        <!-- Option por defecto -->
        <option value="" selected disabled hidden></option>

        <?php
        // Importar el código del otro archivo
        require("../empleado/empleado_select.php");
        
        // Verificar si llegan datos
        if($resultadoEmpleado):
            
            // Iterar sobre los registros que llegaron
            foreach ($resultadoEmpleado as $fila):
        ?>

        <!-- Opción que se genera -->
        <option value="<?= $fila["id"]; ?>-<?= $fila["tipo_id"]; ?>">
            <?= $fila["nombre"]; ?> - ID: <?= $fila["id"]; ?>, Tipo ID: <?= $fila["tipo_id"]; ?>
        </option>            

        <?php
                // Cerrar los estructuras de control
            endforeach;
        endif;
        ?>
    </select>
</div>



        <!-- Consultar la lista de hoteles y desplegarlos -->
<div class="mb-3">
    <label for="hotel" class="form-label">Hotel</label>
    <select name="hotel" id="hotel" class="form-select">
        
        <!-- Option por defecto -->
        <option value="" selected disabled hidden></option>

        <?php
        // Importar el código del otro archivo
        require("../hotel/hotel_select.php");
        
        // Verificar si llegan datos
        if($resultadoHotel):
            
            // Iterar sobre los registros que llegaron
            foreach ($resultadoHotel as $fila):
        ?>

        <!-- Opción que se genera -->
        <option value="<?= $fila["nit"]; ?>"><?= $fila["nombre"]; ?> - NIT: <?= $fila["nit"]; ?></option>

        <?php
                // Cerrar los estructuras de control
            endforeach;
        endif;
        ?>
    </select>
</div>


<!-- Consultar la lista de hoteles y desplegarlos -->
<div class="mb-3">
    <label for="hotel" class="form-label">Hotel</label>
    <select name="hotel" id="hotel" class="form-select">
        
        <!-- Option por defecto -->
        <option value="" selected disabled hidden></option>

        <?php
        // Importar el código del otro archivo
        require("../hotel/hotel_select.php");
        
        // Verificar si llegan datos
        if($resultadoHotel):
            
            // Iterar sobre los registros que llegaron
            foreach ($resultadoHotel as $fila):
        ?>

        <!-- Opción que se genera -->
        <option value="<?= $fila["nit"]; ?>"><?= $fila["nombre"]; ?> - NIT: <?= $fila["nit"]; ?></option>

        <?php
                // Cerrar los estructuras de control
            endforeach;
        endif;
        ?>
    </select>
</div>