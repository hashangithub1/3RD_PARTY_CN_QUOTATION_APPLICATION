<?php
require_once('includes/config.php');
require('fpdf/fpdf.php'); // Include FPDF library

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/autoload.php';

// Define a class for the PDF report
class PDF extends FPDF {
    // Page header
    function Header() {
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Title
        $this->Cell(0,10,'Full Transaction Report - All Branch',0,1,'C');
        // Line break
        $this->Ln(10);
    }

    // Page footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Create PDF object
$pdf = new PDF('P', 'mm', array(110, 297));
$pdf->AliasNbPages();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial','',8);

// Write table header
$pdf->SetDrawColor(255, 255, 255); 
$pdf->SetFillColor(166, 166, 166); // Set background color
$pdf->SetFont('Arial','B',8);

// Calculate x-coordinate for center alignment
$tableWidth = 100; // You can adjust this value based on your table width
$xCenter = ($pdf->GetPageWidth() - $tableWidth) / 2;

$pdf->SetX($xCenter); // Set X-coordinate for center alignment
$pdf->Cell(25,7,'Branch Code',1,0,'C',true);
$pdf->Cell(50,7,'Branch Name',1,0,'C',true);
$pdf->Cell(25,7,'Transactions',1,1,'C',true);
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(255, 255, 255); // reset background color
$pdf->SetDrawColor(255, 255, 255); 

// Fetch data from the database
$sql = "SELECT b.b_code AS branch_added,
                b.b_name,
                COALESCE(COUNT(i.branch_added), 0) AS transaction_count
        FROM tbl_branch b
        LEFT JOIN tbl_insurance i ON b.b_code = i.branch_added
        WHERE b.b_name != 'test'
        GROUP BY b.b_code, b.b_name
        ORDER BY transaction_count DESC";

$result = $con->query($sql);

// Initialize total transaction count
$total_transaction_count = 0;

// Output data of each row
while($row = $result->fetch_assoc()) {
    $pdf->SetX($xCenter); // Set X-coordinate for center alignment
    $pdf->SetDrawColor(255, 255, 255); 
    $pdf->SetFillColor(217, 217, 217);
    $pdf->Cell(25,5,$row["branch_added"],1,0,'C',true);
    $pdf->Cell(50,5,$row["b_name"],1,0,'L',true);
    $pdf->Cell(25,5,$row["transaction_count"],1,1,'C',true);
    
    // Add the transaction count to the total
    $total_transaction_count += intval($row["transaction_count"]);
}

// Output total transaction count
$pdf->SetX($xCenter); // Set X-coordinate for center alignment
$pdf->SetFillColor(166, 166, 166); // Set background color
$pdf->SetFont('Arial','B',8);
$pdf->Cell(75,7,'Total Transactions',1,0,'C',true);
$pdf->Cell(25,7,$total_transaction_count,1,1,'C',true);
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(255, 255, 255); // Reset background color to white

// Output PDF
$pdfPath = 'email-report/full_transaction_report.pdf'; // Path to save the PDF
$pdf->Output($pdfPath, 'F'); // Save the PDF to a file

// Use PHPMailer to send email with PDF attachment
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'tinycabs.com'; // SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply@tinycabs.com'; // SMTP username
    $mail->Password = 'S^8*6Q.#-(dk'; // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('noreply@tinycabs.com', 'System Generated Report');
    $mail->addAddress('srox6666@gmail.com', 'Hashan');
    $mail->addAddress('hashan.madhusanka@takaful.lk', 'Developer');
    $mail->Subject = 'Full Transaction Report - Third Party';
    $mail->Body = 'Please find the attachment.';
    $mail->addAttachment($pdfPath, 'email-report/Full_Transaction_Report.pdf'); 
    $mail->send();
    echo 'Email sent successfully!';
} catch (Exception $e) {
    echo 'Error: ' . $mail->ErrorInfo;
}

// Delete the PDF file after sending email
unlink($pdfPath);
?>
