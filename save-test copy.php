<?php session_start();
include_once('includes/config.php');
//Getting Session data
$quote_no = !empty($_SESSION['quote_no']) ? $_SESSION['quote_no'] : null;
$clientName = !empty($_SESSION['clientName']) ? $_SESSION['clientName'] : null;
$clientAddress = !empty($_SESSION['clientAddress']) ? $_SESSION['clientAddress'] : null;
$mobile_number = !empty($_SESSION['mobile_number']) ? $_SESSION['mobile_number'] : null;
$email_address = !empty($_SESSION['email_address']) ? $_SESSION['email_address'] : null;
$vehiregNo = !empty($_SESSION['regNo']) ? $_SESSION['regNo'] : null;
$registrationStatus = !empty($_SESSION['registrationStatus']) ? $_SESSION['registrationStatus'] : null;
$makeModel = !empty($_SESSION['makeModel']) ? $_SESSION['makeModel'] : null;
$seatingCapacity = !empty($_SESSION['seatingCapacity']) ? $_SESSION['seatingCapacity'] : null;
$manufactureYear = !empty($_SESSION['manufactureYear']) ? $_SESSION['manufactureYear'] : null;
$fuelType = !empty($_SESSION['fuelType']) ? $_SESSION['fuelType'] : null;
$vehiusage = !empty($_SESSION['usage']) ? $_SESSION['usage'] : null;
$sumInsured = !empty($_SESSION['sumInsured']) ? $_SESSION['sumInsured'] : null;
$sumInsured = preg_replace('/[^\d]/', '', $sumInsured);
$datefrom = !empty($_SESSION['datefrom']) ? $_SESSION['datefrom'] : null;
$dateto = !empty($_SESSION['dateto']) ? $_SESSION['dateto'] : null;
$datePeriod = $datefrom .' - '. $dateto;
$branch = !empty($_SESSION['branch']) ? $_SESSION['branch'] : null;

$userid = $_SESSION['id'];
$query = mysqli_query($con, "select * from tbl_staff where id='$userid'");
// Assuming you have only one result for the user
$username = mysqli_fetch_array($query);
$B_username = $username['username'];
$calDate = date('Y-m-d');

$prodcode = !empty($_SESSION['product']) ? $_SESSION['product'] : null;
$compCode = !empty($_SESSION['companycode_form']) ? $_SESSION['companycode_form'] : null;
$totalPremium = !empty($_SESSION['TotalContribution']) ? $_SESSION['TotalContribution'] : null;

//These are array values
$vat_chargers = !empty($_SESSION['vat_chargers']) ? $_SESSION['vat_chargers'] : null;

// Retrieve the VAT chargers array from the session
if (isset($_SESSION['vat_chargers'])) {
    $VAT_chargers = $_SESSION['vat_chargers'];
    $VATChargers = 0;

    foreach ($VAT_chargers as $vatcharger) {
        $cover_des_B = $vatcharger['cover'];
        $premium = $vatcharger['premium'];
        $premium = str_replace(',', '', $premium);
        $VATChargers = $VATChargers + $premium;
    }
} else {
    // echo "No admin chargers data found in session.";
}
// End
$admin_chargers = !empty($_SESSION['admin_chargers']) ? $_SESSION['admin_chargers'] : null;

// Retrieve the admin chargers array from the session
if (isset($_SESSION['admin_chargers'])) {
    $admin_chargers = $_SESSION['admin_chargers'];
    $adminChargers = NULL;

    foreach ($admin_chargers as $charger) {
        $cover_des_B = $charger['cover'];
        $premium = $charger['premium'];
        $adminChargers += $premium;
    }
} else {
    // echo "No admin chargers data found in session.";
}
// End
// Retrieve the SSCL chargers array from the session
if (isset($_SESSION['sscl_chargers'])) {
    $SSCL_chargers = $_SESSION['sscl_chargers'];
    $SSCLChargers = 0;

    foreach ($SSCL_chargers as $ssclcharger) {
        $cover_des_B = $ssclcharger['cover'];
        $premium = $ssclcharger['premium'];
        $premium = str_replace(',', '', $premium);
        $SSCLChargers = $SSCLChargers + $premium;
    }
} else {
    // echo "No admin chargers data found in session.";
}
// End
//admin chargers recal
$adminChargers += $SSCLChargers;
//end
//End

$printStatus = 1;

