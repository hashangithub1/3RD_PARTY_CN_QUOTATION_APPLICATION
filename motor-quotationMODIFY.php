<?php session_start();
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

include_once('includes/config.php');
include_once('datagrid-mt.php');
include_once('calculation-mt-02');

$SelectCompanyCode = !empty($_SESSION['companycode_form']) ? $_SESSION['companycode_form'] : null;   
$SelectCompanyName = !empty($_SESSION['companyname_form']) ? $_SESSION['companyname_form'] : null;     
//Condition for product name
 if (!isset($SelectCompanyName) || $SelectCompanyName === "") {
  $compName = "Select (Optional)";
} else {
  $compName = $SelectCompanyName;
}

//Quotation Number
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
$quote_no =  generateQuotationNumber();
$_SESSION['quote_no'] = $quote_no ;
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
        <li class="active" rel="tab1">Quotation Form <?php echo $SelectCompanyCode?></li>
      </ul>
      <div class="tab_container">
        <h3 class="d_active tab_drawer_heading" rel="tab1">Tab 1</h3>
        <div id="tab1" class="tab_content">
 
        <!-- Quotation Form -->
        <form id="data-form" action="calculation-mt.php" method="post" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'none' : 'initial'; ?>">
        <div class="container-form">
              <div class="form-column">
                  <h2 class="heading">Company Purpose</h2>
                  <hr>
                  <div class="form-group">
                      <label>Business Channel:</label>
                      <select name="bus_channel" id="bus_channel" class="dropdown">
                        <option value="">Please Select</option>
                      <?php
                          $sql = "SELECT * FROM tbl_business_channel_mt WHERE status = 1";
                          $result = $con->query($sql);

                              while ($row = $result->fetch_assoc()) {
                                  $buscode = $row['code'];
                                  $busname = $row['name'];
                                  echo "<option value='$buscode'>$busname</option>";
                              }
                              ?>
                      </select>
                  </div>

                  <div class="form-group">
                      <label>Company: <?php echo $SelectCompanyName ?></label>
                      <select name="company" id="company_select" class="dropdown">
                        <option value="">Please Select</option>
                      </select>
                  </div>

                  <!-- <div class="form-group" id="company_div" style="display:none;">
                      <label>Company:</label>
                      <select name="company" id="company_select2" class="dropdown">
                          <option value=""><?php echo $compName ?></option>
                          <?php
                          // $sql = "SELECT * FROM tbl_company_mt ";
                          // $result = $con->query($sql);

                          //     while ($row = $result->fetch_assoc()) {
                          //         $compcode = $row['code'];
                          //         $compname = $row['name'];
                          //         echo "<option value='$compcode'>$compname</option>";
                          //     }
                              ?>
                      </select>
                  </div> -->

                  <!-- <?php if ($SelectCompanyCode ): ?>
                    <div class="form-group">
                      <label>Product: *</label>
                      <select name="product" id="companyProduct" class="dropdown" required>
                          <option value="">Select</option>
                          <?php
                          // $sql = "SELECT DISTINCT pc.prod_code, c.product_des
                          //         FROM tbl_product_cover_mt pc
                          //         JOIN tbl_product_mt c ON pc.prod_code = c.product_code
                          //         WHERE pc.comp_code = '$SelectCompanyCode'";
                          // $result = $con->query($sql);

                          //     while ($row = $result->fetch_assoc()) {
                          //         $prodc_code = $row['prod_code'];
                          //         $prodc_desc = $row['product_des'];
                          //         echo "<option value='$prodc_code'>$prodc_desc</option>";
                          //     }
                              ?>
                      </select>
                  </div>
                  <?php endif; ?>

                  <?php if (!$SelectCompanyCode ): ?>
                  <div class="form-group" id="product_div" style="display:none;">
                      <label>Product: *</label>
                      <select name="product" id="product" class="dropdown" required>
                          <option value="">Select</option>
                          <?php
                          // $sql = "SELECT * FROM tbl_product_mt ";
                          // $result = $con->query($sql);

                          //     while ($row = $result->fetch_assoc()) {
                          //         $prod_code = $row['product_code'];
                          //         $prod_desc = $row['product_des'];
                          //         echo "<option value='$prod_code'>$prod_desc</option>";
                          //     }
                              ?>
                      </select>
                  </div>
                  <?php endif; ?> -->

                  <div class="form-group">
                      <label>Period:</label>
                      <div class="daterange">
                      <label for="fromDate">From:</label>
                      <input type="date" name="datefrom" id="datefrom" style="margin-left:20px; margin-right:20px;"/>
                      <label for="fromDate">To:</label>
                      <input type="date" name="dateto" id="dateto" style="margin-left:20px;" readonly/>
                      </div>

                      <script>
                      // Get the current date
                          var currentDate = new Date();

                      // Calculate 14 days before the current date
                      var minDate = new Date();
                      minDate.setDate(currentDate.getDate() -14 );

                      // Format the minimum date as 'YYYY-MM-DD'
                      var minDateString = minDate.toISOString().split('T')[0];

                      // Format the current date as 'YYYY-MM-DD'
                      var currentDateString = currentDate.toISOString().split('T')[0];

                      // Set the minimum and maximum attributes of the start_date input element
                      document.getElementById('datefrom').setAttribute('min', minDateString);
                      document.getElementById('datefrom').setAttribute('max', currentDateString);

                      // Set the default value to the current date for start_date
                      document.getElementById('datefrom').value = currentDateString;

                      // Calculate the default end date based on the current date
                      var defaultEndDate = new Date(currentDate);
                      defaultEndDate.setDate(currentDate.getDate() + 364);

                      // Format the default end date as 'YYYY-MM-DD'
                      var defaultEndDateString = defaultEndDate.toISOString().split('T')[0];

                      // Set the value of the end_date input to the default end date
                      document.getElementById('dateto').value = defaultEndDateString;

                      // Add event listener to start_date input for updating end_date
                      document.getElementById('datefrom').addEventListener('input', function() {
                          // Get the selected start date
                          var startDate = new Date(this.value);

                          // Calculate 350 days after the start date
                          var endDate = new Date(startDate);
                          endDate.setDate(startDate.getDate() + 365);

                          // Format the end date as 'YYYY-MM-DD'
                          var endDateString = endDate.toISOString().split('T')[0];

                          // Set the value of the end_date input
                          document.getElementById('dateto').value = endDateString;
                      });

                      </script>
                  </div>

                  <div class="form-group">
                      <label>Sum Insured: *</label><input type="text" id="sum-insured" name="sum-insured" placeholder="Rs." required>
                  </div>

                  <h2 style="margin-top:20px;" class="heading">Customer Information</h2>
                  <hr>

                  <div class="form-group">
                    <label>Fullname:</label><input type="text" name="client_name">
                  </div>

                  <div class="form-group">
                      <label>Address:</label>
                      <input type="text" id="client_address" name="client_address">
                  </div>

                  <div class="form-group">
                      <label>Mobile Number:</label>
                      <input type="text" id="mobile_number" name="mobile_number" placeholder="077xxxxxxx" pattern="\d{10}" maxlength="10">
                      <span class="error" id="mobile-error-message"></span>
                      <script>
                        document.getElementById('mobile_number').addEventListener('input', function (e) {
                            const input = e.target.value;
                            const errorMessage = document.getElementById('mobile-error-message');

                            // Check if the input is exactly 10 digits
                            const isValid = /^\d{10}$/.test(input);

                            if (isValid) {
                                errorMessage.textContent = '';
                            } else {
                                errorMessage.textContent = 'Please enter exactly 10 digits.';
                            }

                            // Allow only numeric input
                            e.target.value = input.replace(/[^\d]/g, '');
                        });
                    </script>
                    </div>

                  <div class="form-group">
                      <label>Email Address:</label>
                      <input type="text" id="email_address" name="email_address">
                      <span class="error" id="email-error-message"></span>

                      <script>
                        document.getElementById('email_address').addEventListener('input', function (e) {
                            const input = e.target.value;
                            const errorMessage = document.getElementById('email-error-message');

                            // Check if the input is a valid email address
                            const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input);

                            if (isValid) {
                                errorMessage.textContent = '';
                            } else {
                                errorMessage.textContent = 'Please enter a valid email address.';
                            }
                        });
                      </script>
                  </div>

              </div>
              <div class="form-column">
                  <h2 class="heading">Vehicle Information</h2>
                  <hr>
                  <div class="form-group">
                      <label>Make & Model: *</label>
                      <select name="make-model" id="make-model" class="dropdown select2-dropdown" required>
                          <option value="">Select</option>
                          <?php
                          $sql = "SELECT * FROM tbl_makemodel_mt ";
                          $result = $con->query($sql);

                              while ($row = $result->fetch_assoc()) {
                                  $mk_code = $row['pmk_make_code'];
                                  $mk_desc = $row['pmk_desc'];
                                  echo "<option value='$mk_code'>$mk_desc</option>";
                              }
                              ?>
                      </select>

                      <script>
                        $(document).ready(function() {
                            
                            $('.select2-dropdown').select2({
                                placeholder: 'Select',
                                allowClear: true,
                                
                            });
                        });
                    </script>
                  </div>

                  <div class="form-group">
                      <label>Fuel Type: *</label>
                      <select name="fuel_type" id="fuel_type" class="dropdown" required>
                        <option value="">Select</option>
                        <option value="P">Petrol</option>
                        <option value="D">Diesel</option>
                        <option value="H">Hybrid</option>
                        <option value="E">Electric</option>
                      </select>
                  </div>

                  <div class="form-group">
                    <label for="">Registration Status: *</label>
                    <div class="form-group row" style="justify-content: center;">
                        <div class="col-sm-4">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="vehi_registration" id="registered" value="regostered" required>
                              Registered
                            <i class="input-helper"></i></label>
                          </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="vehi_registration" id="not-registered" value="unregistered" required>
                            Unregistered
                          <i class="input-helper"></i></label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group" id="reg-no-group" >
                      <label>Registration No: *</label><input type="text" name="reg_no" id="reg_no" placeholder="If registered" required>
                  </div>

                  <div class="form-group">
                      <label>Usage: *</label>
                      <select name="usage"  class="dropdown" required>
                        <option value="">Select</option>
                        <option value="private">Private</option>
                        <option value="hiring">Hiring</option>
                        <option value="rent">Rent</option>
                      </select>
                  </div>

                  <div class="form-group">
                      <label>Seating Capacity: *</label>
                      <input type="text" name="seating_capacity" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                  </div>

                  <div class="form-group">
                      <label>Year of Manufacture: *</label><input type="text" name="manf_year" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                  </div>
              </div>
            </div>
            <button class="save-button1" type="submit" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'none' : 'initial'; ?>">Calculate</button>
            </form>
            <br>

        <!-- End Quotation Form -->
        <div class="table-responsive" style="display: <?php $form = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($form) && $form !== "") ? 'initial' : 'none'; ?>">
          <form id="coverForm" action="save-test.php" method="POST">
            <table class="custom-table">
              <?php
              //calculation to get ncb mr 
              $sum_insured      = !empty($_SESSION['sumInsured']) ? $_SESSION['sumInsured'] : null;
              $rate             = !empty($_SESSION['vehicleRate']) ? $_SESSION['vehicleRate'] : null;
              $basicrate        = !empty($_SESSION['basicRate']) ? $_SESSION['basicRate'] : null;
              $seatingCapacity  = !empty($_SESSION['seatingCapacity']) ? $_SESSION['seatingCapacity'] : null;
              //$rate = 0.01409;
              //echo $rate;
              $our_cont         = NULL;
              $sum_ins          = NULL;
              $total2           = NULL;
              $total3           = NULL;
              $total4           = NULL;
              $total5           = NULL;
              $totvat           = NULL;
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
                  $basicrate_contRS =   number_format($basicrate_cont, 2);
                  //$basicrate_contRS = round((float)$basicrate_cont, 2);
                  $_SESSION['basic_premium'] = $basicrate_cont;

                  $difference       =   $basicrate_cont - $our_cont;
                  $ncb_mr           =   $difference / 2;
                  $ncb_mrRS         =   number_format($ncb_mr, 2);
                  $total1           =   $basicrate_cont - $ncb_mr;
                  $_SESSION['ncb_mr_Amt'] = $ncb_mr;
                  }

              //$total1 = $total1 + 1500;
              //Calculate 
              if ($ncb_mr !== null && !empty($ncb_mr)) {
                  $discountNCB      =   $ncb_mr / $basicrate_cont * 100;
                  $discountNCB      =   number_format($discountNCB, 2);
                  $_SESSION['ncbRate'] = $discountNCB;
                  $discountMR       =   $ncb_mr / $total1 * 100; 
                  $discountMR       =   number_format($discountMR, 2);
                  $_SESSION['mrRate'] = $discountMR;
                  }
              //end calculation to get ncb mr 
              ?>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Cover type</th>
                  <th>Value (int amt)</th>
                  <th>Rate %</th>
                  <th>Cover (Y/N)</th>
                  <th>Premium (Rs)</th>
                </tr>
              </thead>

              <tbody id="coverTable">
                <tr>
                 <td>>></td>
                 <td><b>SUM INSURED </b></td> 
                 <td><input style='text-align: right;' type='number' class='value-input' value="<?php echo $sum_ins = number_format($sum_ins,2) ?>" placeholder='0.0' readonly></td>
                 <td><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td>
                 <td>
                 <select class='cover-select'>
                 <option value='Yes'>Yes</option>
                 </select>
                 </td>
                 <td style='text-align: right;'><b> <?php echo $sum_ins  ?> </b></td>
                 </tr>

                 <tr>
                 <td>>></td>
                 <td><b>BASIC PREMIUM</b></td> 
                 <td><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td>
                 <td><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td>
                 <td>
                 <select class='cover-select'>
                 <option value='Yes'>Yes</option>
                 </select>
                 </td>
                 <td style='text-align: right;'><b> <?php echo $basicrate_contRS ?> </b></td>
                 </tr>

                 <tr>
                 <td>>></td>
                 <td><b>NCB (%)</b></td>
                 <td><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td> 
                 <td><input style='text-align: right;' type='number' class='value-input' value="<?php echo $discountNCB ?>" placeholder='0.0' readonly></td>
                 <td>
                 <select class='cover-select'>
                 <option value='Yes'>Yes</option>
                 </select>
                 </td> 
                 <td style='text-align: right;'><b><?php echo $ncb_mrRS ?></b></td>
                 </tr>

              <?php
              $count = 1;
              $srccTC_chargers = array();
              //Calculation Algorythm Cover - Top //
                if ($result_prcTop->num_rows > 0) {
                  // Counter for numbering rows
                  while ($row = $result_prcTop->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']                        ;
                  $calcProcess        =     $row['is_process']                ;
                  $cover_code         =     $row['cover_code']                ;
                  $initialAmount      =     $row['initial_amt']               ;
                  //$initialAmount      =     number_format($initialAmount, 2)  ;
                  $coverRate          =     $row['cover_rate']                ;
                  $calculationType    =     $row['calc_type']                 ;
                  $coverFormula       =     $row['cov_formula']               ;
                  $calculationBlock   =     $row['code_block']                ;
                  $free_upto          =     $row['free_upto']                 ;
                  $edit_flag          =     $row['edit_flag']                 ;
              // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  //$PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = round((float)$PAB_VALUE, 2);
                                  $total1 += $row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total1 += $row['premium'];
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                              $row['premium'] = round((float)$calValue, 2);
                              $total1 += $row['premium'];
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total1 += $row['premium'];
                              }
                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);;
                                } 
                                else {
                                $row['premium'] = round((float)$initialAmount, 2);
                                $total1 += $row['premium'];
                                }
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total1 += $row['premium'];
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total1 = $total1 + $initialAmount;
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total1 += $row['premium'];
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total1 += $row['premium'];
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total1 += $row['premium'];
                              }
                            break;
                          default:
                          
                      }
                      $row['cover_area'] = "CTNM";
                    //End Calculation Code
                    // Add details to admin chargers array
                    $srccTC_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['premium'] 
                    );
                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_T[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_T[]' value='" . $row['cover_code'] . "'></td>";
                      echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_T[]' value='" . $row['initial_amt'] . "' oninput='recalculatePremium(this)' $readonly></td>";
                      echo "<td><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_T[]' value='" . $row['cover_rate'] . "' $readonly></td>";
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
                      echo "<td style='text-align: right;' class='premium'>" . $row['premium'] = number_format($row['premium'], 2) . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_T[]' value='" . $row['premium'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_T[]' value='" . $row['calc_seq'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_T[]' value='" . $row['cover_area'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_T[]' value='" . $row['edit_flag'] . "'></td>";
                      echo "</tr>";
                      
                      $count++;
                  }
                  $_SESSION['srccTC_chargers'] = $srccTC_chargers;
              } else {
                  echo "No results found.";
              }
              if ($ncb_mr !== null && !empty($ncb_mr)) {
                $discountMR     =   $ncb_mr / $total1 * 100; 
                $discountMR     =   number_format($discountMR, 2);
                $_SESSION['mrRate'] = $discountMR;
                }
              //End Calculation Algorythm //
                ?>
                <tr>
                <td>>></td>
                <td><b>MR</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-rate' value="<?php echo $discountMR ?>" placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php echo $ncb_mrRS ?></b></td>
                </tr>
        
                <tr>
                <td>>></td>
                <td><b>TOTAL 01</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php echo $total1NUMBER = number_format($total1, 2);?></b></td>
                </tr>

                <?php
              //$count = 1;
              $other_cover_chargers = array();
              //Calculation Algorythm  Cover - Bottom//
                if ($result_prcBottom->num_rows > 0) {
                  // Counter for numbering rows
                  while ($row = $result_prcBottom->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;

              // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  $PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = $PAB_VALUE;
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = round((float)$initialAmount, 2);
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                
                              $row['premium'] = round((float)$calValue, 2);
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);;
                                } 
                                else {
                                $row['premium'] = round((float)$initialAmount, 2);
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total2 = $total2 + $initialAmount;
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              }
                            break;
                            
                          default:
                             
                      }
                      $row['cover_area'] = "CBT01";
                    //End Calculation Code
                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                    // Add details to admin chargers array
                    $other_cover_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['premium']
                    );

                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B[]' value='" . $row['cover_code'] . "'></td>";
                      echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $row['initial_amt'] . "' $readonly></td>";
                      echo "<td><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B[]' value='" . $row['code_block'] . "'></td>";
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
                      echo "<td style='text-align: right;'>" . $row['premium'] = number_format($row['premium'], 2) . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B[]' value='" . $row['premium'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B[]' value='" . $row['calc_seq'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B[]' value='" . $row['cover_area'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B[]' value='" . $row['edit_flag'] . "'></td>";
                      echo "</tr>";
                      
                      $count++;
                  }
                  $_SESSION['other_cover_chargers'] = $other_cover_chargers;
              } else {
                  //echo "No results found.";
              }
              
              //End Calculation Algorythm //
                ?>

                <tr>
                <td>>></td>
                <td><b>GROSS CONTRIBUTION (TOTAL 02)</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot2 = $total2 + $total1;
                echo $total2NUMBER = number_format($tot2, 2);
                $_SESSION['GrossContribution_tot02'] = $tot2; ?></b></td>
                </tr>
                <?php
              //$count = 1;
              $admin_chargers = array(); // Initialize the admin chargers array
              //Calculation Algorythm  Cover - Other Chargers under Total 03//
                if ($result_prcBottom_ADC->num_rows > 0) {
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_ADC->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;

              // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  //$PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = round((float)$PAB_VALUE, 2);
                                  $total3 += (float)$row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total3 = $total3 + $initialAmount;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $row['premium'] = round((float)$calValue, 2);
                                $total3 = $total3 + $calValue;
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total3 += (float)$row['premium'];
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total3 += (float)$row['premium'];
                                } 
                                else {
                                $row['premium'] = round((float)$initialAmount, 2);
                                $total3 += (float)$row['premium'];
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total3 = $total3 + $initialAmount;
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total3 += (float)$row['premium'];
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total3 += (float)$row['premium'];
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total3 += (float)$row['premium'];
                              }
                            break;
                            
                          default:
                             
                      }
                      $row['cover_area'] = "CBT02";
                    //End Calculation Code
                    // Add details to admin chargers array
                    $admin_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['premium'] 
                    );

                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";
                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADM[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADM[]' value='" . $row['cover_code'] . "'></td>";
                      echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B_ADM[]' value='" . $row['initial_amt'] . "' $readonly></td>";
                      echo "<td><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADM[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B_ADM[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B_ADM[]' value='" . $row['code_block'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADM5[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADM[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADM[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADM[]' value='" . $row['free_upto'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADM[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B_ADM[]'>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                     
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;'>" . $row['premium'] = number_format($row['premium'], 2) . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADM[]' value='" . $row['premium'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADM[]' value='" . $row['calc_seq'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADM[]' value='" . $row['cover_area'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B_ADM[]' value='" . $row['edit_flag'] . "'></td>";
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
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot3 = $total3 + $total2 + $total1; echo $total3NUMBER = number_format($tot3, 2); ?></b></td>
                </tr>

                <?php
              //$count = 1;
                
              //Calculation Algorythm  Cover - Admin Chargers//
                if ($result_prcBottom_ADCO->num_rows > 0) {
                  $SSCL_chargers = array(); // Initialize the SSCL chargers array
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_ADCO->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;

              // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  //$PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = round((float)$PAB_VALUE, 2);
                                  $total4 += (float)$row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total4 = $total4 + $initialAmount;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $calValue1 = number_format($calValue, 2);
                                $row['premium'] = $calValue1;
                                $total4 = $total4 + $calValue;
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total4 += (float)$row['premium'];
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total4 += (float)$row['premium'];
                                } 
                                else {
                                $row['premium'] = round((float)$initialAmount, 2);
                                $total4 += (float)$row['premium'];
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total4 = $total4 + $initialAmount;
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total4 += (float)$row['premium'];
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total4 += (float)$row['premium'];
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total4 += (float)$row['premium'];
                              }
                            break;
                            
                          default:
                             
                      }
                      $row['cover_area'] = "CBT03";
                    //End Calculation Code
                    // Add details to VAT chargers array
                    $SSCL_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['premium']
                    );
                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";
                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADM1[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADM1[]' value='" . $row['cover_code'] . "'></td>";
                      echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B_ADM1[]' value='" . $row['initial_amt'] . "' $readonly></td>";
                      echo "<td><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADM1[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B_ADM1[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B_ADM1[]' value='" . $row['code_block'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADM1[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADM1[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADM1[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADM1[]' value='" . $row['free_upto'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADM1[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B_ADM1[]'>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                     
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;'>" . $row['premium'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADM1[]' value='" . $row['premium'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADM1[]' value='" . $row['calc_seq'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADM1[]' value='" . $row['cover_area'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B_ADM1[]' value='" . $row['edit_flag'] . "'></td>";
                      echo "</tr>";
                      
                      $count++;
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
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot4 = $total4 + $total3 + $total2 + $total1; echo $total4NUMBER = number_format($tot4, 2); ?></b></td>
                </tr>

                <?php
              //$count = 1;
                
              //Calculation Algorythm  Cover - Admin Chargers//
                if ($result_prcBottom_ADCO1->num_rows > 0) {
                  $vat_chargers = array(); // Initialize the VAT chargers array
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_ADCO1->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;

              // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  //$PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = round((float)$PAB_VALUE, 2);
                                  $total5 += $row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = $initialAmount;
                              $total5 = $total5 + $initialAmount;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                //$calValue1 = number_format($calValue, 2);
                              $row['premium'] = round((float)$calValue, 2);
                              $total5 = $total5 + $calValue;
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total5 += (float)$row['premium'];
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total5 += (float)$row['premium'];
                                } 
                                else {
                                $row['premium'] = round((float)$initialAmount, 2);
                                $total5 += (float)$row['premium'];
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total5 = $total5 + $initialAmount;
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total5 += (float)$row['premium'];
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total5 += (float)$row['premium'];
                              } 
                              else {
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total5 += (float)$row['premium'];
                              }
                            break;
                            
                          default:
                             
                      }
                      $row['cover_area'] = "CBT04";
                    //End Calculation Code
                    
                    // Add details to VAT chargers array
                    $vat_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['premium']
                    );

                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";
                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B_ADMT[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B_ADMT[]' value='" . $row['cover_code'] . "'></td>";
                      echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B_ADMT[]' value='" . $row['initial_amt'] . "' $readonly></td>";
                      echo "<td><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADMT[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B_ADMT[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B_ADMT[]' value='" . $row['code_block'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADMT[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADMT[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADMT[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADMT[]' value='" . $row['free_upto'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADMT[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B_ADMT[]'>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                      
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='text-align: right;'>" . $row['premium'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='premium_B_ADMT[]' value='" . $row['premium'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='calc_seq_B_ADMT[]' value='" . $row['calc_seq'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_area_B_ADMT[]' value='" . $row['cover_area'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='edit_flag_B_ADMT[]' value='" . $row['edit_flag'] . "'></td>";
                      echo "</tr>";
                      
                      $count++;
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
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                    <select class='cover-select'>
                        <option value='Yes'>Yes</option>
                    </select>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot5 = $total5 + $tot4;
                echo $total5NUMBER = number_format($tot5, 2);
                $_SESSION['TotalContribution'] = $tot5; ?></b></td>
                </tr>

              </tbody>
            </table>
           
          </form>
        </div>
        <hr style="margin-top: 1px; margin-bottom: 1px; border: 0px;">
        <div>
        
        <button id="form-reset" class="save-button" type="submit" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'initial' : 'none'; ?>">Reset</button>
        <button id="form-recal" class="save-button" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'initial' : 'none'; ?>">Edit</button>
        <button id="form-save" class="save-button" style="display:none; ?>">Save</button>    
        <button id="form-print" class="save-button" type="button" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'initial' : 'none'; ?>">Save</button>
      </div> 
      <script>
        document.getElementById('form-print').addEventListener('click', function() {
          document.getElementById('coverForm').submit();
        });

        document.getElementById('form-recal').addEventListener('click', function() {
          document.getElementById('coverForm').action = 'motor-quotationEditable.php';
          document.getElementById('coverForm').submit();
        });

        document.getElementById('form-save').addEventListener('click', function() {
          document.getElementById('coverForm').action = 'save-test.php';
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

    // Display selected Company Code from the business channel dropdown on the table fileds.

    $(document).ready(function(){
        $('#bus_channel').change(function(){
            var selectedCompany = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'get_selected_company.php',
                data: { selectedChannel: selectedChannel },
                success: function(response){
                    console.log(response);
                    $('.bus_channel').val(response); 
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

//Form hide and show according to the Business Channel
document.getElementById('buis_channel').addEventListener('change', function () {
        var companyDiv = document.getElementById('company_div');
        if (this.value === 'L/B') {
            companyDiv.style.display = 'block';
        } else {
            companyDiv.style.display = 'none';
        }
    });

document.getElementById('buis_channel').addEventListener('change', function () {
        var companyDiv = document.getElementById('product_div');
        if (this.value === 'ATI') {
            companyDiv.style.display = 'block';
        } else {
            companyDiv.style.display = 'none';
        }
    });
//End
</script>

</body>

</html>
<?php } ?>