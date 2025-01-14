<?php
include_once('includes/config.php');
  
// Values Needed
$SelectChannelCode = !empty($_SESSION['selected_channel_code']) ? $_SESSION['selected_channel_code'] : null;    
$EngineCapacity  = !empty($_SESSION['mqForm_seatingCapacity']) ? $_SESSION['mqForm_seatingCapacity'] : null;
//echo 'EngineCapacity: ' . $EngineCapacity . '<br>';
$product  = !empty($_SESSION['mqForm_prod_code']) ? $_SESSION['mqForm_prod_code'] : null;
//echo 'product: ' . $product . '<br>';
$vehirate_  = !empty($_SESSION['mqForm_vehiRate']) ? $_SESSION['mqForm_vehiRate'] : null;
$basicrate_ = !empty($_SESSION['mqForm_basicRate']) ? $_SESSION['mqForm_basicRate'] : null;
$basicrate_ = $basicrate_ / 100 ;
//echo 'basicRate: ' . $basicrate_ . '<br>';
$sum_insured_ = !empty($_SESSION['mqForm_sumins']) ? $_SESSION['mqForm_sumins'] : null;
$COV_TOT = !empty($_SESSION['T1']) ? $_SESSION['T1'] : null;
//echo 'Cover Total: ' . $COV_TOT . '<br>';
$discount_amount = !empty($_SESSION['mqForm_discount_amt']) ? $_SESSION['mqForm_discount_amt'] : null;
//echo 'Discount Amount: ' . $discount_amount . '</br>';
$total_contribution = !empty($_SESSION['mqForm_premium_matching']) ? $_SESSION['mqForm_premium_matching'] : null;
//echo 'total_contribution: ' . $total_contribution . '</br>';

/////////////////////////// PREMIUM EDJUSTMENT ////////////////////////////

if (!empty($total_contribution))
{
$converted = str_replace(array('Rs.', ','), '', $sum_insured_);
//echo 'total_contribution: ' . $total_contribution . '<br>';
$without_vat = ($total_contribution / 118) * 100;
$without_vat = $without_vat;
//echo 'without_vat: ' . $without_vat . '<br>';
$without_vat_ssl = ($without_vat / 102.5) * 100;
//echo 'without_vat_ssl: ' . $without_vat_ssl . '<br>';

// Extract policy fee, service fee, 	Admin Fee 3
if (isset($_SESSION['admin_chargers'])) {
    $admin_chargers = $_SESSION['admin_chargers'];
    $adminChargers = NULL;
    $policyFee = 0;
    $serviceFee = 0;
    $admin_fee3 = 0;
    foreach ($admin_chargers as $charger) {
        $cover_des_B = $charger['cover'];
        $premium = $charger['premium'];
        $adminChargers += $premium;

    // Check cover description and assign premium to corresponding variable
    if ($cover_des_B == "Policy Fee (S2S / BPA)") {
        $policyFee = $premium;
        //echo 'policyFee: ' . $policyFee . '<br>';
    } elseif($cover_des_B == "Service Fee (B2B)"){
        $serviceFee = $premium;
        //echo 'serviceFee: ' . $serviceFee . '<br>';
    }elseif($cover_des_B == "Admin Fee 3"){
        $admin_fee3 = $premium;
        //echo 'admin_fee3: ' . $admin_fee3 . '<br>';
    }elseif($cover_des_B == "Admin Charges / Cess"){
        $admin_fee3 = $premium;
        //echo 'admin_fee3: ' . $admin_fee3 . '<br>';
    }
    }
} else {
    // echo "No admin chargers data found in session.";
}
//End

$total_of_admin_fees = ($admin_fee3 + $policyFee + $serviceFee);
//echo 'total_of_admin_fees: ' . $total_of_admin_fees . '<br>';
$total_premium_after_deduct_fees = ($without_vat_ssl - $total_of_admin_fees);
//echo 'total_premium_after_deduct_fees: ' . $total_premium_after_deduct_fees . '<br>';
$gross_premium = ($total_premium_after_deduct_fees / 102.5) * 100;
//echo 'gross_premium: ' . $gross_premium . '<br>';
$replace_rate = ($gross_premium / $converted);
$replace_rate = $replace_rate * 100 ;
$replace_rate = number_format($replace_rate, 6);
//echo 'replace_rate: ' . $replace_rate . '<br>';
$vehirate_ = $replace_rate ;
}

