<?php session_start();
include_once('includes/config.php');
require('fpdf/fpdf.php');
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
$basic_premium = !empty($_SESSION['mqForm_basicPremium']) ? $_SESSION['mqForm_basicPremium'] : null;
$datePeriod = !empty($_SESSION['mqForm_date_period']) ? $_SESSION['mqForm_date_period'] : null;
$branch = !empty($_SESSION['branch']) ? $_SESSION['branch'] : null;
$ncbRate = !empty($_SESSION['ncb_rate_']) ? $_SESSION['ncb_rate_'] : null;
$mrRate = !empty($_SESSION['mr_rate_']) ? $_SESSION['mr_rate_'] : null;
$ncb_MRamt = !empty($_SESSION['_mr_price']) ? $_SESSION['_mr_price'] : null;
$rate = !empty($_SESSION['vehicleRate']) ? $_SESSION['vehicleRate'] : null;
$rate = $rate * 100;
$basicrate = !empty($_SESSION['basicRate']) ? $_SESSION['basicRate'] : null;
$basicrate = $basicrate * 100;
$userid = $_SESSION['id'];
$query = mysqli_query($con, "select * from tbl_staff where id='$userid'");
// Assuming you have only one result for the user
$username = mysqli_fetch_array($query);
$B_username = $username['username'];
$calDate = date('Y-m-d');

$prodcode = !empty($_SESSION['mqForm_prod_code']) ? $_SESSION['mqForm_prod_code'] : null;
$compCode = !empty($_SESSION['mqForm_comp_codce']) ? $_SESSION['mqForm_comp_codce'] : null;
$totalPremium = !empty($_SESSION['TotalContribution']) ? $_SESSION['TotalContribution'] : null;
$total_01_ = !empty($_SESSION['T1_total01']) ? $_SESSION['T1_total01'] : null;
//These are array values
$vat_chargers = !empty($_SESSION['vat_chargers']) ? $_SESSION['vat_chargers'] : null;

$comp_excesses       = !empty($_SESSION['mqForm_comp_excesses']) ? $_SESSION['mqForm_comp_excesses'] : 0;
$Age_Exces      = !empty($_SESSION['mqForm_age_exces']) ? $_SESSION['mqForm_age_exces'] : 0;
$discount_amt = !empty($_SESSION['mqForm_discount_amt']) ? $_SESSION['mqForm_discount_amt'] : 0;
$remark            = !empty($_SESSION['mqForm_remark']) ? $_SESSION['mqForm_remark'] : null;
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
    
        for ($i = 0; $i < max(count($cover_codes), count($cover_amts), count($cover_premiums), count($cover_calseqs), count($cover_areas)); $i++) {
            $cover_code = isset($cover_codes[$i]) ? $cover_codes[$i] : '';
            $cover_amt = isset($cover_amts[$i]) ? $cover_amts[$i] : '';
            $cover_premium = isset($cover_premiums[$i]) ? $cover_premiums[$i] : '';
            $cover_calseq = isset($cover_calseqs[$i]) ? $cover_calseqs[$i] : '';
            $cover_area = isset($cover_areas[$i]) ? $cover_areas[$i] : '';
    
            if (!empty($cover_code) || !empty($cover_amt) || !empty($cover_premium) || !empty($cover_calseq) || !empty($cover_area)) {
                $cover_amt = str_replace(',', '', $cover_amt);
                $cover_premium = str_replace(',', '', $cover_premium);
                $cover_amt = number_format((float)$cover_amt, 2, '.', '');
                $cover_premium = number_format((float)$cover_premium, 2, '.', '');
    
                $sql = "INSERT INTO rev_quotation_cover_mt (quote_no, cover_code, cover_amt, print_flag, cal_seq, cover_premium, dis_area, cal_date) 
                        VALUES ('$NEWquote_no', '$cover_code', '$cover_amt', '$printStatus', '$cover_calseq', '$cover_premium', '$cover_area', '$calDate')";
    
                if ($con->query($sql) === TRUE) {
                    // Record inserted successfully.
                } else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
            } else {
                echo "Missing cover code or amount.<br>";
            }
        }
    }
    
}
//insert Free covers into dataase
if (isset($_SESSION['FreeCoversCBT01'])) {
    $freeCovers = $_SESSION['FreeCoversCBT01'];

    foreach ($freeCovers as $free_Covers) {

        $cover_code = $free_Covers['coverCode'];
        $coverType  = $free_Covers['coverType'];
        $coverAMT   = $free_Covers['coverAmt'];
        $dis_area   = $free_Covers['dis_area'];
        $printSeq   = $free_Covers['printSquence'];
        $calSeq   = $free_Covers['calSequence'];

    $sqlFC = "INSERT INTO rev_quotation_cover_mt (quote_no, cover_code, cover_amt, print_flag, cal_seq, cover_premium, dis_area, cal_date) 
              VALUES ('$NEWquote_no', '$cover_code', '$coverAMT', '1', '$calSeq', '0', '$dis_area', '$calDate')";

        if ($con->query($sqlFC) === TRUE) {
            // Record inserted successfully.
        } else {
            echo "Error: " . $sqlFC . "<br>" . $con->error;
        }
    }
} else {

}

