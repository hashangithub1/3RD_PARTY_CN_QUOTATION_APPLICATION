<?php session_start();
require('fpdf/fpdf.php');
include_once('includes/config.php');
//Getting Session data
$quote_no = !empty($_SESSION['mqForm_quote_no']) ? $_SESSION['mqForm_quote_no'] : null;
$NEWquote_no = !empty($_SESSION['REV_quote_no']) ? $_SESSION['REV_quote_no'] : null;
$clientName = !empty($_SESSION['mqForm_cus_name']) ? $_SESSION['mqForm_cus_name'] : null;
$clientAddress = !empty($_SESSION['mqForm_cus_address']) ? $_SESSION['mqForm_cus_address'] : null;
$mobile_number = !empty($_SESSION['mobile_number']) ? $_SESSION['mobile_number'] : null;
$email_address = !empty($_SESSION['mqForm_cus_email']) ? $_SESSION['mqForm_cus_email'] : null;
$vehiregNo = !empty($_SESSION['mqForm_vehi_number']) ? $_SESSION['mqForm_vehi_number'] : null;
$registrationStatus = !empty($_SESSION['mqForm_vehi_reg_status']) ? $_SESSION['mqForm_vehi_reg_status'] : null;
$makeModel = !empty($_SESSION['mqForm_vehi_make_model']) ? $_SESSION['mqForm_vehi_make_model'] : null;
$seatingCapacity = !empty($_SESSION['mqForm_seatingCapacity']) ? $_SESSION['mqForm_seatingCapacity'] : null;
$manufactureYear = !empty($_SESSION['mqForm_vehi_year_of_manu']) ? $_SESSION['mqForm_vehi_year_of_manu'] : null;
$fuelType = !empty($_SESSION['mqForm_vehi_fuel_type']) ? $_SESSION['mqForm_vehi_fuel_type'] : null;
$vehiusage = !empty($_SESSION['mqForm_vehi_usage']) ? $_SESSION['mqForm_vehi_usage'] : null;
$sumInsured = !empty($_SESSION['mqForm_sumins']) ? $_SESSION['mqForm_sumins'] : null;
//Sum Insured Without RS
$coverWithoutRs = str_replace(array('Rs.', ','), '', $sumInsured);
$sum_ins = (int)$coverWithoutRs;  // For integer
$basic_premium    = !empty($_SESSION['mqForm_basicPremium']) ? $_SESSION['mqForm_basicPremium'] : null;
$datePeriod = !empty($_SESSION['mqForm_date_period']) ? $_SESSION['mqForm_date_period'] : null;
$branch = !empty($_SESSION['branch']) ? $_SESSION['branch'] : null;
$ncbRate = !empty($_SESSION['FORMEDITncbRate']) ? $_SESSION['FORMEDITncbRate'] : null;
$mrRate = !empty($_SESSION['FORMEDITmrRate']) ? $_SESSION['FORMEDITmrRate'] : null;
$ncb_MRamt = !empty($_SESSION['FORMEDIT_ncb_mr_Amt']) ? $_SESSION['FORMEDIT_ncb_mr_Amt'] : null;
$rate= !empty($_SESSION['mqForm_vehiRate']) ? $_SESSION['mqForm_vehiRate'] : null;
$basicrate = !empty($_SESSION['mqForm_basicRate']) ? $_SESSION['mqForm_basicRate'] : null;

$userid = $_SESSION['id'];
$query = mysqli_query($con, "select * from tbl_staff where id='$userid'");
// Assuming you have only one result for the user
$username = mysqli_fetch_array($query);
$B_username = $username['username'];
$calDate = date('Y-m-d');

