<?php session_start();

include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
    $username = $_SESSION['u_name'] ;
    //Restricted Users for back date option
    $restrictUsers = ["MTK.PRINTINGSHOP","FALEEL.MOHAMED", "M.SAATHIRA", "S.SITHARA", "S.PATHESVARARAJA", "F.M.RIZVY", "S.A.M.IDREES", "S.L.M.RADEEM", "A.L.M.NASMY", "S.A.M.NAWTHAR", "MM.SAFRAS", "Al.FAIROOS", "F.M.ILHAM", "A.S.THASLEEM", "F.M.RIZVY", "S.SATHATH", "M.I.M.RAFEES"];
// check username in array
if (in_array($username, $restrictUsers)) {
    $display = 1;
} else {
    $display = NULL;
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
  <title>Amana | Third Party Cover Note</title>
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
   <!-- Link to Toast Notification CSS file -->
 <link rel="stylesheet" href="assets/notifications/toast.css">
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
      <?php
        $br_code = $_SESSION['branch'];
        $sql = "SELECT b_shortcode FROM tbl_branch WHERE b_code = '$br_code' ";
        $result = $con->query($sql);

        while ($row = $result->fetch_assoc()) {
            $shortCODE = $row['b_shortcode'];
        }
        //serial number generate for motorcar
        function generate_CN_Number_motorcar($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code) {

            $filename = 'last_serial_number_MC.txt';
            $lastSerialNumber = file_exists($filename) ? intval(file_get_contents($filename)) : 0;
            $serialNumber = str_pad($lastSerialNumber + 1, 5, '0', STR_PAD_LEFT);
            file_put_contents($filename, $serialNumber);
            $currentYearLastTwoDigits = date("y");
  
            return $mc_branchCode . $vm_Code . $cvm_Code . $ptm_Code . $plcy_Code . $serialNumber . '/' . $currentYearLastTwoDigits;
        }
        
        $mc_branchCode = $shortCODE; // First 3 Digits Amana Branch Code
        $vm_Code = 'V'; // 4th Digit Indicate as Vehicle
        $cvm_Code = 'P'; // 5th Digit class of vehicle
        $ptm_Code = 'T'; // 6th digit Policy type 3rd Party
        $plcy_Code = 'DP'; // 7th & 8th Digits mentioned as policy
        
        $AG3_CNumber = generate_CN_Number_motorcar($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code);

        //serial number generate for motorcycle
        function generate_CN_Number_motorcycle($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code) {

            $filename = 'last_serial_number_MCy.txt';
            $lastSerialNumber = file_exists($filename) ? intval(file_get_contents($filename)) : 0;
            $serialNumber = str_pad($lastSerialNumber + 1, 5, '0', STR_PAD_LEFT);
            file_put_contents($filename, $serialNumber);
            $currentYearLastTwoDigits = date("y");
  
            return $mc_branchCode . $vm_Code . $cvm_Code . $ptm_Code . $plcy_Code . $serialNumber . '/' . $currentYearLastTwoDigits;
        }
        
        $mc_branchCode = $shortCODE; // First 3 Digits Amana Branch Code
        $vm_Code = 'V'; // 4th Digit Indicate as Vehicle
        $cvm_Code = 'M'; // 5th Digit class of vehicle
        $ptm_Code = 'S'; // 6th digit Policy type 3rd Party
        $plcy_Code = 'DP'; // 7th & 8th Digits mentioned as policy
        
        $VUN_CNumber = generate_CN_Number_motorcycle($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code);

         //serial number generate for Three Wheel
         function generate_CN_Number_ThreeWheel($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code) {

            $filename = 'last_serial_number_MCy.txt';
            $lastSerialNumber = file_exists($filename) ? intval(file_get_contents($filename)) : 0;
            $serialNumber = str_pad($lastSerialNumber + 1, 5, '0', STR_PAD_LEFT);
            file_put_contents($filename, $serialNumber);
            $currentYearLastTwoDigits = date("y");
  
            return $mc_branchCode . $vm_Code . $cvm_Code . $ptm_Code . $plcy_Code . $serialNumber . '/' . $currentYearLastTwoDigits;
        }
        
        $mc_branchCode = $shortCODE; // First 3 Digits Amana Branch Code
        $vm_Code = 'V'; // 4th Digit Indicate as Vehicle
        $cvm_Code = 'T'; // 5th Digit class of vehicle
        $ptm_Code = 'S'; // 6th digit Policy type 3rd Party
        $plcy_Code = 'DP'; // 7th & 8th Digits mentioned as policy
        
        $THI_CNumber = generate_CN_Number_ThreeWheel($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code);

        //serial number generate for Dual Purpose
        function generate_CN_Number_DualPurpose($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code) {

            $filename = 'last_serial_number_MCy.txt';
            $lastSerialNumber = file_exists($filename) ? intval(file_get_contents($filename)) : 0;
            $serialNumber = str_pad($lastSerialNumber + 1, 5, '0', STR_PAD_LEFT);
            file_put_contents($filename, $serialNumber);
            $currentYearLastTwoDigits = date("y");
  
            return $mc_branchCode . $vm_Code . $cvm_Code . $ptm_Code . $plcy_Code . $serialNumber . '/' . $currentYearLastTwoDigits;
        }
        
        $mc_branchCode = $shortCODE; // First 3 Digits Amana Branch Code
        $vm_Code = 'V'; // 4th Digit Indicate as Vehicle
        $cvm_Code = 'D'; // 5th Digit class of vehicle
        $ptm_Code = 'T'; // 6th digit Policy type 3rd Party
        $plcy_Code = 'DP'; // 7th & 8th Digits mentioned as policy
        
        $ODD_CNumber = generate_CN_Number_DualPurpose($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code);

        //serial number generate for Lorry
        function generate_CN_Number_Lorry($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code) {

            $filename = 'last_serial_number_MCy.txt';
            $lastSerialNumber = file_exists($filename) ? intval(file_get_contents($filename)) : 0;
            $serialNumber = str_pad($lastSerialNumber + 1, 5, '0', STR_PAD_LEFT);
            file_put_contents($filename, $serialNumber);
            $currentYearLastTwoDigits = date("y");
  
            return $mc_branchCode . $vm_Code . $cvm_Code . $ptm_Code . $plcy_Code . $serialNumber . '/' . $currentYearLastTwoDigits;
        }
        
        $mc_branchCode = $shortCODE; // First 3 Digits Amana Branch Code
        $vm_Code = 'V'; // 4th Digit Indicate as Vehicle
        $cvm_Code = 'L'; // 5th Digit class of vehicle
        $ptm_Code = 'T'; // 6th digit Policy type 3rd Party
        $plcy_Code = 'DP'; // 7th & 8th Digits mentioned as policy
        
        $JFN_CNumber = generate_CN_Number_Lorry($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code);

        //serial number generate for Tractor
        function generate_CN_Number_Tractor($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code) {

            $filename = 'last_serial_number_MCy.txt';
            $lastSerialNumber = file_exists($filename) ? intval(file_get_contents($filename)) : 0;
            $serialNumber = str_pad($lastSerialNumber + 1, 5, '0', STR_PAD_LEFT);
            file_put_contents($filename, $serialNumber);
            $currentYearLastTwoDigits = date("y");
  
            return $mc_branchCode . $vm_Code . $cvm_Code . $ptm_Code . $plcy_Code . $serialNumber . '/' . $currentYearLastTwoDigits;
        }
        
        $mc_branchCode = $shortCODE; // First 3 Digits Amana Branch Code
        $vm_Code = 'V'; // 4th Digit Indicate as Vehicle
        $cvm_Code = 'T'; // 5th Digit class of vehicle
        $ptm_Code = 'O'; // 6th digit Policy type 3rd Party
        $plcy_Code = 'DP'; // 7th & 8th Digits mentioned as policy
        
        $KWL_CNumber = generate_CN_Number_Tractor($mc_branchCode, $vm_Code, $cvm_Code, $ptm_Code, $plcy_Code);
 
        ?>

      <div class="container mt-4">

      <div class="container-fluid px-4">
                <div class="main-block">
        <form id="3rd" action="submit.php" method="post" target="_blank">
        <fieldset>
            <legend><br>
                <h3>Customer Information</h3>
            </legend><br>
            <div class="account-details">
                <div>

                    <label>Name of Participant *</label>
                    <select name="prefix" id="" class="dropdown btn btn-sm btn-dark bg-dark" style="width:60px" required>
                        <option value="MR">MR</option> 
                        <option value="MRS">MRS</option>   
                        <option value="DR">DR</option>
                        <option value="M/S">M/S</option>
                        <option value="MISS">MISS</option>
                        <option value="Rev">Rev</option>
                        <option value="MS">MS</option>
                        <option value="PROF">PROF</option>
                    </select>
                    <div >
                    <input type="text" name="name"  style="text-transform: uppercase;width: 230px;" required>
                
                    </div>
                    </div>
                <div>
                    <label>ID. Type : *</label>
                    <select name="reg_type" id="reg_type" class="dropdown btn btn-sm btn-dark bg-dark" required>
                        <option value="old nic">Old NIC</option>
                        <option value="new nic">New NIC</option>
                        <option value="bus.reg no">Bus.Reg No</option>
                    </select>
                </div>
                <div><label>ID. No : *</label><input type="text" id="id-number" name="reg_no" required></div>
                
                <script>
                    const regTypeSelect = document.getElementById('reg_type');
                    const idInput = document.getElementById('id-number');

                    // Function to apply restrictions based on selected ID type
                    function applyInputRestrictions() {
                        const selectedType = regTypeSelect.value;

                        // Remove any existing attributes to reset input
                        idInput.removeAttribute('maxlength');
                        idInput.removeAttribute('pattern');
                        idInput.value = ''; // Clear input when changing type
                        idInput.placeholder = 'Enter ID No';

                        if (selectedType === 'old nic') {
                            idInput.setAttribute('maxlength', '10'); // 9 digits + 1 letter 'V'
                            idInput.setAttribute('pattern', '^[0-9]{9}[Vv]$'); // Regex for 9 digits followed by V (case insensitive)
                            idInput.placeholder = 'e.g., 123456789V';
                        } else if (selectedType === 'new nic') {
                            idInput.setAttribute('maxlength', '12'); // Only 12 numeric digits
                            idInput.setAttribute('pattern', '^[0-9]{12}$'); // Regex for exactly 12 digits
                            idInput.placeholder = 'e.g., 199012345678';
                        } else if (selectedType === 'bus.reg no') {
                            // No restrictions for Bus.Reg No
                            idInput.removeAttribute('maxlength');
                            idInput.removeAttribute('pattern');
                            idInput.placeholder = 'Enter Bus Reg No';
                        }
                    }

                    // Attach event listener to selection box
                    regTypeSelect.addEventListener('change', applyInputRestrictions);

                    // Apply the restrictions when the page loads
                    window.addEventListener('load', applyInputRestrictions);
                </script>
                
                <div><label>Mobile Number *</label><input type="text" name="mbnumber" required pattern="[0-9]{10}" title="10 numeric characters only"  maxlength="10" required></div>
                <div><label>Address 01 *</label><input type="text" name="address_01" required></div>
                <div><label>Address 02 *</label><input type="text" name="address_02" required></div>
                <div><label>City *</label>
                <!-- <input type="text" name="city" required> -->
                <select name="city" id="city" class="dropdown select2-dropdown" required>
                    <option value="">Select</option>
                        <?php
                        $sqlcity = "SELECT PCO_CTRY_CODE, PCO_DESC FROM tbl_city_mt ORDER BY PCO_DESC ASC";
                        $resultcity = $con->query($sqlcity);
                        while ($rowCity = $resultcity->fetch_assoc()) {
                            $CityCode = $rowCity['PCO_CTRY_CODE'];
                            $CityName = $rowCity['PCO_DESC'];
                            echo "<option value='$CityCode'>$CityName</option>";
                        }
                        ?>
                </select>
                </div>
                <?php 
                $sql = "SELECT * FROM tbl_product ";
                                $result = $con->query($sql);
                                $product = array();
                ?>
                <div >
                    <label>Product *</label>
                    <select name="product" id="product" class="dropdown btn btn-sm btn-dark bg-dark" required onchange="updateProductValue()">
                        <option value="">Select</option>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            $P_id = $row['name'];
                            $P_name = $row['name'];
                            $P_value = $row['value'];
                            $P_code = $row['prod_code'];
                            echo "<option value='$P_id' data-product-value='$P_value' data-product-code='$P_code'>$P_name</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="product_value" id="product_value" value="">
                    <input type="hidden" name="product_code" id="product_code" value="">
                    <script>
                                        function updateProductValue() {
                        var selectedProduct = document.getElementById('product');
                        var productValueField = document.getElementById('product_value');
                        var productCodeField = document.getElementById('product_code');

                        // Update hidden fields with selected product data
                        productValueField.value = selectedProduct.options[selectedProduct.selectedIndex].getAttribute('data-product-value');
                        productCodeField.value = selectedProduct.options[selectedProduct.selectedIndex].getAttribute('data-product-code');
                        
                        // Trigger AJAX request to fetch makes and models based on selected product
                        var productCode = productCodeField.value;
                        if (productCode) {
                            fetchMakesAndModels(productCode);
                        }
                    }

                    // Function to fetch makes and models using AJAX
                    function fetchMakesAndModels(productCode) {
                        var makeModelDropdown = document.querySelector('select[name="make_model"]');
                        
                        // Make an AJAX request to fetch make and model data
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', 'get_makes_models.php?prod_code=' + productCode, true);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                var makesModels = JSON.parse(xhr.responseText);
                                // Clear previous options
                                makeModelDropdown.innerHTML = '<option value="">Select</option>';
                                // Populate dropdown with new options
                                makesModels.forEach(function(item) {
                                    var option = document.createElement('option');
                                    option.value = item.model;
                                    option.textContent = item.model + ' - ' + item.model;
                                    makeModelDropdown.appendChild(option);
                                });
                            }
                        };
                        xhr.send();
                    }


                    </script>

                </div>

                <div>
                <label>Policy Start Date</label>
                <input type="date" name="start_date" id="start_date" required>
                </div>
                <div>
                <label>End Policy Date</label>
                <input type="date" name="end_date" id="end_date" readonly>
                </div>
                
                                <?php if (in_array($username, $restrictUsers)): ?>
                <script>
                // Get the current date
                var currentDate = new Date();

                // Calculate 14 days before the current date
                var minDate = new Date();
                minDate.setDate(currentDate.getDate() - 0);

                // Calculate 21 days after the current date
                var maxDate = new Date();
                maxDate.setDate(currentDate.getDate() + 0);

                // Format the minimum and maximum dates as 'YYYY-MM-DD'
                var minDateString = minDate.toISOString().split('T')[0];
                var maxDateString = maxDate.toISOString().split('T')[0];

                // Format the current date as 'YYYY-MM-DD'
                var currentDateString = currentDate.toISOString().split('T')[0];

                // Set the minimum and maximum attributes of the start_date input element
                document.getElementById('start_date').setAttribute('min', minDateString);
                document.getElementById('start_date').setAttribute('max', maxDateString);

                // Set the default value to the current date for start_date
                document.getElementById('start_date').value = currentDateString;

                // Function to set the end date as one day before the next year
                function setEndDateBasedOnStartDate(startDate) {
                    var endDate = new Date(startDate);
                    endDate.setFullYear(startDate.getFullYear() + 1);
                    endDate.setDate(endDate.getDate() - 1);

                    // Format the end date as 'YYYY-MM-DD'
                    return endDate.toISOString().split('T')[0];
                }

                // Calculate and set the default end date based on the current date
                document.getElementById('end_date').value = setEndDateBasedOnStartDate(currentDate);

                // Add event listener to start_date input for updating end_date
                document.getElementById('start_date').addEventListener('input', function() {
                    var startDate = new Date(this.value);
                    var endDateString = setEndDateBasedOnStartDate(startDate);
                    
                    // Set the value of the end_date input
                    document.getElementById('end_date').value = endDateString;
                });
                </script>
    
                <?php else: ?>
                <script>
                // Get the current date
                var currentDate = new Date();
    
                // Calculate 14 days before the current date
                var minDate = new Date();
                minDate.setDate(currentDate.getDate() - 14);
    
                // Calculate 21 days after the current date
                var maxDate = new Date();
                maxDate.setDate(currentDate.getDate() + 21);
    
                // Format the minimum and maximum dates as 'YYYY-MM-DD'
                var minDateString = minDate.toISOString().split('T')[0];
                var maxDateString = maxDate.toISOString().split('T')[0];
    
                // Format the current date as 'YYYY-MM-DD'
                var currentDateString = currentDate.toISOString().split('T')[0];
    
                // Set the minimum and maximum attributes of the start_date input element
                document.getElementById('start_date').setAttribute('min', minDateString);
                document.getElementById('start_date').setAttribute('max', maxDateString);
    
                // Set the default value to the current date for start_date
                document.getElementById('start_date').value = currentDateString;
    
                // Function to set the end date as one day before the next year
                function setEndDateBasedOnStartDate(startDate) {
                    var endDate = new Date(startDate);
                    endDate.setFullYear(startDate.getFullYear() + 1);
                    endDate.setDate(endDate.getDate() - 1);
    
                    // Format the end date as 'YYYY-MM-DD'
                    return endDate.toISOString().split('T')[0];
                }
    
                // Calculate and set the default end date based on the current date
                document.getElementById('end_date').value = setEndDateBasedOnStartDate(currentDate);
    
                // Add event listener to start_date input for updating end_date
                document.getElementById('start_date').addEventListener('input', function() {
                    var startDate = new Date(this.value);
                    var endDateString = setEndDateBasedOnStartDate(startDate);
                    
                    // Set the value of the end_date input
                    document.getElementById('end_date').value = endDateString;
                });
    
                </script>
                <?php endif; ?>

                <!-- Agent code dropdown -->
                <?php
                $sql = "SELECT agent_code FROM tbl_user_agent_codes WHERE branch_code = '$br_code' ORDER BY agent_code + 0 ASC";
                $resultagent_code = $con->query($sql);
                if ($resultagent_code->num_rows > 0 && empty($display)): ?>
                    <div>
                    <label>Agent Code *</label>
                    <select name="ag_code" id="ag_code" class="dropdown btn btn-sm btn-dark bg-dark" required>
                    <option value="">SELECT</option>
                    <?php
                    while ($rowAC = $resultagent_code->fetch_assoc()) {
                        $agent_code = $rowAC['agent_code'];
                        echo "<option value='$agent_code'>$agent_code</option>";
                    }
                    ?>
                    </select>
                </div>
                <?php elseif ($resultagent_code->num_rows > 0  && !empty($display)): ?>
                <input type="hidden" name="ag_code">
                <?php endif; ?>
                <!-- End -->

                <div>
                    <!--label>Cover Note Number</label-->
                    <input type="hidden"  readonly>
                    <input type="hidden" name="cn_motorcar" value="<?php echo $AG3_CNumber; ?>" readonly>
                    <input type="hidden" name="cn_motorcycle" value="<?php echo $VUN_CNumber; ?>" readonly>
                    <input type="hidden" name="cn_threewheel" value="<?php echo $THI_CNumber; ?>" readonly>
                    <input type="hidden" name="cn_dualpurpose" value="<?php echo $ODD_CNumber; ?>" readonly>
                    <input type="hidden" name="cn_lorry" value="<?php echo $JFN_CNumber; ?>" readonly>
                    <input type="hidden" name="cn_tractor" value="<?php echo $KWL_CNumber; ?>" readonly>
                    <!--small>Last Serial Number: <?php //echo $lastSerialNumber; ?></small-->
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend><br>
                <h3>Vehicle Information </h3>
            </legend><br>
            <div class="account-details">
           
                <div>
                    <label>Make & Model *</label>
                    <select name="make_model" class="dropdown select2-dropdown" required>
                        <option value="">Select</option>
                       
                    </select>
                </div>

            <div>
                    <label>Year of Manufacture *</label><input type="text" name="manufac_year" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
                <?php 
                $sql = "SELECT * FROM tbl_usage_type ";
                                $result = $con->query($sql);
                                $product = array();
                ?>
                <div>
                    <label>Usage Type *</label>
                    <select name="usage_type" class = "dropdown btn btn-sm btn-dark bg-dark" required>
                    <option value="">Select</option>
                    <?php
                        while ($row = $result->fetch_assoc()) {
                        $U_id = $row['type'];
                        $U_name = $row['type'];
                        echo "<option value='$U_id'>$U_name</option>";
                    }
                    ?>
                    </select>
                </div>
                <div>
                <?php 
                $sql = "SELECT * FROM tbl_fuel_type";
                                $result = $con->query($sql);                        
                ?>
                    <label>Fuel Type *</label>
                    <select name="fuel_type" class = "dropdown btn btn-sm btn-dark bg-dark" required>
                    <option value="">Select</option>
                    <?php
                        while ($row = $result->fetch_assoc()) {
                        $F_code = $row['code'];
                        $F_name = $row['desc'];
                        echo "<option value='$F_code'>$F_name</option>";
                    }
                    ?>
                    </select>
                </div>
                <div><label>Registered Owner</label><input type="text" name="registered_owner" placeholder = "If Different From Owner" ></div>
                <div><label>Registration Status *</label>
                    <div class="radio_flex">
                        <input id='registered' type="radio" name='reg_status' checked required>
                        <label for="radio-1">Registered</label>
                        <input id='not-registered' type="radio" name='reg_status' required>
                        <label for="radio-2">Unregistered</label>
                    </div>
                </div>
                <div id="reg-no-group"><label>Registration Number *</label><input type="text" name="registration_number" id="reg_no" required></div>
                <div><label>Engine Number *</label><input type="text" id="enging_number" name="engine_number" required></div>
                <div><label>Chassis Number *</label><input type="text" name="chassis_number" required></div>
                <div><label>Engine Capacity *</label><input type="text" id="engine_capacity" name="engine_capacity" required pattern="\d+(\.\d+)?" required></div>
                
                <div><label>Manual CN Number</label><input type="text" name="manualcnnumber" placeholder="Optional"></div>
                    <?php 
                    $branchcode = $_SESSION['branch'];
                    $sql = "SELECT * FROM tbl_branch where b_code = '$branchcode' ";
                    $result = $con->query($sql);
               
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $br_name = strtoupper($row['b_name']);
                    } else {
                        
                    }?>
                   <input type="hidden" name="branchname" value="<?php echo $br_name; ?>" readonly>
                
                <div><label>Cash Recieved *</label>
                    <select name="cash_received" id="cash_received" class="dropdown btn btn-sm btn-dark bg-dark" required>
                    <option value="">SELECT</option>    
                    <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                    <div id="cash_received_error" class="error-message" style="display: none;">You cannot submit the form when Cash Received is "NO".</div>
                </div>
        </fieldset>

        <?php if (empty($display)): ?>
        <fieldset class="section-bottum" >
            <legend><br>
                <h3>Other Information </h3>
            </legend><br>
            <div class="account-details">
            <div>
                <?php 
                //$sql = "SELECT receipt_no, receipt_date FROM tbl_receipt WHERE available_amount >0 AND user_added = '$username' AND status = 1";
                $sql = "SELECT r.receipt_no, r.receipt_date, r.user_added, s.branch
                        FROM tbl_receipt r
                        LEFT JOIN
                        tbl_staff s 
                        ON r.user_added = s.username
                        WHERE
                        r.available_amount >0
                        AND
                        r.status = 1
                        AND
                        (s.branch = '$br_code' OR r.user_added = '$username')";
                                $result = $con->query($sql);                        
                ?>
                    <label>Receipt Number *</label>
                    <select name="receipt_number" id="receipt_number" class = "dropdown btn btn-sm btn-dark bg-dark" required onchange="updateReceiptDate()">
                    <option value="">Select</option>
                    <?php
                        while ($row = $result->fetch_assoc()) {
                        $R_code = $row['receipt_no'];
                        $R_date = $row['receipt_date'];
                        echo "<option value='$R_code' data-receipt-date='$R_date'>$R_code</option>";
                    }
                    ?>
                    </select>

                    <input type="hidden" name="receipt_date" id="receipt_date" value="">
                    <script>
                    function updateReceiptDate() {
                        var selectedreceipt = document.getElementById('receipt_number');
                        var receiptDateField = document.getElementById('receipt_date');

                        // Update the hidden field with the data-receipt-date attribute of the selected option
                        receiptDateField.value = selectedreceipt.options[selectedreceipt.selectedIndex].getAttribute('data-receipt-date');
                    }
                </script>

                </div>
                <div><label>Commission Amount</label><input type="text" id="commission_amount" name="commission_amount" placeholder="Rs." ></div>
        </div>
        </fieldset>
        <?php endif; ?>
        <div>
                <button id="refresh" class = "btn btn-primary mr-2" >Refresh</button>
                <button type="submit" id="submitButton" class = "btn btn-primary mr-2" >Submit</button>
        </div>
        
        
    </form>
     
    <div id="notification" class="notification"></div>  

  <!-- Toast Notification container -->
    <div id="toast-container"></div>
    
    <script>
    $(document).ready(function() {
        
        $('.select2-dropdown').select2({
            placeholder: 'Select',
            allowClear: true,
            
        });
    });
    </script>