/////////////////////////// PREMIUM EDJUSTMENT ////////////////////////////

$vehirate_ = $vehirate_ / 100 ;
//echo 'vehicleRate: ' . $vehirate_ . '<br>';
//SRCC TC Crages
$srccTC = !empty($_SESSION['srccTC']) ? $_SESSION['srccTC'] : null;
        
//Extract values
    if (isset($srccTC)) {
        $SRCCTC_ = $srccTC;
        // Initialize variables to store the premiums
        $loading = 0;

        foreach ($SRCCTC_ as $SRCCTC_premium) {
            $status = $SRCCTC_premium['status'];
            $premium = $SRCCTC_premium['premium'];
            $premium = str_replace(',', '', $premium);

            if ($status == 0) {
                $loading += (float)$premium;
            }
        }
        //cover total with loading
        $loading /= 2;
        $COV_TOT += $loading;
        //echo 'loading: ' . $loading . '<br>';
        //echo 'cover total with loading: ' . $COV_TOT . '<br>';
    }
//ENd

//END
$Our_premium_ = NULL;
$Basic_premium = NULL;
$mr_rate_ = NULL;
$ncb_rate_ = NULL;
$_mr_price = NULL;
$_ncb_price = NULL;
$result_ = NULL;
$flood = NULL;