$prodcode = !empty($_SESSION['mqForm_prod_code']) ? $_SESSION['mqForm_prod_code'] : null;
$compCode = !empty($_SESSION['mqForm_comp_codce']) ? $_SESSION['mqForm_comp_codce'] : null;
$totalPremium = !empty($_SESSION['MYFORMTotalContribution']) ? $_SESSION['MYFORMTotalContribution'] : null;

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
        ['cover_code' => checkAndConvert($_POST['cover_code_T']), 'cover_amt' => checkAndConvert($_POST['initial_amt_T']),
        'cover_premium' => checkAndConvert($_POST['premium_T']), 'calc_seq' => checkAndConvert($_POST['calc_seq_T']), 'cover_area' => checkAndConvert($_POST['cover_area_T'])], 
        ['cover_code' => checkAndConvert($_POST['cover_code_B']), 'cover_amt' => checkAndConvert($_POST['initial_amt_B']),
        'cover_premium' => checkAndConvert($_POST['premium_B']), 'calc_seq' => checkAndConvert($_POST['calc_seq_B']), 'cover_area' => checkAndConvert($_POST['cover_area_B'])],
        ['cover_code' => checkAndConvert($_POST['cover_code_B_ADM']), 'cover_amt' => checkAndConvert($_POST['initial_amt_B_ADM']),
        'cover_premium' => checkAndConvert($_POST['premium_B_ADM']), 'calc_seq' => checkAndConvert($_POST['calc_seq_B_ADM']), 'cover_area' => checkAndConvert($_POST['cover_area_B_ADM'])],
        ['cover_code' => checkAndConvert($_POST['cover_code_B_ADM1']), 'cover_amt' => checkAndConvert($_POST['initial_amt_B_ADM1']),
        'cover_premium' => checkAndConvert($_POST['premium_B_ADM1']), 'calc_seq' => checkAndConvert($_POST['calc_seq_B_ADM1']), 'cover_area' => checkAndConvert($_POST['cover_area_B_ADM1'])],
        ['cover_code' => checkAndConvert($_POST['cover_code_B_ADMT']), 'cover_amt' => checkAndConvert($_POST['initial_amt_B_ADMT']),
        'cover_premium' => checkAndConvert($_POST['premium_B_ADMT']), 'calc_seq' => checkAndConvert($_POST['calc_seq_B_ADMT']), 'cover_area' => checkAndConvert($_POST['cover_area_B_ADMT'])]
    ];

    foreach ($cover_premium_pairs as $pair) {
        $cover_codes = explode(", ", $pair['cover_code']);
        $cover_amts = explode(", ", $pair['cover_amt']);
        $cover_premiums = explode(", ", $pair['cover_premium']);
        $cover_calseqs = explode(", ", $pair['calc_seq']);
        $cover_areas = explode(", ", $pair['cover_area']);

        // Loop through each cover code and corresponding amount
        for ($i = 0; $i < max(count($cover_codes), count($cover_amts),
            count($cover_premiums), count($cover_calseqs), count($cover_areas)); $i++) {
            $cover_code = isset($cover_codes[$i]) ? $cover_codes[$i] : '';
            $cover_amt = isset($cover_amts[$i]) ? $cover_amts[$i] : '';
            $cover_premium = isset($cover_premiums[$i]) ? $cover_premiums[$i] : '';
            $cover_calseq = isset($cover_calseqs[$i]) ? $cover_calseqs[$i] : '';
            $cover_area = isset($cover_areas[$i]) ? $cover_areas[$i] : '';

            if (!empty($cover_code) || !empty($cover_amt) || !empty($cover_premium) || !empty($cover_calseq) || !empty($cover_area)) {
                $cover_amt = str_replace(',', '', $cover_amt);
                $cover_premium = str_replace(',', '', $cover_premium);
            }
        }
    }
}

