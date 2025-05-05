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
        $miembros = $this->modelo->obtenerTodos();

        $pdf = new PDF('P');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        foreach ($miembros as $row) {
            $pdf->Cell(30, 10, utf8_decode($row['Nombre']), 1, 0, 'C');
            $pdf->Cell(30, 10, utf8_decode($row['ApellidoP']), 1, 0, 'C');
            $pdf->Cell(30, 10, utf8_decode($row['ApellidoM']), 1, 0, 'C');
            $pdf->Cell(25, 10, utf8_decode($row['Telefono']), 1, 0, 'C');
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
        $this->Cell(0, 10, 'Reporte de miembros', 0, 1, 'C');
        $this->SetFont('Arial', 'I', 12);
        $this->Cell(0, 10, 'Generado el ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont("Arial", 'B', 12);
        $this->SetTextColor(255,255,255);
        $this->Cell(30, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Paterno', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Materno', 1, 0, 'C', true);
        $this->Cell(25, 10, 'Telefono', 1, 0, 'C', true);
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