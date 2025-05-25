<?php
// controllers/MiembroController.php
include_once("../config.php");
require_once '../modelos/ReporteMiembroPdf.php';
require_once '../lib/fpdf/fpdf.php';

class MiembroController {
    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new MiembroModel($conexion);
    }

    public function generarReportePDF() {
        $miembros = $this->modelo->obtenerProductos();

        $pdf = new PDF('P');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        foreach ($miembros as $row) {
    // Determinar color según stock
    if ($row['Disponible'] == 0) {
        $pdf->SetFillColor(255, 0, 0); // Rojo
    } elseif ($row['Disponible'] <= 5) {
        $pdf->SetFillColor(255, 255, 0); // Amarillo
    } else {
        $pdf->SetFillColor(255, 255, 255); // Blanco (sin relleno)
    }

    $pdf->Cell(20, 10, utf8_decode($row['ID_Producto']), 1, 0, 'C', true);
    $pdf->Cell(60, 10, utf8_decode($row['Descripcion']), 1, 0, 'C', true);
    $pdf->Cell(30, 10, utf8_decode($row['Precio']), 1, 0, 'C', true);
    $pdf->Cell(25, 10, utf8_decode($row['Disponible']), 1, 0, 'C', true);
    $pdf->Cell(40, 10, utf8_decode($row['TipoProducto']), 1, 0, 'C', true);

    $pdf->Ln();
}

        $pdf->Output();
    }
}

// Clase PDF
class PDF extends FPDF {
    function Header() {
        $this->SetFillColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0, 10, 'Reporte de inventario', 0, 1, 'C');
        $this->SetFont('Arial', 'I', 12);
        $this->Cell(0, 10, 'Generado el ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont("Arial", 'B', 12);
        $this->SetTextColor(255,255,255);
        $this->Cell(20, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(60, 10, 'Nombre Producto', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Precio', 1, 0, 'C', true);
        $this->Cell(25, 10, 'Disponible', 1, 0, 'C', true);
         $this->Cell(40, 10, 'TipoProducto', 1, 0, 'C', true);
         
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(100);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
$conexion = dbConectar();
$controlador = new MiembroController($conexion);
$controlador->generarReportePDF();
?>