<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$id = $_POST["id"];
$tipo_id = $_POST["tipo_id"];
$nombre = $_POST["nombre"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$salario = $_POST["salario"];
$entrada= $_POST["entrada"];
$hotel_trabaja = $_POST["hotel_trabaja"];


// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
$query = "INSERT INTO `empleado`(`id`,`tipo_id`, `nombre`, `telefono`, `correo`, `salario`,`hotel_trabaja`,`entrada`) VALUES ('$id', '$tipo_id', '$nombre', '$telefono', '$correo', '$salario', '$hotel_trabaja', '$entrada')";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: empleado.php");
else:
	echo "Ha ocurrido un error al crear el empleado";
endif;

mysqli_close($conn);