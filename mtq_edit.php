<?php session_start();
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
include_once('includes/config.php');
$userName = !empty($_SESSION['u_name']) ? $_SESSION['u_name'] : null;
$restrictUsers = ["admin", "sithija", "BUDDHIKA.JAYAWEERA", "MOHAMED.FAHIM", "VISHWA.VIJAN", "RIDMI.WIJAYABANDARA", "ADEESHA.SAHAN", "CHANAKA.KULIYAPITIYA", "MOHAMED.FAHIM"];
// check username in array
if (in_array($userName, $restrictUsers)) {
    $display = NULL;
} else {
    $display = 1;
}

$total01 = 0;
$total01 = 0;
$total2 = 0;
$total03 = 0;
$total3 = 0;
$total04 = 0;
$total4 = 0;
$total05 = 0;
$total5 = 0;
$totcontribution = 0;
$tot2 = 0;
$tot3 = 0;
$tot4 = 0;
$tot5 = 0;
$T1 = 0;
$rowID = isset($_GET['id']) ? intval($_GET['id']) : 0;
$editStatus = isset($_GET['es']) ? intval($_GET['es']) : 0;
$sum_ins = isset($_GET['sum_ins']) ? intval($_GET['sum_ins']) : 0;
$_SESSION['formRowID'] =  $rowID;
$_SESSION['formsumIns'] =  $sum_ins;
$_SESSION['formEditStatus'] =  $editStatus;