// Getting cover details form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to check and convert array to string if needed
    function checkAndConvert($var) {
        if (is_array($var)) {
            return implode(", ", $var);
        } else {
            // Check if the value contains commas (indicating a formatted number)
            if (strpos($var, ',') !== false) {
                // Remove commas and convert to float
                $var = str_replace(',', '', $var);
                return floatval($var);
            } else {
                // Otherwise, return the value as is
                return $var;
            }
        }
    }

    $cover_premium_pairs = [
        ['cover_code' => checkAndConvert($_POST['cover_code_T']), 'cover_amt' => checkAndConvert($_POST['premium_T'])],
        ['cover_code' => checkAndConvert($_POST['cover_code_B']), 'cover_amt' => checkAndConvert($_POST['premium_B'])],
        ['cover_code' => checkAndConvert($_POST['cover_code_B_ADM']), 'cover_amt' => checkAndConvert($_POST['premium_B_ADM'])],
        ['cover_code' => checkAndConvert($_POST['cover_code_B_ADM1']), 'cover_amt' => checkAndConvert($_POST['premium_B_ADM1'])],
        ['cover_code' => checkAndConvert($_POST['cover_code_B_ADMT']), 'cover_amt' => checkAndConvert($_POST['premium_B_ADMT'])]
    ];

    foreach ($cover_premium_pairs as $pair) {
        $cover_codes = explode(", ", $pair['cover_code']);
        $cover_amts = explode(", ", $pair['cover_amt']);

        // Loop through each cover code and corresponding amount
        for ($i = 0; $i < max(count($cover_codes), count($cover_amts)); $i++) {
            $cover_code = isset($cover_codes[$i]) ? $cover_codes[$i] : '';
            $cover_amt = isset($cover_amts[$i]) ? $cover_amts[$i] : '';

            if (!empty($cover_code) || !empty($cover_amt)) {
                echo "Cover Code: $cover_code, Cover Amount: $cover_amt<br>";
                // Database insertion query
                $sql = "INSERT INTO quotation_cover_mt (quote_no, cover_code, cover_amt, print_flag, print_seq, cover_sumins, cal_date) 
                        VALUES ('$quote_no', '$cover_code', '$cover_amt', '$printStatus', '$printStatus', '$cover_amt', '$calDate')";

            if ($con->query($sql) === TRUE) {
                echo "Record inserted successfully.<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
            } else {
                echo "Missing cover code or amount.<br>";
            }
        }
    }
}

// Insert data into quotation_mt table
$sql_mt = "INSERT INTO quotation_mt (quote_no, comp_codce, prod_code, class_code, cus_name, cus_address, cus_mobile, cus_email, vehi_number, vehi_reg_status, vehi_make_model, vehi_seating_capacity, vehi_year_of_manu, vehi_fuel_type, vehi_usage, sum_ins, date_period, tot_premium, vat_amt, pol_fee, ssl_amt, admin_fee, prnt_status, cal_date, user_ID, user_brnch) 
           VALUES ('$quote_no','$compCode','$prodcode','NULL','$clientName','$clientAddress','$mobile_number','$email_address','$vehiregNo','$registrationStatus','$makeModel','$seatingCapacity','$manufactureYear','$fuelType','$vehiusage','$sumInsured','$datePeriod','$totalPremium','$VATChargers','0','0','$adminChargers','$printStatus','$calDate','$B_username','$branch')";
if (!mysqli_query($con, $sql_mt)) {
    echo "Error: " . mysqli_error($con) . "<br>";
} else {
    echo "Quotation_mt record inserted successfully.<br>";
}
  // End 


  //Generata PDF
  // Print PDF
$quote_no = !empty($_SESSION['quote_no']) ? $_SESSION['quote_no'] : null;
$clientName = !empty($_SESSION['clientName']) ? $_SESSION['clientName'] : null;
$regNo  =   !empty($_SESSION['regNo']) ? $_SESSION['regNo'] : null;
$makeModel = !empty($_SESSION['makeModelDesc']) ? $_SESSION['makeModelDesc'] : null;
$usage = !empty($_SESSION['usage']) ? $_SESSION['usage'] : null;
$vehicleBrand = !empty($_SESSION['makeModelDesc']) ? $_SESSION['makeModelDesc'] : null;
$datefrom = !empty($_SESSION['datefrom']) ? $_SESSION['datefrom'] : null;
$dateto = !empty($_SESSION['dateto']) ? $_SESSION['dateto'] : null;
$datePeriod = $datefrom .' - '. $dateto;
$manufactureYear = !empty($_SESSION['manufactureYear']) ? $_SESSION['manufactureYear'] : null;
$fuelTypeName = !empty($_SESSION['fuelTypeName']) ? $_SESSION['fuelTypeName'] : null;
$product = !empty($_SESSION['product']) ? $_SESSION['product'] : null;
$companyProduct = !empty($_SESSION['companyname_form']) ? $_SESSION['companyname_form'] : null;
$sumInsured = !empty($_SESSION['sumInsured']) ? $_SESSION['sumInsured'] : null;
$basicPremium = !empty($_SESSION['basic_premium']) ? $_SESSION['basic_premium'] : null;
$basicPremium = number_format($basicPremium, 2);
$subjectToTax = !empty($_SESSION['GrossContribution_tot02']) ? $_SESSION['GrossContribution_tot02'] : null;
$totalContribution = !empty($_SESSION['TotalContribution']) ? $_SESSION['TotalContribution'] : null;