//Update Revision status on quotation_mt table
$sql_mt = "UPDATE quotation_mt 
           SET edit_status = '1' 
           WHERE quote_no = '$quote_no'";
if (!mysqli_query($con, $sql_mt)) {
    echo "Error: " . mysqli_error($con) . "<br>";
} else {
    //echo "Quotation_mt record Update successfully.<br>";
}
//End

//echo "NCB Rate: $ncbRate, MR Rate: $mrRate, NCB/MR Amount: $ncb_MRamt";
//echo "Sum Insured: $sum_ins, Basic Premium: $basic_premium, Vehicle Rate: $rate, Basic Rate: $basicrate";
//Insert data into quotation_mt table
$sql_mt = "INSERT INTO rev_quotation_mt (old_quote_no, new_quote_no, comp_codce, prod_code, class_code, cus_name, cus_address, cus_mobile, cus_email, vehi_number, vehi_reg_status, vehi_make_model, vehi_seating_capacity, vehi_year_of_manu, vehi_fuel_type, vehi_usage, sum_ins, ncb_rate, ncb_amt, mr_rate, mr_amt, vehi_rate, basic_rate, date_period, basic_premium, total_01, tot_premium, vat_amt, pol_fee, ssl_amt, admin_fee, comp_excesses, age_exces, discount_amt, remark, prnt_status, cal_date, user_ID, user_brnch) 
           VALUES ('$quote_no', '$NEWquote_no', '$compCode','$prodcode','NULL','$clientName','$clientAddress','$mobile_number','$email_address','$vehiregNo','$registrationStatus','$makeModel','$seatingCapacity','$manufactureYear','$fuelType','$vehiusage','$sum_ins','$ncbRate','$ncb_MRamt','$mrRate','$ncb_MRamt','$rate','$basicrate','$datePeriod', '$basic_premium', '$total_01_', '$totalPremium','$VATChargers','0','0','$adminChargers', '$comp_excesses','$Age_Exces','$discount_amt','$remark','$printStatus','$calDate','$B_username','$branch')";
