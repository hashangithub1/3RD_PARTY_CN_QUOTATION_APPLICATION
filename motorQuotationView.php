<?php session_start();
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
include_once('includes/config.php');
$total01 = 0;
$total01 = 0;
$total02 = 0;
$total03 = 0;
$total04 = 0;
$total05 = 0;
$totcontribution = 0;
$tot2 = 0;
$tot3 = 0;
$tot4 = 0;
$tot5 = 0;

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
          $mr_rate = $result['mr_rate'];
          $_SESSION['FORMEDITmrRate'] = $mr_rate;
          $mr_amt = $result['mr_amt'];
          $vehi_rate = $result['vehi_rate'];
          $_SESSION['mqForm_vehiRate'] = $vehi_rate; 
          $basic_rate = $result['basic_rate'];
          $_SESSION['mqForm_basicRate'] = $basic_rate; 
          $basic_premium = $result['basic_premium'];
          $_SESSION['mqForm_basicPremium'] = $basic_premium; 
          $vehi_seating_capacity = $result['vehi_seating_capacity'];
          $_SESSION['mqForm_seatingCapacity'] = $vehi_seating_capacity; 
          $tot_premium = $result['tot_premium'];
      } 
      // Free the result set
      mysqli_free_result($query);
  } else {

  }
}else{

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
          $basic_premium = $result['basic_premium'];
          $_SESSION['mqForm_basicPremium'] = $basic_premium; 
          $vehi_seating_capacity = $result['vehi_seating_capacity'];
          $_SESSION['mqForm_seatingCapacity'] = $vehi_seating_capacity; 
          $tot_premium = $result['tot_premium'];
      } 
      // Free the result set
      mysqli_free_result($query);
  } else {

  }

}
$total01 = $basic_premium - $mr_amt;
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
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
        <li class="active" rel="tab1">Quotation Form </li>
      </ul>
      <div class="tab_container">
        <h3 class="d_active tab_drawer_heading" rel="tab1">Tab 1</h3>
        <div id="tab1" class="tab_content">
 
        <!-- Quotation Form -->
        <!-- Gethering data from three database tables -->
        <!-- End -->
        <!-- End Quotation Form -->
        <div class="table-responsive" >
          <form id="coverForm" action="motorQuotationViewEdit.php" method="POST">
            <table class="custom-table">
              
              <thead>
                <tr>
                  <th>No</th>
                  <th>Cover type </th>
                  <th>Amount / Rate</th>
                  <th>Cover (Y/N)</th>
                  <th>Premium (Rs)</th>
                </tr>
              </thead>

              <tbody id="coverTable">
                <tr>
                 <td>>></td>
                 <td><b>SUM INSURED </b></td> 
                 <td><input style='text-align: right;' type='number' class='value-input' value="" placeholder='0.0' readonly></td>  
                 <td>
                 <select class='cover-select'>
                 <option value='Yes'>Yes</option>
                 </select>
                 </td>
                 <td style='text-align: right;'><b> <?php echo $sum_ins ?> </b></td>
                 </tr>

                 <tr>
                 <td>>></td>
                 <td><b>BASIC PREMIUM </b></td> 
                 <td><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td>
                 <td>
                 <select class='cover-select'>
                 <option value='Yes'>Yes</option>
                 </select>
                 </td>
                 <td style='text-align: right;'><b><?php echo $basic_premium ?></b></td>
                 </tr>
                <?php

                ?>
                 <tr style="display:none;">
                 <td>>></td>
                 <td><b>NCB (%)</b></td>
                 <td><input style='text-align: right;' type='number' class='value-input' placeholder='<?php echo $ncb_rate ?>' readonly></td> 
                 <td>
                 <select class='cover-select'>
                 <option value='Yes'>Yes</option>
                 </select>
                 </td> 
                 <td style='text-align: right;'><b><?php echo $ncb_amt; $_SESSION['FORMEDIT_ncb_mr_Amt'] = $ncb_amt; ?></b></td>
                 </tr>
                <?php
                // Recalculation Process Top
                $srccTC_chargers = array();
                // Access recalculation Data from Session Array
                $count = 1;
                // Queries for standard covers between NCB and MR
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
                      tpcm.free_upto
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
                    tpcm.default_stat,
                    tpcm.cover_cal_area,
                    tpcm.free_upto
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
                       // store values on following variables for calculation process  
                    $edit_flag          =     $row['edit_flag']                 ;
                    $edit_flag = 0;

                    // Add details to admin chargers array
                    $srccTC_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['cover_premium']
                    );

                      $readonly = ($edit_flag == 0) ? "readonly" : "";
  
                        // Output HTML table row
                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row['cover_description'] . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_T[]' value='" . $row['cover_description'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_T[]' value='" . $row['cover_code'] . "'></td>";
                        echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_T[]' value='" . $row['cover_amt'] . "' oninput='recalculatePremium(this)' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_T[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_T[]' value='" . $row['calc_type'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_T[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_T[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_T[]' value='" . $row['free_upto'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_T[]' value='" . $row['is_process'] . "'></td>";
                        echo "<td>";
                        echo "<select class='cover-select' name='default_stat_T[]'>";
                        echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                        echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td style='text-align: right;' class='premium'>" . $row['cover_premium'] . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_T[]' value='" . $row['cover_premium'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_T[]' value='" . $row['cal_seq'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_T[]' value='" . $row['dis_area'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_T[]' value='" . $row['edit_flag'] . "'></td>";
                        echo "</tr>";
                        
                        $count++;
                        $total01 += $row['cover_premium'];
                    }
                    $_SESSION['srccTC_chargers'] = $srccTC_chargers;
                    
                } else {
                    echo "No results found.";
                }

                // End Recalculation Process
                ?>
              
                <tr style="display:none;">
                <td>>></td>
                <td><b>MR (%)</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='<?php echo $mr_rate ?>' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php echo $mr_amt ?></b></td>
                </tr>
        
                <tr>
                <td>>></td>
                <td><b>TOTAL 01</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php echo  number_format($total01, 2, '.', '') ?></b></td>
                </tr>
                <?php
                // Recalculation Process Under Tot 01
                // Access recalculation Data from Session Array
                $other_cover_chargers = array();
                $free_covers_CBT01 = array();
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
                      tpcm.default_stat,
                      tpcm.cover_cal_area,
                      tpcm.free_upto,
                       tpcm.display_cover
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
                      tpcm.default_stat,
                      tpcm.cover_cal_area,
                      tpcm.free_upto,
                      tpcm.display_cover
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
                       // store values on following variables for calculation process  
                    $edit_flag   =  $row['edit_flag'];
                    $display_cover = $row['display_cover'];
                    $SelectCompanyCode = $row['comp_codce'];
                    $cover_code = $row['cover_code'];
                    $edit_flag = 0;
                      $readonly = ($edit_flag == 0) ? "readonly" : "";

                  // Check conditions based on $sum_ins to hide or show covers
                  if ($SelectCompanyCode === 'lb001') {
                    if ($sum_ins <= 15000000) {
                        if ($cover_code === 'cov-021' || $cover_code === 'cov-022') {
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
                        if ($cover_code === 'cov-021' || $cover_code === 'cov-022') {
                        }
                    }
                  }

                  //hide free covers from the form
                  if ($display_cover === '0') {
                    // Add details to free covers array
                    $free_covers_CBT01[] = array(
                      'cover' => $row['cover_description'],
                      'coverCode' => $row['cover_code'],
                      'coverType' => $row['calc_type'],
                      'coverAmt'  => $row['cover_amt'],
                      'calSequence' => $row['cal_seq'],
                      'dis_area' => "CBT01"
                    );
                    $_SESSION['FreeCoversCBT01'] = $free_covers_CBT01;
                    continue;
                  }
                    
                      // Add details to admin chargers array
                      $other_cover_chargers[] = array(
                        'cover' => $row['cover_description'],
                        'premium' => $row['cover_premium']
                      );
                        // Output HTML table row
                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row['cover_description'] . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B[]' value='" . $row['cover_description'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B[]' value='" . $row['cover_code'] . "'></td>";
                        echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $row['cover_amt'] . "' oninput='recalculatePremium(this)' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B[]' value='" . $row['calc_type'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B[]' value='" . $row['free_upto'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B[]' value='" . $row['is_process'] . "'></td>";
                        echo "<td>";
                        echo "<select class='cover-select' name='default_stat_B[]'>";
                        echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                        echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td style='text-align: right;' class='premium'>" . $row['cover_premium'] . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B[]' value='" . $row['cover_premium'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B[]' value='" . $row['cal_seq'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B[]' value='" . $row['dis_area'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B[]' value='" . $row['edit_flag'] . "'></td>";
                        echo "</tr>";
                        
                        $count++;
                        $total02 += $row['cover_premium'];
                    }
                    $_SESSION['other_cover_chargers'] = $other_cover_chargers;
                } else {
                    echo "No results found.";
                }

                // End Recalculation Process
                ?>
                <tr>
                <td>>></td>
                <td><b>GROSS CONTRIBUTION (TOTAL 02)</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot2 = $total01 + $total02; echo $total2NUMBER = number_format($tot2, 2, '.', '');
                $_SESSION['MYFORMGrossContribution_tot02'] = $tot2;?></b></td>
                </tr>
                <?php
                // Recalculation Process Under Tot 02
                // Access recalculation Data from Session Array
                $admin_chargers = array();
                // Queries for standard covers between NCB and MR
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
                      tpcm.free_upto
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
                      tpcm.free_upto
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
                                                AND qmt.id = $rowID
                                                ORDER BY tpcm.calc_seq
                ";
                }
                    
                $result_Top = $con->query($sqlTop);
                  if ($result_Top->num_rows > 0) {
                    // Counter for numbering rows
                    while ($row = $result_Top->fetch_assoc()) {
                       // store values on following variables for calculation process  
                    $edit_flag          =     $row['edit_flag']                 ;
                    $edit_flag = 0;
                      $readonly = ($edit_flag == 0) ? "readonly" : "";
  
                      // Add details to admin chargers array
                      $admin_chargers[] = array(
                        'cover' => $row['cover_description'],
                      'premium' => $row['cover_premium']
                    );

                        // Output HTML table row
                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row['cover_description'] . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADM[]' value='" . $row['cover_description'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADM[]' value='" . $row['cover_code'] . "'></td>";
                        echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B_ADM[]' value='" . $row['cover_amt'] . "' oninput='recalculatePremium(this)' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADM[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADM[]' value='" . $row['calc_type'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADM[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADM[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADM[]' value='" . $row['free_upto'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADM[]' value='" . $row['is_process'] . "'></td>";
                        echo "<td>";
                        echo "<select class='cover-select' name='default_stat_B_ADM[]'>";
                        echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                        echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td style='text-align: right;' class='premium'>" . $row['cover_premium'] . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADM[]' value='" . $row['cover_premium'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADM[]' value='" . $row['cal_seq'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADM[]' value='" . $row['dis_area'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B_ADM[]' value='" . $row['edit_flag'] . "'></td>";
                        echo "</tr>";
                        
                        $count++;
                        $total03 += $row['cover_premium'];
                    }
                    $_SESSION['admin_chargers'] = $admin_chargers;

                } else {
                    echo "No results found.";
                }

                // End Recalculation Process
                ?>
          
                <tr>
                <td>>></td>
                <td><b>TOTAL 03</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot3 = $tot2 + $total03; echo $total2NUMBER = number_format($tot3, 2, '.', '');?></b></td>
                </tr>
                <?php
                // Recalculation Process Under Tot 03
                // Access recalculation Data from Session Array
                $SSCL_chargers = array();
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
                        tpcm.free_upto
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
                      tpcm.free_upto
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
                                                AND qmt.id = $rowID
                                                ORDER BY tpcm.calc_seq
                ";
                }
                    
                $result_Top = $con->query($sqlTop);
                  if ($result_Top->num_rows > 0) {
                    // Counter for numbering rows
                    while ($row = $result_Top->fetch_assoc()) {
                       // store values on following variables for calculation process  
                    $edit_flag          =     $row['edit_flag']                 ;
                    $edit_flag = 0;
                      $readonly = ($edit_flag == 0) ? "readonly" : "";
  
                      // Add details to VAT chargers array
                      $SSCL_chargers[] = array(
                        'cover' => $row['cover_description'],
                        'premium' => $row['cover_premium']
                      );

                        // Output HTML table row
                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row['cover_description'] . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADM1[]' value='" . $row['cover_description'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADM1[]' value='" . $row['cover_code'] . "'></td>";
                        echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B_ADM1[]' value='" . $row['cover_amt'] . "' oninput='recalculatePremium(this)' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADM1[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADM1[]' value='" . $row['calc_type'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADM1[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADM1[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADM1[]' value='" . $row['free_upto'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADM1[]' value='" . $row['is_process'] . "'></td>";
                        echo "<td>";
                        echo "<select class='cover-select' name='default_stat_B_ADM1[]'>";
                        echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                        echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td style='text-align: right;' class='premium'>" . $row['cover_premium'] . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADM1[]' value='" . $row['cover_premium'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADM1[]' value='" . $row['cal_seq'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADM1[]' value='" . $row['dis_area'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B_ADM1[]' value='" . $row['edit_flag'] . "'></td>";
                        echo "</tr>";
                        
                        $count++;
                        $total04 += $row['cover_premium'];
                    }
                    $_SESSION['sscl_chargers'] = $SSCL_chargers;

                } else {
                    echo "No results found.";
                }

                // End Recalculation Process
                ?>
                <tr>
                <td>>></td>
                <td><b>TOTAL 04</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot4 = $tot3 + $total04; echo $totalNUMBER = number_format($tot4, 2, '.', '');?></b></td>
                </tr>
                <?php
                // Recalculation Process Under Tot 04
                // Access recalculation Data from Session Array
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
                        tpcm.free_upto
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
                      tpcm.free_upto
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
                                                AND qmt.id = $rowID
                                                ORDER BY tpcm.calc_seq
                ";
                }
                    
                $result_Top = $con->query($sqlTop);
                  if ($result_Top->num_rows > 0) {
                    // Counter for numbering rows
                    while ($row = $result_Top->fetch_assoc()) {
                       // store values on following variables for calculation process  
                    $edit_flag          =     $row['edit_flag']                 ;
                    $edit_flag = 0;
                      $readonly = ($edit_flag == 0) ? "readonly" : "";
  
                       // Add details to admin chargers array
                       $vat_chargers[] = array(
                        'cover' => $row['cover_description'],
                        'premium' => $row['cover_premium']
                      );

                        // Output HTML table row
                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row['cover_description'] . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADMT[]' value='" . $row['cover_description'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADMT[]' value='" . $row['cover_code'] . "'></td>";
                        echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B_ADMT[]' value='" . $row['cover_amt'] . "' oninput='recalculatePremium(this)' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADMT[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADMT[]' value='" . $row['calc_type'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADMT[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADMT[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADMT[]' value='" . $row['free_upto'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADMT[]' value='" . $row['is_process'] . "'></td>";
                        echo "<td>";
                        echo "<select class='cover-select' name='default_stat_B_ADMT[]'>";
                        echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                        echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td style='text-align: right;' class='premium'>" . $row['cover_premium'] . "</td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADMT[]' value='" . $row['cover_premium'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADMT[]' value='" . $row['cal_seq'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADMT[]' value='" . $row['dis_area'] . "'></td>";
                        echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B_ADMT[]' value='" . $row['edit_flag'] . "'></td>";
                        echo "</tr>";
                        
                        $count++;
                        $total05 += $row['cover_premium'];
                    }
                    $_SESSION['vat_chargers'] = $vat_chargers;

                } else {
                    echo "No results found.";
                }

                // End Recalculation Process
                ?>
                <tr>
                <td>>></td>
                <td><b>TOTAL CONTRIBUTION</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot5 = $tot4 + $total05; echo $total2NUMBER = number_format($tot5, 2, '.', '');
                $_SESSION['MYFORMTotalContribution'] = $tot5;?></b></td>
                </tr>

              </tbody>
            </table>
           
          </form>
        </div>
        <hr style="margin-top: 1px; margin-bottom: 1px; border: 0px;">
        <div>
        <button id="form-edit" class="save-button" type="button" >edit</button>
        <button id="form-print" class="save-button" type="button" ><i class='fas fa-file-pdf'></i> Generate PDF</button>
      </div> 
      <script>
      document.getElementById('form-edit').addEventListener('click', function() {
      document.getElementById('coverForm').submit();
      });

      document.getElementById('form-print').addEventListener('click', function() {
      document.getElementById('coverForm').action = 'motor-quotation-pdf.php';
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