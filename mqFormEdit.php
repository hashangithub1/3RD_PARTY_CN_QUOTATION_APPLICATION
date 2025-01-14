<?php session_start();
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

include_once('includes/config.php');
include_once('datagrid-mt.php');
include_once('calculation-mt-02');
$total1 = 0;
$total2 = 0;
$total3 = 0;
$total4 = 0;
$total5 = 0;
$total21 = 0;
//New Quotation Number (Revision)
define('SEQUENCE_FILE', 'sequence.txt');
define('PREFIX', 'Q');

function getCurrentSequence() {
    if (!file_exists(SEQUENCE_FILE)) {
        return 1;
    }
    $sequence = file_get_contents(SEQUENCE_FILE);
    return intval($sequence);
}

function saveCurrentSequence($sequence) {
    file_put_contents(SEQUENCE_FILE, $sequence);
}
function generateQuotationNumber() {
    $currentSequence = getCurrentSequence();
    $quotationNumber = PREFIX . str_pad($currentSequence, 5, '0', STR_PAD_LEFT);
    $nextSequence = $currentSequence + 1;
    saveCurrentSequence($nextSequence);

    return $quotationNumber;
}
// Generate and display the quotation number
$Newquote_no =  generateQuotationNumber();
$_SESSION['REV_quote_no'] = $Newquote_no ;
//End

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amana | Motor Quotation</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/select2/select2.min.css">
  <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/fav-icon.jpg" />

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link href="path/to/select2.min.css" rel="stylesheet" />
  <script src="path/to/jquery.min.js"></script>
  <script src="path/to/select2.min.js"></script>

  <style>
    .container-form {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        border: 1px solid #81bd43;
        border-radius:10px;            
    }
    .form-column {
        flex: 1;
        padding: 10px;
    }
    .form-group {
        margin-bottom: 1px;
    }
    label {
        display: block;
        margin-top:5px;
        margin-bottom: 5px; 
    }
    input[type="text"], input[type="email"], input[type="date"], select {
        width: 100%;
        padding: 5px;
        font-size: 13px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        background: white;
        color:#5d6771;
    }
    select:focus {
    border-color: #81bd41; 
    }
    input:focus {
    border-color: #81bd41; 
    }
    select:active {
    border-color: #81bd41; 
    }
    textarea {
      width: 100%;
      height: 100px;
      border: 1px solid #ccc;
      box-sizing: border-box;
      background: white;
      color:#5d6771;
    }
    textarea:focus {
    border-color: #81bd41; 
    }
    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #45a049;
    }
    .heading {
      font-size:15px;
      color: #81bd44;
    }
    hr {
      background: #81bd44;
    }
    .daterange {
      display:flex;
    }
    .form-check {
      margin-top:0px;
      margin-bottom:0px;
    }

    @media screen and (max-width: 480px) {
    .container-form {
    display: block;
    }
    .daterange {
      display: block;
      width: 90%;
    }
    }
    /* Tab */
    ul.tabs {
      margin: 0;;
      float: left;
      list-style: none;
      height: 32px;
      width: 100%;
    }

    ul.tabs li {
      float: left;
      margin-right: 5px;
      cursor: pointer;
      padding: 0px 21px;
      line-height: 31px;
      background-color: #5d6771;
      color: #ccc;
      overflow: hidden;
      position: relative;
    }

    ul.tabs li:hover {
      background-color: #81bd43;
      color: #333;
    }

    ul.tabs li.active {
      background-color: #81bd43;
      color: #333;
      border-bottom: 1px solid #fff;
      display: block;
    }

    .tab_container {
      clear: both;
      float: left;
      width: 100%;
      background: #fff;
      overflow: auto;
    }
    .tab_content {
      padding: 20px;
      display: none;
    }

    .tab_drawer_heading { display: none; }

    @media screen and (max-width: 480px) {
      .tabs {
      display: none;
    }
    .tab_drawer_heading {
      background-color: #ccc;
      color: #fff;
      border-top: 1px solid #333;
      margin: 0;
      padding: 5px 20px;
      display: block;
      cursor: pointer;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    .d_active {
      background-color: #666;
      color: #fff;
    }
  }

  /* Datagrid */
  .table-responsive {
  overflow-x: auto;
}

.custom-table {
  width: 100%;
  border-collapse: collapse;
  font-size:13px;
}

.custom-table th,
.custom-table td {
  border: 1px solid #81bd43;
  padding: 5px;
  text-align: left;
}
.td-premium {
  text-align: right;
}
.custom-table th {
  background-color: #81bd43;
}

.custom-table tbody tr:nth-child(even) {
  background-color: ;
}

    
.add-button, .remove-button, .save-button {
  display: inline-block;
  background-color: #81bd43;
  margin-top: 10px;
  border-radius: 0px;
  padding-top: 2px;
  padding-left: 10px;
  padding-right: 10px;
  padding-bottom: 2px;
}
button:hover {
  background-color: #81bd43;
}

.save-button1 {
  display: inline-block;
  background-color: #81bd43;
  margin-top: 10px;
  border-radius: 0px;
  padding-top: 2px;
  padding-left: 10px;
  padding-right: 10px;
  padding-bottom: 2px;
}
</style>

</head>

<body>

  <div class="container-scroller">
    <!-- partial:../partials/_navbar.html -->
    <?php include_once('includes/navbar.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php'); ?>
      <!-- partial -->

      <!-- Code here -->
      <div class="container mt-4"> 
      <div class="tabform-container">
      <ul class="tabs">
        <li class="active" rel="tab1">Quotation Form</li>
      </ul>
      <div class="tab_container">
        <h3 class="d_active tab_drawer_heading" rel="tab1">Tab 1</h3>
        <div id="tab1" class="tab_content">
 
        <!-- Quotation Form -->
        <?php
              // Getting Recalculation Data from POST
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['initial_amt_T']) && isset($_POST['cover_rate_T']) 
                    && isset($_POST['calc_type_T']) && isset($_POST['cov_formula_T'])
                    && isset($_POST['code_block_T']) && isset($_POST['is_process_T'])
                    && isset($_POST['free_upto_T']) && isset($_POST['cover_des_T'])
                    && isset($_POST['default_stat_T']) && isset($_POST['cover_code_T'])
                    && isset($_POST['calc_seq_T']) && isset($_POST['cover_area_T'])
                    && isset($_POST['edit_flag_T']) && isset($_POST['max_limit_T'])
                    && isset($_POST['min_limit_T'])

                    && isset($_POST['initial_amt_B']) && isset($_POST['cover_rate_B']) 
                    && isset($_POST['calc_type_B']) && isset($_POST['cov_formula_B'])
                    && isset($_POST['code_block_B']) && isset($_POST['is_process_B'])
                    && isset($_POST['free_upto_B']) && isset($_POST['cover_des_B'])
                    && isset($_POST['default_stat_B']) && isset($_POST['cover_code_B'])
                    && isset($_POST['calc_seq_B']) && isset($_POST['cover_area_B'])
                    && isset($_POST['edit_flag_B']) && isset($_POST['max_limit_B'])
                    && isset($_POST['min_limit_B'])

                    && isset($_POST['initial_amt_B_ADM']) && isset($_POST['cover_rate_B_ADM']) 
                    && isset($_POST['calc_type_B_ADM']) && isset($_POST['cov_formula_B_ADM'])
                    && isset($_POST['code_block_B_ADM']) && isset($_POST['is_process_B_ADM'])
                    && isset($_POST['free_upto_B_ADM']) && isset($_POST['cover_des_B_ADM'])
                    && isset($_POST['default_stat_B_ADM']) && isset($_POST['cover_code_B_ADM'])
                    && isset($_POST['calc_seq_B_ADM']) && isset($_POST['cover_area_B_ADM'])
                    && isset($_POST['edit_flag_B_ADM']) && isset($_POST['max_limit_B_ADM'])
                    && isset($_POST['min_limit_B_ADM'])

                    && isset($_POST['initial_amt_B_ADM1']) && isset($_POST['cover_rate_B_ADM1']) 
                    && isset($_POST['calc_type_B_ADM1']) && isset($_POST['cov_formula_B_ADM1'])
                    && isset($_POST['code_block_B_ADM1']) && isset($_POST['is_process_B_ADM1'])
                    && isset($_POST['free_upto_B_ADM1']) && isset($_POST['cover_des_B_ADM1'])
                    && isset($_POST['default_stat_B_ADM1']) && isset($_POST['cover_code_B_ADM1'])
                    && isset($_POST['calc_seq_B_ADM1']) && isset($_POST['cover_area_B_ADM1'])
                    && isset($_POST['edit_flag_B_ADM1']) && isset($_POST['max_limit_B_ADM1'])
                    && isset($_POST['min_limit_B_ADM1'])

                    && isset($_POST['initial_amt_B_ADMT']) && isset($_POST['cover_rate_B_ADMT']) 
                    && isset($_POST['calc_type_B_ADMT']) && isset($_POST['cov_formula_B_ADMT'])
                    && isset($_POST['code_block_B_ADMT']) && isset($_POST['is_process_B_ADMT'])
                    && isset($_POST['free_upto_B_ADMT']) && isset($_POST['cover_des_B_ADMT'])
                    && isset($_POST['default_stat_B_ADMT']) && isset($_POST['cover_code_B_ADMT'])
                    && isset($_POST['calc_seq_B_ADMT']) && isset($_POST['cover_area_B_ADMT'])
                    && isset($_POST['edit_flag_B_ADMT']) && isset($_POST['max_limit_B_ADMT'])
                    && isset($_POST['min_limit_B_ADMT'])) {
            
                    $_SESSION['form_data'] = array(
                        'initial_amt_T' => $_POST['initial_amt_T'],
                        'cover_rate_T' => $_POST['cover_rate_T'],
                        'calc_type_T' => $_POST['calc_type_T'],
                        'cov_formula_T' => $_POST['cov_formula_T'],
                        'code_block_T' => $_POST['code_block_T'],
                        'is_process_T' => $_POST['is_process_T'],
                        'free_upto_T' => $_POST['free_upto_T'],
                        'cover_des_T' => $_POST['cover_des_T'],
                        'default_stat_T' => $_POST['default_stat_T'],
                        'cover_code_T' => $_POST['cover_code_T'],
                        'calc_seq_T' => $_POST['calc_seq_T'],
                        'cover_area_T' => $_POST['cover_area_T'],
                        'edit_flag_T' => $_POST['edit_flag_T'],
                        'max_limit_T' => $_POST['max_limit_T'],
                        'min_limit_T' => $_POST['min_limit_T'],

                        'initial_amt_B' => $_POST['initial_amt_B'],
                        'cover_rate_B' => $_POST['cover_rate_B'],
                        'calc_type_B' => $_POST['calc_type_B'],
                        'cov_formula_B' => $_POST['cov_formula_B'],
                        'code_block_B' => $_POST['code_block_B'],
                        'is_process_B' => $_POST['is_process_B'],
                        'free_upto_B' => $_POST['free_upto_B'],
                        'cover_des_B' => $_POST['cover_des_B'],
                        'default_stat_B' => $_POST['default_stat_B'],
                        'cover_code_B' => $_POST['cover_code_B'],
                        'calc_seq_B' => $_POST['calc_seq_B'],
                        'cover_area_B' => $_POST['cover_area_B'],
                        'edit_flag_B' => $_POST['edit_flag_B'],
                        'max_limit_B' => $_POST['max_limit_B'],
                        'min_limit_B' => $_POST['min_limit_B'],

                        'initial_amt_B_ADM' => $_POST['initial_amt_B_ADM'],
                        'cover_rate_B_ADM' => $_POST['cover_rate_B_ADM'],
                        'calc_type_B_ADM' => $_POST['calc_type_B_ADM'],
                        'cov_formula_B_ADM' => $_POST['cov_formula_B_ADM'],
                        'code_block_B_ADM' => $_POST['code_block_B_ADM'],
                        'is_process_B_ADM' => $_POST['is_process_B_ADM'],
                        'free_upto_B_ADM' => $_POST['free_upto_B_ADM'],
                        'cover_des_B_ADM' => $_POST['cover_des_B_ADM'],
                        'default_stat_B_ADM' => $_POST['default_stat_B_ADM'],
                        'cover_code_B_ADM' => $_POST['cover_code_B_ADM'],
                        'calc_seq_B_ADM' => $_POST['calc_seq_B_ADM'],
                        'cover_area_B_ADM' => $_POST['cover_area_B_ADM'],
                        'edit_flag_B_ADM' => $_POST['edit_flag_B_ADM'],
                        'max_limit_B_ADM' => $_POST['max_limit_B_ADM'],
                        'min_limit_B_ADM' => $_POST['min_limit_B_ADM'],

                        'initial_amt_B_ADM1' => $_POST['initial_amt_B_ADM1'],
                        'cover_rate_B_ADM1' => $_POST['cover_rate_B_ADM1'],
                        'calc_type_B_ADM1' => $_POST['calc_type_B_ADM1'],
                        'cov_formula_B_ADM1' => $_POST['cov_formula_B_ADM1'],
                        'code_block_B_ADM1' => $_POST['code_block_B_ADM1'],
                        'is_process_B_ADM1' => $_POST['is_process_B_ADM1'],
                        'free_upto_B_ADM1' => $_POST['free_upto_B_ADM1'],
                        'cover_des_B_ADM1' => $_POST['cover_des_B_ADM1'],
                        'default_stat_B_ADM1' => $_POST['default_stat_B_ADM1'],
                        'cover_code_B_ADM1' => $_POST['cover_code_B_ADM1'],
                        'calc_seq_B_ADM1' => $_POST['calc_seq_B_ADM1'],
                        'cover_area_B_ADM1' => $_POST['cover_area_B_ADM1'],
                        'edit_flag_B_ADM1' => $_POST['edit_flag_B_ADM1'],
                        'max_limit_B_ADM1' => $_POST['max_limit_B_ADM1'],
                        'min_limit_B_ADM1' => $_POST['min_limit_B_ADM1'],

                        'initial_amt_B_ADMT' => $_POST['initial_amt_B_ADMT'],
                        'cover_rate_B_ADMT' => $_POST['cover_rate_B_ADMT'],
                        'calc_type_B_ADMT' => $_POST['calc_type_B_ADMT'],
                        'cov_formula_B_ADMT' => $_POST['cov_formula_B_ADMT'],
                        'code_block_B_ADMT' => $_POST['code_block_B_ADMT'],
                        'is_process_B_ADMT' => $_POST['is_process_B_ADMT'],
                        'free_upto_B_ADMT' => $_POST['free_upto_B_ADMT'],
                        'cover_des_B_ADMT' => $_POST['cover_des_B_ADMT'],
                        'default_stat_B_ADMT' => $_POST['default_stat_B_ADMT'],
                        'cover_code_B_ADMT' => $_POST['cover_code_B_ADMT'],
                        'calc_seq_B_ADMT' => $_POST['calc_seq_B_ADMT'],
                        'cover_area_B_ADMT' => $_POST['cover_area_B_ADMT'],
                        'edit_flag_B_ADMT' => $_POST['edit_flag_B_ADMT'],
                        'max_limit_B_ADMT' => $_POST['max_limit_B_ADMT'],
                        'min_limit_B_ADMT' => $_POST['min_limit_B_ADMT'],
                    );
                    //  echo '<pre>';
                    //  print_r($_SESSION['form_data']);
                    //  echo '</pre>';
                }

            }
              // End 
        ?>
        <!-- End Quotation Form -->
        <div class="table-responsive">
          <form id="coverForm" action="editedMQsubmit.php" method="POST" target="_blank">
            <table class="custom-table">
            <?php                          
              //calculation to get ncb mr 
              $sum_insured      = !empty($_SESSION['mqForm_sumins']) ? $_SESSION['mqForm_sumins'] : null;
              $basic_premium    = !empty($_SESSION['mqForm_basicPremium']) ? $_SESSION['mqForm_basicPremium'] : null;
              $rates            = !empty($_SESSION['mqForm_vehiRate']) ? $_SESSION['mqForm_vehiRate'] : null;
              $rate             = $rates / 100;
              $basicrates       = !empty($_SESSION['mqForm_basicRate']) ? $_SESSION['mqForm_basicRate'] : null;
              $basicrate        = $basicrates / 100;
              $seatingCapacity  = !empty($_SESSION['mqForm_seatingCapacity']) ? $_SESSION['mqForm_seatingCapacity'] : null;
              $our_cont         = NULL;
              $sum_ins          = NULL;
              $total2           = NULL;
              $total3           = NULL;
              $total4           = NULL;
              $total5           = NULL;
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
                  $_SESSION['FORMEDIT_ncb_mr_Amt'] = $ncb_mr;
                  }

              //$total1 = $total1 + 1500;
              //Calculate 
              if ($ncb_mr !== null && !empty($ncb_mr)) {
                  $discountNCB      =   $ncb_mr / $basicrate_cont * 100;
                  $discountNCB      =   number_format($discountNCB, 2);
                  $_SESSION['FORMEDITncbRate'] = $discountNCB;
                  $discountMR       =   $ncb_mr / $total1 * 100; 
                  $discountMR       =   number_format($discountMR, 2);
                  $_SESSION['FORMEDITmrRate'] = $discountMR;
                  }
              //end calculation to get ncb mr
              //echo "sumins:$sum_insured, basic Premium: $basic_premium, Vehicle Rate: $rates, baisc Rate: $basicrate";
              ?>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Cover type </th>
                  <th>Value (int amt)</th>
                  <th>Premium (Rs)</th>
                </tr>
              </thead>

              <tbody id="coverTable">
                <tr>
                 <td>>></td>
                 <td><b>SUM INSURED </b></td> 
                 <td><input style='text-align: right;' type='number' class='value-input' value="" placeholder='0.0' readonly></td>

                 <td style='text-align: right;'><b><?php echo $sum_insured1 = number_format($sum_insured, 2);?></b></td>
                 </tr>

                 <tr>
                 <td>>></td>
                 <td><b>BASIC PREMIUM </b></td> 
                 <td><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td>

                 <td style='text-align: right;'><b><?php echo $basic_premium1 = number_format($basic_premium, 2); ?></b></td>
                 </tr>

                 <tr style="display:none;">
                 <td>>></td>
                 <td><b>NCB (%)</b></td>
                 <td><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td> 

                 <td style='text-align: right;'><b><?php echo $ncb_mrRS ?></b></td>
                 </tr>
                <?php
                // Recalculation Process Top
                $srccTC_chargers = array();
                // Access recalculation Data from Session Array
                if (isset($_SESSION['form_data'])) {
                  $initial_amt = isset($_SESSION['form_data']['initial_amt_T']) ? $_SESSION['form_data']['initial_amt_T'] : array();
                  $cover_rate = isset($_SESSION['form_data']['cover_rate_T']) ? $_SESSION['form_data']['cover_rate_T'] : array();
                  $cal_type = isset($_SESSION['form_data']['calc_type_T']) ? $_SESSION['form_data']['calc_type_T'] : array();
                  $cov_formula = isset($_SESSION['form_data']['cov_formula_T']) ? $_SESSION['form_data']['cov_formula_T'] : array();
                  $code_block = isset($_SESSION['form_data']['code_block_T']) ? $_SESSION['form_data']['code_block_T'] : array();
                  $is_process = isset($_SESSION['form_data']['is_process_T']) ? $_SESSION['form_data']['is_process_T'] : array();
                  $free_upto_T = isset($_SESSION['form_data']['free_upto_T']) ? $_SESSION['form_data']['free_upto_T'] : array();
                  $cover_des_T = isset($_SESSION['form_data']['cover_des_T']) ? $_SESSION['form_data']['cover_des_T'] : array();
                  $default_stat_T = isset($_SESSION['form_data']['default_stat_T']) ? $_SESSION['form_data']['default_stat_T'] : array();
                  $cover_code_T = isset($_SESSION['form_data']['cover_code_T']) ? $_SESSION['form_data']['cover_code_T'] : array();
                  $calc_seq_T = isset($_SESSION['form_data']['calc_seq_T']) ? $_SESSION['form_data']['calc_seq_T'] : array();
                  $cover_area_T = isset($_SESSION['form_data']['cover_area_T']) ? $_SESSION['form_data']['cover_area_T'] : array();
                  $edit_flag_T = isset($_SESSION['form_data']['edit_flag_T']) ? $_SESSION['form_data']['edit_flag_T'] : array();
                  $maxLimit = isset($_SESSION['form_data']['max_limit_T']) ? max($_SESSION['form_data']['max_limit_T']) : 0;
                  $minLimit = isset($_SESSION['form_data']['min_limit_T']) ? $_SESSION['form_data']['min_limit_T'] : array();
                  // echo "Free up to: $free_upto"; 
                  foreach ($initial_amt as $index => $amt) {

                    $defaultstat_T = isset($default_stat_T[$index]) ? $default_stat_T[$index] : '';

                      // Skip the calculation if default_stat_T is "No"
                      if ($defaultstat_T === 'No') {
                          continue;
                      }
                      $coverRate = isset($cover_rate[$index]) ? $cover_rate[$index] : 0.0;
                      $calculation_type = isset($cal_type[$index]) ? $cal_type[$index] : '';
                      $formula = isset($cov_formula[$index]) ? htmlspecialchars($cov_formula[$index], ENT_QUOTES, 'UTF-8') : '';
                      $codeBlock = isset($code_block[$index]) ? htmlspecialchars($code_block[$index], ENT_QUOTES, 'UTF-8') : '';
                      $isprocess = isset($is_process[$index]) ? $is_process[$index] : '';
                      $free_upto = isset($free_upto_T[$index]) ? $free_upto_T[$index] : 0.0;
                      $coverdes_T = isset($cover_des_T[$index]) ? $cover_des_T[$index] : '';
                      //  $defaultstat_T = isset($default_stat_T[$index]) ? $default_stat_T[$index] : '';
                      $cover_code = isset($cover_code_T[$index]) ? $cover_code_T[$index] : '';
                      $calc_seq = isset($calc_seq_T[$index]) ? $calc_seq_T[$index] : '';
                      $cover_area = isset($cover_area_T[$index]) ? $cover_area_T[$index] : '';
                      $edit_flag = isset($edit_flag_T[$index]) ? $edit_flag_T[$index] : '';
                      $initialAmount = $amt;
                      $premium = '';
                      //echo "Free up to: $free_upto\n";
                      //echo "Free up to: $free_upto"; 
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
                                  $premium = 0;
                              }
                              break;
                              case 'cal':
                                //echo "Cal Case<br>";
                                if ($isprocess === "yes") {
                                    eval($code_block[$index]);
                                    $premium = $calValue;
                                } else {
                                  $premium = 0;
                                }
                                break;
                          case 'rate':
                              if ($isprocess === "yes"){
                                eval($code_block[$index]);
                                $premium = $amt;
                                } 
                                else {
                                  $premium = 0;
                                }
                               
                              break;
                          case 'fixed':
                              if ($isprocess === "yes"){
                                  $premium = $amt;
                              } else {
                                $premium = 0;
                              }
                              break;
                          case 'user-input':
                              if ($isprocess === "yes"){
                                $premium = $amt;
                                } 
                                else {
                                  $premium = 0;
                                }
                              break;
                          default:
                              // Handle other cases or errors if needed
                      }
                      $cover_area = "CTNM";
                      $total1 += (float)$premium; 

                      // Add details to admin chargers array
                      $srccTC_chargers[] = array(
                        'cover' => $coverdes_T,
                        'premium' => $premium
                      );
                  // Determine readonly attribute based on edit_flag
                  $readonly = ($edit_flag == 0) ? "readonly" : "";

                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . ($index + 1) . "</td>";
                      echo "<td>" . $coverdes_T . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_T[]' value='" . $coverdes_T . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_T[]' value='" . $cover_code . "'></td>";
                      echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_T[]' value='" . $initialAmount . "' oninput='recalculatePremium(this)' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_T[]' value='" . $coverRate . "' $readonly></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_T[]' value='" . $calculation_type . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_T[]' value='" . $formula . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_T[]' value='" . $codeBlock . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_T[]' value='" . $free_upto . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_T[]' value='" . $isprocess . "'></td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='default_stat_T[]'>";
                      echo "<option value='Yes'" . ($defaultstat_T == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($defaultstat_T == 'n' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;' class='premium'>" . $premium = number_format($premium, 2) . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_T[]' value='" . $premium . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_T[]' value='" . $calc_seq . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_T[]' value='" . $cover_area . "'></td>";
                      echo "</tr>";

                  }
                  $_SESSION['srccTC_chargers'] = $srccTC_chargers;
                  
              }
                // End
                if ($ncb_mr !== null && !empty($ncb_mr)) {
                  $discountMR     =   $ncb_mr / $total1 * 100; 
                  $discountMR     =   number_format($discountMR, 2);
                  $_SESSION['FORMEDITmrRate'] = $discountMR;
                  }
                // End Recalculation Process
                ?>
              
                <tr style="display:none;">
                <td>>></td>
                <td><b>MR</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>

                <td style='text-align: right;' id="total-contribution"><b><?php echo $ncb_mrRS ?></b></td>
                </tr>
        
                <tr>
                <td>>></td>
                <td><b>TOTAL 01</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>

                <td style='text-align: right;' id="total-contribution"><b><?php echo $total1NUMBER = number_format($total1, 2);?></b></td>
                </tr>
                <?php
                // Recalculation Process Bottum
                $other_cover_chargers = array();
                // Access recalculation Data from Session Array
                if (isset($_SESSION['form_data'])) {
                  $initial_amt = isset($_SESSION['form_data']['initial_amt_B']) ? $_SESSION['form_data']['initial_amt_B'] : array();
                  $cover_rate = isset($_SESSION['form_data']['cover_rate_B']) ? $_SESSION['form_data']['cover_rate_B'] : array();
                  $cal_type = isset($_SESSION['form_data']['calc_type_B']) ? $_SESSION['form_data']['calc_type_B'] : array();
                  $cov_formula = isset($_SESSION['form_data']['cov_formula_B']) ? $_SESSION['form_data']['cov_formula_B'] : array();
                  $code_block = isset($_SESSION['form_data']['code_block_B']) ? $_SESSION['form_data']['code_block_B'] : array();
                  $is_process = isset($_SESSION['form_data']['is_process_B']) ? $_SESSION['form_data']['is_process_B'] : array();
                  $free_upto = isset($_SESSION['form_data']['free_upto_B']) ? $_SESSION['form_data']['free_upto_B'] : array();
                  $cover_des_T = isset($_SESSION['form_data']['cover_des_B']) ? $_SESSION['form_data']['cover_des_B'] : array();
                  $default_stat_T = isset($_SESSION['form_data']['default_stat_B']) ? $_SESSION['form_data']['default_stat_B'] : array();
                  $cover_code_T = isset($_SESSION['form_data']['cover_code_B']) ? $_SESSION['form_data']['cover_code_B'] : array();
                  $calc_seq_T = isset($_SESSION['form_data']['calc_seq_B']) ? $_SESSION['form_data']['calc_seq_B'] : array();
                  $cover_area_T = isset($_SESSION['form_data']['cover_area_B']) ? $_SESSION['form_data']['cover_area_B'] : array();
                  $edit_flag_T = isset($_SESSION['form_data']['edit_flag_B']) ? $_SESSION['form_data']['edit_flag_B'] : array();
                  $maxLimit = isset($_SESSION['form_data']['max_limit_B']) ? max($_SESSION['form_data']['max_limit_B']) : 0;
                  $minLimit = isset($_SESSION['form_data']['min_limit_B']) ? $_SESSION['form_data']['min_limit_B'] : array();

                  foreach ($initial_amt as $index => $amt) {

                    $defaultstat_T = isset($default_stat_T[$index]) ? $default_stat_T[$index] : '';

                      // Skip the calculation if default_stat_T is "No"
                      if ($defaultstat_T === 'No') {
                          continue;
                      }

                      $coverRate = isset($cover_rate[$index]) ? $cover_rate[$index] : 0.0;
                      $calculation_type = isset($cal_type[$index]) ? $cal_type[$index] : '';
                      $formula = isset($cov_formula[$index]) ? htmlspecialchars($cov_formula[$index], ENT_QUOTES, 'UTF-8') : '';
                      $codeBlock = isset($code_block[$index]) ? htmlspecialchars($code_block[$index], ENT_QUOTES, 'UTF-8') : '';
                      $isprocess = isset($is_process[$index]) ? $is_process[$index] : '';
                      $free_upto = isset($free_upto[$index]) ? $free_upto[$index] : 0.0;
                      $coverdes_T = isset($cover_des_T[$index]) ? $cover_des_T[$index] : '';
                     // $defaultstat_T = isset($default_stat_T[$index]) ? $default_stat_T[$index] : '';
                      $cover_code = isset($cover_code_T[$index]) ? $cover_code_T[$index] : '';
                      $calc_seq = isset($calc_seq_T[$index]) ? $calc_seq_T[$index] : '';
                      $cover_area = isset($cover_area_T[$index]) ? $cover_area_T[$index] : '';
                      $edit_flag = isset($edit_flag_T[$index]) ? $edit_flag_T[$index] : '';
                      $initialAmount = $amt;
                      $premium = '';
                      //echo "Free up to: $free_upto\n";
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
                                $premium = 0;
                              }
                              break;
                              case 'cal':
                                //echo "Cal Case<br>";
                                if ($isprocess === "yes") {
                                    eval($code_block[$index]);
                                    $premium = $calValue;
                                } else {
                                  $premium = 0;
                                }
                                break;
                          case 'rate':
                              if ($isprocess === "yes"){
                                eval($code_block[$index]);
                                $premium = $amt;
                                } 
                                else {
                                  $premium = 0;
                                }
                                
                              break;
                          case 'fixed':
                              if ($isprocess === "yes"){
                                  $premium = $amt;
                              } else {
                                $premium = 0;
                              }
                              break;
                          case 'user-input':
                              if ($isprocess === "yes"){
                                $premium = $amt;
                                } 
                                else {
                                  $premium = 0;
                                }
                              break;
                          default:
                              // Handle other cases or errors if needed
                      }
                      $row['cover_area'] = "CBT01";
                      $total2 += (float)$premium; 

                         // Add details to admin chargers array
                    $other_cover_chargers[] = array(
                      'cover' => $coverdes_T,
                      'premium' => $premium
                    );
                  
                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . ($index + 1) . "</td>";
                      echo "<td>" . $coverdes_T . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B[]' value='" . $coverdes_T . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B[]' value='" . $cover_code . "'></td>";
                      echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $initialAmount . "' oninput='recalculatePremium(this)' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B[]' value='" . $coverRate . "' $readonly></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B[]' value='" . $calculation_type . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B[]' value='" . $formula . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B[]' value='" . $codeBlock . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B[]' value='" . $free_upto . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B[]' value='" . $isprocess . "'></td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='default_stat_B[]'>";
                      echo "<option value='Yes'" . ($defaultstat_T == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($defaultstat_T == 'n' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;' class='premium'>" . $premium = number_format($premium, 2) . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B[]' value='" . $premium . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B[]' value='" . $calc_seq . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B[]' value='" . $cover_area . "'></td>";
                      echo "</tr>";

                  }
              }
                // End
                // End Recalculation Process
                ?>
                

                <tr>
                <td>>></td>
                <td><b>GROSS CONTRIBUTION (TOTAL 02)</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>

                <td style='text-align: right;' id="total-contribution"><b><?php $tot2 = $total2 + $total1;
                echo $total2NUMBER = number_format($tot2, 2);
                $_SESSION['MYFORMGrossContribution_tot02'] = $tot2; ?></b></td>
                </tr>
                <?php
                // Recalculation Process Bottom Admin Charges
                $admin_chargers = array(); // Initialize the admin chargers array
                // Access recalculation Data from Session Array
                if (isset($_SESSION['form_data'])) {
                    $initial_amt = isset($_SESSION['form_data']['initial_amt_B_ADM']) ? $_SESSION['form_data']['initial_amt_B_ADM'] : array();
                    $cover_rate = isset($_SESSION['form_data']['cover_rate_B_ADM']) ? $_SESSION['form_data']['cover_rate_B_ADM'] : array();
                    $cal_type = isset($_SESSION['form_data']['calc_type_B_ADM']) ? $_SESSION['form_data']['calc_type_B_ADM'] : array();
                    $cov_formula = isset($_SESSION['form_data']['cov_formula_B_ADM']) ? $_SESSION['form_data']['cov_formula_B_ADM'] : array();
                    $code_block = isset($_SESSION['form_data']['code_block_B_ADM']) ? $_SESSION['form_data']['code_block_B_ADM'] : array();
                    $is_process = isset($_SESSION['form_data']['is_process_B_ADM']) ? $_SESSION['form_data']['is_process_B_ADM'] : array();
                    $free_upto = isset($_SESSION['form_data']['free_upto_B_ADM']) ? $_SESSION['form_data']['free_upto_B_ADM'] : array();
                    $cover_des_T = isset($_SESSION['form_data']['cover_des_B_ADM']) ? $_SESSION['form_data']['cover_des_B_ADM'] : array();
                    $default_stat_T = isset($_SESSION['form_data']['default_stat_B_ADM']) ? $_SESSION['form_data']['default_stat_B_ADM'] : array();
                    $cover_code_T = isset($_SESSION['form_data']['cover_code_B_ADM']) ? $_SESSION['form_data']['cover_code_B_ADM'] : array();
                    $calc_seq_T = isset($_SESSION['form_data']['calc_seq_B_ADM']) ? $_SESSION['form_data']['calc_seq_B_ADM'] : array();
                    $cover_area_T = isset($_SESSION['form_data']['cover_area_B_ADM']) ? $_SESSION['form_data']['cover_area_B_ADM'] : array();
                    $edit_flag_T = isset($_SESSION['form_data']['edit_flag_B_ADM']) ? $_SESSION['form_data']['edit_flag_B_ADM'] : array();
                    $maxLimit = isset($_SESSION['form_data']['max_limit_B_ADM']) ? max($_SESSION['form_data']['max_limit_B_ADM']) : 0;
                    $minLimit = isset($_SESSION['form_data']['min_limit_B_ADM']) ? $_SESSION['form_data']['min_limit_B_ADM'] : array();


                    $admin_chargers = array(); // Initialize the admin chargers array

                    foreach ($initial_amt as $index => $amt) {

                      $defaultstat_T = isset($default_stat_T[$index]) ? $default_stat_T[$index] : '';

                      // Skip the calculation if default_stat_T is "No"
                      if ($defaultstat_T === 'No') {
                          continue;
                      }

                        $coverRate = isset($cover_rate[$index]) ? $cover_rate[$index] : 0.0;
                        $calculation_type = isset($cal_type[$index]) ? $cal_type[$index] : '';
                        $formula = isset($cov_formula[$index]) ? htmlspecialchars($cov_formula[$index], ENT_QUOTES, 'UTF-8') : '';
                        $codeBlock = isset($code_block[$index]) ? htmlspecialchars($code_block[$index], ENT_QUOTES, 'UTF-8') : '';
                        $isprocess = isset($is_process[$index]) ? $is_process[$index] : '';
                        $free_upto = isset($free_upto[$index]) ? $free_upto[$index] : 0.0;
                        $coverdes_T = isset($cover_des_T[$index]) ? $cover_des_T[$index] : '';
                       // $defaultstat_T = isset($default_stat_T[$index]) ? $default_stat_T[$index] : '';
                        $cover_code = isset($cover_code_T[$index]) ? $cover_code_T[$index] : '';
                        $calc_seq = isset($calc_seq_T[$index]) ? $calc_seq_T[$index] : '';
                        $cover_area = isset($cover_area_T[$index]) ? $cover_area_T[$index] : '';
                        $edit_flag = isset($edit_flag_T[$index]) ? $edit_flag_T[$index] : '';
                      
                        $initialAmount = $amt;
                        $premium = '';

                        // Debugging: Print current index and initial amount
                        // echo "Index: $index, Initial Amount: $amt<br>";
                        // echo "Calculation Type: $calculation_type, Is Process: $isprocess<br>";

                        switch ($calculation_type) {
                            case 'sql-formula':
                               // echo "SQL Formula Case<br>";
                                if ($isprocess === "yes") {
                                    $coverFormula = $cov_formula[$index];
                                    $result_sqlblock = $con->query($coverFormula);
                                    if ($result_sqlblock !== false) {
                                        try {
                                            // Execute code block
                                            eval($code_block[$index]);
                                            $premium = $PAB_VALUE;
                                        } catch (ParseError $e) {
                                            echo 'Error in code block: ', $e->getMessage(), "<br>";
                                        }
                                    } else {
                                        echo "Error executing SQL formula: " . $con->error . "<br>";
                                    }
                                } else {
                                  $premium = 0;
                                }
                                break;
                            case 'cal':
                                //echo "Cal Case<br>";
                                if ($isprocess === "yes") {
                                    eval($code_block[$index]);
                                    $premium = $calValue;
                                } else {
                                  $premium = 0;
                                }
                                break;
                            case 'rate':
                                //echo "Rate Case<br>";
                                if ($isprocess === "yes") {
                                    eval($code_block[$index]);
                                    $premium = $amt;
                                } else {
                                  $premium = 0;
                                }
                                
                                break;
                            case 'fixed':
                               // echo "Fixed Case<br>";
                                if ($isprocess === "yes") {
                                    $premium = $amt;
                                } else {
                                  $premium = 0;
                                }
                                break;
                            case 'user-input':
                                //echo "User Input Case<br>";
                                if ($isprocess === "yes") {
                                    $premium = $amt;
                                } else {
                                  $premium = 0;
                                }
                                break;
                            default:
                                //echo "Default Case<br>";
                        }

                        // Debugging: Print premium value
                        //echo "Premium: $premium<br>";
                        $cover_area = "CBT02";
                        $total2 += (float)$premium;

                        // Add details to admin chargers array
                        $admin_chargers[] = array(
                            'cover' => $coverdes_T,
                            'premium' => $premium
                        );

                        // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . ($index + 1) . "</td>";
                      echo "<td>" . $coverdes_T . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADM[]' value='" . $coverdes_T . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADM[]' value='" . $cover_code . "'></td>";
                      echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B_ADM[]' value='" . $initialAmount . "' oninput='recalculatePremium(this)' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADM[]' value='" . $coverRate . "' $readonly></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADM[]' value='" . $calculation_type . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADM[]' value='" . $formula . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADM[]' value='" . $codeBlock . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADM[]' value='" . $free_upto . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADM[]' value='" . $isprocess . "'></td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='default_stat_B_ADM[]'>";
                      echo "<option value='Yes'" . ($defaultstat_T == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($defaultstat_T == 'n' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;' class='premium'>" . $premium = number_format($premium, 2) . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADM[]' value='" . $premium . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADM[]' value='" . $calc_seq . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADM[]' value='" . $cover_area . "'></td>";
                      echo "</tr>";

                    }

                    $_SESSION['admin_chargers'] = $admin_chargers;
                }
                // End Recalculation Process
                ?>
          
                <tr>
                <td>>></td>
                <td><b>TOTAL 03</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>

                <td style='text-align: right;' id="total-contribution"><b><?php $tot3 = $total3 + $total2 + $total1; echo $total3NUMBER = number_format($tot3, 2); ?></b></td>
                </tr>
 
                <?php
                // Recalculation Process Bottum Admin Chargers
                $SSCL_chargers = array();
                // Access recalculation Data from Session Array
                if (isset($_SESSION['form_data'])) {
                  $initial_amt = isset($_SESSION['form_data']['initial_amt_B_ADM1']) ? $_SESSION['form_data']['initial_amt_B_ADM1'] : array();
                  $cover_rate = isset($_SESSION['form_data']['cover_rate_B_ADM1']) ? $_SESSION['form_data']['cover_rate_B_ADM1'] : array();
                  $cal_type = isset($_SESSION['form_data']['calc_type_B_ADM1']) ? $_SESSION['form_data']['calc_type_B_ADM1'] : array();
                  $cov_formula = isset($_SESSION['form_data']['cov_formula_B_ADM1']) ? $_SESSION['form_data']['cov_formula_B_ADM1'] : array();
                  $code_block = isset($_SESSION['form_data']['code_block_B_ADM1']) ? $_SESSION['form_data']['code_block_B_ADM1'] : array();
                  $is_process = isset($_SESSION['form_data']['is_process_B_ADM1']) ? $_SESSION['form_data']['is_process_B_ADM1'] : array();
                  $free_upto = isset($_SESSION['form_data']['free_upto_B_ADM1']) ? $_SESSION['form_data']['free_upto_B_ADM1'] : array();
                  $cover_des_T = isset($_SESSION['form_data']['cover_des_B_ADM1']) ? $_SESSION['form_data']['cover_des_B_ADM1'] : array();
                  $default_stat_T = isset($_SESSION['form_data']['default_stat_B_ADM1']) ? $_SESSION['form_data']['default_stat_B_ADM1'] : array();
                  $cover_code_T = isset($_SESSION['form_data']['cover_code_B_ADM1']) ? $_SESSION['form_data']['cover_code_B_ADM1'] : array();
                  $calc_seq_T = isset($_SESSION['form_data']['calc_seq_B_ADM1']) ? $_SESSION['form_data']['calc_seq_B_ADM1'] : array();
                  $cover_area_T = isset($_SESSION['form_data']['cover_area_B_ADM1']) ? $_SESSION['form_data']['cover_area_B_ADM1'] : array();
                  $edit_flag_T = isset($_SESSION['form_data']['edit_flag_B_ADM1']) ? $_SESSION['form_data']['edit_flag_B_ADM1'] : array();
                  $maxLimit = isset($_SESSION['form_data']['max_limit_B_ADM1']) ? max($_SESSION['form_data']['max_limit_B_ADM1']) : 0;
                  $minLimit = isset($_SESSION['form_data']['min_limit_B_ADM1']) ? $_SESSION['form_data']['min_limit_B_ADM1'] : array();

                  foreach ($initial_amt as $index => $amt) {

                    $defaultstat_T = isset($default_stat_T[$index]) ? $default_stat_T[$index] : '';

                      // Skip the calculation if default_stat_T is "No"
                      if ($defaultstat_T === 'No') {
                          continue;
                      }

                      $coverRate = isset($cover_rate[$index]) ? $cover_rate[$index] : 0.0;
                      $calculation_type = isset($cal_type[$index]) ? $cal_type[$index] : '';
                      $formula = isset($cov_formula[$index]) ? htmlspecialchars($cov_formula[$index], ENT_QUOTES, 'UTF-8') : '';
                      $codeBlock = isset($code_block[$index]) ? htmlspecialchars($code_block[$index], ENT_QUOTES, 'UTF-8') : '';
                      $isprocess = isset($is_process[$index]) ? $is_process[$index] : '';
                      $free_upto = isset($free_upto[$index]) ? $free_upto[$index] : 0.0;
                      $coverdes_T = isset($cover_des_T[$index]) ? $cover_des_T[$index] : '';
                      //$defaultstat_T = isset($default_stat_T[$index]) ? $default_stat_T[$index] : '';
                      $cover_code = isset($cover_code_T[$index]) ? $cover_code_T[$index] : '';
                      $calc_seq = isset($calc_seq_T[$index]) ? $calc_seq_T[$index] : '';
                      $cover_area = isset($cover_area_T[$index]) ? $cover_area_T[$index] : '';
                      $edit_flag = isset($edit_flag_T[$index]) ? $edit_flag_T[$index] : '';
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
                                $premium = 0;
                              }
                              break;
                          case 'cal':
                              if ($isprocess === "yes"){
                                  eval($code_block[$index]);
                                  $premium = $calValue;
                              } else {
                                $premium = 0;
                              }
                              break;
                          case 'rate':
                              if ($isprocess === "yes"){
                                eval($code_block[$index]);
                                $premium = $amt;
                                } 
                                else {
                                  $premium = 0;
                                }
                                
                              break;
                          case 'fixed':
                              if ($isprocess === "yes"){

                                  $premium = $amt;
                              } else {
                                $premium = 0;
                              }
                              break;
                          case 'user-input':
                              if ($isprocess === "yes"){
                                $premium = $amt;
                                } 
                                else {
                                  $premium = 0;
                                }
                              break;
                          default:
                              // Handle other cases or errors if needed
                      }
                      $cover_area = "CBT03";
                      $total4 += (float)$premium; 

                        // Add details to VAT chargers array
                      $SSCL_chargers[] = array(
                        'cover' => $coverdes_T,
                        'premium' => $premium
                      );
                        // Output HTML table row
                        echo "<tr>";
                        echo "<td>" . ($index + 1) . "</td>";
                        echo "<td>" . $coverdes_T . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADM1[]' value='" . $coverdes_T . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADM1[]' value='" . $cover_code . "'></td>";
                        echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B_ADM1[]' value='" . $initialAmount . "' oninput='recalculatePremium(this)' $readonly></td>";
                        echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADM1[]' value='" . $coverRate . "' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADM1[]' value='" . $calculation_type . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADM1[]' value='" . $formula . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADM1[]' value='" . $codeBlock . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADM1[]' value='" . $free_upto . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADM1[]' value='" . $isprocess . "'></td>";
                        echo "<td style='display:none'>";
                        echo "<select class='cover-select' name='default_stat_B_ADM1[]'>";
                        echo "<option value='Yes'" . ($defaultstat_T == 'y' ? ' selected' : '') . ">Yes</option>";
                        echo "<option value='No'" . ($defaultstat_T == 'n' ? ' selected' : '') . ">No</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td style='text-align: right;' class='premium'>" . $premium = number_format($premium, 2) . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADM1[]' value='" . $premium . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADM1[]' value='" . $calc_seq . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADM1[]' value='" . $cover_area . "'></td>";
                        echo "</tr>";

                  }
                  $_SESSION['sscl_chargers'] = $SSCL_chargers;
                  // echo "<tr>";
                  // echo "<td colspan='3'><b>Total: </b></td>";
                  // echo "<td><b>$total</b></td>";
                  // echo "</tr>";
                  
              }
                // End
                // End Recalculation Process
                ?>
                

                <tr>
                <td>>></td>
                <td><b>TOTAL 04</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>

                <td style='text-align: right;' id="total-contribution"><b><?php $tot4 = $total4 + $total3 + $total2 + $total1; echo $total4NUMBER = number_format($tot4, 2); ?></b></td>
                </tr>

                <?php
                // Recalculation Process Bottum Admin Chargers
                $vat_chargers = array(); 
                // Access recalculation Data from Session Array
                if (isset($_SESSION['form_data'])) {
                  $initial_amt = isset($_SESSION['form_data']['initial_amt_B_ADMT']) ? $_SESSION['form_data']['initial_amt_B_ADMT'] : array();
                  $cover_rate = isset($_SESSION['form_data']['cover_rate_B_ADMT']) ? $_SESSION['form_data']['cover_rate_B_ADMT'] : array();
                  $cal_type = isset($_SESSION['form_data']['calc_type_B_ADMT']) ? $_SESSION['form_data']['calc_type_B_ADMT'] : array();
                  $cov_formula = isset($_SESSION['form_data']['cov_formula_B_ADMT']) ? $_SESSION['form_data']['cov_formula_B_ADMT'] : array();
                  $code_block = isset($_SESSION['form_data']['code_block_B_ADMT']) ? $_SESSION['form_data']['code_block_B_ADMT'] : array();
                  $is_process = isset($_SESSION['form_data']['is_process_B_ADMT']) ? $_SESSION['form_data']['is_process_B_ADMT'] : array();
                  $free_upto = isset($_SESSION['form_data']['free_upto_B_ADMT']) ? $_SESSION['form_data']['free_upto_B_ADMT'] : array();
                  $cover_des_T = isset($_SESSION['form_data']['cover_des_B_ADMT']) ? $_SESSION['form_data']['cover_des_B_ADMT'] : array();
                  $default_stat_T = isset($_SESSION['form_data']['default_stat_B_ADMT']) ? $_SESSION['form_data']['default_stat_B_ADMT'] : array();
                  $cover_code_T = isset($_SESSION['form_data']['cover_code_B_ADMT']) ? $_SESSION['form_data']['cover_code_B_ADMT'] : array();
                  $calc_seq_T = isset($_SESSION['form_data']['calc_seq_B_ADMT']) ? $_SESSION['form_data']['calc_seq_B_ADMT'] : array();
                  $cover_area_T = isset($_SESSION['form_data']['cover_area_B_ADMT']) ? $_SESSION['form_data']['cover_area_B_ADMT'] : array();
                  $edit_flag_T = isset($_SESSION['form_data']['edit_flag_B_ADMT']) ? $_SESSION['form_data']['edit_flag_B_ADMT'] : array();
                  $maxLimit = isset($_SESSION['form_data']['max_limit_B_ADMT']) ? max($_SESSION['form_data']['max_limit_B_ADMT']) : 0;
                  $minLimit = isset($_SESSION['form_data']['min_limit_B_ADMT']) ? $_SESSION['form_data']['min_limit_B_ADMT'] : array();
                  
                  $vat_chargers = array(); // Initialize the VAT chargers array

                  foreach ($initial_amt as $index => $amt) {

                    $defaultstat_T = isset($default_stat_T[$index]) ? $default_stat_T[$index] : '';

                      // Skip the calculation if default_stat_T is "No"
                      if ($defaultstat_T === 'No') {
                          continue;
                      }

                      $coverRate = isset($cover_rate[$index]) ? $cover_rate[$index] : 0.0;
                      $calculation_type = isset($cal_type[$index]) ? $cal_type[$index] : '';
                      $formula = isset($cov_formula[$index]) ? htmlspecialchars($cov_formula[$index], ENT_QUOTES, 'UTF-8') : '';
                      $codeBlock = isset($code_block[$index]) ? htmlspecialchars($code_block[$index], ENT_QUOTES, 'UTF-8') : '';
                      $isprocess = isset($is_process[$index]) ? $is_process[$index] : '';
                      $free_upto = isset($free_upto[$index]) ? $free_upto[$index] : 0.0;
                      $coverdes_T = isset($cover_des_T[$index]) ? $cover_des_T[$index] : '';
                      //$defaultstat_T = isset($default_stat_T[$index]) ? $default_stat_T[$index] : '';
                      $cover_code = isset($cover_code_T[$index]) ? $cover_code_T[$index] : '';
                      $calc_seq = isset($calc_seq_T[$index]) ? $calc_seq_T[$index] : '';
                      $cover_area = isset($cover_area_T[$index]) ? $cover_area_T[$index] : '';
                      $edit_flag = isset($edit_flag_T[$index]) ? $edit_flag_T[$index] : '';
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
                                $premium = 0;
                              }
                              break;
                          case 'cal':
                              if ($isprocess === "yes"){
                                  eval($code_block[$index]);
                                  $premium = (float)$calValue;
                              } else {
                                $premium = 0;
                              }
                              break;
                          case 'rate':
                              if ($isprocess === "yes"){
                                eval($code_block[$index]);
                                $premium = $amt;
                                } 
                                else {
                                  $premium = 0;
                                }
                                
                              break;
                          case 'fixed':
                              if ($isprocess === "yes"){

                                  $premium = $amt;
                              } else {
                                $premium = 0;
                              }
                              break;
                          case 'user-input':
                              if ($isprocess === "yes"){
                                $premium = $amt;
                                } 
                                else {
                                  $premium = 0;
                                }
                              break;
                          default:
                              // Handle other cases or errors if needed
                      }
                      $cover_area = "CBT04";
                      //End Calculation Code
  
                      $total5 += (float)$premium; 
                      // Add details to admin chargers array
                      $vat_chargers[] = array(
                        'cover' => $coverdes_T,
                        'premium' => $premium
                      );

                        // Output HTML table row
                        echo "<tr>";
                        echo "<td>" . ($index + 1) . "</td>";
                        echo "<td>" . $coverdes_T . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADMT[]' value='" . $coverdes_T . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADMT[]' value='" . $cover_code . "'></td>";
                        echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B_ADMT[]' value='" . $initialAmount . "' oninput='recalculatePremium(this)' $readonly></td>";
                        echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADMT[]' value='" . $coverRate . "' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADMT[]' value='" . $calculation_type . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADMT[]' value='" . $formula . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADMT[]' value='" . $codeBlock . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADMT[]' value='" . $free_upto . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADMT[]' value='" . $isprocess . "'></td>";
                        echo "<td style='display:none'>";
                        echo "<select class='cover-select' name='default_stat_B_ADMT[]'>";
                        echo "<option value='Yes'" . ($defaultstat_T == 'y' ? ' selected' : '') . ">Yes</option>";
                        echo "<option value='No'" . ($defaultstat_T == 'n' ? ' selected' : '') . ">No</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td style='text-align: right;' class='premium'>" . $premium = number_format($premium, 2) . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADMT[]' value='" . $premium . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADMT[]' value='" . $calc_seq . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADMT[]' value='" . $cover_area . "'></td>";
                        echo "</tr>";
                  }
                  
                  $_SESSION['vat_chargers'] = $vat_chargers;
                  
              }
                // End
                // End Recalculation Process
                ?>
                

                <tr>
                <td>>></td>
                <td><b>TOTAL CONTRIBUTION</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>

                <td style='text-align: right;' id="total-contribution"><b><?php $tot5 = $total5 + $total4 + $total3 + $total2 + $total1;
                echo $total5NUMBER = number_format($tot5, 2);
                $_SESSION['MYFORMTotalContribution'] = $tot5; ?></b></td>
                </tr>

              </tbody>
            </table>
           
          </form>
        </div>
        <hr style="margin-top: 1px; margin-bottom: 1px; border: 0px;">
        <div>
        
        <button id="form-reset" class="save-button" type="submit" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'initial' : 'none'; ?>">Reset</button>
        <button id="form-back" class="save-button" style="display:">Previous</button>
        <button id="form-print" class="save-button" type="button">Save</button>
      </div> 
      <script>
        document.getElementById('form-print').addEventListener('click', function() {
          document.getElementById('coverForm').submit();
        });

        document.getElementById('form-back').addEventListener('click', function() {
          document.getElementById('coverForm').action = 'motorQuotationViewEdit.php';
          document.getElementById('coverForm').submit();
        });

        document.getElementById('form-save').addEventListener('click', function() {
          document.getElementById('coverForm').action = 'save-test1.php';
          document.getElementById('coverForm').submit();
        });
      </script>        
      </div>

  <!-- #tab1 -->
  <h3 class="tab_drawer_heading" rel="tab2">Tab 2</h3>
  <div id="tab2" class="tab_content">
  <!-- DataGrid Here -->

  <!--End DataGrid Here -->

  </div>
  <!-- #tab2 -->