if (!empty($editStatus)) {
  $query = mysqli_query($con, "SELECT *
                               FROM quotation_mt WHERE id='$rowID'");    
  if ($query) {
      $result = mysqli_fetch_assoc($query);
      if ($result) {
          $quote_no = $result['quote_no'];
          $comp_codce = $result['comp_codce'];
          $prod_code = $result['prod_code'];
          $class_code = $result['class_code'];
          $cus_name = $result['cus_name'];
          $cus_address = $result['cus_address'];
          $cus_email = $result['cus_email'];
          $vehi_number = $result['vehi_number'];
          $vehi_reg_status = $result['vehi_reg_status'];
          $vehi_make_model = $result['vehi_make_model'];
          $vehi_year_of_manu = $result['vehi_year_of_manu'];
          $vehi_fuel_type = $result['vehi_fuel_type'];
          $vehi_usage = $result['vehi_usage'];
          $date_period = $result['date_period'];

          $_SESSION['mqForm_quote_no'] = $quote_no;
          $_SESSION['mqForm_comp_codce'] = $comp_codce;
          $_SESSION['mqForm_prod_code'] = $prod_code;
          $_SESSION['mqForm_class_code'] = $class_code;
          $_SESSION['mqForm_cus_name'] = $cus_name;
          $_SESSION['mqForm_cus_address'] = $cus_address;
          $_SESSION['mqForm_cus_email'] = $cus_email;
          $_SESSION['mqForm_vehi_number'] = $vehi_number;
          $_SESSION['mqForm_vehi_reg_status'] = $vehi_reg_status;
          $_SESSION['mqForm_vehi_make_model'] = $vehi_make_model;
          $_SESSION['mqForm_vehi_year_of_manu'] = $vehi_year_of_manu;
          $_SESSION['mqForm_vehi_fuel_type'] = $vehi_fuel_type;
          $_SESSION['mqForm_vehi_usage'] = $vehi_usage;
          $_SESSION['mqForm_date_period'] = $date_period;

          $sum_ins = $result['sum_ins'];
          $_SESSION['mqForm_sumins'] = $sum_ins; 
          $ncb_rate = $result['ncb_rate']; 
          $_SESSION['FORMEDITncbRate'] = $ncb_rate;
          $ncb_amt = $result['ncb_amt'];
          $_SESSION['FORMEDIT_ncb_amount'] = $ncb_amt;
          $mr_rate = $result['mr_rate'];
          $_SESSION['FORMEDITmrRate'] = $mr_rate;
          $mr_amt = $result['mr_amt'];
          $_SESSION['FORMEDIT_mr_amount'] = $mr_amt;
          $vehi_rate = $result['vehi_rate'];
          $_SESSION['mqForm_vehiRate'] = $vehi_rate; 
          $basic_rate = $result['basic_rate'];
          $_SESSION['mqForm_basicRate'] = $basic_rate;
          $comp_excesses =  $result['comp_excesses'];
          $_SESSION['mqForm_comp_excesses'] = $comp_excesses; 
          $age_excesses =  $result['age_exces'];
          $_SESSION['mqForm_age_exces'] = $age_excesses; 
          $discount_amt =  $result['discount_amt'];
          $_SESSION['mqForm_discount_amt'] = $discount_amt;
          $basic_premium = $result['basic_premium'];
          $_SESSION['mqForm_basicPremium'] = $basic_premium; 
          $total01 = $result['total_01'];
          $_SESSION['mqForm_total_01'] = $total01; 
          $vehi_seating_capacity = $result['vehi_seating_capacity'];
          $_SESSION['mqForm_seatingCapacity'] = $vehi_seating_capacity; 
          $remark = $result['remark'];
          $_SESSION['mqForm_remark'] = $remark; 
          $tot_premium = $result['tot_premium'];
      } 
      // Free the result set
      mysqli_free_result($query);
  } else {

  }
}else {

  $query = mysqli_query($con, "SELECT *
                               FROM rev_quotation_mt WHERE id='$rowID'");    
  if ($query) {
      $result = mysqli_fetch_assoc($query);
      if ($result) {
        $quote_no = $result['old_quote_no'];
        $comp_codce = $result['comp_codce'];
        $prod_code = $result['prod_code'];
        $class_code = $result['class_code'];
        $cus_name = $result['cus_name'];
        $cus_address = $result['cus_address'];
        $cus_email = $result['cus_email'];
        $vehi_number = $result['vehi_number'];
        $vehi_reg_status = $result['vehi_reg_status'];
        $vehi_make_model = $result['vehi_make_model'];
        $vehi_year_of_manu = $result['vehi_year_of_manu'];
        $vehi_fuel_type = $result['vehi_fuel_type'];
        $vehi_usage = $result['vehi_usage'];
        $date_period = $result['date_period'];

        $_SESSION['mqForm_quote_no'] = $quote_no;
        $_SESSION['mqForm_comp_codce'] = $comp_codce;
        $_SESSION['mqForm_prod_code'] = $prod_code;
        $_SESSION['mqForm_class_code'] = $class_code;
        $_SESSION['mqForm_cus_name'] = $cus_name;
        $_SESSION['mqForm_cus_address'] = $cus_address;
        $_SESSION['mqForm_cus_email'] = $cus_email;
        $_SESSION['mqForm_vehi_number'] = $vehi_number;
        $_SESSION['mqForm_vehi_reg_status'] = $vehi_reg_status;
        $_SESSION['mqForm_vehi_make_model'] = $vehi_make_model;
        $_SESSION['mqForm_vehi_year_of_manu'] = $vehi_year_of_manu;
        $_SESSION['mqForm_vehi_fuel_type'] = $vehi_fuel_type;
        $_SESSION['mqForm_vehi_usage'] = $vehi_usage;
        $_SESSION['mqForm_date_period'] = $date_period;

        $sum_ins = $result['sum_ins'];
        $_SESSION['mqForm_sumins'] = $sum_ins; 
        $ncb_rate = $result['ncb_rate']; 
        $_SESSION['FORMEDITncbRate'] = $ncb_rate;
        $ncb_amt = $result['ncb_amt'];
        $mr_rate = $result['mr_rate'];
        $_SESSION['FORMEDITmrRate'] = $mr_rate;
        $mr_amt = $result['mr_amt'];
        $vehi_rate = $result['vehi_rate'];
        $_SESSION['mqForm_vehiRate'] = $vehi_rate; 
        $basic_rate = $result['basic_rate'];
        $_SESSION['mqForm_basicRate'] = $basic_rate;
        $comp_excesses =  $result['comp_excesses'];
        $_SESSION['mqForm_comp_excesses'] = $comp_excesses; 
        $age_excesses =  $result['age_exces'];
        $_SESSION['mqForm_age_exces'] = $age_excesses; 
        $discount_amt =  $result['discount_amt'];
        $_SESSION['mqForm_discount_amt'] = $discount_amt;
        $basic_premium = $result['basic_premium'];
        $_SESSION['mqForm_basicPremium'] = $basic_premium; 
        $total01 = $result['total_01'];
        $_SESSION['mqForm_total_01'] = $total01; 
        $vehi_seating_capacity = $result['vehi_seating_capacity'];
        $_SESSION['mqForm_seatingCapacity'] = $vehi_seating_capacity; 
        $remark = $result['remark'];
        $_SESSION['mqForm_remark'] = $remark; 
        $tot_premium = $result['tot_premium'];
      } 
      // Free the result set
      mysqli_free_result($query);
  } else {

  }

}

$SelectCompanyCode = $comp_codce;
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
  <link rel="stylesheet" href="assets/css/quotation_form.css">
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

      <!-- Alert Messages -->
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
          <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
          </symbol>
          <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
          </symbol>
          <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
          </symbol>
        </svg>

      <!-- <ul class="tabs">
        <li class="active" rel="tab1">Quotation Form</li>
      </ul> -->
      <div class="tab_container">
        <h3 class="d_active tab_drawer_heading" rel="tab1">Tab 1</h3>
        <div id="tab1" class="tab_content">
 

        <!-- End Quotation module -->
        <div class="table-responsive">
          <form id="coverForm" action="mtq_output.php?id=<?php echo $rowID?>&es=<?php echo $editStatus?>" method="POST" >
            <table class="custom-table">
              
              <thead>
                <tr>
                  <th>No</th>
                  <th>Cover type</th>
                  <th style='text-align: end;'>Value (int amt)</th>
                  <th style="display:none">Rate %</th>
                  <th>Cover<br> (Y/N)</th>
                  <th>Calculate<br> (Y/N)</th>
                  <th style='text-align: end;'>Premium (Rs)</th>
                </tr>
              </thead>

              <tbody id="coverTable">
                <tr>
                 <td>>></td>
                 <td><b>SUM INSURED </b></td> 
                 <td><input style='text-align: end;width: 100%;' type='number' class='value-input' value="<?php echo $sum_ins1 = number_format($sum_ins,2) ?>" placeholder='0.0' readonly></td>
                 <td style="display:none"><input style='text-align: end;' type='number' class='value-input' placeholder='0.0' readonly></td>
                 <td>
                 <!-- <select class='cover-select'>
                 <option value='Yes'>Yes</option>
                 </select> -->
                 </td>
                 <td>
                    <!-- <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select> -->
                </td>
                 <td style='text-align: end;'><b> <?php echo $sum_ins1  ?> </b></td>
                 </tr>

                 <tr>
                 <td>>></td>
                 <td><b>BASIC PREMIUM</b></td> 
                 <td><input style='text-align: end;width: 100%;' type='number' class='value-input' placeholder='0.0' readonly></td>
                 <td style="display:none"><input style='text-align: end;' type='number' class='value-input' placeholder='0.0' readonly></td>
                 <td>
                 <!-- <select class='cover-select'>
                 <option value='Yes'>Yes</option>
                 </select> -->
                 </td>
                 <td>
                    <!-- <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select> -->
                </td>
                 <td style='text-align: end;'><b> <?php echo $basic_premium = number_format($basic_premium,2)?> </b></td>
                 </tr>

                 <tr style="display:;">
                 <td>>></td>
                 <td><b>MR</b></td>
                 <td><input style='text-align: end;width: 100%;' type='number' class='value-input' placeholder='0.0' readonly></td> 
                 <td style="display:none"><input style='text-align: end;' type='number' class='value-input' value="<?php echo $mr_rate = number_format($mr_rate, 3)?>" placeholder='0.0' readonly></td>
                 <td>
                 <!-- <select class='cover-select'>
                 <option value='Yes'>Yes</option>
                 </select> -->
                 </td> 
                 <td>
                    <!-- <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select> -->
                </td>
                 <td style='text-align: end;'><b><?php echo $mr_amt = number_format($mr_amt, 2); ?></b></td>
                 </tr>

              <?php
              $count = 1;
              $free_covers = array();
              $front_covers = array();

              if (!empty($editStatus)) {
                $sqlTop = "SELECT DISTINCT
                  qmt.quote_no,
                  qmt.prod_code,
                  qmt.id,
                  qcmt.*,
                  cmt.cover_description,
                  tpcm.calc_type,
                  tpcm.calc_seq,
                  tpcm.is_process,
                  tpcm.cover_code,
                  tpcm.cover_rate,
                  tpcm.cov_formula,
                  tpcm.code_block,
                  tpcm.edit_flag,
                  tpcm.print_flag,
                  tpcm.default_stat,
                  tpcm.cover_cal_area,
                  tpcm.free_upto,
                  tpcm.display_cover,
                  tpcm.max_limit,
                  tpcm.min_limit
              FROM
                  quotation_mt qmt
              JOIN
                  quotation_cover_mt qcmt ON qmt.quote_no = qcmt.quote_no
              JOIN
                  tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
              JOIN
                  tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                            AND qcmt.cover_code = tpcm.cover_code 
                                            AND tpcm.remark = 'P'
                                            AND tpcm.cover_cal_area = 'T'
                                            AND qcmt.dis_area = 'CTNM'
                                            AND qmt.id = $rowID
                                            ORDER BY tpcm.calc_seq
            ";
            }else{
                $sqlTop = "SELECT DISTINCT
                qmt.new_quote_no,
                qmt.prod_code,
                qmt.id,
                qcmt.*,
                cmt.cover_description,
                tpcm.calc_type,
                 tpcm.calc_seq,
                tpcm.is_process,
                tpcm.cover_code,
                tpcm.cover_rate,
                tpcm.cov_formula,
                tpcm.code_block,
                tpcm.edit_flag,
                tpcm.print_flag,
                tpcm.default_stat,
                tpcm.cover_cal_area,
                tpcm.free_upto,
                tpcm.display_cover,
                  tpcm.max_limit,
                  tpcm.min_limit 
            FROM
                rev_quotation_mt qmt
            JOIN
                rev_quotation_cover_mt qcmt ON qmt.new_quote_no = qcmt.quote_no
            JOIN
                tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
            JOIN
                tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                          AND qcmt.cover_code = tpcm.cover_code 
                                          AND tpcm.remark = 'P'
                                          AND tpcm.cover_cal_area = 'T'
                                          AND qcmt.dis_area = 'CTNM'
                                          AND qmt.id = $rowID
                                          ORDER BY tpcm.calc_seq
          ";
            }
            $result_Top = $con->query($sqlTop);
              if ($result_Top->num_rows > 0) {
                // Counter for numbering rows
                while ($row = $result_Top->fetch_assoc()) {
                    $display_cover      =     $row['display_cover'] ;
                    // Hide free covers from the form
                    if ($display_cover === '0') {
                        $_SESSION['FreeCovers'] = $free_covers;
                        continue;
                    }
                    
             // Add details to admin chargers array
             $front_covers[] = array(
                'cover' => $row['cover_description'],
                'printflag' => $row['print_flag'],
                'initialamt' => $row['cover_amt'],
                'premium' => $row['cover_premium']
              );
                      // Determine readonly attribute based on edit_flag
                      $edit_flag          =     $row['edit_flag']                 ;
                      $readonly = ($edit_flag == 0) ? "readonly" : "";
                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_T[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_T[]' value='" . $row['cover_code'] . "'></td>";
                        //echo "<input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $initialAmount . "' $readonly>";
                        echo "<td>";
                        if (strpos($row['cover_amt'], ',') !== false) {
                            // Split the initial_amt by commas
                            $amounts = explode(',', $row['cover_amt']);
                            echo "<select style = 'text-align: right; width:80%;' class='value-select' name='initial_amt_T[]'>";
                            foreach ($amounts as $amount) {
                                // Trim any whitespace and set it as the value for the dropdown options
                                $amount = trim($amount);
                                echo "<option value='" . $amount . "'>" . $amount . "</option>";
                            }
                            echo "</select>";
                        } else {
                            // If there's no comma, display as an input box
                            echo "<input style='text-align: right;width: 100%;' type='number' class='value-input' name='initial_amt_T[]' value='" . $row['cover_amt'] . "' $readonly>";
                        }
                        echo "</td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_T[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_T[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_T[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_T[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_T[]' value='" . $row['free_upto'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_T[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_T[]' readonly>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='is_process_T[]'>";
                      echo "<option value='Yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_flag_T[]'>";
                      echo "<option value='1'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='0'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;' class='premium'>" . $row['cover_premium'] = number_format($row['cover_premium'], 2) . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_T[]' value='" . $row['cover_premium'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_T[]' value='" . $row['calc_seq'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_T[]' value='" . $row['dis_area'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_T[]' value='" . $row['edit_flag'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='max_limit_T[]' value='" . $row['max_limit'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='min_limit_T[]' value='" . $row['min_limit'] . "'></td>";
                      echo "</tr>";              
                      $count++;
                  }
                  $_SESSION['front_covers'] = $front_covers;
              } else {
                  echo "No results found.";
              }

            
              ?>
              
                <tr style="display:;">
                <td>>></td>
                <td><b>NCB</b></td>
                <td><input style='text-align: end;width: 100%;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td style='display:none'><input style='text-align: end;' type='number' class='value-input' id='total-rate' value="<?php echo $ncb_rate = number_format($ncb_rate , 3)?>" placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: end;' id="total-contribution"><b><?php echo $ncb_amt = number_format($ncb_amt, 2)?></b></td>
                </tr>
        
                <?php
              //$count = 1;
              $other_cover_chargers = array();
              $srccTC_chargers = array();
              $free_covers = array();
              $free_covers_CBT01 = array();

              if (!empty($editStatus)) {
                $sqlTop = "SELECT DISTINCT
                  qmt.quote_no,
                  qmt.prod_code,
                  qmt.id,
                  qcmt.*,
                  cmt.cover_description,
                  tpcm.calc_type,
                  tpcm.calc_seq,
                  tpcm.is_process,
                  tpcm.cover_code,
                  tpcm.cover_rate,
                  tpcm.cov_formula,
                  tpcm.code_block,
                  tpcm.edit_flag,
                  tpcm.print_flag,
                  tpcm.default_stat,
                  tpcm.cover_cal_area,
                  tpcm.free_upto,
                  tpcm.display_cover,
                  tpcm.max_limit,
                  tpcm.min_limit 
              FROM
                  quotation_mt qmt
              JOIN
                  quotation_cover_mt qcmt ON qmt.quote_no = qcmt.quote_no
              JOIN
                  tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
              JOIN
                  tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                            AND qcmt.cover_code = tpcm.cover_code 
                                            AND tpcm.remark = 'P'
                                            AND tpcm.cover_cal_area = 'B'
                                            AND qcmt.dis_area = 'CBT00'
                                            AND qmt.id = $rowID
                                            ORDER BY tpcm.calc_seq
            ";
            }else{
                $sqlTop = "SELECT DISTINCT
                qmt.new_quote_no,
                qmt.prod_code,
                qmt.id,
                qcmt.*,
                cmt.cover_description,
                tpcm.calc_type,
                 tpcm.calc_seq,
                tpcm.is_process,
                tpcm.cover_code,
                tpcm.cover_rate,
                tpcm.cov_formula,
                tpcm.code_block,
                tpcm.edit_flag,
                tpcm.print_flag,
                tpcm.default_stat,
                tpcm.cover_cal_area,
                tpcm.free_upto,
                tpcm.display_cover,
                  tpcm.max_limit,
                  tpcm.min_limit 
            FROM
                rev_quotation_mt qmt
            JOIN
                rev_quotation_cover_mt qcmt ON qmt.new_quote_no = qcmt.quote_no
            JOIN
                tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
            JOIN
                tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                          AND qcmt.cover_code = tpcm.cover_code 
                                          AND tpcm.remark = 'P'
                                          AND tpcm.cover_cal_area = 'B'
                                          AND qcmt.dis_area = 'CBT00'
                                          AND qmt.id = $rowID
                                          ORDER BY tpcm.calc_seq
          ";
            }
            $result_Top = $con->query($sqlTop);
              if ($result_Top->num_rows > 0) {
                // Counter for numbering rows
                while ($row = $result_Top->fetch_assoc()) {
                    //End Calculation Code
                    // Determine readonly attribute based on edit_flag
                    $cover_code =  $row['cover_code'];
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                    $display_cover      =     $row['display_cover'] ;
                    //hide free covers from the form
                  if ($display_cover === '0') {
                    // Add details to free covers array
                    $free_covers_CBT01[] = array(
                      'cover' => $row['cover_description'],
                      'coverCode' => $row['cover_code'],
                      'coverType' => $row['calc_type'],
                      'coverAmt'  => $row['cover_amt'],
                      'calSequence' => $row['calc_seq'],
                      'printSquence' => $row['cover_prt_seq'],
                      'dis_area' => "CBT01"
                    );
                    $_SESSION['FreeCovers'] = $free_covers_CBT01;
                    continue;
                  }
                    

                  // Check conditions based on $sum_ins to hide or show covers
                if ($SelectCompanyCode === 'lb001' || $SelectCompanyCode === 'amn-001'
                || $SelectCompanyCode === 'afl003' || $SelectCompanyCode === 'vb002'
                || $SelectCompanyCode === 'ccl004' || $SelectCompanyCode === 'of005'
                || $SelectCompanyCode === 'ab006') {
                if ($sum_ins <= 15000000) {
                    if ($cover_code === 'cov-021' || $cover_code === 'cov-022' ||  $cover_code === 'cov-030' ||  $cover_code === 'cov-031' ) {
                        continue; 
                    }
                    // Show 'cov-032'
                    if ($cover_code === 'cov-032') {
                    }
                }
                elseif ($sum_ins >= 15000000) {
                    if ($cover_code === 'cov-032') {
                        continue; 
                    }
                    // Show 'cov-021' and 'cov-022'
                    if ($cover_code === 'cov-021' || $cover_code === 'cov-022' ||  $cover_code === 'cov-030' ||  $cover_code === 'cov-031' ) {
                    }
                }
                }

                    // Add details to admin chargers array
                    $other_cover_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'printflag' => $row['print_flag'],
                      'initialamt' => $row['cover_amt'],
                      'premium' => $row['cover_premium']
                    );

                      // Add details to admin chargers array
                      $srccTC_chargers[] = array(
                        'cover' => $row['cover_description'],
                        'printflag' => $row['print_flag'],
                        'premium' => $row['cover_premium']
                    );

                    $maxLimit           =     $row['max_limit']     ;
                    $minLimit           =     $row['min_limit']     ;

                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B[]' value='" . $row['cover_code'] . "'></td>";
                      //echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $row['initial_amt'] . "' $readonly data-minlimit='$minLimit' data-maxlimit='$maxLimit' oninput='validateAmount(this)'></td>";
                      echo "<td>";
                      if (strpos($row['cover_amt'], ',') !== false) {
                          // Split the initial_amt by commas
                          $amounts = explode(',', $row['cover_amt']);
                          echo "<select style = 'text-align: right; width:80%;' class='value-select' name='initial_amt_B[]'>";
                          foreach ($amounts as $amount) {
                              // Trim any whitespace and set it as the value for the dropdown options
                              $amount = trim($amount);
                              echo "<option value='" . $amount . "'>" . $amount . "</option>";
                          }
                          echo "</select>";
                      } else {
                          // If there's no comma, display as an input box
                          echo "<input style='text-align: right;width: 100%;' type='number' class='value-input' name='initial_amt_B[]' value='" . $row['cover_amt'] . "' $readonly data-minlimit='$minLimit' data-maxlimit='$maxLimit' oninput='validateAmount(this)'>";
                      }
                      echo "</td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B[]' value='" . $row['free_upto'] . "'></td>";
                      // echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B[]'>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='is_process_B[]'>";
                      echo "<option value='yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='no'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_flag_B[]'>";
                      echo "<option value='1'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='0'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;'>" . $row['cover_premium'] = number_format($row['cover_premium'], 2) . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B[]' value='" . $row['cover_premium'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B[]' value='" . $row['calc_seq'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B[]' value='" . $row['dis_area'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B[]' value='" . $row['edit_flag'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='max_limit_B[]' value='" . $row['max_limit'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='min_limit_B[]' value='" . $row['min_limit'] . "'></td>";
                      echo "</tr>";
                      
                      $count++;
                  }
                  $_SESSION['other_cover_chargers'] = $other_cover_chargers;
                  $_SESSION['FreeCoversCBT01'] = $free_covers_CBT01;
                  $_SESSION['srccTC_chargers'] = $srccTC_chargers;
              } else {
                  //echo "No results found.";
              }
              
              $_SESSION['T1'] = $total01;
              $T1 += $total01;
              //End Calculation Algorythm //
              ?>
              <!-- Re calculate MR and NCB -->
               <?php

               ?>
              <!-- END -->

                <tr>
                <td>>></td>
                <td><b>TOTAL 01 </b></td>
                <td><input style='text-align: end;width: 100%;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td style='display:none'><input style='text-align: end;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                    <!-- <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select> -->
                </td>
                <td>
                    <!-- <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select> -->
                </td>
                <td style='text-align: end;' id="total-contribution"><b><?php echo $T1RS = number_format($T1, 2); $_SESSION['T1_total01'] = $T1;?></b></td>
                </tr>

                <?php
              //$count = 1;
              $other_cover_chargers = array();
              $free_covers = array();
               // Queries for standard covers between NCB and MR
               if (!empty($editStatus)) {
                $sqlTop = "SELECT DISTINCT
                qmt.quote_no,
                qmt.prod_code,
                qmt.comp_codce,
                qmt.id,
                qcmt.*,
                cmt.cover_description,
                tpcm.calc_type,
                tpcm.calc_seq,
                tpcm.is_process,
                tpcm.cover_code,
                tpcm.cover_rate,
                tpcm.cov_formula,
                tpcm.code_block,
                tpcm.edit_flag,
                tpcm.print_flag,
                tpcm.default_stat,
                tpcm.cover_cal_area,
                tpcm.free_upto,
                tpcm.display_cover,
                  tpcm.max_limit,
                  tpcm.min_limit
            FROM
                quotation_mt qmt
            JOIN
                quotation_cover_mt qcmt ON qmt.quote_no = qcmt.quote_no
            JOIN
                tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
            JOIN
                tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                          AND qcmt.cover_code = tpcm.cover_code 
                                          AND tpcm.remark = 'P'
                                          AND tpcm.cover_cal_area = 'B'
                                          AND qcmt.dis_area = 'CBT01'
                                          AND qmt.id = $rowID
                                          ORDER BY tpcm.calc_seq
          ";
          }else
          {
            $sqlTop = "SELECT DISTINCT
                qmt.new_quote_no,
                qmt.prod_code,
                qmt.comp_codce,
                qmt.id,
                qcmt.*,
                cmt.cover_description,
                tpcm.calc_type,
                tpcm.calc_seq,
                tpcm.is_process,
                tpcm.cover_code,
                tpcm.cover_rate,
                tpcm.cov_formula,
                tpcm.code_block,
                tpcm.edit_flag,
                tpcm.print_flag,
                tpcm.default_stat,
                tpcm.cover_cal_area,
                tpcm.free_upto,
                tpcm.display_cover,
                  tpcm.max_limit,
                  tpcm.min_limit
            FROM
                rev_quotation_mt qmt
            JOIN
                rev_quotation_cover_mt qcmt ON qmt.new_quote_no = qcmt.quote_no
            JOIN
                tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
            JOIN
                tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                          AND qcmt.cover_code = tpcm.cover_code 
                                          AND tpcm.remark = 'P'
                                          AND tpcm.cover_cal_area = 'B'
                                          AND qcmt.dis_area = 'CBT01'
                                          AND qmt.id = $rowID
                                          ORDER BY tpcm.calc_seq
          ";
          }
              
          $result_Top = $con->query($sqlTop);
            if ($result_Top->num_rows > 0) {
                
              // Counter for numbering rows
              while ($row = $result_Top->fetch_assoc()) {
                $display_cover      =     $row['display_cover'] ;
                    //End Calculation Code
                    
                    // Determine readonly attribute based on edit_flag
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                    //hide free covers from the form
                  if ($display_cover === '0') {
                    // Add details to free covers array
                    $free_covers_CBT01[] = array(
                      'cover' => $row['cover_description'],
                      'coverCode' => $row['cover_code'],
                      'coverType' => $row['calc_type'],
                      'coverAmt'  => $row['cover_amt'],
                      'calSequence' => $row['calc_seq'],
                      'printSquence' => $row['cal_seq'],
                      'dis_area' => "CBT01"
                    );
                    $_SESSION['FreeCovers'] = $free_covers_CBT01;
                    continue;
                  }

                  // Add details to admin chargers array
                  $other_cover_chargers[] = array(
                    'cover' => $row['cover_description'],
                    'printflag' => $row['print_flag'],
                    'initialamt' => $row['cover_amt'],
                    'premium' => $row['cover_premium'] 
                  );

                    $maxLimit           =     $row['max_limit']     ;
                    $minLimit           =     $row['min_limit']     ;

                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B1[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B1[]' value='" . $row['cover_code'] . "'></td>";
                      //echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $row['initial_amt'] . "' $readonly data-minlimit='$minLimit' data-maxlimit='$maxLimit' oninput='validateAmount(this)'></td>";
                      echo "<td>";
                      if (strpos($row['cover_amt'], ',') !== false) {
                          // Split the initial_amt by commas
                          $amounts = explode(',', $row['cover_amt']);
                          echo "<select style = 'text-align: right; width:80%;' class='value-select' name='initial_amt_B1[]'>";
                          foreach ($amounts as $amount) {
                              // Trim any whitespace and set it as the value for the dropdown options
                              $amount = trim($amount);
                              echo "<option value='" . $amount . "'>" . $amount . "</option>";
                          }
                          echo "</select>";
                      } else {
                          // If there's no comma, display as an input box
                          echo "<input style='text-align: right;width: 100%;' type='number' class='value-input' name='initial_amt_B1[]' value='" . $row['cover_amt'] . "' $readonly data-minlimit='$minLimit' data-maxlimit='$maxLimit' oninput='validateAmount(this)'>";
                      }
                      echo "</td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B1[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B1[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B1[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B1[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B1[]' value='" . $row['free_upto'] . "'></td>";
                      // echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B1[]'>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='is_process_B1[]'>";
                      echo "<option value='yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='no'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_flag_B1[]'>";
                      echo "<option value='1'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='0'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;'>" . $row['cover_premium'] = number_format($row['cover_premium'], 2) . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B1[]' value='" . $row['cover_premium'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B1[]' value='" . $row['calc_seq'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B1[]' value='" . $row['dis_area'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B1[]' value='" . $row['edit_flag'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='max_limit_B1[]' value='" . $row['max_limit'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='min_limit_B1[]' value='" . $row['min_limit'] . "'></td>";
                      echo "</tr>";
                      
                      $count++;
                      $total2 += (float)$row['cover_premium'];
                  }
                  $_SESSION['other_cover_chargers'] = $other_cover_chargers;
                  $_SESSION['FreeCoversCBT01'] = $free_covers_CBT01;
              } else {
                  //echo "No results found.";
              }
              
              //End Calculation Algorythm //
                ?>

                <tr>
                <td>>></td>
                <td><b>GROSS CONTRIBUTION (TOTAL 02)</b></td>
                <td><input style='text-align: end;width: 100%;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td style='display:none'><input style='text-align: end;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: end;' id="total-contribution"><b><?php $tot2 += $total2 + $T1;
                echo $total2NUMBER = number_format($tot2, 2);
                $_SESSION['GrossContribution_tot02'] = $tot2; ?></b></td>
                </tr>
                <?php
              //$count = 1;

              $admin_chargers = array(); // Initialize the admin chargers array
              if (!empty($editStatus)) {
                $sqlTop = "SELECT DISTINCT
                qmt.quote_no,
                qmt.prod_code,
                qmt.id,
                qcmt.*,
                cmt.cover_description,
                tpcm.calc_type,
                tpcm.calc_seq,
                tpcm.is_process,
                tpcm.cover_code,
                tpcm.cover_rate,
                tpcm.cov_formula,
                tpcm.code_block,
                tpcm.edit_flag,
                tpcm.default_stat,
                tpcm.cover_cal_area,
                tpcm.free_upto,
                 tpcm.display_cover,
                  tpcm.max_limit,
                  tpcm.min_limit
            FROM
                quotation_mt qmt
            JOIN
                quotation_cover_mt qcmt ON qmt.quote_no = qcmt.quote_no
            JOIN
                tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
            JOIN
                tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                          AND qcmt.cover_code = tpcm.cover_code 
                                          AND tpcm.remark = 'P'
                                          AND tpcm.cover_cal_area = 'B'
                                          AND qcmt.dis_area = 'CBT02'
                                          AND tpcm.edit_flag = '0'
                                          AND qmt.id = $rowID
                                          ORDER BY tpcm.calc_seq
          ";
          }else
          {
            $sqlTop = "SELECT DISTINCT
                qmt.new_quote_no,
                qmt.prod_code,
                qmt.id,
                qcmt.*,
                cmt.cover_description,
                tpcm.calc_type,
                tpcm.calc_seq,
                tpcm.is_process,
                tpcm.cover_code,
                tpcm.cover_rate,
                tpcm.cov_formula,
                tpcm.code_block,
                tpcm.edit_flag,
                tpcm.default_stat,
                tpcm.cover_cal_area,
                tpcm.free_upto,
                tpcm.display_cover,
                  tpcm.max_limit,
                  tpcm.min_limit
            FROM
                rev_quotation_mt qmt
            JOIN
                rev_quotation_cover_mt qcmt ON qmt.new_quote_no = qcmt.quote_no
            JOIN
                tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
            JOIN
                tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                          AND qcmt.cover_code = tpcm.cover_code 
                                          AND tpcm.remark = 'P'
                                          AND tpcm.cover_cal_area = 'B'
                                          AND qcmt.dis_area = 'CBT02'
                                          AND tpcm.edit_flag = '0'
                                          AND qmt.id = $rowID
                                          ORDER BY tpcm.calc_seq
          ";
          }
              
          $result_Top = $con->query($sqlTop);
            if ($result_Top->num_rows > 0) {
                
              // Counter for numbering rows
              while ($row = $result_Top->fetch_assoc()) {;
                if ($row['cover_description'] === 'Policy Fee (S2S / BPA)' && $row['calc_type'] === 'cal'){
                    continue;
                }
                
            

                $total3 += $row['cover_premium'];
                    //End Calculation Code
                    // Add details to admin chargers array
                    $admin_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['cover_premium'] 
                    );

                    
                    // Determine readonly attribute based on edit_flag
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                    $maxLimit           =     $row['max_limit']     ;
                    $minLimit           =     $row['min_limit']     ;

                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADM[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADM[]' value='" . $row['cover_code'] . "'></td>";
                      echo "<td><input style='text-align: right;width: 100%;' type='number' class='value-input' name='initial_amt_B_ADM[]' value='" . $row['cover_amt'] . "' $readonly data-minlimit='$minLimit' data-maxlimit='$maxLimit' oninput='validateAmount(this)'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADM[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B_ADM[]' value='" . $row['calc_type'] . "'></td>";
                      // echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B_ADM[]' value='" . $row['code_block'] . "'></td>";
                      // echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADM5[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADM[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADM[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADM[]' value='" . $row['free_upto'] . "'></td>";
                      // echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADM[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B_ADM[]'>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                     
                      echo "</select>";
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='is_process_B_ADM[]'>";
                      echo "<option value='yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='no'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_flag_B_ADM[]'>";
                      echo "<option value='1'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='0'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;'>" . $row['cover_premium'] = number_format($row['cover_premium'], 2) . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADM[]' value='" . $row['cover_premium'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADM[]' value='" . $row['calc_seq'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADM[]' value='" . $row['dis_area'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B_ADM[]' value='" . $row['edit_flag'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='max_limit_B_ADM[]' value='" . $row['max_limit'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='min_limit_B_ADM[]' value='" . $row['min_limit'] . "'></td>";
                      echo "</tr>";
                      
                      $count++;
                      
                  }
                  $_SESSION['admin_chargers'] = $admin_chargers;
              } else {
                  //echo "No results found.";
              }
              
              //End Calculation Algorythm //
                ?>
                <tr>
                <td>>></td>
                <td><b>TOTAL 03</b></td>
                <td><input style='text-align: end;width: 100%;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td style='display:none'><input style='text-align: end;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: end;' id="total-contribution"><b><?php $tot3 = $total3 + $tot2; echo $total3NUMBER = number_format($tot3, 2); ?></b></td>
                </tr>

                <?php
              //$count = 1;
                
              if (!empty($editStatus)){
                $sqlTop = "SELECT DISTINCT
                qmt.quote_no,
                qmt.prod_code,
                qmt.id,
                qcmt.*,
                cmt.cover_description,
                tpcm.calc_type,
                tpcm.calc_seq,
                tpcm.is_process,
                tpcm.cover_code,
                tpcm.cover_rate,
                tpcm.cov_formula,
                tpcm.code_block,
                tpcm.edit_flag,
                tpcm.default_stat,
                tpcm.cover_cal_area,
                tpcm.free_upto,
                  tpcm.max_limit,
                  tpcm.min_limit
            FROM
                quotation_mt qmt
            JOIN
                quotation_cover_mt qcmt ON qmt.quote_no = qcmt.quote_no
            JOIN
                tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
            JOIN
                tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                          AND qcmt.cover_code = tpcm.cover_code 
                                          AND tpcm.remark = 'P'
                                          AND tpcm.cover_cal_area = 'B'
                                          AND qcmt.dis_area = 'CBT03'
                                          AND tpcm.edit_flag = '0'
                                          AND qmt.id = $rowID
                                          ORDER BY tpcm.calc_seq
          ";
        }else
        {
          $sqlTop = "SELECT DISTINCT
              qmt.new_quote_no,
              qmt.prod_code,
              qmt.id,
              qcmt.*,
              cmt.cover_description,
              tpcm.calc_type,
              tpcm.calc_seq,
              tpcm.is_process,
              tpcm.cover_code,
              tpcm.cover_rate,
              tpcm.cov_formula,
              tpcm.code_block,
              tpcm.edit_flag,
              tpcm.default_stat,
              tpcm.cover_cal_area,
              tpcm.free_upto,
                  tpcm.max_limit,
                  tpcm.min_limit
          FROM
              rev_quotation_mt qmt
          JOIN
              rev_quotation_cover_mt qcmt ON qmt.new_quote_no = qcmt.quote_no
          JOIN
              tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
          JOIN
              tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                        AND qcmt.cover_code = tpcm.cover_code 
                                        AND tpcm.remark = 'P'
                                        AND tpcm.cover_cal_area = 'B'
                                        AND qcmt.dis_area = 'CBT03'
                                        AND tpcm.edit_flag = '0'
                                        AND qmt.id = $rowID
                                        ORDER BY tpcm.calc_seq
        ";
        }
            
        $result_Top = $con->query($sqlTop);
        $SSCL_chargers = array();
          if ($result_Top->num_rows > 0) {
            // Counter for numbering rows
            while ($row = $result_Top->fetch_assoc()) {

                  // Add details to VAT chargers array
                  $SSCL_chargers[] = array(
                    'cover' => $row['cover_description'],
                    'premium' => $row['cover_premium']
                  );
                    // Determine readonly attribute based on edit_flag
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                    $maxLimit           =     $row['max_limit']     ;
                    $minLimit           =     $row['min_limit']     ;

                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADM1[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADM1[]' value='" . $row['cover_code'] . "'></td>";
                      echo "<td><input style='text-align: right;width: 100%;' type='number' class='value-input' name='initial_amt_B_ADM1[]' value='" . $row['cover_amt'] . "' $readonly data-minlimit='$minLimit' data-maxlimit='$maxLimit' oninput='validateAmount(this)'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADM1[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B_ADM1[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B_ADM1[]' value='" . $row['code_block'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADM1[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADM1[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADM1[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADM1[]' value='" . $row['free_upto'] . "'></td>";
                      // echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADM1[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B_ADM1[]'>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                     
                      echo "</select>";
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='is_process_B_ADM1[]'>";
                      echo "<option value='yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='no'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_flag_B_ADM1[]'>";
                      echo "<option value='1'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='0'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;'>" . $row['cover_premium'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADM1[]' value='" . $row['cover_premium'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADM1[]' value='" . $row['calc_seq'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADM1[]' value='" . $row['dis_area'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B_ADM1[]' value='" . $row['edit_flag'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='max_limit_B_ADM1[]' value='" . $row['max_limit'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='min_limit_B_ADM1[]' value='" . $row['min_limit'] . "'></td>";
                      echo "</tr>";
                      
                      $count++;
                      $total4 += (float)$row['cover_premium'];
                      //echo $total4;
                  }
                  $_SESSION['sscl_chargers'] = $SSCL_chargers;
              } else {
                  //echo "No results found.";
              }
              
              //End Calculation Algorythm //
                ?>
                <tr>
                <td>>></td>
                <td><b>TOTAL 04</b></td>
                <td><input style='text-align: end;width: 100%;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td style='display:none'><input style='text-align: end;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: end;' id="total-contribution"><b><?php $tot4 = $total4 + $tot3; echo $total4NUMBER = number_format($tot4, 2); ?></b></td>
                </tr>

                <?php
              //$count = 1;
                
              $vat_chargers = array(); 
              // Queries for standard covers between NCB and MR
              if (!empty($editStatus)){
                      $sqlTop = "SELECT DISTINCT
                      qmt.quote_no,
                      qmt.prod_code,
                      qmt.id,
                      qcmt.*,
                      cmt.cover_description,
                      tpcm.calc_type,
                      tpcm.calc_seq,
                      tpcm.is_process,
                      tpcm.cover_code,
                      tpcm.cover_rate,
                      tpcm.cov_formula,
                      tpcm.code_block,
                      tpcm.edit_flag,
                      tpcm.default_stat,
                      tpcm.cover_cal_area,
                      tpcm.free_upto,
                  tpcm.max_limit,
                  tpcm.min_limit
                  FROM
                      quotation_mt qmt
                  JOIN
                      quotation_cover_mt qcmt ON qmt.quote_no = qcmt.quote_no
                  JOIN
                      tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
                  JOIN
                      tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                                AND qcmt.cover_code = tpcm.cover_code 
                                                AND tpcm.remark = 'P'
                                                AND tpcm.cover_cal_area = 'B'
                                                AND qcmt.dis_area = 'CBT04'
                                                AND tpcm.edit_flag = '0'
                                                AND qmt.id = $rowID
                                                ORDER BY tpcm.calc_seq
                ";
              }else{
                $sqlTop = "SELECT DISTINCT
                    qmt.new_quote_no,
                    qmt.prod_code,
                    qmt.id,
                    qcmt.*,
                    cmt.cover_description,
                    tpcm.calc_type,
                    tpcm.calc_seq,
                    tpcm.is_process,
                    tpcm.cover_code,
                    tpcm.cover_rate,
                    tpcm.cov_formula,
                    tpcm.code_block,
                    tpcm.edit_flag,
                    tpcm.default_stat,
                    tpcm.cover_cal_area,
                    tpcm.free_upto,
                  tpcm.max_limit,
                  tpcm.min_limit
                FROM
                    rev_quotation_mt qmt
                JOIN
                    rev_quotation_cover_mt qcmt ON qmt.new_quote_no = qcmt.quote_no
                JOIN
                    tbl_covers_mt cmt ON qcmt.cover_code = cmt.cover_code
                JOIN
                    tbl_product_cover_mt tpcm ON qmt.prod_code = tpcm.prod_code 
                                              AND qcmt.cover_code = tpcm.cover_code 
                                              AND tpcm.remark = 'P'
                                              AND tpcm.cover_cal_area = 'B'
                                              AND qcmt.dis_area = 'CBT04'
                                              AND tpcm.edit_flag = '0'
                                              AND qmt.id = $rowID
                                              ORDER BY tpcm.calc_seq
              ";
              }
                  
              $result_Top = $con->query($sqlTop);
                if ($result_Top->num_rows > 0) {
                  // Counter for numbering rows
                  while ($row = $result_Top->fetch_assoc()) {
                    
                    // Add details to VAT chargers array
                    $vat_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['cover_premium']
                    );

                    // Determine readonly attribute based on edit_flag
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                    $maxLimit           =     $row['max_limit']     ;
                    $minLimit           =     $row['min_limit']     ;

                      // Output HTML table row
                       echo "<tr>";
                    echo "<td>" . $count . "</td>";
                    echo "<td>" . $row['cover_description'] . "</td>";
                    echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADMT[]' value='" . $row['cover_description'] . "'></td>";
                    echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADMT[]' value='" . $row['cover_code'] . "'></td>";
                    echo "<td><input style='text-align: right;width: 100%;' type='number' class='value-input' name='initial_amt_B_ADMT[]' value='" . $row['cover_amt'] . "' $readonly data-minlimit='$minLimit' data-maxlimit='$maxLimit' oninput='validateAmount(this)'></td>";
                    echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADMT[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                    echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B_ADMT[]' value='" . $row['calc_type'] . "'></td>";
                    echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B_ADMT[]' value='" . $row['code_block'] . "'></td>";
                    echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADMT[]' value='" . $row['calc_type'] . "'></td>";
                    echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADMT[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                    echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADMT[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                    echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADMT[]' value='" . $row['free_upto'] . "'></td>";
                    // echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADMT[]' value='" . $row['is_process'] . "'></td>";
                    echo "<td>";
                    echo "<select class='cover-select' name='default_stat_B_ADMT[]'>";
                    echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                    
                    echo "</select>";
                    echo "</td>";
                    echo "<td>";
                    echo "<select class='cover-select' name='is_process_B_ADMT[]'>";
                    echo "<option value='yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                    echo "<option value='no'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                    echo "</select>";
                    echo "</td>";
                    echo "<td style='display:none'>";
                    echo "<select class='cover-select' name='print_flag_B_ADMT[]'>";
                    echo "<option value='1'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                    echo "<option value='0'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
                    echo "</select>";
                    echo "</td>";
                    echo "<td style='text-align: right;'>" . $row['cover_premium'] . "</td>";
                    echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADMT[]' value='" . $row['cover_premium'] . "'></td>";
                    echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADMT[]' value='" . $row['calc_seq'] . "'></td>";
                    echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADMT[]' value='" . $row['dis_area'] . "'></td>";
                    echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B_ADMT[]' value='" . $row['edit_flag'] . "'></td>";
                    echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='max_limit_B_ADMT[]' value='" . $row['max_limit'] . "'></td>";
                    echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='min_limit_B_ADMT[]' value='" . $row['min_limit'] . "'></td>";
                    echo "</tr>";
                      
                      $count++;
                      $total5 += (float)$row['cover_premium'];
                      //echo $total5;
                  }
                  $_SESSION['vat_chargers'] = $vat_chargers;
              } else {
                  //echo "No results found.";
              }
              
              //End Calculation Algorythm //
                ?>
                <tr>
                <td>>></td>
                <td><b>TOTAL CONTRIBUTION</b></td>
                <td>
                <td style='display:none'><input style='text-align: end; width: 100%;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: end;' id="total-contribution"><b><?php $tot5 = $total5 + $tot4;
                echo $total5NUMBER = number_format($tot5, 2);
                $_SESSION['TotalContribution'] = $tot5; ?></b></td>
                </tr>

                <!-- Premium Matching  -->
                <?php if (empty($display)): 
                    
                    echo "<tr>";
                    echo "<td>>></td>";
                    echo "<td><b>SET MANUAL CONTRIBUTION</b></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td><input style='text-align: end; width: 100%;' type='number' id='premium_matching' class='code-block-input' placeholder='0.0'></td>";
                    echo "</tr>"; 
                    ?>
                    <?php endif; ?>
              <!-- End -->

              <!-- Compulsory Excesses  -->
               <?php
                    // Output HTML table row
                    echo "<tr>";
                    echo "<td></td>";
                    echo "<td>Compulsory Excesses</td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td><input style='text-align: end;' type='text' id='cex-premium' class='code-block-input' placeholder='Nil' name='comp_excesses[]' value=".$comp_excesses."></td>";
                    echo "</tr>"; 

               ?>
              <!-- End -->

              </tbody>
            </table>
            <!-- Remarks -->
            <?php
                echo "<br>";
                echo "<div style='display: flex; align-items: center; margin-block-end: 10px;'>";
                echo "<div style='inline-size: 30%; text-align: end; font-weight: bold; padding-inline-end: 10px;'>Remark</div>";
                echo "<div style='inline-size: 70%;'>";
                echo "<input style='text-align: start; inline-size: 100%; padding: 5px;' type='text' id='remark-note' class='code-block-input' placeholder='Comment Here' name='remark[]' value=".$remark.">";
                echo "</div>";
                echo "</div>";
                ?>
            <!-- End -->
          </form>
        </div>
        <hr style="margin-block-start: 1px; margin-block-end: 1px; border: 0px;">
        <div>
        <button onclick="backFunction()" class="save-button" >Back</button> 
        <button id="form-print" class="save-button" type="button" ><i class='fas fa-calculator'></i> Calculate</button>
      </div> 
      <script>
        document.getElementById('form-print').addEventListener('click', function() {
          document.getElementById('coverForm').submit();
        });

        function backFunction() {
        var rowValue = <?php echo json_encode($rowID); ?>;
        var esValue = <?php echo json_encode($editStatus); ?>;
          location.replace("mtq_view.php?id=" + rowValue + " &es=" + esValue + "")
        }
        //  document.getElementById('form-recal').addEventListener('click', function() {
        //  document.getElementById('coverForm').action = 'motor-quotationEditable.php';
        //    document.getElementById('coverForm').submit();
        //  });

        document.getElementById('form-save').addEventListener('click', function() {
          document.getElementById('coverForm').action = 'mtq_view_pdf.php';
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


//Year of Manufacture is 30 Years OLD
  $(document).ready(function () {
  const currentYear = new Date().getFullYear();

  $(document).on('click', '#close-btn', function () {
      $('#yom-warning-box').hide();
  });

  $('#manf-year').on('input', function () {
      var yearInput = $(this).val();
      var numericYear = parseInt(yearInput.replace(/\D/g, ''), 10);

      if (numericYear.toString().length === 4) {
          if (currentYear - numericYear >= 30) {
              $('#yom-warning-box').fadeIn(); 
              $(this).val(''); 
          } else {
              $('#yom-warning-box').fadeOut(); 
          }
      } else {
          $('#yom-warning-box').fadeOut(); 
      }
  });
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


//Store Compulsory Exxcell value and remark on the session
$(document).ready(function() {

    $('#cex-premium').on('input', function() {
        var amount = $(this).val();

        $.ajax({
            url: 'update_remark_session.php', 
            type: 'POST',
            data: {
                amount: amount,
                input_id: 'cex-premium_rev' 
            },
            success: function(response) {
                console.log("Session updated successfully");
            }
        });
    });

    $('#remark-note').on('input', function() {
        var remark = $(this).val();

        $.ajax({
            url: 'update_remark_session.php', 
            type: 'POST',
            data: {
                remark: remark,
                input_id: 'remark_rev' 
            },
            success: function(response) {
                console.log("Session updated successfully");
            }
        });
    });

    $('#premium_matching').on('input', function() {
        var premium = $(this).val();

        $.ajax({
            url: 'update_remark_session.php', 
            type: 'POST',
            data: {
                premium: premium,
                input_id: 'premium_matching' 
            },
            success: function(response) {
                console.log("Session updated successfully");
            }
        });
    });
});
//End
</script>

<!-- //page reload -->
<script type="text/javascript">
        // Get the PHP session reload count
        var reloadCount = <?php echo $_SESSION['reload_count']; ?>;

        // Reload the page if the count is less than 2
        if (reloadCount < 2) {
            setTimeout(function(){
                window.location.reload(); // Reload the page
            }, 0001); // Reload after 2 seconds (adjustable)
        }
</script>
</body>

</html>
<?php } ?>