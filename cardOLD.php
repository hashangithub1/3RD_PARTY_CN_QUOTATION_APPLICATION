<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
    
?>
<?php
// Assuming you have a database connection
require_once('includes/config.php');
require('fpdf/fpdf.php');

    $userid = $_SESSION['id'];
    $query = mysqli_query($con, "select * from tbl_staff where id='$userid'");
    
    // Assuming you have only one result for the user
    $username = mysqli_fetch_array($query);
    $branchcode = $_SESSION['branch'];
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $rcpnumber = strtoupper($_POST["rep-number"]);
    $cash_receipt = $_POST["cash_rec"];

    $user_added = $username['username'];
    $covernum = $_POST["cover-note"];

    if ($cash_receipt === "on") {
        $Cash_R = "YES";                            
    } else {
        $Cash_R = "NO";
    }

    // Insert data into the database
    $sql = "UPDATE tbl_insurance SET receipt_number = '$rcpnumber', cash_recieved = '$Cash_R' WHERE id = '$id'";

if ($con->query($sql) === TRUE) {
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        //Notification System
        $currentTime = date('Y-m-d H:i:s');
        $newNotification = [
            'message' => 'Card Issued Successfully.', 
            'time' => $currentTime,
            'is_read' => false
        ];
        $_SESSION['notifications'][] = $newNotification;
        //End
        echo '<div style="color:green;">Data submitted successfully!</div>';
    }

    //// INSERT LOG DATA ////
        $comment = "PDF Generated - 3RD Party Card";

        if (!empty($_SESSION['user_log'])) {
        foreach ($_SESSION['user_log'] as $log) {
            $action = $log['action'];
            $timestamp = $log['timestamp'];

            $sql_log = "INSERT INTO tbl_log (username, branch, comment, action, dateadded) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql_log);
            $stmt->bind_param('sssss', $user_added, $branchcode, $comment, $action, $timestamp);
            $stmt->execute();
        }

        // Clear session log after inserting into the database
        $_SESSION['user_log'] = [];

         //Notification System
         $currentTime = date('Y-m-d H:i:s');
         $newNotification = [
             'message' => 'Actions logged successfully.', 
             'time' => $currentTime,
             'is_read' => false
         ];
         $_SESSION['notifications'][] = $newNotification;
         //End
        //echo "Actions logged successfully.";
        }
    ////       END      ////
    
    $userid = $_SESSION['id'];
    $query = mysqli_query($con, "select first_name, last_name from tbl_staff where id='$userid'");
    // Assuming you have only one result for the user
    $result1 = mysqli_fetch_array($query);
    $f_name = $result1['first_name'];
    $l_name = $result1['last_name'];
    $issued_by = $f_name .' ' . $l_name;        $u_issued_by = strtoupper($issued_by);

    // Create a new FPDF instance
    $name = $_POST["name"];                     $u_name = strtoupper($name); //Convert Name into Uppercase
    $ad1 = $_POST["address_01"];                
    $ad2 = $_POST["address_02"];                
    $fullAddress = $ad1 . ', ' . $ad2;          $u_fullAddress = strtoupper($fullAddress);
    $city = $_POST["city"];                     $u_city = strtoupper($city);
    $p_no = $_POST["cover-note"];               
    $period = $_POST["valid"];                  
    $v_no = $_POST["registration_number"];      $u_v_no = strtoupper($v_no);
    $e_no = $_POST["engine_number"];            $u_e_no = strtoupper($e_no);
    $c_no = $_POST["chassis_number"];           $u_c_no = strtoupper($c_no);
    $type = $_POST["usage_type"];               $u_type = strtoupper($type);
    $product = $_POST["product"];               

    // Conditionally set $product_name based on the value of $product
    if ($product === "Motor Car") {
        $PN = "CAR";                            
    } elseif ($product === "Motor cycle") {
        $PN = $product;                         
    }elseif ($product === "Three Wheeler") {
        $PN = $product;                         
    }elseif ($product === "Dual Purpose") {
        $PN = $product;                         
    }elseif ($product === "Lorry") {
        $PN = $product;
    }elseif ($product === "Tractor") {
        $PN = $product;
    }
     else {    
        $PN = "";
    }
                                                $u_PN = strtoupper($PN);

    $branchcode = $_SESSION['branch'];
    $sql = "SELECT * FROM tbl_branch where b_code = '$branchcode' ";
        $result = $con->query($sql);
   
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $b_name = $row['b_name'];         $u_b_name = strtoupper($b_name);
        } else {
            
        }
    $date = date('d/m/Y');

        class PDF_Rotate extends FPDF
        {
            var $angle = 0;
        
            function Rotate($angle, $x = -1, $y = -1)
            {
                if ($x == -1)
                    $x = $this->x;
                if ($y == -1)
                    $y = $this->y;
                if ($this->angle != 0)
                    $this->_out('Q');
                $this->angle = $angle;
                if ($angle != 0) {
                    $angle *= M_PI / 180;
                    $c = cos($angle);
                    $s = sin($angle);
                    $cx = $x * $this->k;
                    $cy = ($this->h - $y) * $this->k;
                    $this->_out(sprintf(
                        'q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',
                        $c,
                        $s,
                        -$s,
                        $c,
                        $cx,
                        $cy,
                        -$cx,
                        -$cy
                    ));
                }
            }
        
            function _endpage()
            {
                if ($this->angle != 0) {
                    $this->angle = 0;
                    $this->_out('Q');
                }
                parent::_endpage();
            }
        
        }
    
    $pdf = new PDF_Rotate();
    $pdf->SetAutoPageBreak(false); // Disable auto page break
    $pdf->SetMargins(140, 10, 0); // Set margins to zero
    $pdf->AddPage('P', 'A5'); // Set page size to A5
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Rotate(-90);


    $pdf->Cell(40, 10,''.$u_type. ' '.$u_PN. '  (THIRD PARTY ONLY COVER)');
    $pdf->Ln(20); 

    // Create a table with two rows
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(40, 10, 'NAME', ); // Border around the cell
    $pdf->Cell(40, 10, '        '.$u_name, ); // Border around the cell
    $pdf->Ln(); // Move to the next line