if (!empty($vehirate_) || !empty($basicrate_) || !empty($sum_insured_)) {
// Sum Insured Without 'Rs' and commas
if ($sum_insured_ !== null && !empty($sum_insured_)) {
    $converted = str_replace(array('Rs.', ','), '', $sum_insured_);
    $_suminsured_ = (int)$converted; 
    //echo 'Sum Insured: ' . $_suminsured_ . '<br>';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////

// Represent new Suminsured as actual sum insured
if (!empty($sum_insured_Edit)){
    $_suminsured_ = $sum_insured_Edit;
    
// Getting Basic Rate for calculating Premium based on sum insured
if (empty($EngineCapacity)){

    if ($_suminsured_ >= 0 && $_suminsured_ <= 9500000) {
        $slab = '0000000-9500000';
    } elseif ($_suminsured_ > 9500000 && $_suminsured_ <= 10000000) {
        $slab = '9500000-10000000';
    } elseif ($_suminsured_ > 10000000 && $_suminsured_ <= 25000000) {
        $slab = '10000000-25000000';
    } elseif ($_suminsured_ > 25000000) {
        $slab = '25000000-above';
    } else {
       // echo "Condition not met";
        $basicrate_ = 0.0;
    }
    
    if (isset($slab)) {
        // Debug: print the query and slab value
       // echo "Slab: $slab<br>";
        
        $sql = "SELECT rate FROM tbl_basicrate_mt WHERE slab = '$slab' AND vehi_type = '$product'";
        //echo "SQL Query: $sql<br>"; // Print the SQL query for verification
        
        $result = $con->query($sql);
    
        if ($result && $row = $result->fetch_assoc()) {
            $basicrate_ = $row['rate'] / 100;
          //  echo "Basic Rate After Recal: $basicrate_<br>";
            //echo "Sum: $sum_ins<br>"; // Print the basic rate for debugging
        } else {
            //echo "Error executing query: " . mysqli_error($con);
        }
    }

} else
{
    if ($EngineCapacity == 'A_250') {
        $eng_cap = $EngineCapacity;
    } elseif ($EngineCapacity == 'B_250') {
        $eng_cap = $EngineCapacity;
    } else {
       // echo "Condition not met";
        $basicrate_ = 0.0;
    }
    
    if (isset($eng_cap)) {
        
        $sql = "SELECT rate FROM tbl_basicrate_mt WHERE engine_capacity = '$eng_cap' AND vehi_type = '$product'";
       // echo "SQL Query: $sql<br>"; // Print the SQL query for verification
        
        $result = $con->query($sql);
    
        if ($result && $row = $result->fetch_assoc()) {
            $basicrate_ = $row['rate'] / 100;
         // echo "Basic Rate After Recal: $basicrate_<br>";
          //  echo "Sum: $sum_ins<br>"; // Print the basic rate for debugging
        } else {
          //  echo "Error executing query: " . mysqli_error($con);
        }
    }
}

// Getting Vehicle Rate for calculating Premium based on sum insured and make code
function getPriceSlab($_suminsured_) {
    if ($_suminsured_ < 5000000) {
        return 'Below 5M';
    } elseif ($_suminsured_ < 6000000) {
        return '5M to 6M';
    } elseif ($_suminsured_ < 7000000) {
        return '6M to 7M';
    } elseif ($_suminsured_ < 8000000) {
        return '7M to 8M';
    } elseif ($_suminsured_ < 9000000) {
        return '8M to 9M';
    } elseif ($_suminsured_ < 10000000) {
        return '9M to 10M';
    } elseif ($_suminsured_ < 11000000) {
        return '10M to 11M';
    } elseif ($_suminsured_ < 12000000) {
        return '11M to 12M';
    } elseif ($_suminsured_ < 13000000) {
        return '12M to 13M';
    } elseif ($_suminsured_ < 14000000) {
        return '13M to 14M';
    } elseif ($_suminsured_ < 15000000) {
        return '14M to 15M';
    } elseif ($_suminsured_ < 16000000) {
        return '15M to 16M';
    } elseif ($_suminsured_ <= 20000000) {
        return '16M to 20M';
    } else {
        return '20M & Above';
    }
}
// Get price slab
$priceSlab = getPriceSlab($_suminsured_);

// First, find the category for the given make_code
if ($SelectCompanyCode === "lb001") {
    $rate_table = "vehicle_rates_leasing";
} elseif ($SelectCompanyCode === "vb002") {
    $rate_table = "vehicle_rates_leasing";
} elseif ($SelectCompanyCode === "afl003") {
    $rate_table = "vehicle_rates_leasing_other";
} elseif ($SelectCompanyCode === "ccl004") {
    $rate_table = "vehicle_rates_leasing_other";
} elseif ($SelectCompanyCode === "of005") {
    $rate_table = "vehicle_rates_leasing_other";
} elseif ($SelectCompanyCode === "amn-001") {
    $rate_table = "vehicle_rates_direct";
} elseif ($SelectCompanyCode === "ab006") {
    $rate_table = "vehicle_rates_leasing_amanabank";
} elseif ($SelectCompanyCode === "mi007") {
    $rate_table = "vehicle_rates_leasing";
} elseif ($SelectCompanyCode === "otr008") {
    $rate_table = "vehicle_rates_leasing_other";
} elseif ($SelectCompanyCode === "otr008-1") {
    $rate_table = "vehicle_rates_leasing_other";
} elseif ($SelectCompanyCode === "hnb009") {
    $rate_table = "vehicle_rates_leasing_other";
} elseif ($SelectCompanyCode === "ctlf010") {
    $rate_table = "vehicle_rates_leasing_other";
} elseif ($SelectCompanyCode === "cbcf011") {
    $rate_table = "vehicle_rates_leasing_other";
} else {
    header("Location: motor-quotation.php");
}

$categoryQuery = "SELECT category_id FROM vehicle_make_category WHERE make_code = ?";
if ($stmt = mysqli_prepare($con, $categoryQuery)) {
mysqli_stmt_bind_param($stmt, 's', $makeModel);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $categoryId);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($categoryId) {
    // Query to fetch rate based on category and price slab
    $rateQuery = "SELECT rate FROM $rate_table WHERE category_id = ? AND price_slab = ?";
    if ($stmt = mysqli_prepare($con, $rateQuery)) {
        mysqli_stmt_bind_param($stmt, 'is', $categoryId, $priceSlab);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $rate);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($rate !== null) {
           // echo "The rate for make code $makeCode with sum insured $sumInsured is $rate.";
            $vehirate_ = $rate / 100;
           // echo "Vehicle Rate After Recal: $vehirate_<br>";
        } else {
            echo "No rate found for the given make code and sum insured.";
            $vehirate_ = 0.0;
        }
    }
} else {
   // echo "No category found for the given make code.";
   $vehirate_ = 0.0;
}
} else {
// echo "Failed to prepare the query.";
$vehirate_ = 0.0;
}
//End of rate part.

}
/////////////////////////////////////////////////////////////////////////////////////