if (!mysqli_query($con, $sql_mt)) {
    echo "Error: " . mysqli_error($con) . "<br>";
} else {
    //echo "Quotation_mt record inserted successfully.<br>";
}
  // End
  
  //Generate PDF
  // Print PDF
  $quote_no = !empty($_SESSION['mqForm_quote_no']) ? $_SESSION['mqForm_quote_no'] : null;
  $clientName = !empty($_SESSION['mqForm_cus_name']) ? $_SESSION['mqForm_cus_name'] : null;
  $clientName = $clientName ?: "To be advised";
  $regNo  =   !empty($_SESSION['mqForm_vehi_number']) ? $_SESSION['mqForm_vehi_number'] : null;
  $regNo = $regNo ?: "To be advised";
  $makeModel = !empty($_SESSION['mqForm_vehi_make_model']) ? $_SESSION['mqForm_vehi_make_model'] : null;
  
  //find Vehicle Brand Name
  $sql_vehi_desc = "SELECT pmk_desc from tbl_makemodel_mt WHERE pmk_make_code = $makeModel  ";
  $result_vehi_name = $con->query($sql_vehi_desc);
  while ($row1 = $result_vehi_name->fetch_assoc()) {
  $makeModel = $row1['pmk_desc'];
  } 
  //End
  
  $makeModel = ucwords(strtolower($makeModel));
  $usage = !empty($_SESSION['mqForm_vehi_usage']) ? ucfirst($_SESSION['mqForm_vehi_usage']) : null;
  $vehicleBrand = !empty($makeModel) ? $makeModel : null;
  $vehicleBrand = ucwords(strtolower(explode(" ", $vehicleBrand)[0]));
  $datePeriod = 'One Year';
  $manufactureYear = !empty($_SESSION['mqForm_vehi_year_of_manu']) ? $_SESSION['mqForm_vehi_year_of_manu'] : null;
  $fuelType = !empty($_SESSION['mqForm_vehi_fuel_type']) ? $_SESSION['mqForm_vehi_fuel_type'] : null;
  
  //Find Fuel Name
  if($fuelType=="P")
      {
          $fuelTypeName = "Petrol";
      }
      elseif($fuelType == "D")
      {
          $fuelTypeName = "Diesel";
      }
      elseif($fuelType == "H")
      {
          $fuelTypeName = "Hybrid";
      }
      elseif($fuelType == "E")
      {
          $fuelTypeName = "Electric";
      }
      else
      {
          $fuelTypeName = NULL;
      }
  //End
  
  $product = !empty($_SESSION['product']) ? $_SESSION['product'] : null;
  $companyProduct = !empty($_SESSION['mqForm_comp_codce']) ? $_SESSION['mqForm_comp_codce'] : null;
  
  //Find Company Name
  $sql_company_name = "SELECT name FROM tbl_company_mt WHERE code = '$companyProduct'";
  $result_comp_name = $con->query($sql_company_name);
  while ($row = $result_comp_name->fetch_assoc()) {
  $companyProduct = $row['name'];
  } 
  //End
  $companyProduct = ucwords(strtolower($companyProduct));
  if($companyProduct == "Other Leasing Company - Malicious Damage"){$companyProduct = "Other Leasing Company";}
  if($companyProduct == "Other Leasing Company - Srcc & Tc"){$companyProduct = "Other Leasing Company";}
  if($companyProduct == "Lb Finance Plc"){$companyProduct = "LB Finance PLC";}
  if($companyProduct == "Orient Finance Plc"){$companyProduct = "Orient Finance PLC";}
  if($companyProduct == "Vallibel Finance Plc"){$companyProduct = "Vallibel Finance PLC";}
  if($companyProduct == "Commercial Credit & Finance Plc"){$companyProduct = "Commercial Credit & Finance PLC";}
  if($companyProduct == "Cbc Finance"){$companyProduct = "CBC Finance";}
  if($companyProduct == "Hnb Finance"){$companyProduct = "HNB Finance";}
  //Company product is Amana
  if ($companyProduct === "Amana"){ $companyProduct = "Direct / ATI Sales Staff";}
  //End
  $sumInsured = !empty($_SESSION['mqForm_sumins']) ? $_SESSION['mqForm_sumins'] : null;
  //Sum Insured Without RS
  $sumInsured = str_replace(array('Rs.', ','), '', $sumInsured);
  //$sum_ins = (int)$coverWithoutRs;  // For integer
  $basicPremium = !empty($_SESSION['basic_premium']) ? $_SESSION['basic_premium'] : null;
  $gross_premium_ = !empty($_SESSION['gross_premium_']) ? $_SESSION['gross_premium_'] : null;
  $T1_total01 = !empty($_SESSION['T1_total01']) ? $_SESSION['T1_total01'] : null;
  //$basicPremium = number_format($basicPremium, 2);
  $subjectToTax = !empty($_SESSION['GrossContribution_tot02']) ? $_SESSION['GrossContribution_tot02'] : null;
  $totalContribution = !empty($_SESSION['TotalContribution']) ? $_SESSION['TotalContribution'] : null;
  $issuedBy = !empty($_SESSION['u_name']) ? $_SESSION['u_name'] : null;
  
  $comp_excesses  = !empty($_SESSION['mqForm_comp_excesses']) ? $_SESSION['mqForm_comp_excesses'] : 0;
  if(!empty($comp_excesses))
  {
      $comp_excesses = 'Rs. '. $comp_excesses = number_format($comp_excesses,2);
  }
  else {
      $comp_excesses = "Nil";
  }
  $Age_Exces      = !empty($_SESSION['mqForm_age_exces']) ? $_SESSION['mqForm_age_exces'] : 0;
  if(!empty($Age_Exces))
  {
      $Age_Exces = 'Rs. '. $Age_Exces = number_format($Age_Exces,2);
  }
  else {
      $Age_Exces = "Nil";
  }
  $remark         = !empty($_SESSION['mqForm_remark']) ? $_SESSION['mqForm_remark'] : null;
  //Covers On PDF
  // Access the session variable for FREE COVERS
  $sessionCovers = $_SESSION['srccTC_chargers'];
  $sessionFreeCovers = $_SESSION['FreeCoversCBT01'];
  usort($sessionFreeCovers, function($a, $b) {
      return $a['printSquence'] - $b['printSquence'];
  });
  //Extract Flood cover and merge it into the session free cover
  $floodcover = null;
  foreach ($sessionCovers as $coverItem) {
      if ($coverItem['cover'] == 'Flood & Natural Disaster Perils') {
          $floodcover = $coverItem;
          $floodcover['printSequence'] = 1;
          break; // Stop the loop once found
      }
  }
  if ($floodcover !== null) {
      $ExclusiveCover = array_merge([$floodcover], $sessionFreeCovers);
  } else {
      $ExclusiveCover = $sessionFreeCovers;
  }
  //END
  $OtherCovers = $_SESSION['other_cover_chargers'];
  $front_covers = $_SESSION['front_covers'];
  // Check age excess cover is taken
  $AGE_cover = 0;
  foreach ($OtherCovers as $coverItem) {
      if ($coverItem['cover'] === 'Agents Garage Excess Removal' && $coverItem['printflag'] == 1) {
          $AGE_cover = 1;
          break; 
      }
  }
  //End 
  
  // $filteredCovers = array_filter($OtherCovers, function($cover) {
  //     return $cover['printflag'] == 1;
  // });
  
  //END
  
  //Condition for Folowing fields are empty
  
  //END
  // product type
  $sql = "SELECT product_des FROM tbl_product_mt WHERE product_code = 'V001'";
                      $result = $con->query($sql);
  
                      while ($row = $result->fetch_assoc()) {
                          $vehiType = $row['product_des'];
                      } 
                      $vehiType = preg_replace('/\s*\(.*?\)\s*/', '', $vehiType);
                      $vehiType = ucwords(strtolower($vehiType));
  //end
  
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
          if ($cover_des_B == "SRCC (Strike, Riot & Civil Commotion) Cover") {
              $srcc_premium = $premium;
          } elseif ($cover_des_B == "Terrorism Cover") {
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
      $basicPremium = $subjectToTax;
  // End
  
  $basicPremium_01 = ($srcc_premium + $tc_premium) ;
  $gross_premium_ = ($basicPremium - $basicPremium_01);
  //PDF NAME
  $PDFname = "Motor Quotation";
  
  //date
  $issueddate = date('Y-m-d');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(92, 103, 113);
        $this->SetY(8);
        $this->Image('images/header-logo.png', 10, 5, 35);
        
        $this->SetY(8);
        $this->SetX(80); 
        $this->SetTextColor(129, 189, 67);
        $this->Cell(0, 0, 'TOTAL DRIVE', 0, 1, 'R'); 
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(80); 
        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(93, 103, 113);
        $this->Cell(0, 7, 'A HASSLE FREE', 0, 1, 'R');
        $this->SetX(80); 
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(0, -1, 'MOTOR INSURANCE', 0, 1, 'R'); 
        $this->Ln(0);
        $this->RoundedRect(5, 5, 200, 287, 5); // Extend border till the bottom of the page (287mm)
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

     // Page footer
     function Footer()
     {
         // Set position at 20 mm from bottom
         $this->SetY(-30);
         
         // Set color and style
         $this->SetDrawColor(93, 103, 113); 
         $this->SetLineWidth(0.5);
         
         // Draw a horizontal line
         $this->Line(10, $this->GetY(), 200, $this->GetY());
         
         // Move to the next line and add footer content
         $this->Ln(3);
         $this->SetFont('Arial', '', 8);
         $this->Cell(0, 3, 'This is a computer-generated quotation, hence no signature is required.', 0, 1, 'C');
         $this->Cell(0, 5, 'Issued By: '.$GLOBALS['issuedBy'].' | Reference: '.$GLOBALS['companyProduct'].' - '.$GLOBALS['vehiType'].' | Issued Date: '.$GLOBALS['issueddate'].' | Quotation No: '.$GLOBALS['NEWquote_no'], 0, 1, 'C');
         
         $this->SetFont('Arial', 'B', 8);
         $this->Cell(0, 7, 'Amana Takaful PLC (PQ23)', 0, 1, 'C');
         
         $this->SetFont('Arial', '', 7);
         $this->Cell(0, 0, 'No:660-1/1, Galle Road, Colombo 03, Sri Lanka | Tel : +94 11 7501000 | Fax: +94 11 750 1097 / 2597429 | E-mail : info@takaful.lk | Website : www.takaful.lk', 0, 1, 'C');
         
         $this->Cell(0, 8, '(M)'.$GLOBALS['mrRate'].' (N)'.$GLOBALS['ncbRate'].' (S)'.$GLOBALS['serviceFee'].' (P)'.$GLOBALS['policyFee'], 0, 1, 'L');
     }
}

