<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start(); // Inicia el almacenamiento en buffer

require '../../conexion/conexion.php';
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Verificar si se ha subido un archivo
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $filePath = $_FILES['file']['tmp_name'];

    try {
        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($filePath);

        // Hojas de interés
        $sheets = ['HOSTDIME', 'DATACENTER', 'NEBULA', 'CERTIFICACIONES'];

        foreach ($sheets as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
            if ($sheet) {
                echo "Procesando la hoja: $sheetName<br>";
                // Obtener el número máximo de filas, pero procesar solo las primeras 40
                $highestRow = min(40, $sheet->getHighestRow());
                echo "Número de filas a procesar en la hoja $sheetName: $highestRow<br>";

                // Recorrer las filas desde la fila 2 hasta la fila 40 o la última fila disponible, lo que ocurra primero
                for ($row = 2; $row <= $highestRow; $row++) {
                    // Leer las columnas A (pregunta) y B (respuesta)
                    $pregunta = $sheet->getCell("A$row")->getValue();
                    $respuesta = $sheet->getCell("B$row")->getValue();

                    echo "Fila $row - Pregunta: $pregunta, Respuesta: $respuesta<br>";

                    // Verificar si la pregunta y respuesta no están vacías
                    if ($pregunta && $respuesta) {
                        // Obtener el id de clasificacion basado en el nombre de la hoja
                        $stmt = $conexion->prepare("SELECT id FROM clasificacion WHERE clasificacion = :clasificacion");
                        $stmt->execute(['clasificacion' => $sheetName]);
                        $clasificacionRow = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($clasificacionRow) {
                            $id_clasificacion = $clasificacionRow['id'];

                            // Insertar en la tabla cuestionario
                            $insertQuery = "INSERT INTO cuestionario (id_clasificacion, pregunta, respuesta) 
                                            VALUES (:id_clasificacion, :pregunta, :respuesta)";
                            $insertStmt = $conexion->prepare($insertQuery);
                            $insertStmt->execute([
                                'id_clasificacion' => $id_clasificacion,
                                'pregunta' => $pregunta,
                                'respuesta' => $respuesta
                            ]);

                            echo "Datos insertados para la fila $row en la hoja $sheetName.<br>";
                        } else {
                            echo "No se encontró la clasificación para la hoja $sheetName.<br>";
                        }
                    } else {
                        echo "Fila $row está vacía o incompleta en la hoja $sheetName.<br>";
                    }
                }
            } else {
                echo "No se encontró la hoja $sheetName en el archivo.<br>";
            }
        }

        echo "El archivo se ha procesado correctamente.";
        header('Location: ../admin/dasboard.php');
        exit; // Asegura que el script se detenga después de la redirección

    } catch (Exception $e) {
        echo "Error al procesar el archivo: " . $e->getMessage();
    }
} else {
    echo "Error al subir el archivo.";
}

ob_end_flush(); // Envía la salida almacenada
?>
