<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Plugin css for page paggination -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<!-- Data Table CSS -->
<link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
<!-- Font Awesome CSS -->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
<!-- Plugin css for page paggination -->
  

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amana | Branch Report</title>
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



      <!-- Code here -->
<!-- Data Table -->
<legend><br>
                <h3>Branch Report - (Third Party)</h3>
            </legend><br>
<!-- search form-->

    <form class="form-inline" method="POST" action="">
        <!-- Column 1 - Selection -->

        <?php 
        $sql = "SELECT * FROM tbl_product ";
                        $result = $con->query($sql);
                        $product = array();
        ?>
        <div class="form-group mx-2">
            <label for="select1">Product : &ensp;</label>
            <select class="form-control" id="select1" name="product">
            <option value="">Select Product</option>
            <?php
                while ($row = $result->fetch_assoc()) {
                $B_id = $row['name'];
                $B_name = $row['name'];
                echo "<option value='$B_id'>$B_name</option>";
            }
            ?>
            </select>
        </div>

        <!-- Date Picker Column - From -->
        <div class="form-group mx-2">
            <label for="datepickerFrom">From Date : &ensp;</label>
            <input type="date" class="form-control" id="datepickerFrom" name="dateFrom">
        </div>

        <!-- Date Picker Column - To -->
        <div class="form-group mx-2">
            <label for="datepickerTo">To Date : &ensp;</label>
            <!--input type="date" class="form-control" id="datepickerTo" name="dateTo"-->
            <input type="date" class="form-control" id="datepickerTo" name="dateTo">
        </div>

        <!-- Submit Button -->
        &ensp;<button type="" class="btn btn-primary" name="search">Search</button>&ensp;
        <!-- a href="./clients" class="btn btn-info">Reload</a-->
    </form> 
    <br><br>
<!-- end search form-->

<!-- Search Function -->
<?php 
      // require the database connection
      $product = "";
      $dateFrom = "";
      $dateTo = "";
      $startDate = date('Y-m-d', strtotime('-30 days'));
      $branchcode = $_SESSION['branch'];

      // Check if the form is submitted
      if (isset($_POST['search'])) {
          // Sanitize and assign values from the form
          $product = $con->real_escape_string($_POST['product']);
          $dateFrom = $con->real_escape_string($_POST['dateFrom']);
          $dateTo = $con->real_escape_string($_POST['dateTo']);
      }

      $sql = "SELECT * FROM tbl_insurance";

      // Append WHERE clause based on form input
      if (!empty($product) || !empty($dateFrom) || !empty($dateTo)) {
          $sql .= " WHERE ";
          $conditions = [];

          if (!empty($product)) {
            $conditions[] = "product = '$product'";
          }
          if (!empty($dateFrom)) {
              $conditions[] = "date_added >= '$dateFrom'";
          }

          if (!empty($dateTo)) {
              $conditions[] = "date_added <= '$dateTo'";
          }

          if (!empty($branchcode)) {
            $conditions[] = "branch_added = '$branchcode'";
          }

          $sql .= " " . implode(" AND ", $conditions);
      } else {
          $sql = "SELECT * FROM tbl_insurance WHERE branch_added = '$branchcode'  AND date_added >= '$startDate'";
      }

      $result = $con->query($sql);
      $con->close();
      ?>
<!-- Filter/Search Input -->
<div class="d-flex justify-content-end mb-3">
    <!-- input type="text" class="form-control mr-2" id="searchInput" placeholder="Search"-->
</div>
<div class="table-responsive">
        <table id="example" class="display expandable-table" style="width:100%">
            <thead class="custom-thead">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Reg Type</th>
                <th>Reg No</th>
                <th>Address</th>
                <th>City</th>
                <th>Product</th>
                <th>Cover Note Number</th>
                <th>Manual Cover Note Number</th>
                <th>Receipt Number</th>
                <th>Model</th>
                <th>Usage Type</th>
                <th>Reg. Owner</th>
                <th>Reg. Number</th>
                <th>Engine Number</th>
                <th>Chassis Number</th>
                <th>Engine Capacity</th>
                <th>Issued By</th>
                <th>Issued Date</th>
            </tr>
            </thead>
            <tbody>
              <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['reg_type'] . "</td>";
                echo "<td>" . $row['reg_no'] . "</td>";
                echo "<td>" . $row['address_01'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                echo "<td>" . $row['product'] . "</td>";
                echo "<td>" . $row['cover_note_number'] . "</td>";
                echo "<td>" . $row['manual_cn_number'] . "</td>";
                echo "<td>" . $row['receipt_number'] . "</td>";
                echo "<td>" . $row['make_model'] . "</td>";
                echo "<td>" . $row['usage_type'] . "</td>";
                echo "<td>" . $row['registered_owner'] . "</td>";
                echo "<td>" . $row['registration_number'] . "</td>";
                echo "<td>" . $row['engine_number'] . "</td>";
                echo "<td>" . $row['chassis_number'] . "</td>";
                echo "<td>" . $row['engine_capacity'] . "</td>";
                echo "<td>" . $row['issued_by'] . "</td>";
                echo "<td>" . $row['date_added'] . "</td>";
                echo "</tr>";

            }
            ?>
            </tbody>
        </table>
    </div>
    <style>
    .custom-thead {
    background-color: #81bd43;
    }
    </style>

    <br><br>
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
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>
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

  <!-- Paggination -->
  <!-- jQuery -->
<script src='https://code.jquery.com/jquery-3.7.0.js'></script>
<!-- Data Table JS -->
<script src='https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js'></script>
<script src='https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js'></script>
      <!-- Script JS -->
      <script src="./js/script.js"></script>
      <!--$%analytics%$-->
</body>
<script>
    // Add your JavaScript code for filtering/searching here
    $(document).ready(function () {
        $("#searchInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<style>
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
.container{
    background-color: white;
    margin-bottom: 20px;
    padding-top: 20px;
    padding-bottom: 20px;
}

</style>
</html>
<?php } ?>