</div>
<style>
.select2-dropdown {
    background-color: #24282d;
    color: white;
}
.select2-selection--single {
    background-color: #24282d !important;
    }

form {
width: 100%;
padding: 0px;
}
.display{
    display: none;
}

fieldset {
border: none;
border-top: 1px solid #8ebf42;

}
.account-details input:focus {
    border-color: #000000; /* Black color */
}
.account-details, .personal-details {
display: flex;
flex-wrap: wrap;
justify-content: space-between;
}
.account-details >div, .personal-details >div >div {
display: flex;
align-items: center;
margin-bottom: 10px;
}
.account-details >div, .personal-details >div, input, label {
width: 100%;
}
label {
padding: 0 5px;
text-align: left;
vertical-align: middle;
}
input {
padding: 1px;
vertical-align: middle;
text-transform: uppercase;
background-color: #282f3a;
color: white;
}
.dropdown{
    vertical-align: middle;
    width: calc(60% + 5px);
padding: 3px 0;
font-size: 14px;
text-transform: uppercase;


}
.checkbox {
margin-bottom: 0px;
}
select, .children, .gender, .bdate-block {
width: calc(100% + 5px);
padding: 5px 0;
}
select {
background: transparent;
}
.gender input {
width: auto;
} 
.gender label {
padding: 0 5px 0 0;
} 
.bdate-block {
display: flex;
justify-content: space-between;
}
.birthdate select.day {
width: 35px;
}
.birthdate select.mounth {
width: calc(100% - 94px);
}
.birthdate input {
width: 38px;
vertical-align: unset;
}
.checkbox input, .children input {
width: auto;
margin: -2px 10px 0 0;
}
.checkbox a {
color: #8ebf42;
}
.checkbox a:hover {
color: #82b534;
}
.fbtn {
width: 10%;
padding: 10px 0;
margin: 10px auto;
border-radius: 5px; 
border: none;
background: #8ebf42; 
font-size: 14px;
font-weight: 600;
color: #fff;
}

