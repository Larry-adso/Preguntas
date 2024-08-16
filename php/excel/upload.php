<?php
require 'vendor/autoload.php'; // Asegúrate de que la ruta a Composer es correcta
require '../conexion/conexion.php'; // Conexión a la base de datos

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $spreadsheet = IOFactory::load($fileTmpPath);
        $worksheet = $spreadsheet->getActiveSheet();
        
        // Iteramos sobre las filas del archivo Excel
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }

            // Asumimos que la columna A es 'pregunta' y la columna B es 'respuesta'
            $pregunta = isset($data[0]) ? $data[0] : null;
            $respuesta = isset($data[1]) ? $data[1] : null;

            if (!empty($pregunta) && !empty($respuesta)) {
                // Insertar en la base de datos
                $sql = "INSERT INTO cuestionario (pregunta, respuesta) VALUES (:pregunta, :respuesta)";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':pregunta', $pregunta);
                $stmt->bindParam(':respuesta', $respuesta);
                $stmt->execute();
            }
        }

        echo "Datos guardados correctamente.";
    } else {
        echo "Error al subir el archivo.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