$pdf = new PDF('P', 'mm', 'A4'); 
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 5, 'Motor Insurance Quotation', 0, 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(0, 5, 'We greatly appreciate your interest in our services and thank you for requesting a quotation for your insurance needs. We are pleased to share our terms and conditions for', 0, 1, 'L');
$pdf->Cell(0, 3, 'your review, based on the information provided.', 0, 1, 'L');

$pdf->Ln(2);

// Divider
$pdf->SetDrawColor(93, 103, 113); 
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 7);

// Adjust the widths to align colons vertically
$labelWidth = 45; // Width for the label (before the colon)
$colonWidth = 3;  // Width for the colon
$valueWidth = 47; // Width for the value (after the colon)

$pdf->Cell($labelWidth, 4, 'Name of the Participant', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $clientName, 0, 0);

$pdf->Cell(10, 4, '', 0); // Spacer between columns

$pdf->Cell($labelWidth, 4, 'Period of Cover', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $datePeriod, 0, 1);

$pdf->Cell($labelWidth, 4, 'Registration Number', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $regNo, 0, 0);

$pdf->Cell(10, 4, '', 0); // Spacer between columns

$pdf->Cell($labelWidth, 4, 'Year of Manufacture', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $manufactureYear, 0, 1);

$pdf->Cell($labelWidth, 4, 'Vehicle Brand', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $vehicleBrand, 0, 0);