// product type
$sql = "SELECT product_des FROM tbl_product_mt WHERE product_code = 'V001'";
                    $result = $con->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $vehiType = $row['product_des'];
                    } 
                    $vehiType = preg_replace('/\s*\(.*?\)\s*/', '', $vehiType);
//end

// Retrieve the admin chargers array from the session
if (isset($_SESSION['admin_chargers'])) {
    $admin_chargers = $_SESSION['admin_chargers'];
    $adminChargers = NULL;

    foreach ($admin_chargers as $charger) {
        $cover_des_B = $charger['cover'];
        $premium = $charger['premium'];
        $adminChargers += $premium;
    }
} else {
    // echo "No admin chargers data found in session.";
}
// End

// Retrieve the SSCL chargers array from the session
if (isset($_SESSION['sscl_chargers'])) {
    $SSCL_chargers = $_SESSION['sscl_chargers'];
    $SSCLChargers = 0;

    foreach ($SSCL_chargers as $ssclcharger) {
        $cover_des_B = $ssclcharger['cover'];
        $premium = $ssclcharger['premium'];
        $premium = str_replace(',', '', $premium);
        $SSCLChargers = $SSCLChargers + $premium;
    }
} else {
    // echo "No admin chargers data found in session.";
}
// End
//admin chargers recal
$adminChargers += $SSCLChargers;
//end
// Retrieve the VAT chargers array from the session
if (isset($_SESSION['vat_chargers'])) {
    $VAT_chargers = $_SESSION['vat_chargers'];
    $VATChargers = 0;

    foreach ($VAT_chargers as $vatcharger) {
        $cover_des_B = $vatcharger['cover'];
        $premium = $vatcharger['premium'];
        $premium = str_replace(',', '', $premium);
        $VATChargers = $VATChargers + $premium;
    }
} else {
    // echo "No admin chargers data found in session.";
}
// End

// Retrieve the SRCC TC chargers array from the session
if (isset($_SESSION['srccTC_chargers'])) {
    $SRCCTC_chargers = $_SESSION['srccTC_chargers'];
    
    // Initialize variables to store the premiums
    $srcc_premium = 0;
    $tc_premium = 0;

    foreach ($SRCCTC_chargers as $srtccharger) {
        $cover_des_B = $srtccharger['cover'];
        $premium = $srtccharger['premium'];
        $premium = str_replace(',', '', $premium);

        // Check cover description and assign premium to corresponding variable
        if ($cover_des_B == "SRCC on Vehicle") {
            $srcc_premium = $premium;
        } elseif ($cover_des_B == "Terrorism Cover on Vehicle ") {
            $tc_premium = $premium;
        }
    }

    // Now $srcc_premium and $tc_premium hold the respective premium values
    // You can use them as needed, for example, inserting them into a database
} else {
    // echo "No admin chargers data found in session.";
}
// End



//PDF NAME
if(!empty($regNo))
{
    $PDFname = $regNo;
}
else
{
    $PDFname = "Doc";
}

//date
$issueddate = date('Y-m-d');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(92, 103, 113);
        $this->SetY(8);
        $this->Image('images/header-logo.png', 10, 5, 50);
        
        $this->SetY(8);
        $this->SetX(80); 
        $this->SetTextColor(129, 189, 67);
        $this->Cell(0, 5, 'TOTAL DRIVE', 0, 1, 'R'); 
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(80); 
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(93, 103, 113);
        $this->Cell(0, 5, 'A HASSLE FREE', 0, 1, 'R');
        $this->SetX(80); 
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(0, 5, 'MORTOR INSURENCE', 0, 1, 'R'); 
        $this->Ln(0);
        $this->RoundedRect(5, 5, 200, 270, 5);
    }

    // Custom function to draw a rounded rectangle
    function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op = 'f';
        elseif($style=='FD' || $style=='DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x+$r)*$k, ($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k, ($hp-$y)*$k ));
        $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k, ($hp-($y+$h-$r))*$k));
        $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l', ($x+$r)*$k, ($hp-($y+$h))*$k));
        $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', ($x)*$k, ($hp-($y+$r))*$k ));
        $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    // Arc helper function
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', 
            $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k,
            $x3*$this->k, ($h-$y3)*$this->k));
    }
}

