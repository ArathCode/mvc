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
        $miembros = $this->modelo->obtenerVentas();
       
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

      

        // Encabezados
        $encabezados = ['ID_Venta', 'Fecha', 'Usuario', 'Producto',"Cantidad","Subtotal"];
        $sheet->fromArray($encabezados, NULL, 'A1');

        // Datos
        $fila = 2;
        foreach ($miembros as $row) {
            $sheet->setCellValue("A$fila", $row['ID_Venta']);
            $sheet->setCellValue("B$fila", $row['Fecha']);
            $sheet->setCellValue("C$fila", $row['Usuario']);
            $sheet->setCellValue("D$fila", $row['Producto']);
            $sheet->setCellValue("E$fila", $row['Cantidad']);
            $sheet->setCellValue("F$fila", $row['Subtotal']);
            $fila++;
        }
        ob_clean();
        // Enviar encabezados
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ventas.xlsx"');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
?>