<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('logo.png', 10, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title without border and aligned to the right
        $this->Cell(30, 10, 'Motor 3rd Party Cover Note', 0, 0, 'L');
        // Line break
        $this->Ln(0);
        
        // Additional labels
        
        $this->SetFont('Arial', '', 7);
        $this->Ln(10); 
        $text = "As per Motor Traffic Act No. 14 of 1951 and its subsequent amendments";
        $this->MultiCell(0, 3, $text, 0, 'C'); // 'J' for justified alignment
        $this->Ln(3); 
        $text = "Whereas the Participant having proposed for the annual motor 3rd party cover in respect of the Motor Vehicle described below and having paid the agreed takaful contribution, the risk is hereby held covered in terms of the company's usual form of Third Party Policy, applicable there to for a Maximum period of THIRTY DAYS. Unless the cover be terminated by the company by notice in writing in which case the Policy will thereupon cease and a proprotionate part of the annual Takaful contribution otherwise payable for such cover will be charged for the period the company has been on risk.";
        $this->MultiCell(0, 3, $text, 0, 'J');
        $this->Ln(3); 
    
         // Add table
         $this->Ln(0); // Add some space before the table
         $this->SetFillColor(196, 196, 196); // Set fill color for the header row
         $this->SetFont('Arial', 'B', 7);

         // Table content
         $this->SetFont('Arial', '', 7);
         $this->Cell(95, 5, 'Name of Participant:', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Cell(95, 5, 'Registered Owner Name:', 1);
         $this->Cell(95, 5, '', 1, 1);
         $this->Cell(95, 5, 'Postal Address:', 1);
         $this->Cell(95, 5, '', 1, 1);
         $this->Cell(95, 5, 'NIC No. / Business Reg. No.:', 1);
         $this->Cell(95, 5, '', 1, 1);
         $this->Cell(95, 5, 'Usage:', 1);
         $this->Cell(95, 5, '', 1, 1);
         $this->Cell(95, 5, 'Period of Takaful (Insurance):', 1);
         $this->Cell(95, 5, '', 1, 1);
         $this->Cell(95, 5, 'This Cover Note is Valid for a 
Maximum Period of 30 DAYS from:', 1);
         $this->Cell(95, 5, '', 1, 1);

        // Add table
        $this->Ln(4); // Add some space before the table
        $this->SetFillColor(196, 196, 196); // Set fill color for the header row
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(95, 5, 'Type of Vehicle', 1, 0, 'C', true);
        $this->Cell(95, 5, 'Annual Takaful Contribution (Premium)', 1, 1, 'C', true);
 
         // Table content
         $this->SetFont('Arial', '', 7);
         $this->Cell(95, 5, '   Motor Car', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Cell(95, 5, '   Motor cycle', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Cell(95, 5, '   Hand Tractor', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Cell(95, 5, '   Tractor', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Cell(95, 5, '   Three Wheeler', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Cell(95, 5, '   Dual Purpose', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Cell(95, 5, '   Lorry', 1);
         $this->Cell(95, 5, '', 1, 1);

         // Add table
         $this->Ln(4); // Add some space before the table
         $this->SetFillColor(196, 196, 196); // Set fill color for the header row
         $this->SetFont('Arial', 'B', 7);
 
         // Table content
         $this->SetFont('Arial', '', 7);
         $this->Cell(95, 5, '   1. Vehicle Make and Model', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Cell(95, 5, '   2. Registration No.', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Cell(95, 5, '   3. Engine No.', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Cell(95, 5, '   4. Chassis No.', 1);
         $this->Cell(95, 5, '', 1, 1);

         $this->Ln(2); 
         $text = "This Cover Note is issued subject to the (above mentioned) vehicle is NOT under any Hire Purchase / Lease facility & NOT liable for payment of luxury or semi luxury taxes or any related penalty.
This document should be duly filled as it is being considered as proposal form.";
         $this->MultiCell(0, 3, $text, 0, 'J');

         $this->Ln(1); 
         $text = "DECLARATION BY PROPOSER";
         $this->MultiCell(0, 3, $text, 0, 'C');

         $this->Ln(1); 
         $text = "I/We to the best of my/our knowledge hereby confirm that the statements contained in the proposal form are true and correct and I/We have not concealed, misrepresented or mis-stated any material fact. I/We agree that the statements and declaration contained in this proposal form shall be the basis of the Certificate of takaful with the Company and are deemed to be incorporated in the Certificate.
I/We hereby agree that the takaful contribution (premium) which I/We undertake to pay to Amana Takaful PLC (The Company) be credited into the takaful fund (Risk Fund) for the company to manage the various schemes of Insurance under the General Takaful (Insurance) business and pay takaful (Insurance) benefits to the Participants as expressed in the terms and conditions of this takaful (Insurance) certificate. I/We agree that the Company take a non refundable 40% of the takaful contribution (Premium) as their fees for managing the above takaful (Insurance) operations. I/We also agree that the company invests the said fund in a compliant manner deemed fit by the company and the profit from investment if any be shared in a proportion of 50% to the Takaful Fund (Risk Fund) and 50% to the company. Losses if any will be borne solely by the Takaful Fund (Risk fund).
If there is a surplus from the fund after payment of benefits to any participant who shall be entitled to such benefits under the said takaful contract and deducting the cost related to the Fund, the same shall be distributed on pro rata among the participants, provided always that they have not incurred any claim and/or received any benefits under the said takaful contract whilst the same is in force. The Company may hold a portion of the surplus as a contingenc";
         $this->MultiCell(0, 3, $text, 0, 'J');
         $this->Ln(10); 

         $this->Cell(0, 5, 'Place : ..................................                                                                                                                                                                   Date : ..................................', 0, 1);
         $this->Cell(0, 5, '                                                                                                                                                                                                                 Time : ..................................', 0, 1);
         $this->SetFont('Arial', '', 7);
         $this->Ln(8); 
         $this->Cell(0, 5, '..................................................................                                                                                                                    ........................................... ', 0, 1);
         $this->Cell(0, 5, '      AMANA TAKAFUL INSURANCE    
                                                                                                                            Participant Signature', 0, 1);
         $this->Cell(0, 5, '              (Authorised Signatory)', 0, 1);
         $this->Ln(8); 
         $this->Cell(0, 5, 'Branch : ..................................                                                                                                This document is to be cosidered as the official receipt for the payment made.', 0, 1);
         $this->Ln(5);
         $this->Cell(0, 5, '                                                                                                                                                No:', 0, 1);
    }

    // Page footer
    function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial', 'I', 8);

    // Add another logo on the left side of the footer
    $this->Image('3rd-Party-CN.png', 5, $this->GetY() + 3, 11);
    //$this->Cell(0, 3, '660-1/1, Galle Road, Colombo 03, Sri Lanka.', 0, 1, 'L');
    //$this->Cell(0, 3, 'Tel : 94-11-7501000 ; Fax: 94-11-7501097/2597429', 0, 1, 'L');
    //$this->Cell(0, 3, 'E-mail : info@takaful.lk ; Website : www.takaful.lk', 0, 1, 'L');

    // Add the main logo on the right side of the footer
    $this->Image('', $this->GetPageWidth() - 50, $this->GetY() + 3, 40);
}
}

// Instanciation of inherited class with A4 page size
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

$pdf->Output();
?>