button:hover {
background: #82b534;
}
@media (min-width: 568px) {
.account-details >div, .personal-details >div {
width: 45%;
}
label {
width: 40%;
color: #d9d9da;
}
input {
width: 60%;
}
select, .children, .gender, .bdate-block {
width: calc(60% + 16px);
}
}
/* Form Background Effect*/ 
.container-fluid .px-4 {
background-color: #1e1e1e;
margin-bottom: 30px;
padding-bottom: 30px;
border-radius:10px;
}
.container-fluid {
    background-color: #24282d;
}

H3 {
    color: yellowgreen;
}
.dropdown.btn.btn-sm.btn-dark.bg-dark {
    border-radius: 0;
    border-color: #ffffff8a;
    text-align:left;
}
.radio_flex
{
display:flex;
}
.save-button {
  display: inline-block;
  background-color: #282F3A;
  margin-top: 10px;
  border-radius: 0px;
  padding-top: 2px;
  padding-left: 10px;
  padding-right: 10px;
  padding-bottom: 2px;
}
.save-button:hover {
    background: #81bd43;
    color: white;
}
/* dropdown search */
/* Agent code section */
.modal {
            display: <?php echo $formSubmitted ? 'none' : 'block'; ?>;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 400px;
            margin: 250px auto;
            text-align: center;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .modal-content button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }

        .form-container {
            text-align: center;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
      
</style>
<script>

//Refresh page
 // Get reference to the button
 const refreshButton = document.getElementById('refresh');

// Add event listener to reload the page on click
refreshButton.addEventListener('click', function(e) {
    e.preventDefault(); // Prevent default button behavior (especially if inside a form)
    location.reload();  // Reload the page
});

//Cash Received Condition 
const cashReceived = document.getElementById('cash_received');
    const receiptNumber = document.getElementById('receipt_number');
    const submitButton = document.getElementById('submitButton');
    const form = document.getElementById('3rd');

    // Disable receipt number if "NO" is selected
    cashReceived.addEventListener('change', function () {
        if (this.value === 'no') {
            receiptNumber.disabled = true;
            showToast('error', 'Receipt number is disabled because Cash Received is set to "NO"');
        } else {
            receiptNumber.disabled = false;
        }
    });

    // Prevent form submission if Cash Received is "NO"
    form.addEventListener('submit', function (event) {
        if (cashReceived.value === 'no') {
            event.preventDefault(); // Prevent form submission
            showToast('error', 'You cannot submit the form when Cash Received is "NO".');
        }
    });
    
 //Product Filter
const productSelect = document.getElementById('product');
const engineInput = document.getElementById('enging_number');
const chassisInput = document.getElementById('engine_capacity');

// Function to apply/remove 'required' attribute based on product selection
function toggleRequiredFields() {
    const selectedProduct = productSelect.value;

    if (selectedProduct === 'Tractor' || selectedProduct === 'Lorry') {
        // Remove 'required' attribute from engine and chassis number
        engineInput.removeAttribute('required');
        chassisInput.removeAttribute('required');
    } else {
        // Add 'required' attribute back to engine and chassis number
        engineInput.setAttribute('required', 'required');
        chassisInput.setAttribute('required', 'required');
    }
}

// Attach event listener to product selection
productSelect.addEventListener('change', toggleRequiredFields);

// Apply logic when the page loads
window.addEventListener('load', toggleRequiredFields);

//Commission Amount RS
$(document).ready(function() {
        setDefaultcomamt();

        $('#commission_amount').on('input', formatcomamntInput);

        function setDefaultcomamt() {
            var CommisionInput = $('#commission_amount');
            
        }

        function formatcomamntInput() {
            var CommisionInput = $('#commission_amount');
            var CommissionValue = CommisionInput.val();
            var numericValue = CommissionValue.replace(/\D/g, '');

            console.log('Original Value:', CommissionValue);
            console.log('Numeric Value:', numericValue);

            var formattedValue = 'Rs. ' + parseInt(numericValue, 10).toLocaleString();

            console.log('Formatted Value:', formattedValue);
            CommisionInput.val(formattedValue);
        }
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

$(document).ready(function() {
$('#productDropdown').change(function() {
var productId = $(this).val();

// Make an AJAX request to get the product code based on the selected product
$.ajax({
url: 'getProductCode.php', // Replace with the actual file to fetch the product code
method: 'POST',
data: { productId: productId },
success: function(response) {
// Update the product code input field
$('#productCode').val(response);
}
});
});
});

// Function to show the notification popup
function showNotification(message) {
var notification = document.getElementById('notification');
notification.innerHTML = message;
notification.style.display = 'block';

// Hide the notification after 3 seconds (adjust as needed)
setTimeout(function () {
notification.style.display = 'none';
}, 3000);
}

// Submit form using AJAX to prevent page reload
document.getElementById('myForm').addEventListener('submit', function (event) {
event.preventDefault();

var formData = new FormData(this);

// Send form data to the server using AJAX
fetch('submit.php', {
method: 'POST',
body: formData
})
.then(response => response.json())
.then(data => {
if (data.success) {
// If data is inserted successfully, show the notification
showNotification('Data inserted successfully');
} else {
// Handle error cases if needed
console.error(data.error);
}
})
.catch(error => {
// Handle network errors
console.error('Error:', error);
});
});

function openInNewTab(url) {
//var win = window.open(url, '_blank');
win.focus();
}  


</script>

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
  <!-- Include Toast Notification JavaScript -->
<script src="assets/notifications/toast.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
<?php } ?>