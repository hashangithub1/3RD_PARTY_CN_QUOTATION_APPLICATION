<?php
// Start session at the beginning of your PHP script if not started already
session_start();
include_once('includes/config.php');

              //calculation to get ncb mr 
              $sum_insured      = !empty($_SESSION['sumInsured']) ? $_SESSION['sumInsured'] : null;
              $rate             = !empty($_SESSION['vehicleRate']) ? $_SESSION['vehicleRate'] : null;
              $basicrate        = !empty($_SESSION['basicRate']) ? $_SESSION['basicRate'] : null;
              $seatingCapacity  = !empty($_SESSION['seatingCapacity']) ? $_SESSION['seatingCapacity'] : null;
              $our_cont         = NULL;
              $sum_ins          = NULL;
              $total2           = NULL;
              // $basicrate = 0;
              // $basicrate_cont = 0;
              //Sum Insured Without RS
              if ($sum_insured !== null && !empty($sum_insured)) {
              $coverWithoutRs =   str_replace(array('Rs.', ','), '', $sum_insured);
              $sum_ins        =   (int)$coverWithoutRs;  // For integer
              //$sum_ins = number_format($sum_ins, 2);
              }
              //calculate Our contribution based on Rate
              if ($rate !== null && !empty($rate)) {
              $our_cont     =   $sum_ins * $rate;
              $our_contRS   =   number_format($our_cont). '.00';
              }

              //calculate basic contribution based on Rate
              if ($basicrate !== null && !empty($basicrate)) {
                  $basicrate_cont   =   $sum_ins * $basicrate;
                  $basicrate_contRS =   number_format($basicrate_cont). '.00';

                  $difference       =   $basicrate_cont - $our_cont;
                  $ncb_mr           =   $difference / 2;
                  $ncb_mrRS         =   number_format($ncb_mr, 2);
                  $total1           =   $basicrate_cont - $ncb_mr;

                  }

              //$total1 = $total1 + 1500;
              //Calculate 
              if ($ncb_mr !== null && !empty($ncb_mr)) {
                  $discountNCB      =   $ncb_mr / $basicrate_cont * 100;
                  $discountNCB      =   number_format($discountNCB, 2);
                  $discountMR       =   $ncb_mr / $total1 * 100; 
                  $discountMR       =   number_format($discountMR, 2);
                  }
              //end calculation to get ncb mr

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['initial_amt_T']) && isset($_POST['cover_rate_T']) 
        && isset($_POST['calc_type_T']) && isset($_POST['cov_formula_T'])
        && isset($_POST['code_block_T']) && isset($_POST['is_process_T'])
        && isset($_POST['free_upto_T']) && isset($_POST['cover_des_T'])) {

        $_SESSION['form_data'] = array(
            'initial_amt_T' => $_POST['initial_amt_T'],
            'cover_rate_T' => $_POST['cover_rate_T'],
            'calc_type_T' => $_POST['calc_type_T'],
            'cov_formula_T' => $_POST['cov_formula_T'],
            'code_block_T' => $_POST['code_block_T'],
            'is_process_T' => $_POST['is_process_T'],
            'free_upto_T' => $_POST['free_upto_T'],
            'cover_des_T' => $_POST['cover_des_T'],
        );
    }
}

if (isset($_SESSION['form_data'])) {
    $initial_amt = isset($_SESSION['form_data']['initial_amt_T']) ? $_SESSION['form_data']['initial_amt_T'] : array();
    $cover_rate = isset($_SESSION['form_data']['cover_rate_T']) ? $_SESSION['form_data']['cover_rate_T'] : array();
    $cal_type = isset($_SESSION['form_data']['calc_type_T']) ? $_SESSION['form_data']['calc_type_T'] : array();
    $cov_formula = isset($_SESSION['form_data']['cov_formula_T']) ? $_SESSION['form_data']['cov_formula_T'] : array();
    $code_block = isset($_SESSION['form_data']['code_block_T']) ? $_SESSION['form_data']['code_block_T'] : array();
    $is_process = isset($_SESSION['form_data']['is_process_T']) ? $_SESSION['form_data']['is_process_T'] : array();
    $free_upto = isset($_SESSION['form_data']['free_upto_T']) ? $_SESSION['form_data']['free_upto_T'] : array();
    $cover_des_T = isset($_SESSION['form_data']['cover_des_T']) ? $_SESSION['form_data']['cover_des_T'] : array();
    $total = 0;
    $total1 = 0; 
    foreach ($initial_amt as $index => $amt) {
        $coverRate = isset($cover_rate[$index]) ? $cover_rate[$index] : 0.0;
        $calculation_type = isset($cal_type[$index]) ? $cal_type[$index] : '';
        $formula = isset($cov_formula[$index]) ? htmlspecialchars($cov_formula[$index], ENT_QUOTES, 'UTF-8') : '';
        $codeBlock = isset($code_block[$index]) ? htmlspecialchars($code_block[$index], ENT_QUOTES, 'UTF-8') : '';
        $isprocess = isset($is_process[$index]) ? $is_process[$index] : '';
        $free_upto = isset($free_upto[$index]) ? $free_upto[$index] : 0.0;
        $coverdes_T = isset($cover_des_T[$index]) ? $cover_des_T[$index] : '';
        
        $initialAmount = $amt;
        $premium = '';
    
        switch ($calculation_type) {
            case 'sql-formula':
                if ($isprocess === "yes" ){
                    $coverFormula = $cov_formula[$index];
                    $result_sqlblock = $con->query($coverFormula);
                    if ($result_sqlblock !== false) {
                        try {
                            // Execute code block
                            eval($code_block[$index]);
                            $premium = $PAB_VALUE;
                        } catch (ParseError $e) {
                            echo 'Error in code block: ',  $e->getMessage(), "\n";
                        }
                    } else {
                        echo "Error executing SQL formula: " . $con->error . "<br>";
                    }
                } else {
                    $premium = $amt;
                }
                break;
            case 'cal':
                if ($isprocess === "yes"){
                    $tenPercent = $initialAmount - $free_upto;
                    $calValue = $tenPercent * $coverRate;
                    $premium = $calValue;
                } else {
                    $premium = $amt;
                }
                break;
            case 'fixed':
                if ($isprocess === "yes"){
                    $premium = $amt;
                } else {
                    $premium = $amt;
                }
                break;
            default:
                // Handle other cases or errors if needed
        }
        
        $total += (float)$premium; 
    
        echo "<tr>";
        echo "<td>" . ($index + 1) . "</td>";
        echo "<td><input type='text' name='calc_type[]' value='$calculation_type'></td>";
        echo "<td><input type='number' name='initial_amt[]' value='$amt'></td>";
        echo "<td><input type='number' name='free_upto[]' value='$free_upto'></td>";
        echo "<td><input type='number' name='cover_rate[]' value='$coverRate'></td>";
        echo "<td><input type='text' name='cov_formula[]' value='$formula'></td>";
        echo "<td><input type='text' name='code_block[]' value='$codeBlock'></td>";
        echo "<td><input type='text' name='is_process[]' value='$isprocess'></td>";
        echo "<td><input type='text' name='premium[]' value='$premium' readonly></td>";
        echo "<td><input type='text' name='premium[]' value='$coverdes_T' readonly></td>";
        echo "</tr>";
    }
    
    echo "<tr>";
    echo "<td colspan='3'><b>Total: </b></td>";
    echo "<td><b>$total</b></td>";
    echo "</tr>";
    
}
?>
