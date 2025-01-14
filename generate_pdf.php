<?php
require('fpdf/fpdf.php'); 

// Get form data
$name = $_POST['name'];
$old_nic = $_POST['old_nic'];
// ... (get other form data)

// Create PDF document
$pdf = new FPDF();
$pdf->AddPage();

// Add content to the PDF
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Customer Information');

$pdf->SetFont('Arial', '', 12);
$pdf->Ln(10); // Line break
$pdf->Cell(40, 10, 'Name: ' . $name);
$pdf->Cell(40, 10, 'Old NIC: ' . $old_nic);
// ... (add other form data to the PDF)

// Output the PDF (you can save or display it)
$pdf->Output();

// Optionally, you can save the PDF to a file
// $pdf->Output('generated_pdf.pdf', 'F');
?>

