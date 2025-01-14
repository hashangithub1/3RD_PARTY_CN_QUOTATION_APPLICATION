<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Staff Member</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/fav-icon.jpg" />

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

      <div class="container-fluid px-4">
                <div class="main-block">
        <form action="submit.php" method="post">
        <fieldset>
            <legend><br>
                <h3>Customer Information</h3>
            </legend><br>
            <div class="account-details">
                <div><label>Name *</label><input type="text" name="name" required></div>
                <div><label>Old NIC *</label><input type="text" name="old_nic" required></div>
                <div><label>New NIC *</label><input type="text" name="new_nic" required></div>
                <div><label>Address 01 *</label><input type="text" name="address_01" required></div>
                <div><label>Address 02 *</label><input type="text" name="address_02" required></div>
                <div><label>City *</label><input type="text" name="city" required></div>
                <?php 
                $sql = "SELECT * FROM tbl_product ";
                                $result = $con->query($sql);
                                $product = array();
                ?>
                <div >
                    <label>Product *</label>
                    <select name="product" class = "dropdown" required>
                    <option value="">Select</option>
                    <?php
                        while ($row = $result->fetch_assoc()) {
                        $P_id = $row['id'];
                        $P_name = $row['name'];
                        echo "<option value='$P_id'>$P_name</option>";
                    }
                    ?>
                    </select>
                </div>
                <div><label>Cover Note Number *</label><input type="text" name="cover_note_number" required></div>
            </div>
        </fieldset>

        <fieldset>
            <legend><br>
                <h3>Vehicle Information </h3>
            </legend><br>
            <div class="account-details">
            <?php 
            $sql = "SELECT * FROM tbl_model ";
                            $result = $con->query($sql);
                            $product = array();
            ?>
                <div>
                    <label>Make & Model *</label>
                    <select name="make_model" class = "dropdown" required>
                    <option value="">Select</option>
                    <?php
                        while ($row = $result->fetch_assoc()) {
                        $M_id = $row['id'];
                        $M_name = $row['model'];
                        echo "<option value='$M_id'>$M_name</option>";
                    }
                    ?>
                    </select>
                </div>
                <?php 
                $sql = "SELECT * FROM tbl_usage_type ";
                                $result = $con->query($sql);
                                $product = array();
                ?>
                <div>
                    <label>Usage Type *</label>
                    <select name="usage_type" class = "dropdown" required>
                    <option value="">Select</option>
                    <?php
                        while ($row = $result->fetch_assoc()) {
                        $U_id = $row['id'];
                        $U_name = $row['type'];
                        echo "<option value='$U_id'>$U_name</option>";
                    }
                    ?>
                    </select>
                </div>
                <div><label>Registered Owner</label><input type="text" name="registered_owner" placeholder = "If Different From Owner" ></div>
                <div><label>Registration Number *</label><input type="text" name="registration_number" required></div>
                <div><label>Engine Number *</label><input type="text" name="engine_number" required></div>
                <div><label>Chassis Number *</label><input type="text" name="chassis_number" required></div>
                <div><label>Engine Capacity *</label><input type="text" name="engine_capacity" required></div>
            </div>
        </fieldset>

        <button type="submit" class = "fbtn">Submit</button>
    </form>
    <div id="notification" class="notification"></div>
</div>

<style>
    form {
width: 100%;
padding: 0px;
}
fieldset {
border: none;
border-top: 1px solid #8ebf42;
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
width: 100%;
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
}
input {
width: 60%;
}
select, .children, .gender, .bdate-block {
width: calc(60% + 16px);
}
}
</style>
<script>
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
    </script>


      <!-- Code here -->

   
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../js/file-upload.js"></script>
  <script src="../js/typeahead.js"></script>
  <script src="../js/select2.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
<?php } ?>