$pdf->Cell(10, 4, '', 0); // Spacer between columns

$pdf->Cell($labelWidth, 4, 'Fuel Type', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $fuelTypeName, 0, 1);

$pdf->Cell($labelWidth, 4, 'Make / Model', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $makeModel, 0, 0);

$pdf->Cell(10, 4, '', 0); // Spacer between columns

$pdf->Cell($labelWidth, 4, 'Type of Vehicle', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $vehiType, 0, 1);

$pdf->Cell($labelWidth, 4, 'Usage', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $usage, 0, 0);

$pdf->Cell(10, 4, '', 0); // Spacer between columns

$pdf->Cell($labelWidth, 4, 'Financial Institution / Bank', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $companyProduct, 0, 1);


$pdf->Ln(2);

$pdf->SetFont('Arial', '', 9);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 5, 2, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 3, 'Takaful Contribution', 0, 1, 'L');

$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(213, 219, 225);
$pdf->SetTextColor(0, 0, 0);
$pdf->RoundedRect(10, $pdf->GetY(), 100, 5, 2, 'F');
$pdf->SetXY(10, $pdf->GetY() + 2);
$pdf->Cell(95, 1.5, '     Sum Insured', 0, 0, 'L'); 
$pdf->Cell(-5, 1.5, 'Rs '.$sumInsured = number_format($sumInsured,2), 0, 1, 'R');

