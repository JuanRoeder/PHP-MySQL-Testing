<?php
// Configuración de visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de registro de errores en la consola del navegador
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php_errors.log');

// Configuración de la conexión a la base de datos
$servername = "10.0.0.7:3306";
$username = "root";
$password = "BwRU02o0@j5d";
$dbname = "mysql-testing";

// Crear una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si hay algún error de conexión
if ($conn->connect_error) {
    error_log("Error de conexión a la base de datos: " . $conn->connect_error);
    die("Error de conexión a la base de datos.");
}

// Consultar un registro específico de la tabla TBL_PERSON
$sql = "SELECT * FROM TBL_PERSON WHERE id = 1";
$result = $conn->query($sql);

// Verificar si se encontraron resultados
if ($result === false) {
    error_log("Error en la consulta SQL: " . $conn->error);
    die("Error en la consulta SQL.");
}

// Obtener los datos del registro
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row["id"];
    $dni = $row["dni"];
    $name = $row["name"];

    // Mostrar los datos en pantalla
    echo "ID: " . $id . "<br>";
    echo "DNI: " . $dni . "<br>";
    echo "Nombre: " . $name . "<br>";
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
