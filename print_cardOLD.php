<?php session_start();
header("Cache-Control: public, max-age=86400");
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
    
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
  <title>Amana | Third Party Card Print</title>
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
<!-- search form-->
 
  

    <!-- Search Function -->
    <?php
    $id = "";
    $CNnumber = "";
    $nop = "";
    $onic = "";
    $nnic = "";
    $ad1 = "";
    $ad2 = "";
    $city = "";
    $product = "";
    $covernum = "";
    $manualCN = "";
    $mmodel = "";
    $utype  = "";
    $regowner = "";
    $regnumber = "";
    $engnum = "";
    $chnum = "";
    $engcapacity = "";
    $rcpnumber = "";
    $valid = "";
    $issdate = "";

    if(isset($_POST['search']))
    {
    $CNnumber=$_POST['cn-number'];
    $ret= mysqli_query($con,"SELECT cover_note_number manual_cn_number FROM tbl_insurance WHERE cover_note_number ='$CNnumber' OR manual_cn_number ='$CNnumber' ");
    $num=mysqli_fetch_array($ret);
    if($num>0)
    {

        $sql = "SELECT * FROM tbl_insurance where cover_note_number = '$CNnumber' OR manual_cn_number ='$CNnumber' ";
        $result = $con->query($sql);
   
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $nop = $row['name'];
            $onic = $row['reg_type'];
            $nnic = $row['reg_no'];
            $ad1 = $row['address_01'];
            $ad2 = $row['address_02'];
            $city = $row['city'];
            $product = $row['product'];
            $covernum = $row['cover_note_number'];
            $manualCN = $row['manual_cn_number'];
            $mmodel = $row['make_model'];
            $utype = $row['usage_type'];
            $regowner = $row['registered_owner'];
            $regnumber = $row['registration_number'];
            $engnum = $row['engine_number'];
            $chnum = $row['chassis_number'];
            $engcapacity = $row['engine_capacity'];
            $rcpnumber = $row['receipt_number'];
            $valid = $row['valid_period'];
            $issdate = $row['date_added'];

            
            
        } else {
            $id = "";
            $nop = "";
            $onic = "";
            $nnic = "";
            $ad1 = "";
            $ad2 = "";
            $city = "";
            $product = "";
            $covernum = "";
            $manualCN = "";
            $mmodel = "";
            $utype  = "";
            $regowner = "";
            $regnumber = "";
            $engnum = "";
            $chnum = "";
            $engcapacity = "";
            $rcpnumber = "";
            $valid = "";
            $issdate = "";
            
        }
        

    }
    else
    {
    
    echo "<script>alert('Invalid Cover Note Number');</script>";
        $id = "";
        $nop = "";
        $onic = "";
        $nnic = "";
        $ad1 = "";
        $ad2 = "";
        $city = "";
        $product = "";
        $covernum = "";
        $manualCN = "";
        $mmodel = "";
        $utype  = "";
        $regowner = "";
        $regnumber = "";
        $engnum = "";
        $chnum = "";
        $engcapacity = "";
        $rcpnumber = "";
        $valid = "";
        $issdate = "";
    }
    }
    ?>


      <div class="container-fluid px-4">
      <form class="form-inline" method="POST" action="" style="width: 50%;padding-top:30px;">
        <!-- Column 1 - Selection -->
        <div class="form-group mx-2">
            <input class = "form-control" type="text" name = "cn-number" placeholder = "Search Cover Note Number... " required >
            </select>
        </div>

        <!-- Submit Button -->
        &ensp;<button type="submit" class="btn btn-primary" name="search">Search</button>&ensp;
        <!-- a href="./clients" class="btn btn-info">Reload</a-->
    </form>
                <div class="main-block">
        <form action="card.php" method="post" target="_blank">
        <fieldset>
            <legend><br>
                <h3>Customer Information</h3>
            </legend><br>
            <div class="account-details">
                <input type="hidden" name="id" value = "<?php echo $id; ?>">
                <div><label>Name of Participant</label><input type="text" name="name" value = "<?php echo $nop; ?>" readonly></div>
                <div><label>ID Type :</label><input type="text" name="old_nic" value = "<?php echo $onic; ?>" readonly></div>
                <div><label>ID No :</label><input type="text" name="new_nic" value = "<?php echo $nnic; ?>" readonly></div>
                <div><label>Address 01</label><input type="text" name="address_01" value = "<?php echo $ad1; ?>" readonly></div>
                <div><label>Address 02</label><input type="text" name="address_02" value = "<?php echo $ad2; ?>" readonly></div>
                <div><label>City</label><input type="text" name="city" value = "<?php echo $city; ?>" readonly></div>
                <div >
                    <label>Product</label>
                    <input type="text" name="product" value = "<?php echo $product; ?>" readonly>
                </div>
                <div>
                    <?php
                        if (isset($manualCN) && !empty($manualCN)) {
                            $CN_number = $manualCN;
                        } else {
                            $CN_number = $covernum;
                        } 
                    ?>
                    <label>Cover Note Number</label>
                    <input type="text" name="cover-note" value = "<?php echo $CN_number; ?>" readonly>
                </div>
                <div>
                    <label>Issued Date</label>
                    <input type="text" name="date-added" value = "<?php echo $issdate; ?>" readonly>
                </div>
                <div>
                    <label>Period</label>
                    <input type="text" name="valid" value = "<?php echo $valid; ?>" readonly>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend><br>
                <h3>Vehicle Information </h3>
            </legend><br>
            <div class="account-details">
                <div>
                    <label>Make & Model</label>
                    <input type="text" name="make-model" value = "<?php echo $mmodel; ?>" readonly>
                </div>
                <div>
                    <label>Usage Type</label>
                    <input type="text" name="usage_type" value = "<?php echo $utype; ?>" readonly>
                </div>
                <div><label>Registered Owner</label><input type="text" name="registered-owner" value = "<?php echo $regowner; ?>" readonly ></div>
                <div><label>Registration Number</label><input type="text" name="registration_number" value = "<?php echo $regnumber; ?>" readonly></div>
                <div><label>Engine Number</label><input type="text" name="engine_number" value = "<?php echo $engnum; ?>" readonly></div>
                <div><label>Chassis Number</label><input type="text" name="chassis_number" value = "<?php echo $chnum; ?>" readonly></div>
                <div><label>Engine Capacity</label><input type="text" name="engine_capacity" value = "<?php echo $engcapacity; ?>" readonly ></div>
                <div><label>Receipt Number *</label><input type="text" name="rep-number" onclick="logAction('Clicked Receipt Number Input')"  value = "<?php echo $rcpnumber; ?>" style="text-transform: uppercase;" required></div>
                
                <div><label>Cash Recieved *</label>
                    <div class="radio_flex">
                        <input id='radio-1' type="radio" name='cash_rec' onclick="logAction('Clicked Cash Received Yes')" required>
                        <label for="radio-1">Yes</label>
                        <input id='radio-2' type="radio" name='cash_rec' onclick="logAction('Clicked Cash Received No')" required>
                        <label for="radio-2">No</label>
                    </div>
                </div>
            
            </div>
        </fieldset>

        <button type="submit" class = "btn btn-primary mr-2 btn-icon-text" onclick="logAction('Clicked Print Card Button')">
            Print Card 
            <i class="ti-printer btn-icon-append"></i>
        </button>
    </form>
    <div id="notification" class="notification"></div>  
</div>

<script>
    function validateForm() {

        var engCapacity = "<?php echo $engcapacity; ?>";

        // Check if engcapacity is not empty
        if (engCapacity.trim() === '') {
            alert('Please enter the Engine Capacity.');
            return false; // Prevent form submission
        }

        // You can add more checks for other fields if needed

        return true; // Allow form submission
    }
</script>

<style>
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
background-color: #282f3a;
color: white;
}
.dropdown{
    vertical-align: middle;
    width: calc(60% + 5px);
padding: 3px 0;
font-size: 14px;
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
.radio_flex
{
display:flex;
}
</style>

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
  
    <script>
    // Function to log actions
    function logAction(actionDescription) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "log_action.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("action=" + encodeURIComponent(actionDescription));
        }
  </script>
  
</body>

</html>
<?php } ?>