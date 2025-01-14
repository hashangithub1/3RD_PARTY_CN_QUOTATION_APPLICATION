<?php 
session_start();
// Assuming you have a database connection
require_once('../../includes/config.php');
require_once('search.php');
require('fpdf/fpdf.php');

if (isset($_POST['cover_note_numbers']) && !empty($_POST['cover_note_numbers'])) {
    $coverNoteNumbers = $_POST['cover_note_numbers'];
    $coverNoteNumbersList = implode("','", array_map(function($number) use ($con) {
        return mysqli_real_escape_string($con, trim($number));
    }, $coverNoteNumbers));

// Fetch Data For The Card
$querySearch = "SELECT 
                    i.name, 
                    i.address_01, 
                    i.address_02, 
                    i.city, 
                    i.usage_type, 
                    i.product, 
                    i.cover_note_number, 
                    i.manual_cn_number, 
                    i.valid_period, 
                    i.registration_number, 
                    i.engine_number, 
                    i.chassis_number, 
                    i.issued_by, 
                    i.branch_added, 
                    b.b_name 
                FROM 
                    tbl_insurance i 
                JOIN 
                    tbl_branch b 
                ON 
                    i.branch_added = b.b_code 
                WHERE 
                    i.cover_note_number IN ('$coverNoteNumbersList')";
$resultSearch = $con->query($querySearch);

if ($resultSearch->num_rows > 0) {
    // Initialize PDF
    class PDF_Rotate extends FPDF {
        var $angle = 0;

        function Rotate($angle, $x = -1, $y = -1) {
            if ($x == -1) $x = $this->x;
            if ($y == -1) $y = $this->y;
            if ($this->angle != 0) $this->_out('Q');
            $this->angle = $angle;
            if ($angle != 0) {
                $angle *= M_PI / 180;
                $c = cos($angle);
                $s = sin($angle);
                $cx = $x * $this->k;
                $cy = ($this->h - $y) * $this->k;
                $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
            }
        }

        function _endpage() {
            if ($this->angle != 0) {
                $this->angle = 0;
                $this->_out('Q');
            }
            parent::_endpage();
        }
    }

    $pdf = new PDF_Rotate();
    $pdf->SetAutoPageBreak(false); 
    $pdf->SetMargins(140, 10, 0);

    // Loop through each result and add a new page for each
    while ($row = $resultSearch->fetch_assoc()) {
        // Prepare data for each card
        $u_type = strtoupper($row['usage_type']);
        $u_PN = strtoupper($row['product']);
        $u_name = strtoupper($row['name']);
        $addr1 = strtoupper($row['address_01']);
        $addr2 = strtoupper($row['address_02']);
        $u_fullAddress = strtoupper($addr1 . ', ' . $addr2);
        $u_city = strtoupper($row['city']);
        $p_no = strtoupper($row['cover_note_number']);
        $period = strtoupper($row['valid_period']);
        $u_v_no = strtoupper($row['registration_number']);
        $u_e_no = strtoupper($row['engine_number']);
        $u_c_no = strtoupper($row['chassis_number']);
        $u_issued_by = strtoupper($row['issued_by']);
        $u_b_name = strtoupper($row['b_name']);
        $date = date('d/m/Y');

        // Add a new page for each record
        $pdf->AddPage('P', 'A5');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Rotate(-90);

        // First section
        $pdf->Cell(40, 10,''.$u_type. ' '.$u_PN. '  (THIRD PARTY ONLY COVER)');
        $pdf->Ln(35);

        // Create a table with data
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(40, 10, 'NAME'); 
        $pdf->Cell(40, 10, '        '.$u_name); 
        $pdf->Ln(); 

        $pdf->Cell(40, 10, 'ADDRESS'); 
        $pdf->Cell(40, 10, '        '.$u_fullAddress); 
        $pdf->Ln();

        $pdf->Cell(40, 10, ''); 
        $pdf->Cell(40, 10, '        '.$u_city); 
        $pdf->Ln();
        $pdf->Ln();

        $pdf->Cell(40, 10, 'POLICY NO'); 
        $pdf->Cell(40, 10, '        '.$p_no); 
        $pdf->Ln();

        $pdf->Cell(40, 10, 'PERIOD'); 
        $pdf->Cell(40, 10, '        '.$period); 
        $pdf->Ln();

        $pdf->Cell(40, 10, 'VEHICLE NO'); 
        $pdf->Cell(40, 10, '        '.$u_v_no); 
        $pdf->Ln();

        $pdf->Cell(40, 10, 'ENGINE NO'); 
        $pdf->Cell(40, 10, '        '.$u_e_no); 
        $pdf->Ln();

        $pdf->Cell(40, 10, 'CHASSIS NO'); 
        $pdf->Cell(40, 10, '        '.$u_c_no); 
        $pdf->Ln(10);

        // Footer section
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 8.3, ''.$u_issued_by);
        $pdf->Cell(40, 8.3, '                                                                                                           '.$date);
        $pdf->Cell(40, 8.3, '                                          '.$u_b_name);
        
        //INSERT GENERATED CN NO TO VERIFY TABLE
        $coverNoteNumber = $row['cover_note_number'];
        $printed_by = $_SESSION['u_name'];
            
        $queryInsert = "INSERT INTO tbl_issued_cards (cn_no, print_flag, printed_by) 
                        VALUES ('$coverNoteNumber', 1, '$printed_by')
                        ON DUPLICATE KEY UPDATE print_flag = 1";
        $con->query($queryInsert);
        //END
    }

    // Save the PDF to a file
    $directory = 'exported_files/';
    $pdfFileName = $directory . 'Bulk_Card' . '.pdf';
    $pdf->Output($pdfFileName, 'F'); // 'F' saves the file to the server
    $pdf->Output($pdfFileName, 'I'); // Display the PDF inline in the browser
    
    //Notification System
    $currentTime = date('Y-m-d H:i:s');
    $newNotification = [
        'message' => 'Bulk Card PDF File Exported', 
        'time' => $currentTime,
        'is_read' => false
    ];
    $_SESSION['notifications'][] = $newNotification;
    //End

    } else {
    echo "No records found.";
    }
}
else 
{
    echo 'No cover note numbers were selected.';
}
?>
