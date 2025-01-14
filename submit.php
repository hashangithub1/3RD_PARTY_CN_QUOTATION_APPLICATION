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
    $ag_code = NULL;

    // Getting Agent code
       //Select City Name form DB
       if(!empty($userid)){
        $sqlagentcode = "SELECT agent_code FROM tbl_staff WHERE id ='$userid'";
        $resultagentcode = $con->query($sqlagentcode);

        while ($rowagent = $resultagentcode->fetch_assoc()) {
            $agentCOde = $rowagent['agent_code'];
        }
    }

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strtoupper($_POST["name"]);  //Convert Name into Uppercase
    $prefix = $_POST["prefix"];
    $reg_type = strtoupper($_POST["reg_type"]);
    $reg_no = strtoupper($_POST["reg_no"]);
    $mbnumber = $_POST["mbnumber"];
    $address_01 = strtoupper($_POST["address_01"]);
    $address_02 = strtoupper($_POST["address_02"]);
    $cityCode = $_POST["city"];

    //Select City Name form DB
    if(!empty($cityCode)){
        $sqlCity = "SELECT PCO_DESC FROM tbl_city_mt WHERE PCO_CTRY_CODE = '$cityCode' ";
        $resultCity = $con->query($sqlCity);

        while ($rowCity = $resultCity->fetch_assoc()) {
            $city = $rowCity['PCO_DESC'];
        }
    }
    //END
    //$product = $_POST["product"];
    $product = $_POST["product"];
    $u_product = strtoupper($product);
    $cn_motorcar = strtoupper($_POST["cn_motorcar"]);
    $cn_motorcycle = strtoupper($_POST["cn_motorcycle"]);
    $cn_threewheel = strtoupper($_POST["cn_threewheel"]);
    $cn_dualpurpose = strtoupper($_POST["cn_dualpurpose"]);
    $cn_lorry = strtoupper($_POST["cn_lorry"]);
    $cn_tractor = strtoupper($_POST["cn_tractor"]);


    // Conditionally set $SN based on the value of $product
    if ($product === "Motor Car") {
        $SN = 'CN'.$cn_motorcar;
    } elseif ($product === "Motor Cycle") {
        $SN = 'CN'.$cn_motorcycle;
    }elseif ($product === "Three Wheeler") {
        $SN = 'CN'.$cn_threewheel;
    }elseif ($product === "Dual Purpose") {
        $SN = 'CN'.$cn_dualpurpose;
    }elseif ($product === "Lorry") {
        $SN = 'CN'.$cn_lorry;
    }elseif ($product === "Tractor") {
        $SN = 'CN'.$cn_tractor;
    }elseif ($product === "Motor Car (3RD Party)") {
        $SN = 'CN'.$cn_motorcar;
    }
        else {    
        $SN = "";
    }

    $P_value = strtoupper($_POST['product_value']);
    $P_id = strtoupper($product);
    $make_model = strtoupper($_POST["make_model"]);

    if(!empty($make_model)){
        $ret = mysqli_query($con, "SELECT m_code FROM tbl_model WHERE model ='$make_model'");
        $num = mysqli_fetch_array($ret);
        if ($num > 0)
        {
            $make_code = $num['m_code'];
        }
        else{
            $make_code = NULL;
        }
    }
    $usage_type = strtoupper($_POST["usage_type"]);
    $fuel_type = $_POST["fuel_type"];
    $registered_owner = strtoupper($_POST["registered_owner"]);
    $registration_number = strtoupper($_POST["registration_number"]);
    $engine_number = !empty($_POST['engine_number']) ? strtoupper($_POST['engine_number']) : 'NULL';
    $chassis_number = strtoupper($_POST["chassis_number"]);
    $engine_capacity = !empty($_POST['engine_capacity']) ? strtoupper($_POST['engine_capacity']) : 'NULL';
    $manualCN = $_POST["manualcnnumber"];
    $date_Start = $_POST["start_date"];
    $date_end = $_POST["end_date"];
    $date_period = $date_Start . '  -  ' . $date_end;
    $branch_added = strtoupper($_SESSION['branch']);
    $user_added = $username['username'];
    $policy_post = '1';
    $manufac_year = $_POST["manufac_year"];
    $ag_code      = !empty($_POST['ag_code']) ? $_POST['ag_code'] : null;
    $product_code = $_POST["product_code"];
    $product_value = $_POST["product_value"];
    $product_value = str_replace(array('Rs.', ','), '', $product_value);
    $product_value = (int)$product_value;  // For integer
    $receipt_number = !empty($_POST['receipt_number']) ? $_POST['receipt_number'] : null; 
    $receipt_date = !empty($_POST['receipt_date']) ? $_POST['receipt_date'] : 'NULL'; 
    $commission_amount = !empty($_POST['commission_amount']) ? $_POST['commission_amount'] : 0;
    $commission_amount = str_replace(array('Rs.', ','), '', $commission_amount);
    $commission_amount = (int)$commission_amount;  // For integer

    //Variable Declaration For Receipt
    $availableAmount = NULL;
    $spentAmount = NULL;
    $availableAmount = NULL;
    //End

 // ========= RECEIPT VALIDATION ========== //

    if(!empty($receipt_number)){
        $sqlreceipt = "SELECT available_amount, spent_amount FROM tbl_receipt WHERE receipt_no ='$receipt_number'";
        $resultreceipt = $con->query($sqlreceipt);

        //Receipt Number Validation
        if ($resultreceipt->num_rows > 0){

        while ($rowreceipt = $resultreceipt->fetch_assoc())
            {
            $availableAmount = $rowreceipt['available_amount'];
            $spentAmount = $rowreceipt['spent_amount'];
            }
        $Spent_prod_Amount = ($product_value - $commission_amount);
        if($Spent_prod_Amount > $availableAmount)
            {
                echo "<script>alert('Insufficient Credit Limit!');</script>";
                exit();
            }
            else
            {
                $availableAmount -= $Spent_prod_Amount;
                $spentAmount += $Spent_prod_Amount;
            }
        }
    }
    // ========= END RECEIPT VALIDATION ========== //
    
    //   echo '<pre>';
    //              print_r($_POST);
    //              echo '</pre>';
    //              exit();

    //Agent code logic
    if(!empty($ag_code)){
        $agentCOde = $ag_code;
    }
                //  echo '<pre>';
                //  print_r($_POST);
                //  echo '</pre>';
                //  exit();

    date_default_timezone_set('Asia/Colombo');
    $print_time = date('h:i A');

    // ========= DATA VALIDATION ========== //

        // Check if the generated cover note number already exists in the database
        $checkExistingSql = "SELECT cover_note_number FROM tbl_insurance WHERE cover_note_number = '$SN'";
        $resultExisting = $con->query($checkExistingSql);
    
        if ($resultExisting->num_rows > 0) {
            echo "<script>alert('Cover note number already exists. Please try again.');</script>";
            echo "<script type='text/javascript'> document.location = 'manage_thirdparty.php'; </script>";
            exit();
        }
    
        
    
            // Check if the registration number already exists in the database
        $checkRegistrationSql = "SELECT registration_number FROM tbl_insurance WHERE registration_number = '$registration_number'";
        $resultRegistration = $con->query($checkRegistrationSql);
    
        if ($resultRegistration->num_rows > 0) {
            echo "<script>alert('Registration number already exists. Please try again.');</script>";
            echo "<script type='text/javascript'> document.location = 'manage_thirdparty.php'; </script>";
            exit();
        }
    
        // Check if the engine number already exists in the database
        $checkEngineSql = "SELECT engine_number FROM tbl_insurance WHERE engine_number = '$engine_number'";
        $resultEngine = $con->query($checkEngineSql);
    
        if ($resultEngine->num_rows > 0) {
            echo "<script>alert('Engine number already exists. Please try again.');</script>";
            echo "<script type='text/javascript'> document.location = 'manage_thirdparty.php'; </script>";
            exit();
        }
    
        // Check if the chassis number already exists in the database
        $checkChassisSql = "SELECT chassis_number FROM tbl_insurance WHERE chassis_number = '$chassis_number'";
        $resultChassis = $con->query($checkChassisSql);
    
        if ($resultChassis->num_rows > 0) {
            echo "<script>alert('Chassis number already exists. Please try again.');</script>";
            echo "<script type='text/javascript'> document.location = 'manage_thirdparty.php'; </script>";
            exit();
        }
        
    // Insert data into the database
    $sql = "INSERT INTO tbl_insurance ( prefix, name, reg_type, reg_no, mobile_number, address_01, address_02, city, city_code,  product, cover_note_number, manual_cn_number, make_model, make_code, year_of_manufac, usage_type, fuel_type, registered_owner, registration_number, engine_number, chassis_number, engine_capacity, receipt_number, receipt_date, valid_period, issued_date, issued_time, branch_added, issued_by, agent_code, policy_post)
            VALUES ('$prefix', '$name', '$reg_type', '$reg_no', '$mbnumber', '$address_01', '$address_02', '$city', '$cityCode', '$u_product', '$SN', '$manualCN', '$make_model', '$make_code', '$manufac_year', '$usage_type', '$fuel_type', '$registered_owner', '$registration_number', ". ($engine_number === 'NULL' ? "NULL" : "'$engine_number'") . ", '$chassis_number', ". ($engine_capacity === 'NULL' ? "NULL" : "'$engine_capacity'") . ", '$receipt_number', " . ($receipt_date === 'NULL' ? "NULL" : "'$receipt_date'") . ", '$date_period', '$date_Start', '$print_time', '$branch_added', '$user_added', '$agentCOde', '$policy_post')";

    // ========= DATA VALIDATION ========== //
    
 // ========= INSERT RECEIPT DATA ========== //
    if (!empty($receipt_number)){
    $sqlreceiptupdate = "UPDATE tbl_receipt 
    SET spent_amount = '$spentAmount', available_amount = '$availableAmount' 
    WHERE receipt_no = '$receipt_number' AND status = 1";

    $sqlreceiptupdatehistory = "INSERT INTO tbl_receipt_history (receipt_no, prod_code, covernote_no, commission_amount, deduct_amount)
    VALUES ('$receipt_number', '$product_code', '$SN', '$commission_amount', '$Spent_prod_Amount')";
    
    if ($con->query($sqlreceiptupdate) === TRUE) {
        $con->query($sqlreceiptupdatehistory);
    } else {
        echo "Error updating Receipt record: " . $con->error;
        exit();
    }
    }
    // ========= END INSERT RECEIPT DATA ========== //
    
