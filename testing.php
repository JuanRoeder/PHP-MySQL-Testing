<?php
// Configuración de la conexión a la base de datos
$servername = "10.0.0.7:3306";
$username = "root";
$password = "BwRU02o0@j5d";
$dbname = "mysql-testing";

// Crear una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si hay algún error de conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Ejecutar una consulta inicial para obtener los datos actuales de la tabla
$sql = "SELECT * FROM TBL_PERSON";
$result = $conn->query($sql);

// Función para procesar los resultados de la consulta
function processResults($result)
{
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $dni = $row["dni"];
            $name = $row["name"];
            
            // Realiza aquí las operaciones que deseas con los datos
            // Por ejemplo, puedes imprimirlos en la pantalla
            echo "ID: " . $id . "<br>";
            echo "DNI: " . $dni . "<br>";
            echo "Nombre: " . $name . "<br>";
            
            // Puedes añadir lógica adicional según tus necesidades
        }
    } else {
        echo "No se encontraron resultados.";
    }
}

// Llama a la función para procesar los resultados iniciales
processResults($result);

// Configura el tiempo máximo de ejecución del script y la memoria máxima permitida
set_time_limit(0);
ini_set('memory_limit', '-1');

// Configura el intervalo de tiempo para la verificación de cambios en la tabla (en segundos)
$interval = 5;

// Ciclo infinito para verificar los cambios en la tabla
while (true) {
    sleep($interval); // Espera el intervalo de tiempo especificado

    // Realiza la consulta para obtener los nuevos cambios en la tabla
    $result = $conn->query($sql);

    // Verifica si hay nuevos resultados y procesa los cambios
    if ($result->num_rows > 0) {
        processResults($result);
    }
}

// Cerrar la conexión a la base de datos (este bloque de código no se ejecutará debido al ciclo infinito anterior)
$conn->close();
?>