</div>
<!-- .tab_container -->

      <!-- Code here -->
   
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/file-upload.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>
  <!-- End custom js for this page-->

  <!-- Tab Content -->
  <script>
    // tabbed content
    // http://www.entheosweb.com/tutorials/css/tabs.asp
    $(".tab_content").hide();
    $(".tab_content:first").show();

  /* if in tab mode */
    $("ul.tabs li").click(function() {
		
      $(".tab_content").hide();
      var activeTab = $(this).attr("rel"); 
      $("#"+activeTab).fadeIn();		
		
      $("ul.tabs li").removeClass("active");
      $(this).addClass("active");

	  $(".tab_drawer_heading").removeClass("d_active");
	  $(".tab_drawer_heading[rel^='"+activeTab+"']").addClass("d_active");
	  
    });
	/* if in drawer mode */
	$(".tab_drawer_heading").click(function() {
      
      $(".tab_content").hide();
      var d_activeTab = $(this).attr("rel"); 
      $("#"+d_activeTab).fadeIn();
	  
	  $(".tab_drawer_heading").removeClass("d_active");
      $(this).addClass("d_active");
	  
	  $("ul.tabs li").removeClass("active");
	  $("ul.tabs li[rel^='"+d_activeTab+"']").addClass("active");
    });
	
	
	/* Extra class "tab_last" 
	   to add border to right side
	   of last tab */
	$('ul.tabs li').last().addClass("tab_last");

      //Sum Insured RS
      $(document).ready(function() {
        setDefaultLifeCover();

        $('#sum-insured').on('input', formatLifeCoverInput);

        function setDefaultLifeCover() {
            var lifeCoverInput = $('#sum-insured');
            
        }

        function formatLifeCoverInput() {
            var lifeCoverInput = $('#sum-insured');
            var lifeCoverValue = lifeCoverInput.val();
            var numericValue = lifeCoverValue.replace(/\D/g, '');

            console.log('Original Value:', lifeCoverValue);
            console.log('Numeric Value:', numericValue);

            var formattedValue = 'Rs. ' + parseInt(numericValue, 10).toLocaleString();

            console.log('Formatted Value:', formattedValue);
            lifeCoverInput.val(formattedValue);
        }
    });

    // Display selected Company Code from the company dropdown on the table fileds.

    $(document).ready(function(){
        $('#company_select').change(function(){
            var selectedCompany = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'get_selected_company.php',
                data: { selectedCompany: selectedCompany },
                success: function(response){
                    console.log(response);
                    $('.company-code').val(response); 
                    location.reload(); 
                }
            });
        });
    });

  // Registration no display
  document.addEventListener('DOMContentLoaded', function() {
            const registeredRadio = document.getElementById('registered');
            const notRegisteredRadio = document.getElementById('not-registered');
            const regNoGroup = document.getElementById('reg-no-group');
            const regNoInput = document.getElementById('reg_no');

            registeredRadio.addEventListener('click', function() {
                regNoGroup.style.display = 'block';
                regNoInput.required = true;
            });

            notRegisteredRadio.addEventListener('click', function() {
                regNoGroup.style.display = 'none';
                regNoInput.required = false;
            });
            if (!registeredRadio.checked) {
                regNoGroup.style.display = 'none';
                regNoInput.required = false;
            }
        });

  //Save function
    document.querySelector('.save-button').addEventListener('click', function() {
        document.getElementById('data-form').submit();
    });

    // Form-01 Submit button
    document.getElementById("form-save").addEventListener("click", function() {
        document.getElementById("data-form").submit();
    });
    
    // Reset Button
    document.addEventListener("DOMContentLoaded", function() {
    var resetButton = document.getElementById("form-reset");

    resetButton.addEventListener("click", function(event) {
        event.preventDefault();

        var productDropdown = document.getElementById("product");
        productDropdown.value = "";

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "reset-session.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE)
            {
                if (xhr.status === 200) {
                    location.reload();
                } else {
                    console.error("Error resetting session:", xhr.statusText);
                }
            }
        };
        xhr.send("reset_product=true");
    });
  });

  // From validation
  document.getElementById('form-save').addEventListener('click', function(event) {
      // Get the form element
      var form = document.getElementById('data-form');
      
      // Check if all required fields are filled
      if (!form.checkValidity()) {
          // Prevent form submission
          event.preventDefault();
          
          // Display an alert or message to the user
          alert('Please fill out all required fields.');
      }
  });
// End form validation
      
</script>

</body>

</html>
<?php } ?>