$pdf = new PDF('P', 'mm', 'A4'); 
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(0, 5, 'Motor Insurance Quotation', 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 5, 'We greatly appreciate your interest in our services and thank you for requesting a quotation for your insurance needs. We are
 pleased to share our', 0, 1, 'L');
$pdf->Cell(0, 3, 'terms and conditions for your review, based on the information provided.', 0, 1, 'L');

$pdf->Ln(2);

// Divider
$pdf->SetDrawColor(93, 103, 113); 
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(95, 4, 'Name of the Participant      :'.'    '.$clientName);
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, 'Period of Cover                     :'.'     '.$datePeriod, 0, 1);

$pdf->Cell(95, 4, 'Registration Number           :'.'   '.$regNo);
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, 'Year of Manufacture              :'.'    '.$manufactureYear, 0, 1);

$pdf->Cell(95, 4, 'Vehicle Brand                     :'.'   '.$vehicleBrand);
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, 'Fuel Type                               :'.'    '.$fuelTypeName, 0, 1);

$pdf->Cell(95, 4, 'Make / Model                      :'.'   '.$makeModel);
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, 'Type of Vehicle                      :'.'    '.$vehiType, 0, 1);

$pdf->Cell(95, 4, 'Usage                                 :'.'   '.$usage);
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, 'Financial Institution / Bank     :'.'    '.$companyProduct, 0, 1);

$pdf->Ln(1);

$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 7, 3, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 6, 'Takaful Contribution', 0, 1, 'L');

$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(213, 219, 225);
$pdf->SetTextColor(0, 0, 0);
$pdf->RoundedRect(10, $pdf->GetY(), 100, 7, 3, 'F');
$pdf->SetXY(10, $pdf->GetY() + 2);
$pdf->Cell(95, 4, '     Sum Insured', 0, 0, 'L'); 
$pdf->Cell(-5, 4, $sumInsured, 0, 1, 'R');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(95, 12, '     Basic Contribution', 0, 0, 'L'); 
$pdf->Cell(-5, 11, 'Rs. '. $basicPremium, 0, 1, 'R');
$pdf->Cell(95, 0, '     SRCC Contribution', 0, 0, 'L'); 
$pdf->Cell(-5, 0, 'Rs. '. $srcc_premium = number_format($srcc_premium,2), 0, 1, 'R');
$pdf->Cell(95, 10, '     TC Contribution', 0, 0, 'L'); 
$pdf->Cell(-5, 10, 'Rs. '. $tc_premium = number_format($tc_premium,2), 0, 1, 'R');

$pdf->Image('images/call-and-go.jpg', 130, 80, 60);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(213, 219, 225);
$pdf->SetTextColor(0, 0, 0);
$pdf->RoundedRect(10, $pdf->GetY(), 100, 7, 3, 'F');
$pdf->SetXY(10, $pdf->GetY() + 2);
$pdf->Cell(95, 4, '     Subject to Tax', 0, 0, 'L'); 
$pdf->Cell(-5, 4,'Rs. '. $subjectToTax = number_format($subjectToTax,2), 0, 1, 'R');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(95, 12, '     Admin Charges', 0, 0, 'L'); 
$pdf->Cell(-5, 11, 'Rs. '.$adminChargers, 0, 1, 'R');
$pdf->Cell(95, 0, '     VAT', 0, 0, 'L'); 
$pdf->Cell(-5, 0, 'RS. '.$VATChargers = number_format($VATChargers,2), 0, 1, 'R');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(213, 219, 225);
$pdf->SetTextColor(0, 0, 0);
$pdf->RoundedRect(10, $pdf->GetY(), 100, 7, 3, 'F');
$pdf->SetXY(10, $pdf->GetY() + 2);
$pdf->Cell(95, 4, '     Total Contribution', 0, 0, 'L'); 
$pdf->Cell(-5, 4, 'Rs. '. $totalContribution = number_format($totalContribution,2), 0, 1, 'R');

$pdf->Ln(3);

$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 7, 3, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 6, 'Exclusive Total Drive Benefits', 0, 1, 'L');

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(95, 4, '          * Accidental damage, Fire & Theft');
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, '* Third-party death & bodily injury - Unlimited', 0, 1);

$pdf->Cell(95, 4, '          * Flood & natural perils');
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, '* Third-party property damage - up to Rs. 20,000,000/', 0, 1);