// Define the maximum width for the address text
$maxWidth = 110; // Adjust based on your PDF layout and page size
$address = $u_fullAddress;

// Calculate the lines manually
$pdf->Cell(40, 10, 'ADDRESS', 0); // Label

$x = $pdf->GetX();
$y = $pdf->GetY();

// Manually split the text into lines
$lines = [];
$currentLine = '';
$words = explode(' ', $address);

foreach ($words as $word) {
    $testLine = $currentLine . ' ' . $word;
    $width = $pdf->GetStringWidth(trim($testLine));

    if ($width <= $maxWidth) {
        $currentLine = $testLine;
    } else {
        $lines[] = trim($currentLine);
        $currentLine = $word;
    }
}
if (!empty($currentLine)) {
    $lines[] = trim($currentLine);
}

// Print the address line by line
$pdf->SetXY($x + 14, $y); // Position for the first line
foreach ($lines as $line) {
    $pdf->Cell(0, 10, $line, 0, 1); // Print each line
    $pdf->SetX($x + 14); // Maintain alignment for subsequent lines
}
$pdf->Ln(1);


    $pdf->Cell(40, 10, '', ); // Border around the cell
    $pdf->Cell(40, 10, '        '.$u_city, ); // Border around the cell
    $pdf->Ln();
    $pdf->Ln();

    $pdf->Cell(40, 10, 'POLICY NO', ); // Border around the cell
    $pdf->Cell(40, 10, '        '.$p_no, ); // Border around the cell
    $pdf->Ln();

    $pdf->Cell(40, 10, 'PERIOD', ); // Border around the cell
    $pdf->Cell(40, 10, '        '.$period, ); // Border around the cell
    $pdf->Ln();

    $pdf->Cell(40, 10, 'VEHICLE NO', ); // Border around the cell
    $pdf->Cell(40, 10, '        '.$u_v_no, ); // Border around the cell
    $pdf->Ln();

    $pdf->Cell(40, 10, 'ENGINE NO', ); // Border around the cell
    $pdf->Cell(40, 10, '        '.$u_e_no, ); // Border around the cell
    $pdf->Ln();

    $pdf->Cell(40, 10, 'CHASSIS NO', ); // Border around the cell
    $pdf->Cell(40, 10, '        '.$u_c_no, ); // Border around the cell
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 8.3, ''.$u_issued_by);
    $pdf->Cell(40, 8.3, '                                                                                                           '.$date);
    $pdf->Cell(40, 8.3, '                                          '.$u_b_name);

    // Save the PDF to a file
    $directory = 'assets/card/'; 
    $pdfFileName = $directory . $name . '.pdf';
    $pdf->Output($pdfFileName, 'F'); // 'F' saves the file to the server
    $pdf->Output($pdfFileName, 'I');
    // Display a link to download the generated PDF
    //echo '<p>Your card is ready to print. <a href="' . $pdfFileName . '" target="_blank">Download or Print PDF</a></p>';
    
    //Notification System
    $currentTime = date('Y-m-d H:i:s');
    $newNotification = [
        'message' => 'Third Party Card Issued', 
        'time' => $currentTime,
        'is_read' => false
    ];
    $_SESSION['notifications'][] = $newNotification;
    //End

} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
    
}

$con->close();

?>
<?php } ?>