// Calculate Our contribution based on Rate
if ($vehirate_ !== null && !empty($vehirate_)) {
    $Our_premium_ = $_suminsured_ * $vehirate_;
    $Our_premium_ = round((float)$Our_premium_, 2);
  //  echo 'Our Premium: ' . $Our_premium_ . '<br>';
}

// Calculate Basic contribution based on Rate
if ($basicrate_ !== null && !empty($basicrate_)) {
    $Basic_premium = $_suminsured_ * $basicrate_;
    $Basic_premium = round((float)$Basic_premium, 2);
  //  echo 'Basic Premium: ' . $Basic_premium . '<br>';
}

// Calculate the Total after reducing Cover Total from Our Premium
$Tot_01_ = ($Our_premium_ - $COV_TOT);
  //Discount if yes
  //$Tot_01_ -= $discount_amount;
  //
//echo 'Total after Cover Deduction: ' . $Tot_01_ . '<br>';

// Calculate Difference between Basic Premium and Total
$different = ($Basic_premium - $Tot_01_);
//echo 'Difference: ' . $different . '<br>';

// Calculate MR and NCB Price (Splitting Difference equally)
$_mr_price = ($different / 2);
//$_mr_price += 3;
$_ncb_price = ($different / 2);
//$_ncb_price += 3;

// Calculate MR Rate based on the formula
$mr_rate_ = ($_mr_price / $Basic_premium) * 100;
//echo 'MR Price: ' . $_mr_price . '<br>';
//echo 'MR Rate: ' . number_format(abs($mr_rate_), 3) . '%<br>'; // Using abs() to match Excel behavior

// Calculate NCB Rate using the correct formula
$_cal = $Basic_premium + abs($_mr_price); // Ensure adding absolute value
//echo 'Basic Premium + MR Price: ' . $_cal . '<br>';

$result_ = abs($_mr_price) / $_cal; // Correct handling of percentage
$ncb_rate_ = $result_ * 100; // Convert to percentage
//echo 'NCB Price: ' . $_ncb_price . '<br>';
//echo 'NCB Rate: ' . number_format($ncb_rate_, 3) . '%<br>';

//Gross Premium Calculation
        // Retrieve the SRCC TC chargers array from the session
        if (isset($_SESSION['srccTC_chargers'])) {
            $SRCCTC_chargers = $_SESSION['srccTC_chargers'];
            $flood = 0;

            foreach ($SRCCTC_chargers as $srtccharger) {
                $cover_des_B = $srtccharger['cover'];
                $premium = $srtccharger['premium'];
                $premium = str_replace(',', '', $premium);

                // Check cover description and assign premium to corresponding variable
                if ($cover_des_B == "Flood & Natural Disaster Perils") {
                    $flood = $premium;
                }
            }
        } 
        //echo $flood;
        // End
$gross_premium = $Tot_01_ + $flood;
//echo 'Gross Premium: ' . $gross_premium . '<br>';

//Passing Session Data
$_SESSION['Tot_01_'] = $Tot_01_;
$_SESSION['_mr_price'] = $_mr_price;
$_SESSION['_ncb_price'] = $_ncb_price;
$_SESSION['mr_rate_'] = number_format(abs($mr_rate_), 3);
$_SESSION['ncb_rate_'] = number_format($ncb_rate_, 3);
$_SESSION['gross_premium_'] = number_format($gross_premium, 2);

//Restore Rates on Session
$_SESSION['vehicleRate']            =       $vehirate_          ;
$_SESSION['basicRate']              =       $basicrate_         ;

//Redirect
}else {
}
//Passing Session Data

?>