$pdf->SetFont('Arial', '', 7);
if(!empty($srcc_premium || $tc_premium)){
$pdf->Cell(95, 8, '     Basic Contribution', 0, 0, 'L'); 
$pdf->Cell(-5, 8, 'Rs. '. $gross_premium_ , 0, 1, 'R');
$pdf->Cell(95, -2, '     SRCC Contribution', 0, 0, 'L'); 
$pdf->Cell(-5, -2, 'Rs. '. $srcc_premium = number_format($srcc_premium,2), 0, 1, 'R');
$pdf->Cell(95, 8, '     TC Contribution', 0, 0, 'L'); 
$pdf->Cell(-5, 8, 'Rs. '. $tc_premium = number_format($tc_premium,2), 0, 1, 'R');
}else {
$pdf->Cell(95, 8, '     Comprehensive Contribution', 0, 0, 'L'); 
$pdf->Cell(-5, 8, 'Rs. '. $basicPremium = number_format($basicPremium,2), 0, 1, 'R');
}

$pdf->Image('images/call-and-go.jpg', 130, 60, 60);

$pdf->Ln(-2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(213, 219, 225);
$pdf->SetTextColor(0, 0, 0);
$pdf->RoundedRect(10, $pdf->GetY(), 100, 5, 2, 'F');
$pdf->SetXY(10, $pdf->GetY() + 2);
$pdf->Cell(95, 1.5, '     Subject to Tax', 0, 0, 'L'); 
$pdf->Cell(-5, 1.5,'Rs. '. $subjectToTax = number_format($subjectToTax,2), 0, 1, 'R');

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(95, 8, '     Admin Charges', 0, 0, 'L'); 
$pdf->Cell(-5, 8, 'Rs. '.$adminChargers = number_format($adminChargers,2), 0, 1, 'R');
$pdf->Cell(95, 0, '     VAT', 0, 0, 'L'); 
$pdf->Cell(-5, 0, 'Rs. '.$VATChargers = number_format($VATChargers,2), 0, 1, 'R');

$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(213, 219, 225);
$pdf->SetTextColor(0, 0, 0);
$pdf->RoundedRect(10, $pdf->GetY(), 100, 5, 2, 'F');
$pdf->SetXY(10, $pdf->GetY() + 2);
$pdf->Cell(95, 1.5, '     Total Contribution', 0, 0, 'L'); 
$pdf->Cell(-5, 1.5, 'Rs. '. $totalContribution = number_format($totalContribution,2), 0, 1, 'R');

$pdf->Ln(4);

$pdf->SetFont('Arial', '', 8);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 5, 2, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 3.5, 'Exclusive Total Drive Benefits', 0, 1, 'L');

$pdf->Ln(3);

$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', '', 7);
// Calculate the total number of covers and split them into two columns
$totalCovers = count($ExclusiveCover);
$half = ceil($totalCovers / 2);

for ($i = 0; $i < $half; $i++) {
    // Left Column
    $pdf->Cell(95, 4, '* ' . trim($ExclusiveCover[$i]['cover']), 0, 0);

    // Right Column
    if (isset($ExclusiveCover[$i + $half])) {
        $pdf->SetX(105); 
        $pdf->MultiCell(95, 4, '* ' . trim($ExclusiveCover[$i + $half]['cover']), 0, 1);
    } else {
        $pdf->SetX(105);
        $pdf->Cell(95, 4, '', 0, 1);
    }
}


$pdf->Ln(2);

$pdf->SetFont('Arial', '', 8);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 5, 2, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 3.5, 'Additional Covers', 0, 1, 'L');

$pdf->Ln(3);

$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(0, 0, 0);

// Showing Covers Two Columns
// $filteredSessionCovers = array_filter($sessionCovers, function($cover) {
//     return $cover['printflag'] == 1;
// });

// $totalCovers2 = count($filteredSessionCovers);
// $half2 = ceil($totalCovers2 / 2);

// for ($i = 0; $i < $half2; $i++) {
//     // Left
//     $pdf->Cell(95, 3, '* ' . $filteredSessionCovers[$i]['cover'], 0, 0);

//     // Right
//     if (isset($filteredSessionCovers[$i + $half2])) {

//         $pdf->SetX(105); 
//         $pdf->MultiCell(95, 4, '* ' . $filteredSessionCovers[$i + $half2]['cover'], 0, 1);
//     } else {
//         $pdf->SetX(105);
//         $pdf->Cell(95, 4, '', 0, 1);
//     }
// }

