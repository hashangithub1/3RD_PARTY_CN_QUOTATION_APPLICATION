<?php session_start();
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

include_once('includes/config.php');
include_once('datagrid-mt.php');
include_once('calculate_mr_ncb.php');
$_SESSION['mqForm_premium_matching'] = null;
$_SESSION['page_name'] = "motor-quotation.php";

// Page Reload
if (!isset($_SESSION['reload_count'])) {
  $_SESSION['reload_count'] = 0;
}
if ($_SESSION['reload_count'] < 2) {
  $_SESSION['reload_count'] += 1;
};
// END
//include_once('calculation-mt-02');
$SelectCompanyCode = !empty($_SESSION['companycode_form']) ? $_SESSION['companycode_form'] : null;   
$SelectCompanyName = !empty($_SESSION['companyname_form']) ? $_SESSION['companyname_form'] : null;
$SelectChannelCode = !empty($_SESSION['selected_channel_code']) ? $_SESSION['selected_channel_code'] : null;   
$SelectChannelName = !empty($_SESSION['selected_channel_name']) ? $_SESSION['selected_channel_name'] : null;     
$basicRate         = !empty($_SESSION['basicRate']) ? $_SESSION['basicRate'] : null;
$vehicleRate       = !empty($_SESSION['vehicleRate']) ? $_SESSION['vehicleRate'] : null;
$_SESSION['srccTC'] =   NULL;
//Condition for Company name
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

//Condition for business Channel name
if (!isset($SelectChannelName) || $SelectChannelName === "") {
  $channelName = "Select a Channel";
} else {
  $channelName = $SelectChannelName;
}
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
option {
  width: 80%;
}
/* Form Background Effect*/ 

.container-fluid {
    background-color: #24282d;
}
.container {
  padding-bottom: 25px;
}

