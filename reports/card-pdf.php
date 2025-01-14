<?php
require('fpdf/fpdf.php');
// Create a new FPDF instance
$pdf = new FPDF();
$pdf->SetAutoPageBreak(false); // Disable auto page break
$pdf->SetMargins(10, 10, 0); // Set margins to zero
$pdf->AddPage('L', 'A5'); // Set page size to A5
$pdf->SetFont('Arial', 'B', 11);


$pdf->Cell(40, 10, 'PRIVATE CAR (THIRD PARTY ONLY COVER');
$pdf->Ln(38); 

// Create a table with two rows
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(40, 10, 'NAME', ); // Border around the cell
$pdf->Cell(40, 10, '    MR. S M IRSHAD', ); // Border around the cell
$pdf->Ln(); // Move to the next line

$pdf->Cell(40, 10, 'ADDRESS', ); // Border around the cell
$pdf->Cell(40, 10, '    NO. 9/229,  MAWILMADA ROAD,', ); 
$pdf->Ln();

$pdf->Cell(40, 10, '', ); // Border around the cell
$pdf->Cell(40, 10, '    SIYAMBALAGASTENNA, KANDY', ); // Border around the cell
$pdf->Ln();
$pdf->Ln();

$pdf->Cell(40, 10, 'POLICY NO', ); // Border around the cell
$pdf->Cell(40, 10, '     KA3VPTDP00017/24', ); // Border around the cell
$pdf->Ln();

$pdf->Cell(40, 10, 'PERIOD', ); // Border around the cell
$pdf->Cell(40, 10, '     02/01/2024 - 01/01/2025', ); // Border around the cell
$pdf->Ln();

$pdf->Cell(40, 10, 'VEHICLE NO', ); // Border around the cell
$pdf->Cell(40, 10, '     WP KV-8560', ); // Border around the cell
$pdf->Ln();

$pdf->Cell(40, 10, 'ENGINE NO', ); // Border around the cell
$pdf->Cell(40, 10, '     1NZ-3CM-G042476', ); // Border around the cell
$pdf->Ln();

$pdf->Cell(40, 10, 'CHASSIS NO', ); // Border around the cell
$pdf->Cell(40, 10, '     NHW20-3586850', ); // Border around the cell
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8.3, 'YAKABE GERARA MADUSHI SHIWA');
$pdf->Cell(40, 8.3, '                                                                                                           24/01/2023');
$pdf->Cell(40, 8.3, '                                          HEAD OFFICE');
// Save the PDF to a file
$pdfFileName = 'generated_pdf.pdf';
$pdf->Output($pdfFileName, 'I'); // 'F' saves the file to the server