//merge arrays and get advanced cover as one array
$advanced_cover = array_merge($sessionCovers, $OtherCovers, $front_covers);
$filteredCovers = array_filter($advanced_cover, function($cover) {
    return $cover['printflag'] == 1 && $cover['cover'] != 'Flood & Natural Disaster Perils';
});

// Reindex the array to make the keys sequential
$filteredCovers = array_values($filteredCovers);

// Showing Other Covers in Two Columns
$totalCovers3 = count($filteredCovers);
$half3 = ceil($totalCovers3 / 2);

// Loop through the covers if there are any
for ($i = 0; $i < $half3; $i++) {
    // Left column
    if (isset($filteredCovers[$i]['cover'])) {
        $leftCover = '* ' . $filteredCovers[$i]['cover'];
        // Check if the cover is "Towing Charges" and append the formatted premium value
        if ($filteredCovers[$i]['cover'] === 'Towing Charges') {
            $formattedAmount = number_format((float)$filteredCovers[$i]['initialamt'], 2, '.', ',');  // Format the amount with separators and 2 decimal places
            $leftCover .= ' - Rs.' . $formattedAmount;
        }
        if ($filteredCovers[$i]['cover'] === 'WCI - for Driver/Cleaner') {
            $formattedAmount = $filteredCovers[$i]['initialamt'];  // Format the amount with separators and 2 decimal places
            if (intval($formattedAmount) == $formattedAmount) {// if Amount has decimals then remove decimals. ex:1.5 conert 1
                $formattedAmount = intval($formattedAmount);
            } else {
                $formattedAmount = floor($formattedAmount);
            }
            $leftCover .= ' - ' . $formattedAmount. ' Person(s)';
        }
        if ($filteredCovers[$i]['cover'] === 'Special Windscreen Cover') {
            if (empty($filteredCovers[$i]['premium'])) {
                $leftCover .= ' - Up to Rs.50,000/-';
            }
        }        
        
    } else {
        $leftCover = '';
    }
    
    $pdf->Cell(95, 3, $leftCover, 0, 0);

    // Right column
    if (isset($filteredCovers[$i + $half3]['cover'])) {
        $rightCover = '* ' . $filteredCovers[$i + $half3]['cover'];
        // Check if the cover is "Towing Charges" and append the formatted premium value
        if ($filteredCovers[$i + $half3]['cover'] === 'Towing Charges') {
            $formattedAmount = number_format((float)$filteredCovers[$i + $half3]['initialamt'], 2, '.', ',');  // Format the amount with separators and 2 decimal places
            $rightCover .= ' - Rs.' . $formattedAmount;
        }
        if ($filteredCovers[$i + $half3]['cover'] === 'WCI - for Driver/Cleaner') {
            $formattedAmount = $filteredCovers[$i + $half3]['initialamt'];  // Format the amount with separators and 2 decimal places
            if (intval($formattedAmount) == $formattedAmount) { // if Amount has decimals then remove decimals. ex:1.5 conert 1
                $formattedAmount = intval($formattedAmount);
            } else {
                $formattedAmount = floor($formattedAmount);
            }
            $rightCover .= ' - ' .$formattedAmount. ' Person(s)';
        }
        if ($filteredCovers[$i + $half3]['cover'] === 'Special Windscreen Cover') {
            $rightCover .= ' - ';
        }
        if ($filteredCovers[$i]['cover'] === 'Special Windscreen Cover') {
            if (empty($filteredCovers[$i]['premium'])) {
                $leftCover .= ' - Up to Rs.50,000/-';
            }
        }
        
    } else {
        $rightCover = '';
    }
    
    $pdf->SetX(105);
    $pdf->MultiCell(95, 4, $rightCover, 0, 1);
}



$pdf->Ln(1);

$pdf->SetFont('Arial', '', 8);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 5, 2, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 3.5, 'Deductibles / Excesses', 0, 1, 'L');

$pdf->Ln(2);
$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(0, 0, 0);

$labelWidth = 45; // Width for the label (before the colon)
$colonWidth = 3;  // Width for the colon
$valueWidth = 47; // Width for the value (after the colon)

$pdf->Cell($labelWidth, 4, '* Compulsory Excess', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $comp_excesses , 0, 0);

$pdf->Cell(10, 4, '',  0, 1, 'L');

