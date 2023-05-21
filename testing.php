<?php
// Configuración de visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la conexión a la base de datos
$servername = "10.0.0.7:3306";
$username = "root";
$password = "BwRU02o0@j5d";
$dbname = "mysql-testing";

// Configuración de salida para el streaming de datos
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('Access-Control-Allow-Origin: *');

// Función para enviar el evento de actualización de datos
function sendEvent($data) {
    echo "data: " . json_encode($data) . "\n\n";
    ob_flush();
    flush();
}

// Función para obtener la lista de registros de la tabla TBL_PERSON
function getPersonList($conn) {
    $sql = "SELECT * FROM tbl_person";
    $result = $conn->query($sql);

    $personList = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $personList[] = $row;
        }
    }

    return $personList;
}

// Crear una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si hay algún error de conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener la lista inicial de registros de la tabla TBL_PERSON
$initialPersonList = getPersonList($conn);

// Enviar la lista inicial como el primer evento de actualización de datos
sendEvent($initialPersonList);

// Realizar un bucle infinito para seguir enviando eventos de actualización de datos
while (true) {
    // Esperar 1 segundo antes de consultar nuevamente la tabla
    sleep(1);

    // Obtener la lista actual de registros de la tabla TBL_PERSON
    $currentPersonList = getPersonList($conn);

    // Verificar si ha habido cambios en la lista de registros
    if ($currentPersonList != $initialPersonList) {
        // Actualizar la lista inicial con la lista actual
        $initialPersonList = $currentPersonList;

        // Enviar el evento de actualización de datos
        sendEvent($currentPersonList);
    }
}

// Cerrar la conexión a la base de datos (este código nunca se ejecutará debido al bucle infinito)
$conn->close();
?>
