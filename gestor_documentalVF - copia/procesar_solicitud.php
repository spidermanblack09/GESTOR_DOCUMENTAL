<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'includes/conexion.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num_solicitud = trim($_POST['num_solicitud']);
    $unidad = trim($_POST['unidad']);
    $grado = trim($_POST['grado']);
    $nombre = trim($_POST['nombre']);
    $identificacion = trim($_POST['identificacion']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $tipo_documento = $_POST['tipo_documento'];
    $fecha_documento = $_POST['fecha_documento'];

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare('INSERT INTO solicitudes (num_solicitud, unidad, grado, nombre, identificacion, correo, telefono) VALUES (:num_solicitud, :unidad, :grado, :nombre, :identificacion, :correo, :telefono)');
        $stmt->execute([
            'num_solicitud' => $num_solicitud,
            'unidad' => $unidad,
            'grado' => $grado,
            'nombre' => $nombre,
            'identificacion' => $identificacion,
            'correo' => $correo,
            'telefono' => $telefono
        ]);

        $solicitud_id = $conn->lastInsertId();

        $stmt = $conn->prepare('INSERT INTO documentos (solicitud_id, tipo_documento, fecha_documento) VALUES (:solicitud_id, :tipo_documento, :fecha_documento)');
        for ($i = 0; $i < count($tipo_documento); $i++) {
            $stmt->execute([
                'solicitud_id' => $solicitud_id,
                'tipo_documento' => $tipo_documento[$i],
                'fecha_documento' => $fecha_documento[$i]
            ]);
        }

        $conn->commit();

        // Generar archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Fecha y hora de la solicitud');
        $sheet->setCellValue('B1', 'Número de solicitud');
        $sheet->setCellValue('C1', 'Unidad');
        $sheet->setCellValue('D1', 'Grado');
        $sheet->setCellValue('E1', 'Nombre');
        $sheet->setCellValue('F1', 'Número de identificación');
        $sheet->setCellValue('G1', 'Correo electrónico');
        $sheet->setCellValue('H1', 'Teléfono');
        $sheet->setCellValue('I1', 'Tipo de documento');
        $sheet->setCellValue('J1', 'Fecha del documento');

        $stmt = $conn->query('SELECT solicitudes.*, documentos.tipo_documento, documentos.fecha_documento FROM solicitudes LEFT JOIN documentos ON solicitudes.id = documentos.solicitud_id');
        $row = 2;
        while ($solicitud = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sheet->setCellValue('A' . $row, $solicitud['fecha']);
            $sheet->setCellValue('B' . $row, $solicitud['num_solicitud']);
            $sheet->setCellValue('C' . $row, $solicitud['unidad']);
            $sheet->setCellValue('D' . $row, $solicitud['grado']);
            $sheet->setCellValue('E' . $row, $solicitud['nombre']);
            $sheet->setCellValue('F' . $row, $solicitud['identificacion']);
            $sheet->setCellValue('G' . $row, $solicitud['correo']);
            $sheet->setCellValue('H' . $row, $solicitud['telefono']);
            $sheet->setCellValue('I' . $row, $solicitud['tipo_documento']);
            $sheet->setCellValue('J' . $row, $solicitud['fecha_documento']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'solicitudes.xlsx';
        $writer->save($filename);

        echo "Archivo Excel generado correctamente: $filename";
        header('Location: confirmacion.php');
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        die('Error al procesar la solicitud: ' . $e->getMessage());
    }
}
?>