$pdf->Cell(95, 4, '          * Theft of parts');
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, '* Alternative transportation', 0, 1);

$pdf->Cell(95, 4, '          * Airbag cover');
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, '         -   sum covered up to Rs.2.5 Mn - Rs.2,500/- per day', 0, 1);

$pdf->Cell(95, 4, '          * Accidental injury hospitalization cover');
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, '         -   sum covered exceeding Rs.2.5 Mn - R.3,500/- per day', 0, 1);

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 7, 3, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 6, 'Optional Covers', 0, 1, 'L');

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(95, 4, '          * Strikes, riots & civil commotion');
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, '* PAB cover up to Rs. 500,000/- for 4 passengers', 0, 1);

$pdf->Cell(95, 4, '          * Terrorism cover');
$pdf->Cell(10, 4, '', 0); 
$pdf->Cell(95, 4, '* Towing charges - up to Rs. 7500/-', 0, 1);

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 7, 3, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 6, 'Special Notes', 0, 1, 'L');

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(0, 5, '          * This quotation is offered based on the information provided by the proposer and is subject to revision upon changes to the risk', 0, 1, 'L');
$pdf->Cell(0, 3, '          * This quotation is valid for 30 days from the date of issue.', 0, 1, 'L');
$pdf->Cell(0, 3, '          * This quotation is only valid only for leasing/finance customers of Vallibel Finance PLC.', 0, 1, 'L');
$pdf->Cell(0, 3, '          * This quotation cannot be combined with any other existing packages, and the above premiums cannot be discounted by producing No Claims', 0, 1, 'L');
$pdf->Cell(0, 3, '             Bonus certificates.', 0, 1, 'L');
$pdf->Cell(0, 3, '          * Premiums at the renewal may change due to claims experience and change in Government Fiscal policy/IRCSL regulation/NITF guidelines', 0, 1, 'L');
$pdf->Cell(0, 3, '            otherwise remain as it is.', 0, 1, 'L');
$pdf->Cell(0, 3, '          * The above quoted terms are deemed null & void if the vehicle is found already insured with Amana Takaful Insurance and/or quoted under', 0, 1, 'L');
$pdf->Cell(0, 3, '            any other active package at the time of confirming the business.', 0, 1, 'L');
$pdf->Cell(0, 3, '          * We always advise keeping the sum insured in accordance with the market value to avoid any disputes at the time of the claim.', 0, 1, 'L');
$pdf->Cell(0, 3, '          * Extra Fittings (such as Ceramic Coating/Wrapping/Nano Coating & Any item other than the standard factory-fitted items) should be disclosed', 0, 1, 'L');
$pdf->Cell(0, 3, '            as a separate item apart from the vehicle sum insured at the offer level (Quotation) to cover under this insurance.', 0, 1, 'L');
$pdf->Cell(0, 3, '          * If any item or peril which is not mentioned/agreed in this Quotation is required or is included in the Proposal From, It is requested to inform the', 0, 1, 'L');
$pdf->Cell(0, 3, '            Insurance Company in advance to incorporate to the Policy.', 0, 1, 'L');
$pdf->Cell(0, 3, '          * Only vehicles purchased from Agents as "Brand New" are entitled to repairs at the Agent\'s Garage. All other vehicles are subject to an additional', 0, 1, 'L');
$pdf->Cell(0, 3, '            excess of 20%, if repaired at the Agent\'s garage.', 0, 1, 'L');
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 5, 'We trust that the above terms are acceptable and look forward to hearing a positive response from you. If you have any clarification,', 0, 1, 'L');
$pdf->Cell(0, 3, 'please do not hesitate to contact us.', 0, 1, 'L');
$pdf->Ln(3);
// Divider
$pdf->SetDrawColor(93, 103, 113); 
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(3);
$pdf->Cell(0, 3, 'This is a computer-generated quotation, hence no signature is required.', 0, 1, 'C');
$pdf->Cell(0, 5, 'Reference:'.' '.$companyProduct.' | Issued Date:'.' '.$issueddate.' | Quotation No: '.$quote_no, 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(0, 7, 'Amana Takaful PLC (PQ23)', 0, 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(0, 0, 'No:660-1/1, Galle Road, Colombo 03, Sri Lanka | Tel : +94 11 7501000 | Fax: +94 11 750 1097 / 2597429 | E-mail : info@takaful.lk | Website : www.takaful.lk', 0, 1, 'C');
$pdf->Cell(0, 8, 'V-01.00.001-3000Beta', 0, 1, 'L');

$pdf->Output($PDFname, 'I');
?>