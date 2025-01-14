<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{}
  $test = "";
// Code for login 
if (isset($_POST['login'])) {
  $br_code = isset($_POST['brcode']) ? $_POST['brcode'] : '';
  $_SESSION['branch'] = $br_code;
  $bb = $_SESSION['branch'];
  header("location: dashboard.php?test=$test");

}
?>



<!DOCTYPE html>
<html lang="en">
<?php echo $test; ?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/fav-icon.jpg" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include_once('includes/navbar.php');?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->

      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php');?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
            <?php 
              $userid = $_SESSION['id'];
              $bb = $_SESSION['branch'];
              $query = mysqli_query($con, "select * from tbl_staff where id='$userid'");
              
              // Assuming you have only one result for the user
              $result = mysqli_fetch_array($query);

              // Initialize $rowBranch outside the loop
              $rowBranch = array();

              if (isset($result['branch'])) {
                  $branchCodes = explode(",", $result['branch']);
                  
                  foreach ($branchCodes as $branchCode) {
                      $queryBranch = "SELECT b_name FROM tbl_branch WHERE b_code = '$bb'";
                      $resultBranch = mysqli_query($con, $queryBranch);

                      if ($resultBranch) {
                          $rowBranch[] = mysqli_fetch_assoc($resultBranch);
                      }
                  }
              }{
              ?>  
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome <?php echo $result['first_name'];?></h3>
                  <button class="btn btn-sm btn-light bg-white" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Branch : <?php echo implode(', ', array_column($rowBranch, 'b_name')); ?>
                    </button>
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <!--button class="btn btn-sm btn-light bg-white" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Branch : <?php  //echo implode(', ', array_column($rowBranch, 'b_name')); ?>
                    </button-->

                    <!-- Branch Login -->
                    <form class="form-inline" method="POST" action="#">
                          <!-- Column 1 - Selection -->
                          <?php 
                              $username = $result['username'];
                              $sql = "SELECT DISTINCT branch_code, branch_name FROM tbl_access WHERE username = '$username'";
                              $result = $con->query($sql);

                              $branches = [];
                              if ($result->num_rows > 0) {
                                  while ($row = $result->fetch_assoc()) {
                                      $branches[] = $row;
                                  }
                              }
                          ?>
                          <div class="form-group mx-2">
                              <label for="select1">&ensp;</label>
                              <select class="btn btn-sm btn-light bg-white" id="select1" name="brcode">
                                  <option value="<?php echo $bb; ?>">Change Branch</option>
                                  <?php foreach ($branches as $branch): ?>
                                      <option value="<?php echo $branch['branch_code']; ?>">
                                          <?php echo $branch['branch_name'];//echo $branch['branch_code'] . ' - ' . $branch['branch_name']; ?>
                                      </option>
                                  <?php endforeach; ?>
                              </select>
                          </div>                          <!-- Submit Button -->
                          <button name="login" id="login" type="submit" class="btn btn-sm btn-light bg-white">Login</button>
                          <!-- a href="./clients" class="btn btn-info">Reload</a-->
                      </form> 
                    <!-- Branch Login -->

                  </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">   
          <?php 
                $sql = "SELECT * FROM tbl_product ";
                                $result = $con->query($sql);
                                $product = array();
                ?>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                
              <div class="table-responsive">
              <table class="table table-striped table-borderless">
    <thead>
        <tr>
            <th class="text-left">Product</th>
            <th class="text-right">Premium</th>
        </tr>  
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td class='text-right'>" . $row['value'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

                  </div>
              </div>
            </div>



            <style>
              .ttt{
                text-align: right;
              }
            </style>

            <?php

            $currentDate = date('Y-m-d');

            $sql = "SELECT COUNT(*) as id FROM tbl_insurance WHERE branch_added = '$bb' AND DATE(date_added) = '$currentDate'";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                $rowCount = $row['id'];

            } else {
                echo "No rows found";
            }

            ?>


            <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Today’s Transactions</p>
                      <p class="fs-30 mb-2"><?php echo $rowCount; ?></p>
                      
                    </div>
                  </div>
                </div>

                <?php
            // SQL query to get the row count
            $sql = "SELECT COUNT(*) as id FROM tbl_insurance WHERE branch_added = '$bb'";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                // Fetch the result
                $row = $result->fetch_assoc();
                $rowCount = $row['id'];

                //echo "Total rows in the table: " . $rowCount;
            } else {
                echo "No rows found";
            }

            ?>

                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Transactions</p>
                      <p class="fs-30 mb-2"><?php echo $rowCount; ?></p>
                    </div>
                  </div>
                </div>
              </div>

              <?php
            // SQL query to get the row count
            $sql = "SELECT COUNT(*) as id FROM tbl_product";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                // Fetch the result
                $row = $result->fetch_assoc();
                $rowCount = $row['id'];

                //echo "Total rows in the table: " . $rowCount;
            } else {
                echo "No rows found";
            }

            ?>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Products</p>
                      <p class="fs-30 mb-2"><?php echo $rowCount; ?></p>
                      
                    </div>
                  </div>
                </div>

                <?php
            // SQL query to get the row count
            $sql = "SELECT COUNT(*) as id FROM tbl_staff WHERE branch = '$bb'";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                // Fetch the result
                $row = $result->fetch_assoc();
                $rowCount = $row['id'];

                //echo "Total rows in the table: " . $rowCount;
            } else {
                echo "No rows found";
            }

            ?>
                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">Total Users</p>
                      <p class="fs-30 mb-2"><?php echo $rowCount; ?></p>
    
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            
            <div class="col-md-6 grid-margin stretch-card">
           
            </div>
            <div class="col-md-6 grid-margin stretch-card">

            </div>
          </div>
          
        </div>
        <?php include'pr_piechart.php'?>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!--footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer-->
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
<?php } ?>
