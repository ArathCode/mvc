<?php
// controllers/MiembroController.php
require_once '../config.php';
require_once '../modelos/ReporteMiembroPdf.php';
require_once '../lib/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
$conexion = dbConectar();
$controlador = new MiembroController($conexion);
$controlador->generarReporteExcel();
class MiembroController {
    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new MiembroModel($conexion);
    }


    public function generarReporteExcel() {
        ob_start();
        $miembros = $this->modelo->obtenerTodos();
       
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

      

        // Encabezados
        $encabezados = ['Nombre', 'Apellido Paterno', 'Apellido Materno', 'Telefono'];
        $sheet->fromArray($encabezados, NULL, 'A1');

        // Datos
        $fila = 2;
        foreach ($miembros as $row) {
            $sheet->setCellValue("A$fila", $row['Nombre']);
            $sheet->setCellValue("B$fila", $row['ApellidoP']);
            $sheet->setCellValue("C$fila", $row['ApellidoM']);
            $sheet->setCellValue("D$fila", $row['Telefono']);
            $fila++;
        }
        ob_clean();
        // Enviar encabezados
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ReporteUsuarios.xlsx"');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
?>