$pdf->Cell($labelWidth, 4, '* Age Excess', 0, 0);
$pdf->Cell($colonWidth, 4, ':', 0, 0);
$pdf->Cell($valueWidth, 4, $Age_Exces,0, 0);
$pdf->Ln(5);

if ($AGE_cover === 0) {
$pdf->Cell(0, 4, '* Only vehicles purchased from Agents as "Brand New" are entitled to repairs at the Agent\'s Garage. All other vehicles are subject to an additional excess of 20%, if repaired at', 0, 1, 'L');
$pdf->Cell(0, 4, '  the Agent\'s garage.', 0, 1, 'L');
}

if ($fuelTypeName === "Hybrid" || $fuelTypeName === "Electric") {
    $pdf->Cell(0, 4, '* Max. Indemnification on Battery/Inverter is limited to 10% of Vehicle Sum Covered or Market Value, or the current market value of a similar battery/inverter, or the cost of', 0, 1, 'L');
    $pdf->Cell(0, 4, '  restoring the damaged battery/inverter, whichever is less.', 0, 1, 'L');
}

if ($AGE_cover === 1) {
    $pdf->Cell(0, 4, '* Agents Garage Excess - Not Applicable ', 0, 1, 'L');
}

$pdf->Cell(10, 4, '', 0);
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 7);
$pdf->SetFillColor(93, 103, 113);
$pdf->SetTextColor(255, 255, 255);

$pdf->RoundedRect(10, $pdf->GetY(), 190, 4, 2, 'F');
$pdf->SetXY(15, $pdf->GetY() + 1); 
$pdf->Cell(0, 2.5, 'Special Notes', 0, 1, 'L'); 

$pdf->Ln(2);

$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(0, 4, '* This quotation is offered based on the information provided by the proposer and is subject to revision upon changes to the risk', 0, 1, 'L');
$pdf->Cell(0, 4, '* This quotation is valid for 30 days from the date of issue.', 0, 1, 'L');
$pdf->Cell(0, 4, '* This quotation cannot be combined with any other existing packages, and the above premiums cannot be discounted by producing No Claims Bonus certificates.', 0, 1, 'L');
$pdf->Cell(0, 4, '* Premiums at the renewal may change due to claims experience and change in Government Fiscal policy/IRCSL regulation/NITF guidelines otherwise remain as it is.', 0, 1, 'L');
$pdf->Cell(0, 4, '* The above quoted terms are deemed null & void if the vehicle is found already insured with Amana Takaful Insurance and/or quoted under any other active package at the', 0, 1, 'L');
$pdf->Cell(0, 4, '  time of confirming the business.', 0, 1, 'L');
$pdf->Cell(0, 4, '* We always advise keeping the sum insured in accordance with the market value to avoid any disputes at the time of the claim.', 0, 1, 'L');
$pdf->Cell(0, 4, '* Extra Fittings (such as Ceramic Coating/Wrapping/Nano Coating & Any item other than the standard factory-fitted items) should be disclosed as a separate item apart from', 0, 1, 'L');
$pdf->Cell(0, 4, '  the vehicle sum insured at the offer level (Quotation) to cover under this insurance.', 0, 1, 'L');
$pdf->Cell(0, 4, '* If any item or peril which is not mentioned/agreed in this Quotation is required or is included in the Proposal From, It is requested to inform the Insurance Company in advance', 0, 1, 'L');
$pdf->Cell(0, 4, '  to incorporate to the Policy.', 0, 1, 'L');
$pdf->Cell(0, 4, '* Free telemedicine consultation', 0, 1, 'L');
$pdf->Cell(0, 4, '* All others terms and conditions as per standard Motor Takaful Policy.', 0, 1, 'L');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 6.5);
$pdf->Cell(0, 5, 'We trust that the above terms are acceptable and look forward to hearing a positive response from you. If you have any clarification, please do not hesitate to contact us.', 0, 1, 'L');
$pdf->Ln(0);
if (!empty($remark)) {
    // $pdf->Cell(0, 5, 'Remarks :  ' . $remark, 0, 1, 'L');
    $pdf->MultiCell(0, 5, 'Remarks : ' . $remark, 0, 'L', false);
}

//CLEAE SESSION
$_SESSION['comp_excesses']          =   NULL;
$_SESSION['remark']                 =   NULL;
//END
$pdf->Output($PDFname, 'I');
?>