// generate PDF
$quote_no = !empty($_SESSION['REV_quote_no']) ? $_SESSION['REV_quote_no'] : null;
$clientName = !empty($_SESSION['mqForm_cus_name']) ? $_SESSION['mqForm_cus_name'] : null;
$regNo  =   !empty($_SESSION['mqForm_vehi_number']) ? $_SESSION['mqForm_vehi_number'] : null;
$makeModelcode = !empty($_SESSION['mqForm_vehi_make_model']) ? $_SESSION['mqForm_vehi_make_model'] : null;
$usage = !empty($_SESSION['mqForm_vehi_usage']) ? ucfirst($_SESSION['mqForm_vehi_usage']) : null;
$vehicleBrand = !empty($_SESSION['mqForm_vehi_make_model']) ? $_SESSION['mqForm_vehi_make_model'] : null;
$datePeriod = !empty($_SESSION['mqForm_date_period']) ? $_SESSION['mqForm_date_period'] : null;
$manufactureYear = !empty($_SESSION['mqForm_vehi_year_of_manu']) ? $_SESSION['mqForm_vehi_year_of_manu'] : null;
$fuelType = !empty($_SESSION['mqForm_vehi_fuel_type']) ? $_SESSION['mqForm_vehi_fuel_type'] : null;
$product = !empty($_SESSION['mqForm_prod_code']) ? $_SESSION['mqForm_prod_code'] : null;
$companyProduct = !empty($_SESSION['mqForm_comp_codce']) ? $_SESSION['mqForm_comp_codce'] : null;
$sumInsured = !empty($_SESSION['mqForm_sumins']) ? $_SESSION['mqForm_sumins'] : null;
$basicPremium = !empty($_SESSION['mqForm_basicPremium']) ? $_SESSION['mqForm_basicPremium'] : null;
//$basicPremium = number_format($basicPremium, 2);
$subjectToTax = !empty($_SESSION['MYFORMGrossContribution_tot02']) ? $_SESSION['MYFORMGrossContribution_tot02'] : null;
$totalContribution = !empty($_SESSION['MYFORMTotalContribution']) ? $_SESSION['MYFORMTotalContribution'] : null;
$issuedBy = !empty($_SESSION['u_name']) ? $_SESSION['u_name'] : null;
//Covers On PDF
// Access the session variable for FREE COVERS
$sessionFreeCovers = $_SESSION['FreeCoversCBT01'];
$sessionCovers = $_SESSION['srccTC_chargers'];
$OtherCovers = $_SESSION['other_cover_chargers'];
//Covers

//END

// product type
$sql = "SELECT product_des FROM tbl_product_mt WHERE product_code = 'V001'";
                    $result = $con->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $vehiType = $row['product_des'];
                    } 
                    $vehiType = preg_replace('/\s*\(.*?\)\s*/', '', $vehiType);
//end

// Make Model type
$sql = "SELECT pmk_desc FROM tbl_makemodel_mt WHERE pmk_make_code = '$makeModelcode'";
                    $result = $con->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $makeModel = $row['pmk_desc'];
                        $vehicleBrand = $makeModel;
                    } 
//end

// Financial Institute type
$sql = "SELECT name FROM tbl_company_mt WHERE code = '$companyProduct'";
                    $result = $con->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $companyProduct = $row['name'];
                    } 
//end

//Fuel Type
if($fuelType == 'P'){
    $fuelTypeName = "Petrol";
} elseif($fuelType == 'D'){
    $fuelTypeName = "Diesel";
} elseif($fuelType == 'H'){
    $fuelTypeName = "Hybrid";
} elseif($fuelType == 'E'){
    $fuelTypeName = "Electric";
} else {
    $fuelTypeName = "";
}
//End

