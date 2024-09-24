<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$nit = $_POST["nit"];
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$telefono = $_POST["telefono"];
$ubicacion = $_POST["ubicacion"];
$categoria = $_POST["categoria"];

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
if ($categoria == ""){
	$query = "INSERT INTO `hotel`(`nit`,`nombre`, `correo`, `telefono`, `ubicacion`, `categoria`) VALUES ('$nit', '$nombre', '$correo', '$telefono', '$ubicacion', NULL)";	
} else{
	$query = "INSERT INTO `hotel`(`nit`,`nombre`, `correo`, `telefono`, `ubicacion`, `categoria`) VALUES ('$nit', '$nombre', '$correo', '$telefono', '$ubicacion', '$categoria')";
}

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: hotel.php");
else:
	echo "Ha ocurrido un error al crear el hotel";
endif;

mysqli_close($conn);