/* Custom alert message */
.warning-box {
    display: none; /* Initially hidden */
    align-items: center;
    background-color: #1e1e1e; /* Orange background */
    color: #e67e22;; /* White text */
    padding: 15px;
    border-radius: 5px;
    border-left: 10px solid #e67e22; /* Left border with darker orange */
    margin: 20px 0;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Icon container */
.warning-icon {
    font-size: 30px;
    margin-right: 15px;
}

/* Text container */
.warning-content {
    flex-grow: 1;
}

.warning-content h4 {
    margin: 0;
    font-size: 18px;
}

.warning-content p {
    margin: 0;
    font-size: 14px;
}

/* Styles for the close button */
.close-btn {
    background: white;
    color: #e67e22;
    padding: 5px 10px;
    border: none;
    cursor: pointer;
    border-radius: 3px;
    margin-left: 20px;
    font-size: 14px;
}

.close-btn:hover {
    background: #e67e22;
    color: white;
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
 
        <!-- Quotation Form -->
        <form id="data-form" action="calculation-mt.php" method="post" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'none' : 'initial'; ?>">
        <div class="container-form">
              <div class="form-column">
                  <h2 class="heading">Company Purpose</h2>
                  <hr>
                  <div class="form-group">
                      <label>Business Channel: *</label>
                      <select name="buis_channel" id="channel_select" class="dropdown" >
                          <option value=""><?php echo $channelName ?></option>
                          <option value="ATI">Direct / ATL Sales Staff</option>
                          <option value="L/B">Leasing / Banca</option>
                          <option value="I/B">Insurance Broker</option>
                      </select>
                  </div>

                  <?php if ($SelectChannelCode ): ?>
                  <div class="form-group" id="company_div">
                      <label>Company: *</label>
                      <select name="company" id="company_select" class="dropdown">
                          <option value=""><?php echo $compName ?></option>
                          <?php
                          $sql = "SELECT * FROM tbl_company_mt WHERE bus_channel = '$SelectChannelCode' ORDER BY name ASC ";
                          $result = $con->query($sql);

                              while ($row = $result->fetch_assoc()) {
                                  $compcode = $row['code'];
                                  $compname = $row['name'];
                                  echo "<option value='$compcode'>$compname</option>";
                              }
                              ?>
                      </select>
                  </div>
                  <?php endif; ?>

                  <?php if ($SelectCompanyCode ): ?>
                    <div class="form-group">
                      <label>Product: *</label>
                      <select name="product" id="companyProduct_select" class="dropdown" required>
                          <option value="">Select</option>
                          <?php
                          $sql = "SELECT DISTINCT pc.prod_code, c.product_des
                                  FROM tbl_product_cover_mt pc
                                  JOIN tbl_product_mt c ON pc.prod_code = c.product_code
                                  WHERE pc.comp_code = '$SelectCompanyCode'";
                          $result = $con->query($sql);

                              while ($row = $result->fetch_assoc()) {
                                  $prodc_code = $row['prod_code'];
                                  $prodc_desc = $row['product_des'];
                                  echo "<option value='$prodc_code'>$prodc_desc</option>";
                              }
                              ?>
                      </select>
                  </div>
                  <?php endif; ?>

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
                      minDate.setDate(currentDate.getDate() -0 );

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
                  <!-- Alert Message Custom -->
                  <div class="warning-box" id="warning-box">
                  <div class="warning-icon">
                      &#9888; <!-- Unicode character for warning icon -->
                  </div>
                  <div class="warning-content">
                      <h4>Warning</h4>
                      <p id="warning-message">Please refer to the H/O underwriting team.</p>
                  </div>
                  <button class="close-btn" id="close-btn">OK</button>
                  </div>
                  <!-- END -->

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

                  <div class="form-group" id="engine_capacity_group" style="display:none;">
                      <label>Engine Capacity: </label>
                      <select name="eng_cap" id="eng_cap" class="dropdown">
                          <option value="">Select</option>
                          <option value="A_250">Above 250 CC</option>
                          <option value="B_250">Below 250 CC</option>
                      </select>
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

                  <!-- Display a Message if fuel type is electric -->
                  <div class="warning-box" id="fuel-warning-box">
                  <div class="warning-icon">
                      &#9888; <!-- Unicode character for warning icon -->
                  </div>
                  <div class="warning-content">
                      <h4>Warning</h4>
                      <p id="warning-message">Please refer to the H/O underwriting team.</p>
                  </div>
                  <button class="close-btn" id="close-fuel-btn">OK</button>
                  </div>
                  <!-- End -->

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
                        <!-- <option value="hiring">Hiring</option>
                        <option value="rent">Rent</option> -->
                      </select>
                  </div>

                  <div class="form-group">
                      <label>Seating Capacity: *</label>
                      <input type="text" name="seating_capacity" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                  </div>

                  <div class="form-group">
                      <label>Year of Manufacture: *</label><input type="text" id="manf-year" name="manf_year" required maxlength="4" 
                      oninput="validateYear();" placeholder="YYYY">
                  </div>

                  <!-- Display a Message if year above 30 years -->
                  <div class="warning-box" id="yom-warning-box">
                      <div class="warning-icon">&#9888;</div> <!-- Unicode character for warning icon -->
                      <div class="warning-content">
                          <h4>Warning</h4>
                          <p id="warning-message">Please refer to the H/O underwriting team.</p>
                      </div>
                      <button class="close-btn" id="close-btn">OK</button>
                  </div>
                  <!-- End -->

              </div>
            </div>
            <button class="save-button1" type="submit" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'none' : 'initial'; ?>">Calculate</button>
            </form>
            <br>

        <!-- End Quotation Form -->
        <div class="table-responsive" style="display: <?php $form = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($form) && $form !== "") ? 'initial' : 'none'; ?>">
          <form id="coverForm" action="quo-pdf.php" method="POST" target="_blank">
            <table class="custom-table">
              <?php
              //calculation to get ncb mr 
              $sum_insured      = !empty($_SESSION['sumInsured']) ? $_SESSION['sumInsured'] : null;
              $rate             = !empty($_SESSION['vehicleRate']) ? $_SESSION['vehicleRate'] : null;
              $basicrate        = !empty($_SESSION['basicRate']) ? $_SESSION['basicRate'] : null;
              $seatingCapacity  = !empty($_SESSION['seatingCapacity']) ? $_SESSION['seatingCapacity'] : null;
              
              //$rate = 0.01409;
              
              $our_cont         = NULL;
              $sum_ins          = NULL;
              $total2           = NULL;
              $total3           = NULL;
              $total4           = NULL;
              $total5           = NULL;
              $totvat           = NULL;
              $tot2             = NULL;
              //  NEW TOTALS VARIABLES
              $T  = NULL;
              $T1 = NULL;
              $T2 = NULL;
              $T3 = NULL;
              $T4 = NULL;
              $T5 = NULL;
              $T6 = NULL;
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
              $_SESSION['our_contribution'] = $our_cont;
              //echo 'our Pre:'. $our_cont . '<br>';
              }

              //calculate basic contribution based on Rate
              if ($basicrate !== null && !empty($basicrate)) {
                  $basicrate_cont   =   $sum_ins * $basicrate;
                  $basicrate_contRS =   number_format($basicrate_cont, 2);
                  //$basicrate_contRS = round((float)$basicrate_cont, 2);
                  $_SESSION['basic_premium'] = $basicrate_cont;
                  //echo 'basic pre:'.$basicrate_cont;
              }
              
              ?>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Cover type</th>
                  <th>Value (int amt)</th>
                  <th style="display:none">Rate %</th>
                  <th>Cover<br> (Y/N)</th>
                  <th>Calculate<br> (Y/N)</th>
                  <th>Premium (Rs)</th>
                </tr>
              </thead>

              <tbody id="coverTable">
                <tr>
                 <td>>></td>
                 <td><b>SUM INSURED </b></td> 
                 <td><input style='text-align: right;' type='number' class='value-input' value="<?php echo $sum_ins1 = number_format($sum_ins,2) ?>" placeholder='0.0' readonly></td>
                 <td style="display:none"><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td>
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
                 <td style='text-align: right;'><b> <?php echo $sum_ins1  ?> </b></td>
                 </tr>

                 <tr>
                 <td>>></td>
                 <td><b>BASIC PREMIUM</b></td> 
                 <td><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td>
                 <td style="display:none"><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td>
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
                 <td style='text-align: right;'><b> <?php echo $basicrate_contRS ?> </b></td>
                 </tr>

                 <tr style="display:;">
                 <td>>></td>
                 <td><b>MR</b></td>
                 <td><input style='text-align: right;' type='number' class='value-input' placeholder='0.0' readonly></td> 
                 <td style="display:none"><input style='text-align: right;' type='number' class='value-input' value="<?php echo $mr_rate_ = number_format($mr_rate_, 3)?>" placeholder='0.0' readonly></td>
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
                 <td style='text-align: right;'><b><?php echo '('. $_mr_price = number_format($_mr_price, 2). ')' ?></b></td>
                 </tr>

              <?php
              $count = 1;
              $free_covers = array();
              $front_covers = array();
              // Calculation Algorithm Cover - Top //
              if ($result_prcTop->num_rows > 0) {
                  while ($row = $result_prcTop->fetch_assoc()) {
                      // Store values for calculation
                      $id = $row['id'];
                      $calcProcess = $row['is_process'];
                      $cover_code = $row['cover_code'];
                      $initialAmount = $row['initial_amt'];
                      $initialVariable = $row['variation_amounts'];
                      $coverRate = $row['cover_rate'];
                      $calculationType = $row['calc_type'];
                      $coverFormula = $row['cov_formula'];
                      $calculationBlock = $row['code_block'];
                      $free_upto = $row['free_upto'];
                      $edit_flag = $row['edit_flag'];
                      $display_cover = $row['display_cover'];
                      
                      // Hide free covers from the form
                      if ($display_cover === '0') {
                          $_SESSION['FreeCovers'] = $free_covers;
                          continue;
                      }
              
                      // Initialize the premium field
                      $row['premium'] = "";
              
                  // Handle comma-separated initial amounts
                  if (!empty($initialVariable)){

                    if (strpos($initialVariable, ',') !== false) {
                      $amounts = explode(',', $initialVariable);
                      $firstAmount = trim($amounts[0]); 
                      $remainingAmounts = array_slice($amounts, 1); 
          
                      // Use the first amount for calculations
                      $initialAmount = $firstAmount;
                      $row['initial_amt'] = $row['variation_amounts'];
                  } else {
                      $remainingAmounts = []; 
                  }
                  
                  }
                      // Calculation code based on calc_type
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                              if ($calcProcess === "yes") {
                                  $coverFormula = $row['cov_formula'];
                                  $result_sqlblock = $con->query($coverFormula);
                                  if ($result_sqlblock !== false) {
                                    echo $cover_code;
                                      eval($row['code_block']);
                                      $row['premium'] = round((float)$PAB_VALUE, 2);
                                      $T += $row['premium'];
                                  } else {
                                      echo "Error executing SQL formula: " . $con->error . "<br>";
                                  }
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          case 'cal':
                              if ($calcProcess === "yes") {
                                  eval($row['code_block']);
                                  $row['premium'] = round((float)$calValue, 2);
                                  $T += $row['premium'];
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          case 'rate':
                              if ($calcProcess === "yes") {
                                  eval($row['code_block']);
                              } else {
                                  $row['premium'] = 0;
                              }
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T += $row['premium'];
                              break;
                          case 'fixed':
                              if ($calcProcess === "yes") {
                                  $row['premium'] = round((float)$initialAmount, 2);
                                  $T += $row['premium'];
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                              if ($calcProcess === "yes") {
                                  $row['premium'] = round((float)$initialAmount, 2);
                                  $T += $row['premium'];
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          default:
                              break;
                      }
              
                      $row['cover_area'] = "CTNM";

                         // Add details to admin chargers array
                    $front_covers[] = array(
                      'cover' => $row['cover_description'],
                      'printflag' => $row['print_flag'],
                      'initialamt' => $row['initial_amt'],
                      'premium' => $row['premium']
                    );

            
                      // Determine readonly attribute based on edit_flag
                      $readonly = ($edit_flag == 0) ? "readonly" : "";
              
                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_T[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_T[]' value='" . $row['cover_code'] . "'></td>";
                      //echo "<input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $initialAmount . "' $readonly>";
                      echo "<td>";
                      if (strpos($row['initial_amt'], ',') !== false) {
                          // Split the initial_amt by commas
                          $amounts = explode(',', $row['initial_amt']);
                          echo "<select style = 'text-align: right; width:80%;' class='value-select' name='initial_amt_T[]' $readonly>";
                          foreach ($amounts as $amount) {
                              // Trim any whitespace and set it as the value for the dropdown options
                              $amount = trim($amount);
                              echo "<option value='" . $amount . "'>" . $amount . "</option>";
                          }
                          echo "</select>";
                      } else {
                          // If there's no comma, display as an input box
                          echo "<input style='text-align: right;' type='number' class='value-input' name='initial_amt_T[]' value='" . $row['initial_amt'] . "' $readonly>";
                      }
                      echo "</td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_T[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_T[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_T[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_T[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_T[]' value='" . $row['free_upto'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_T[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_T[]' disabled>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                      echo "</select>";               
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='is_process_T[]' disabled>";
                      echo "<option value='Yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_flag_T[]' disabled>";
                      echo "<option value='Yes'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
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
                  $_SESSION['front_covers'] = $front_covers;
              } else {
                  echo "No results found.";
              }

            
              ?>
              
                <tr style="display:;">
                <td>>></td>
                <td><b>NCB</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td style='display:none'><input style='text-align: right;' type='number' class='value-input' id='total-rate' value="<?php echo $ncb_rate_ = number_format($ncb_rate_ , 3)?>" placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php echo '('. $_ncb_price = number_format($_ncb_price, 2).')'?></b></td>
                </tr>

                <tr style="display:;">
                <td>>></td>
                <td><b>Total After Discount</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td style='display:none'><input style='text-align: right;' type='number' class='value-input' id='total-rate' value="" placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php echo $Tot_01_2 = number_format($Tot_01_, 2)?></b></td>
                </tr>
        
                <?php
              //$count = 1;
              $T1 = $T;
              $other_cover_chargers = array();
              $srccTC_chargers = array();
              $free_covers = array();
              $free_covers_CBT01 = array();
              //Calculation Algorythm  Cover - Bottom//
                if ($result_prcBottom_1->num_rows > 0) {
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_1->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $initialVariable    =     $row['variation_amounts'];
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;
                  $display_cover      =     $row['display_cover'] ;

                  //hide free covers from the form
                  if ($display_cover === '0') {
                    // Add details to free covers array
                    $free_covers_CBT01[] = array(
                      'cover' => $row['cover_description'],
                      'coverCode' => $row['cover_code'],
                      'coverType' => $row['calc_type'],
                      'coverAmt'  => $row['initial_amt'],
                      'calSequence' => $row['calc_seq'],
                      'printSquence' => $row['cover_prt_seq'],
                      'dis_area' => "CBT01"
                    );
                    $_SESSION['FreeCovers'] = $free_covers_CBT01;
                    continue;
                  }

                  // Handle comma-separated initial amounts
                  if (!empty($initialVariable)){

                    if (strpos($initialVariable, ',') !== false) {
                      $amounts = explode(',', $initialVariable);
                      $firstAmount = trim($amounts[0]); 
                      $remainingAmounts = array_slice($amounts, 1); 
          
                      // Use the first amount for calculations
                      $initialAmount = $firstAmount;
                      $row['initial_amt'] = $row['variation_amounts'];
                  } else {
                      $remainingAmounts = []; 
                  }

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
                                  $T1 += (float)$row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = 0;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                
                              $row['premium'] = round((float)$calValue, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $T1 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                              $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;
                          case 'free':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;  
                          default:
                             
                      }
                      $row['cover_area'] = "CBT00";


                    //End Calculation Code
                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                    // Add details to admin chargers array
                    $other_cover_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'printflag' => $row['print_flag'],
                      'initialamt' => $row['initial_amt'],
                      'premium' => $row['premium']
                    );

                      // Add details to admin chargers array
                      $srccTC_chargers[] = array(
                        'cover' => $row['cover_description'],
                        'printflag' => $row['print_flag'],
                        'premium' => $row['premium']
                    );

                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B[]' value='" . $row['cover_code'] . "'></td>";
                      //echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $row['initial_amt'] . "' $readonly></td>";
                      echo "<td>";
                      if (strpos($row['initial_amt'], ',') !== false) {
                          // Split the initial_amt by commas
                          $amounts = explode(',', $row['initial_amt']);
                          echo "<select style = 'text-align: right; width:80%;' class='value-select' name='initial_amt_B[]'>";
                          foreach ($amounts as $amount) {
                              // Trim any whitespace and set it as the value for the dropdown options
                              $amount = trim($amount);
                              echo "<option value='" . $amount . "'>" . $amount . "</option>";
                          }
                          echo "</select>";
                      } else {
                          // If there's no comma, display as an input box
                          echo "<input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $row['initial_amt'] . "' $readonly>";
                      }
                      echo "</td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B[]' value='" . $row['code_block'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B[]' value='" . $row['free_upto'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B[]' disabled>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' disabled>";
                      echo "<option value='Yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_flag_B[]' disabled>";
                      echo "<option value='Yes'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
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
                  $_SESSION['FreeCoversCBT01'] = $free_covers_CBT01;
                  $_SESSION['srccTC_chargers'] = $srccTC_chargers;
              } else {
                  //echo "No results found.";
              }
              
              $_SESSION['T1'] = $T1;
              $T1 += $Tot_01_;
              //End Calculation Algorythm //
              ?>
              <!-- Re calculate MR and NCB -->
               <?php

               ?>
              <!-- END -->

                <tr>
                <td>>></td>
                <td><b>TOTAL 01 </b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td style='display:none'><input style='text-align: right;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
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
                <td style='text-align: right;' id="total-contribution"><b><?php echo $T1RS = number_format($T1, 2); $_SESSION['T1_total01'] = $T1;?></b></td>
                </tr>

                <?php
              //$count = 1;
              $other_cover_chargers = array();
              $free_covers = array();
              //Calculation Algorythm  Cover - Bottom//
                if ($result_prcBottom_2->num_rows > 0) {
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_2->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $initialVariable    =     $row['variation_amounts'];
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;
                  $display_cover      =     $row['display_cover'] ;

                  //hide free covers from the form
                  if ($display_cover === '0') {
                    // Add details to free covers array
                    $free_covers_CBT01[] = array(
                      'cover' => $row['cover_description'],
                      'coverCode' => $row['cover_code'],
                      'coverType' => $row['calc_type'],
                      'coverAmt'  => $row['initial_amt'],
                      'calSequence' => $row['calc_seq'],
                      'printSquence' => $row['cover_prt_seq'],
                      'dis_area' => "CBT01"
                    );
                    $_SESSION['FreeCovers'] = $free_covers_CBT01;
                    continue;
                  }

                  // Handle comma-separated initial amounts
                  if (!empty($initialVariable)){

                    if (strpos($initialVariable, ',') !== false) {
                      $amounts = explode(',', $initialVariable);
                      $firstAmount = trim($amounts[0]); 
                      $remainingAmounts = array_slice($amounts, 1); 
          
                      // Use the first amount for calculations
                      $initialAmount = $firstAmount;
                      $row['initial_amt'] = $row['variation_amounts'];
                  } else {
                      $remainingAmounts = []; 
                  }

                  }

                
                  // Check conditions based on $sum_ins to hide or show covers
                  if ($SelectCompanyCode === 'lb001' || $SelectCompanyCode === 'amn-001'
                      || $SelectCompanyCode === 'afl003' || $SelectCompanyCode === 'vb002'
                      || $SelectCompanyCode === 'ccl004' || $SelectCompanyCode === 'of005'
                      || $SelectCompanyCode === 'ab006') {
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
                                  $total2 += (float)$row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = 0;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                
                              $row['premium'] = round((float)$calValue, 2);
                              $total2 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total2 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total2 += (float)$row['premium'];
                              } 
                              else {
                              $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total2 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;
                          case 'free':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total2 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;  
                          default:
                             
                      }
                      $row['cover_area'] = "CBT01";
                    //End Calculation Code
                    // Add details to admin chargers array
                    $other_cover_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'printflag' => $row['print_flag'],
                      'initialamt' => $row['initial_amt'],
                      'premium' => $row['premium'] 
                    );
                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";


                      // Output HTML table row
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['cover_description'] . "</td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_des_B[]' value='" . $row['cover_description'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='cover_code_B[]' value='" . $row['cover_code'] . "'></td>";
                      //echo "<td><input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $row['initial_amt'] . "' $readonly></td>";
                      echo "<td>";
                      if (strpos($row['initial_amt'], ',') !== false) {
                          // Split the initial_amt by commas
                          $amounts = explode(',', $row['initial_amt']);
                          echo "<select style = 'text-align: right; width:80%;' class='value-select' name='initial_amt_B[]'>";
                          foreach ($amounts as $amount) {
                              // Trim any whitespace and set it as the value for the dropdown options
                              $amount = trim($amount);
                              echo "<option value='" . $amount . "'>" . $amount . "</option>";
                          }
                          echo "</select>";
                      } else {
                          // If there's no comma, display as an input box
                          echo "<input style='text-align: right;' type='number' class='value-input' name='initial_amt_B[]' value='" . $row['initial_amt'] . "' $readonly>";
                      }
                      echo "</td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B[]' value='" . $row['code_block'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B[]' value='" . $row['free_upto'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B[]' disabled>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['default_stat'] == 'n' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' disabled>";
                      echo "<option value='Yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_flag[]' disabled>";
                      echo "<option value='Yes'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
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
                  $_SESSION['FreeCoversCBT01'] = $free_covers_CBT01;
              } else {
                  //echo "No results found.";
              }
              
              //End Calculation Algorythm //
                ?>

                <tr>
                <td>>></td>
                <td><b>GROSS CONTRIBUTION (TOTAL 02)</b></td>
                <td><input style='text-align: right;' type='number' class='value-input' id='total-initial' placeholder='0.0' readonly></td>
                <td style='display:none'><input style='text-align: right;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot2 += $total2 + $T1;
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
                  $display_cover      =     $row['display_cover'] ;
                  $maxLimit           =     $row['max_limit']     ;
                  //hide free covers from the form
                  if ($display_cover === '0') {
                    $_SESSION['FreeCovers'] = $free_covers;
                    continue;
                  }
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
                              $row['premium'] = 0;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $row['premium'] = round((float)$calValue, 2);
                                $total3 = $total3 + $calValue;
                              } 
                              else {
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total3 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total3 = $total3 + $initialAmount;
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total3 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
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
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADM[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B_ADM[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B_ADM[]' value='" . $row['code_block'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADM5[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADM[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADM[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADM[]' value='" . $row['free_upto'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADM[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B_ADM[]' disabled>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='is_process_T[]' disabled>";
                      echo "<option value='Yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_fla[]' disabled>";
                      echo "<option value='Yes'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
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
                <td style='display:none'><input style='text-align: right;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot3 = $total3 + $tot2; echo $total3NUMBER = number_format($tot3, 2); ?></b></td>
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
                  $display_cover      =     $row['display_cover'] ;

                  //hide free covers from the form
                  if ($display_cover === '0') {
                    $_SESSION['FreeCovers'] = $free_covers;
                    continue;
                  }

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
                              $row['premium'] = 0;
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
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total4 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total4 = $total4 + $initialAmount;
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total4 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
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
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADM1[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B_ADM1[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B_ADM1[]' value='" . $row['code_block'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADM1[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADM1[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADM1[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADM1[]' value='" . $row['free_upto'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADM1[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B_ADM1[]' disabled>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='is_process_T[]' disabled>";
                      echo "<option value='Yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_fla[]' disabled>";
                      echo "<option value='Yes'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
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
                <td style='display:none'><input style='text-align: right;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot4 = $total4 + $tot3; echo $total4NUMBER = number_format($tot4, 2); ?></b></td>
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
                  $display_cover      =     $row['display_cover'] ;

                  //hide free covers from the form
                  if ($display_cover === '0') {
                    $_SESSION['FreeCovers'] = $free_covers;
                    continue;
                  }

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
                              $row['premium'] = 0;
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
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total5 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total5 = $total5 + $initialAmount;
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total5 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
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
                      echo "<td style='display:none'><input style='text-align: right;' type='number' class='rate-input' name='cover_rate_B_ADMT[]' value='" . $row['cover_rate'] . "' $readonly></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='calc_type_B_ADMT[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none'><input style='text-align: right;' type='text' class='rate-input' name='code_block_B_ADMT[]' value='" . $row['code_block'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  class='calc-type-input' name='calc_type_B_ADMT[]' value='" . $row['calc_type'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;'  maxlength='255' class='cov-formula-input' name='cov_formula_B_ADMT[]' value='" . htmlspecialchars($row['cov_formula']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='code_block_B_ADMT[]' value='" . htmlspecialchars($row['code_block']) . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='free_upto_B_ADMT[]' value='" . $row['free_upto'] . "'></td>";
                      echo "<td style='display:none;'><input style='text-align: right;' type='text' class='code-block-input' name='is_process_B_ADMT[]' value='" . $row['is_process'] . "'></td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='default_stat_B_ADMT[]' disabled>";
                      echo "<option value='Yes'" . ($row['default_stat'] == 'y' ? ' selected' : '') . ">Yes</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td>";
                      echo "<select class='cover-select' name='is_process_T[]' disabled>";
                      echo "<option value='Yes'" . ($row['is_process'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['is_process'] == 'no' ? ' selected' : '') . ">No</option>";
                      echo "</select>";
                      echo "</td>";
                      echo "<td style='display:none'>";
                      echo "<select class='cover-select' name='print_fla[]' disabled>";
                      echo "<option value='Yes'" . ($row['print_flag'] == '1' ? ' selected' : '') . ">Yes</option>";
                      echo "<option value='No'" . ($row['print_flag'] == '0' ? ' selected' : '') . ">No</option>";
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
                <td style='display:none'><input style='text-align: right;' type='number' class='value-input' id='total-rate'  placeholder='0.0' readonly></td>
                <td>
                </td>
                <td>
                </td>
                <td style='text-align: right;' id="total-contribution"><b><?php $tot5 = $total5 + $tot4;
                echo $total5NUMBER = number_format($tot5, 2);
                $_SESSION['TotalContribution'] = $tot5; ?></b></td>
                </tr>
              <!-- Compulsory Excesses  -->
               <?php
                    // Output HTML table row
                    echo "<tr>";
                    echo "<td></td>";
                    echo "<td>Compulsory Excesses</td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td><input style='text-align: right;' type='text' id='cex-premium' class='code-block-input' placeholder='Nil' name='comp_excesses[]'></td>";
                    echo "</tr>"; 

               ?>
              <!-- End -->

              </tbody>
            </table>
            <!-- Remarks -->
            <?php
                echo "<br>";
                echo "<div style='display: flex; align-items: center; margin-bottom: 10px;'>";
                echo "<div style='width: 30%; text-align: right; font-weight: bold; padding-right: 10px;'>Remark</div>";
                echo "<div style='width: 70%;'>";
                echo "<input style='text-align: left; width: 100%; padding: 5px;' type='text' id='remark-note' class='code-block-input' placeholder='Comment Here' name='remark[]'>";
                echo "</div>";
                echo "</div>";
                ?>
            <!-- End -->
          </form>
        </div>
        <hr style="margin-top: 1px; margin-bottom: 1px; border: 0px;">
        <div>
        <button  onclick="exitFunction()"class="save-button" type="submit" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'initial' : 'none'; ?>">Reset</button>
        <button onclick="editFunction()" class="save-button" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'initial' : 'none'; ?>">Edit</button>
        <button id="form-save" class="save-button" style="display:none; ?>">Save</button>    
        <button id="form-print" class="save-button" type="button" style="display: <?php $btn = !empty($_SESSION['product']) ? $_SESSION['product'] : null; echo (isset($btn) && $btn !== "") ? 'initial' : 'none'; ?>"><i class='fas fa-file-pdf'></i> Generate PDF</button>
      </div> 
      <script>
        document.getElementById('form-print').addEventListener('click', function() {
          document.getElementById('coverForm').submit();
        });

        function editFunction() {
          location.replace("motor-quotationEditable.php")
        }
        //  document.getElementById('form-recal').addEventListener('click', function() {
        //  document.getElementById('coverForm').action = 'motor-quotationEditable.php';
        //    document.getElementById('coverForm').submit();
        //  });

        document.getElementById('form-save').addEventListener('click', function() {
          document.getElementById('coverForm').action = 'quo-pdf.php';
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

// Sum Insured include RS sign with condition if greater than 30M then show prompt a message 
$(document).ready(function () {
  const MAX_LIMIT = 30000000; 

  $('#sum-insured').on('input', function () {
      formatLifeCoverInput();
  });

  $('#close-btn').on('click', function () {
      $('#warning-box').hide(); 
  });

  function formatLifeCoverInput() {
      var lifeCoverInput = $('#sum-insured');
      var lifeCoverValue = lifeCoverInput.val();
      var numericValue = parseInt(lifeCoverValue.replace(/\D/g, ''), 10); 

      if (isNaN(numericValue)) numericValue = 0;

      if (numericValue > MAX_LIMIT) {
          $('#warning-box').fadeIn();
          $('#sum-insured').val(''); 
      } else {
          var formattedValue = 'Rs. ' + numericValue.toLocaleString();
          lifeCoverInput.val(formattedValue);
      }
  }
});

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
 
// Selected fuel type is Electric show the message box
$(document).ready(function () {
    console.log("Document is ready");

    // Monitor changes in the fuel type dropdown
    $('#fuel_type').on('change', function () {
        var selectedFuel = $(this).val(); 
        var selectedMakeModel = $('#make-model').val(); 
        console.log("Fuel type selected: " + selectedFuel); 
        console.log("Make-Model selected: " + selectedMakeModel); 

        
        if (selectedFuel === "E" && selectedMakeModel !== "04323") {
            $('#fuel-warning-box').fadeIn(); 
        } else {
            $('#fuel-warning-box').fadeOut(); 
        }
    });

    // Close button functionality for the fuel warning box
    $(document).on('click', '#close-fuel-btn', function () {
        console.log("OK button clicked!");
        $('#fuel-warning-box').fadeOut(); 
        $('#fuel_type').val('');
    });

    // Monitor changes in the make-model dropdown
    $('#make-model').on('change', function () {
        var selectedFuel = $('#fuel_type').val(); 
        var selectedMakeModel = $(this).val(); 
        console.log("Make-Model selected: " + selectedMakeModel); 

        
        if (selectedMakeModel === "1148" && selectedFuel === "E") {
            $('#fuel-warning-box').fadeOut(); 
            $('#fuel_type').val(''); 
        }
    });
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

    // Display selected Channel Code from the channel dropdown on the table fileds.

    $(document).ready(function(){
        $('#channel_select').change(function(){
            var selectedChannel = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'store_selected_channel.php',
                data: { selectedChannel: selectedChannel },
                success: function(response){
                    console.log(response);
                    $('.channel-code').val(response); 
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
    function exitFunction() {
            fetch('exit_quotation.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'exit' })
            })
            .then(response => {
                if (response.ok) {
                    location.replace("motor-quotation.php");
                } else {
                    //alert("Failed to exit. Please try again.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                //alert("An error occurred.");
            });
        }

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

//Display Engile Capacity based on the Product Type

    document.getElementById('companyProduct_select').addEventListener('change', function() {
        var selectedProduct = this.options[this.selectedIndex].text;
        var engineCapacityGroup = document.getElementById('engine_capacity_group');
        var engineCapacityDropdown = document.getElementById('eng_cap');

        if (selectedProduct === 'MOTOR CYCLE (COMPREHENSIVE COVER)') {
            engineCapacityGroup.style.display = 'block';
            engineCapacityDropdown.setAttribute('required', 'required');
        } else {
            engineCapacityGroup.style.display = 'none';
            engineCapacityDropdown.removeAttribute('required');
            engineCapacityDropdown.value = ''; // Reset the selection if hidden
        }
    });

//End

//Store Compulsory Exxcell value and remark on the session
$(document).ready(function() {

    $('#cex-premium').on('input', function() {
        var amount = $(this).val();

        $.ajax({
            url: 'update_remark_session.php', 
            type: 'POST',
            data: {
                amount: amount,
                input_id: 'cex-premium' 
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
                input_id: 'remark' 
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