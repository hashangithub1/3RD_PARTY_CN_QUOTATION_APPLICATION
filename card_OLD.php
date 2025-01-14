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
        echo '<div style="color:green;">Data submitted successfully!</div>';
    }

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
        var $angle=0;

        function Rotate($angle,$x=-1,$y=-1)
        {
            if($x==-1)
                $x=$this->x;
            if($y==-1)
                $y=$this->y;
            if($this->angle!=0)
                $this->_out('Q');
            $this->angle=$angle;
            if($angle!=0)
            {
                $angle*=M_PI/180;
                $c=cos($angle);
                $s=sin($angle);
                $cx=$x*$this->k;
                $cy=($this->h-$y)*$this->k;
                $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
            }
        }

        function _endpage()
        {
            if($this->angle!=0)
            {
                $this->angle=0;
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
    $pdf->Ln(35); 

    // Create a table with two rows
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(40, 10, 'NAME', ); // Border around the cell
    $pdf->Cell(40, 10, '        '.$u_name, ); // Border around the cell
    $pdf->Ln(); // Move to the next line

    $pdf->Cell(40, 10, 'ADDRESS', ); // Border around the cell
    $pdf->Cell(40, 10, '        '.$u_fullAddress, ); 
    $pdf->Ln();

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