if ($con->query($sql) === TRUE) {
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<div style="color:green;">Data submitted successfully!</div>';
    }


class PDF extends FPDF
{
    
    // Page header
    function Header()
    {   
        date_default_timezone_set('Asia/Colombo');

        $name = strtoupper($_POST["name"]);

        $productname = strtoupper($_POST["product"]);
        $product = $_POST["product"];
        $cn_motorcar = strtoupper($_POST["cn_motorcar"]);
        $cn_motorcycle = strtoupper($_POST["cn_motorcycle"]);
        $cn_threewheel = strtoupper($_POST["cn_threewheel"]);
        $cn_dualpurpose = strtoupper($_POST["cn_dualpurpose"]);
        $cn_lorry = strtoupper($_POST["cn_lorry"]);
        $cn_tractor = strtoupper($_POST["cn_tractor"]);


        // Conditionally set $SN based on the value of $product
        if ($product === "Motor Car") {
            $SN = 'CN'.$cn_motorcar;
        } elseif ($product === "Motor Cycle") {
            $SN = 'CN'.$cn_motorcycle;
        }elseif ($product === "Three Wheeler") {
            $SN = 'CN'.$cn_threewheel;
        }elseif ($product === "Dual Purpose") {
            $SN = 'CN'.$cn_dualpurpose;
        }elseif ($product === "Lorry") {
            $SN = 'CN'.$cn_lorry;
        }elseif ($product === "Tractor") {
            $SN = 'CN'.$cn_tractor;
        }
         else {    
            $SN = "";
        }

        $nic = strtoupper($_POST["reg_no"]);
        $mbnumber = $_POST["mbnumber"];
        $address_01 = strtoupper($_POST["address_01"]);
        $address_02 = strtoupper($_POST["address_02"]);
        $city = strtoupper($_POST["city"]);
        //Select City Name form DB
        if(!empty($cityCode)){
            $sqlCity = "SELECT PCO_DESC FROM tbl_city_mt WHERE PCO_CTRY_CODE = '$cityCode' ";
            $resultCity = $con->query($sqlCity);

            while ($rowCity = $resultCity->fetch_assoc()) {
                $city = $rowCity['PCO_DESC'];
            }
        }
        //END
        $fullAddress = $address_01 . ', ' . $address_02 . ', ' . $city;
        $P_value = strtoupper($_POST['product_value']);
        $make_model = strtoupper($_POST["make_model"]);
        $usage_type = strtoupper($_POST["usage_type"]);
        $registered_owner = strtoupper($_POST["registered_owner"]);
        $registration_number = strtoupper($_POST["registration_number"]);
        $engine_number = strtoupper($_POST["engine_number"]);
        $chassis_number = strtoupper($_POST["chassis_number"]);
        $engine_capacity = strtoupper($_POST["engine_capacity"]);
        $manualCN = strtoupper($_POST["manualcnnumber"]);

        if (isset($manualCN) && !empty($manualCN)) {
            $CN_number = $manualCN;
        } else {
            $CN_number = $SN;
        }

        $date_Start = $_POST["start_date"];
        $date_end = $_POST["end_date"];
        $date_period = $date_Start . '  -  ' . $date_end;
        $u_b_name = $_POST["branchname"];
        $date = date('Y-m-d');
        $currentTime = date('h:i A');

        // Logo
        $this->Image('logo.png', 10, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title without border and aligned to the right
        $this->Cell(30, 0, '                      Motor 3rd Party Cover Note', 0, 0, 'L');
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(500, 17, '                                                  '.$CN_number, 0, 0, 'L');
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
         $this->Cell(95, 5, '   Name of Participant:', 1);
         $this->Cell(95, 5, '   '.$name, 1, 1);
         $this->Cell(95, 5, '   Registered Owner Name:', 1);
         $this->Cell(95, 5, '   '.$registered_owner, 1, 1);
         $this->Cell(95, 5, '   Postal Address:', 1);
         $this->MultiCell(95, 5, '   '.$fullAddress, 1);
         $this->Cell(95, 5, '   NIC No. / Business Reg. No.:', 1);
         $this->Cell(95, 5, '   '.$nic, 1, 1);
         $this->Cell(95, 5, '   Mobile No:', 1);
         $this->Cell(95, 5, '   '.$mbnumber, 1, 1);
         $this->Cell(95, 5, '   Usage:', 1);
         $this->Cell(95, 5, '   '.$usage_type, 1, 1);
         $this->Cell(95, 5, '   Period of Takaful (Insurance):', 1);
         $this->Cell(95, 5, '   '.$date_period, 1, 1);
         $this->Cell(95, 5, '   This Cover Note is Valid for a 
Maximum Period of 30 DAYS from:', 1);
         $this->Cell(95, 5, '   '.$date_Start, 1, 1);

        // Add table
        $this->Ln(4); // Add some space before the table
        $this->SetFillColor(196, 196, 196); // Set fill color for the header row
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(95, 5, 'Type of Vehicle', 1, 0, 'C', true);
        $this->Cell(95, 5, 'Annual Takaful Contribution (Premium)', 1, 1, 'C', true);
 
         // Table content
         $this->SetFont('Arial', '', 7);
         $this->Cell(95, 5, '   '.$productname, 1);
         $this->Cell(95, 5, '   '.$P_value, 1, 1);

         // Add table
         $this->Ln(4); // Add some space before the table
         $this->SetFillColor(196, 196, 196); // Set fill color for the header row
         $this->SetFont('Arial', 'B', 7);
 
         // Table content
         $this->SetFont('Arial', '', 7);
         $this->Cell(95, 5, '   1. Vehicle Make and Model', 1);
         $this->Cell(95, 5, '   '.$make_model, 1, 1);

         $this->Cell(95, 5, '   2. Registration No.', 1);
         $this->Cell(95, 5, '   '.$registration_number, 1, 1);

         $this->Cell(95, 5, '   3. Engine No.', 1);
         $this->Cell(95, 5, '   '.$engine_number, 1, 1);

         $this->Cell(95, 5, '   4. Chassis No.', 1);
         $this->Cell(95, 5, '   '.$chassis_number, 1, 1);

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

         $this->Cell(0, -3, '                                                                                                                                                                                                                               '.$date, 0, 1);
         $this->Cell(0, 5, 'Place : ..................................                                                                                                                                                                   Date : ..................................', 0, 1);
         $this->Cell(0, 5, '                                                                                                                                                                                                                 Time : ..................................', 0, 1);
         $this->Cell(0, -7, '                                                                                                                                                                                                                                '.$currentTime, 0, 1);
         $this->SetFont('Arial', 'B', 7);
         $this->Ln(15); 
         $this->Cell(0, 5, 'This is a computer generated document, no signature is required         ', 0, 1);
         $this->SetFont('Arial', '', 7);
         $this->Cell(0, 5, '                                                                                                                                                                                     ........................................... ', 0, 1);
         $this->Cell(0, 5, '          
                                                                                                                                                                                Participant Signature', 0, 1);

         $this->Ln(8); 
         $this->Cell(0, 5, 'Branch : ..................................                                                                                                This document is to be cosidered as the official receipt for the payment made.', 0, 1);
         $this->Cell(0, -8, '                   '.$u_b_name, 0, 1);
         $this->Ln(10);
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
    $this->Image('footer-logo1.png', 6, $this->GetY() + -3, 55);
    //$this->Cell(0, 3, '660-1/1, Galle Road, Colombo 03, Sri Lanka.', 0, 1, 'L');
    //$this->Cell(0, 3, 'Tel : 94-11-7501000 ; Fax: 94-11-7501097/2597429', 0, 1, 'L');
    //$this->Cell(0, 3, 'E-mail : info@takaful.lk ; Website : www.takaful.lk', 0, 1, 'L');

    // Add the main logo on the right side of the footer
    $this->Image('footer-logo.png', $this->GetPageWidth() - 50, $this->GetY() + -3, 40);
}
}

// Instanciation of inherited class with A4 page size
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

// Add a page border
$pdf->SetLineWidth(0.5);
$pdf->Rect(5, 5, $pdf->GetPageWidth() - 10, $pdf->GetPageHeight() - 10);
$pdf->SetLineWidth(0.1); // Resetting the line width to the default value

        $directory = 'assets/cover_note/'; 
        $pdfFileName = $directory . $name . '.pdf';
        $pdf->Output($pdfFileName, 'F'); // 'F' saves the file to the server
        $pdf->Output($pdfFileName, 'I');
        //$pdf->Output('Cover_Note.pdf', 'I');

    //Notification System
    $currentTime = date('Y-m-d H:i:s');
    $newNotification = [
        'message' => 'Third Party Cover Issued', 
        'time' => $currentTime,
        'is_read' => false
    ];
    $_SESSION['notifications'][] = $newNotification;
    //End

    exit();
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
    
}


$con->close();

?>
<?php } ?>