// Retrieve the admin chargers array from the session
if (isset($_SESSION['admin_chargers'])) {
    $admin_chargers = $_SESSION['admin_chargers'];
    $adminChargers = NULL;
    $policyFee = 0;
    $serviceFee = 0;
    foreach ($admin_chargers as $charger) {
        $cover_des_B = $charger['cover'];
        $premium = $charger['premium'];
        $adminChargers += $premium;
    // Check cover description and assign premium to corresponding variable
    if ($cover_des_B == "Policy Fee (S2S / BPA)") {
        $policyFee = $premium;
    } elseif($cover_des_B == "Service Fee (B2B)"){
        $serviceFee = $premium;
    }
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

// Retrieve the all charges underNCB  from the session array
if (isset($_SESSION['srccTC_chargers'])) {
    $All_Chargers = $_SESSION['srccTC_chargers'];
    $AllChargers = 0;

    foreach ($All_Chargers as $Chargers) {
        $cover_ = $Chargers['cover'];
        $premium = $Chargers['premium'];
        $premium = str_replace(',', '', $premium);
        $AllChargers = $AllChargers + $premium;
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
    
} else {
    // echo "No admin chargers data found in session.";
}

// Retrieve the all Other Chargers from the session array
if (isset($_SESSION['other_cover_chargers'])) {
    $other_chargers = $_SESSION['other_cover_chargers'];
    $OtherChargers = 0;

    foreach ($other_chargers as $othercharge) {
        $cover_ = $othercharge['cover'];
        $premium = $othercharge['premium'];
        $premium = str_replace(',', '', $premium);
        $OtherChargers = $OtherChargers + $premium;
    }
} else {
    // echo "No admin chargers data found in session.";
}
// End

    $AllChargers -= $tc_premium + $srcc_premium;
    $basicPremium -= $ncb_MRamt;
    $basicPremium += $AllChargers + $OtherChargers;
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
$pdf->Cell(-5, 4, 'Rs. '.$sumInsured = number_format($sumInsured,2), 0, 1, 'R');

$pdf->SetFont('Arial', '', 9);
if(!empty($srcc_premium || $tc_premium)){
    $pdf->Cell(95, 12, '     Basic Contribution', 0, 0, 'L'); 
    $pdf->Cell(-5, 11, 'Rs. '. $basicPremium = number_format($basicPremium,2), 0, 1, 'R');
    $pdf->Cell(95, 0, '     SRCC Contribution', 0, 0, 'L'); 
    $pdf->Cell(-5, 0, 'Rs. '. $srcc_premium = number_format($srcc_premium,2), 0, 1, 'R');
    $pdf->Cell(95, 10, '     TC Contribution', 0, 0, 'L'); 
    $pdf->Cell(-5, 10, 'Rs. '. $tc_premium = number_format($tc_premium,2), 0, 1, 'R');
    }else {
    $pdf->Cell(95, 12, '     Comprehensive Contribution', 0, 0, 'L'); 
    $pdf->Cell(-5, 11, 'Rs. '. $basicPremium = number_format($basicPremium,2), 0, 1, 'R');
    }

// $pdf->Cell(95, 12, '     Basic Contribution', 0, 0, 'L'); 
// $pdf->Cell(-5, 11, 'Rs. '. $basicPremium, 0, 1, 'R');
// $pdf->Cell(95, 0, '     SRCC Contribution', 0, 0, 'L'); 
// $pdf->Cell(-5, 0, 'Rs. '. $srcc_premium = number_format($srcc_premium,2), 0, 1, 'R');
// $pdf->Cell(95, 10, '     TC Contribution', 0, 0, 'L'); 
// $pdf->Cell(-5, 10, 'Rs. '. $tc_premium = number_format($tc_premium,2), 0, 1, 'R');

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
$pdf->Cell(-5, 11, 'Rs. '.$adminChargers = number_format($adminChargers,2), 0, 1, 'R');
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

$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(0, 0, 0);

// Showing Fre Covers Two Columns
$totalCovers = count($sessionFreeCovers);
$half = ceil($totalCovers / 2);

for ($i = 0; $i < $half; $i++) {
    // Left
    $pdf->Cell(95, 4, '* ' . $sessionFreeCovers[$i]['cover'], 0, 0);

    // Right
    if (isset($sessionFreeCovers[$i + $half])) {
        $pdf->SetX(105); 
        $pdf->MultiCell(95, 4, '* ' . $sessionFreeCovers[$i + $half]['cover'], 0, 1);
    } else {
        $pdf->SetX(105);
        $pdf->Cell(95, 4, '', 0, 1);
    }
}

// $pdf->Cell(95, 4, '          * Accidental damage, Fire & Theft');
// $pdf->Cell(10, 4, '', 0); 
// $pdf->Cell(95, 4, '* Third-party death & bodily injury - Unlimited', 0, 1);

// $pdf->Cell(95, 4, '          * Flood & natural perils');
// $pdf->Cell(10, 4, '', 0); 
// $pdf->Cell(95, 4, '* Third-party property damage - up to Rs. 20,000,000/', 0, 1);

// $pdf->Cell(95, 4, '          * Theft of parts');
// $pdf->Cell(10, 4, '', 0); 
// $pdf->Cell(95, 4, '* Alternative transportation', 0, 1);

// $pdf->Cell(95, 4, '          * Airbag cover');
// $pdf->Cell(10, 4, '', 0); 
// $pdf->Cell(95, 4, '         -   sum covered up to Rs.2.5 Mn - Rs.2,500/- per day', 0, 1);

// $pdf->Cell(95, 4, '          * Accidental injury hospitalization cover');
// $pdf->Cell(10, 4, '', 0); 
// $pdf->Cell(95, 4, '         -   sum covered exceeding Rs.2.5 Mn - R.3,500/- per day', 0, 1);

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 7, 3, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 6, 'Optional Covers', 0, 1, 'L');

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(0, 0, 0);

// Showing Covers Two Columns
$totalCovers2 = count($sessionCovers);
$half2 = ceil($totalCovers2 / 2);

for ($i = 0; $i < $half2; $i++) {
    // Left
    $pdf->Cell(95, 4, '* ' . $sessionCovers[$i]['cover'], 0, 0);

    // Right
    if (isset($sessionCovers[$i + $half2])) {

        $pdf->SetX(105); 
        $pdf->MultiCell(95, 4, '* ' . $sessionCovers[$i + $half2]['cover'], 0, 1);
    } else {
        $pdf->SetX(105);
        $pdf->Cell(95, 4, '', 0, 1);
    }
}

// Showing Other Covers Two Columns
$totalCovers3 = count($OtherCovers);
$half3 = ceil($totalCovers3 / 2);

for ($i = 0; $i < $half3; $i++) {
    // Left
    $pdf->Cell(95, 4, '* ' . $OtherCovers[$i]['cover'], 0, 0);

    // Right
    if (isset($OtherCovers[$i + $half3])) {
        $pdf->SetX(105); 
        $pdf->MultiCell(95, 4, '* ' . $OtherCovers[$i + $half3]['cover'], 0, 1);
    } else {
        $pdf->SetX(105);
        $pdf->Cell(95, 4, '', 0, 1);
    }
}
// $pdf->Cell(95, 4, '          * Strikes, riots & civil commotion');
// $pdf->Cell(10, 4, '', 0); 
// $pdf->Cell(95, 4, '* PAB cover up to Rs. 500,000/- for 4 passengers', 0, 1);

// $pdf->Cell(95, 4, '          * Terrorism cover');
// $pdf->Cell(10, 4, '', 0); 
// $pdf->Cell(95, 4, '* Towing charges - up to Rs. 7500/-', 0, 1);

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 7, 3, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 6, 'Special Notes', 0, 1, 'L');

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 7);
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
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(0, 5, 'We trust that the above terms are acceptable and look forward to hearing a positive response from you. If you have any clarification,', 0, 1, 'L');
$pdf->Cell(0, 3, 'please do not hesitate to contact us.', 0, 1, 'L');
$pdf->Ln(3);
// Divider
$pdf->SetDrawColor(93, 103, 113); 
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(3);
$pdf->Cell(0, 3, 'This is a computer-generated quotation, hence no signature is required.', 0, 1, 'C');
$pdf->Cell(0, 5, 'Issued By:'.' '.$issuedBy.' | Reference:'.' '.$companyProduct.' - '.$vehiType.' | Issued Date:'.' '.$issueddate.' | Quotation No: '.$quote_no, 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 7, 'Amana Takaful PLC (PQ23)', 0, 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(0, 0, 'No:660-1/1, Galle Road, Colombo 03, Sri Lanka | Tel : +94 11 7501000 | Fax: +94 11 750 1097 / 2597429 | E-mail : info@takaful.lk | Website : www.takaful.lk', 0, 1, 'C');
$pdf->Cell(0, 8, '(M)'.$mrRate.' '.'(N)'.$ncbRate.' '.'(S)'.$serviceFee.' '.'(P)'.$policyFee, 0, 1, 'L');

$pdf->Output($PDFname, 'I');
  // End 
?>