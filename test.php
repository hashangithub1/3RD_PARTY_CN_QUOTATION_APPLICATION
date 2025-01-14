<?php session_start();

$total_contribution = !empty($_SESSION['mqForm_premium_matching']) ? $_SESSION['mqForm_premium_matching'] : null;
$sum_insured_ = !empty($_SESSION['mqForm_sumins']) ? $_SESSION['mqForm_sumins'] : null;
if ($sum_insured_ !== null && !empty($sum_insured_)) {
    $converted = str_replace(array('Rs.', ','), '', $sum_insured_);
   echo 'Sum Insured: ' . $converted . '<br>';
}

echo 'total_contribution: ' . $total_contribution . '<br>';
$without_vat = ($total_contribution / 118) * 100;
$without_vat = $without_vat;
echo 'without_vat: ' . $without_vat . '<br>';
$without_vat_ssl = ($without_vat / 102.5) * 100;
echo 'without_vat_ssl: ' . $without_vat_ssl . '<br>';

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
        echo 'policyFee: ' . $policyFee . '<br>';
    } elseif($cover_des_B == "Service Fee (B2B)"){
        $serviceFee = $premium;
        echo 'serviceFee: ' . $serviceFee . '<br>';
    }elseif($cover_des_B == "Admin Fee 3"){
        $admin_fee3 = $premium;
        echo 'admin_fee3: ' . $admin_fee3 . '<br>';
    }
    }
} else {
    // echo "No admin chargers data found in session.";
}
//End

$total_of_admin_fees = ($admin_fee3 + $policyFee + $serviceFee);
echo 'total_of_admin_fees: ' . $total_of_admin_fees . '<br>';
$total_premium_after_deduct_fees = ($without_vat_ssl - $total_of_admin_fees);
echo 'total_premium_after_deduct_fees: ' . $total_premium_after_deduct_fees . '<br>';
$gross_premium = ($total_premium_after_deduct_fees / 102.5) * 100;
echo 'gross_premium: ' . $gross_premium . '<br>';
$replace_rate = ($gross_premium / $converted);
$replace_rate = $replace_rate * 100 ;
$replace_rate = number_format($replace_rate, 6);
echo 'replace_rate: ' . $replace_rate . '<br>';
?>