<?php session_start();
header("Cache-Control: public, max-age=86400");
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
 
    // greeting message
  // Get the current hour
  date_default_timezone_set('asia/colombo');
  $current_hour = date('H');
  
  // Define time ranges and corresponding messages
  if ($current_hour >= 0 && $current_hour < 12) {
      $gt_message = "Good Morning";
  } elseif ($current_hour >= 12 && $current_hour < 15) {
      $gt_message = "Good Afternoon";
  } elseif ($current_hour >= 15 && $current_hour < 18) {
      $gt_message = "Good Evening";
  } else {
      $gt_message = "Good Night";
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
   <!-- Include Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <style>
    .banner {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-image: url('images/motor-insurance.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  padding: 80px;
  color: #ffffff; /* Set text color to contrast with the background */
}
    .left-content {
      background-color: #1e1e1e;
      opacity:85%;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 300px;
      transition: all 0.3s ease;
      
    }
    .left-content:hover {
      transform: translateY(-5px);
      box-shadow: 0px 0px 20px rgb(129, 189, 67);
    }

    .left-content h3 {
      margin-bottom: 10px;
      color: #d9d9da;
      font-weight: bold;
      font-size: 24px;
    }

    .left-content p {
      color: #d9d9da;
      font-size: 16px;
    }

    .right-content {
      background-color: #1e1e1e;
      opacity:85%;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      padding-bottom:0px;
      max-width: 200px;
      text-align: center;
      transition: all 0.3s ease;
    }
    .right-content:hover {
      transform: translateY(-5px);
      box-shadow: 0px 0px 20px rgb(129, 189, 67);
    }
    .date {
      font-size: 16px;
      color: #d9d9db;
    }

    .date .month {
      font-size: 24px;
      font-weight: bold;
      color: #d9d9db;
      border-bottom: 2px solid #ffffff;
      padding-bottom: 5px;
    }

    .date .time {
      font-size: 16px;
      font-weight: bold;
      color: #d9d9db;
    }
@media (max-width: 768px) {
  .banner {
    flex-direction: column;
    text-align: center;
  }
  .left-content{
    background-color:#0000;
    border-radius: 0px;
    box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.1);
    perspective: 1000px; /* Add perspective for the 3D effect */
  }
  .left-content h3 {
      margin-bottom: 10px;
      color: white;
      font-weight: bold;
      font-size: 24px;
    }

    .left-content p {
      color: white;
      font-size: 16px;
    }
}
  .container1 {
      display: flex;
      justify-content: space-around;
      margin-bottom: 30px;
    }
    .content-wrapper {
    background: #24282d;
    }
    .tile {
      width: 480px;
      height: 120px;
      background-color: #1e1e1e;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      margin: 10px; /* Added margin to create gap between tiles */
    }

    .tile:hover {
      transform: translateY(-5px);
      box-shadow: 0px 0px 20px rgb(129, 189, 67);
    }

    .tile .count {
      font-size: 36px;
      font-weight: bold;
      color: #8d9189;
    }

    .tile .label {
      font-size: 16px;
      color: #cfd1d2;
      text-transform: uppercase;
    }
    @media (max-width: 768px) {
      .container1 {
        display: block;
        text-align: center;
      }

      .tile {
        width: 100%;
        margin: 10px auto;
      }
    }
    .branch-section {
      margin-top: 20px;
      border-top: 1px solid #e0e0e0;
      padding-top: 10px;
    }

    .branch-section h5 {
      margin-bottom: 5px;
      color: #d8d8da;
      font-size: 16px;
    }

    .branch-section span {
      font-weight: bold;
      color: #d8d8da;
      font-size: 14px;
    }
    /* Card View Product Premium */
    table {
    width: 100%;
    border-collapse: collapse;
    background-color: #1E1E1E;
    border-bottom: 1px solid #ddd;
    border-radius: 10px;
    color: #cfd1d2;
  }

  th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #486a25;
  }

  th {
    background-color: #1E1E1E;
  }
  tr:hover {
    background-color: #81bd43;
  }

  .price {
    color: #81bd43;
    font-weight: bold;
    text-align: right;
    white-space: nowrap; /* Prevent line breaks */
    padding-right:25px;
  }
  .table-responsive {
    border-bottom: 3px solid #81bd43;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }
  .table-responsive:hover {
      transform: translateY(-5px);
      box-shadow:0px 0px 20px rgb(129, 189, 67);
  }
  .chart-pr {
    background-color: #1E1E1E;
    border-bottom: 3px solid #81bd43;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    padding:50px;
  }
  .chart-pr:hover {
      transform: translateY(-5px);
      box-shadow: 0px 0px 20px rgb(129, 189, 67);
  }
.row{
  padding-top:30px;
}
.dash-right{
  margin-top: -35px;
  color: #cfd1d2;
  text-align: center;
  padding-bottom: 10px;
}
.card {
  background-color:none !important; 
}
.card.tale-bg {
    background: none;
    background-color: none;
}
 
  </style>
</head>
<body>
  <div class="container-scroller" id="dashboard" >
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
        <!-- Banner Section -->
        <div class="banner">
            <div class="left-content">
            <h3 class="font-weight-bold" style="font-size:20px;"><?php echo $gt_message .', '. $result['first_name'];?><br>
              <p  style="font-size:16px; padding-top: 10px"> How are you today ?</p>
             </h3> 
              <div class="branch-section">
                <h5><i class="fas fa-building icon" ></i> Branch: <span><?php echo implode(', ', array_column($rowBranch, 'b_name')); ?></span></h5>
              </div> 
              <div>
                <!-- Branch Login -->
                <form class="form-inline" method="POST" action="#">
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
                <select class="btn btn-sm btn-dark bg-dark" id="select1" name="brcode">
                    <option value="<?php echo $bb; ?>">Change Branch</option>
                    <?php foreach ($branches as $branch): ?>
                        <option value="<?php echo $branch['branch_code']; ?>">
                            <?php echo $branch['branch_name'];//echo $branch['branch_code'] . ' - ' . $branch['branch_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>        
                <button style="padding-left:10px;" name="login" id="login" type="submit" class="btn btn-sm btn-dark bg-dark">Login</button>
                </form> 
                <!-- Branch Login -->
              </div>           
            </div>
            <div class="right-content">
            <?php
                date_default_timezone_set("asia/colombo"); // Set your timezone here
                $current_day = date("l"); // Full day name
                $current_date = date("j"); // Day of the month without leading zeros
                $current_month = date("F"); // Full month name
                $current_year = date("Y"); // 4-digit year
                $current_time = date("h:i A"); // Current time in 12-hour format with AM/PM
            ?>
            <div class='date'>
              <div class='month'><?php echo $current_date ?><br><span style='border-bottom: 2px solid #ffffff;'><?php echo $current_month ?></span></div>
              <div class='time' id='clock'><?php echo $current_time ?></div>
              <i class="fas fa-clock icon"></i>
            </div>"
             
              
            </div>
          </div>
        
        <div class="content-wrapper" >
        <div class="container1">
          <div class="tile" style="border-bottom: 3px solid #81bd43;">
          <?php
            // SQL query to get the row count
            $sql = "SELECT COUNT(*) as id FROM tbl_insurance WHERE branch_added = '$bb'";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                // Fetch the result
                $row = $result->fetch_assoc();
                $rowCountTotal = $row['id'];

                //echo "Total rows in the table: " . $rowCount;
            } else {
                echo "No rows found";
            }

            ?>
            <div class="count" ><?php echo $rowCountTotal; ?></div>
            <div class="label">Total Policies</div>
          </div>
          <div class="tile" style="border-bottom: 3px solid #81bd43;">
          <?php
            $currentDate = date('Y-m-d');
            $sql = "SELECT COUNT(*) as id FROM tbl_insurance WHERE branch_added = '$bb' AND DATE(date_added) = '$currentDate'";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                $rowCountToday = $row['id'];

            } else {
                echo "No rows found";
            }
            ?>
            <div class="count"><?php echo $rowCountToday; ?></div>
            <div class="label">Today's Policies</div>
          </div>
          <div class="tile" style="border-bottom: 3px solid #81bd43;">
          <?php
            // SQL query to get the row count
            $sql = "SELECT COUNT(*) as id FROM tbl_product";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                // Fetch the result
                $row = $result->fetch_assoc();
                $rowCountProduct = $row['id'];

                //echo "Total rows in the table: " . $rowCount;
            } else {
                echo "No rows found";
            }
            ?>
            <div class="count"><?php echo $rowCountProduct; ?></div>
            <div class="label">Total Products</div>
          </div>
          <div class="tile" style="border-bottom: 3px solid #81bd43;">
          <?php
            // Query to select the most frequently occurring product name
            $sql = "SELECT product, COUNT(product) AS count FROM tbl_insurance WHERE branch_added = '$bb' GROUP BY product ORDER BY count DESC LIMIT 1";

            $result = mysqli_query($con, $sql);

            // Check if the query was successful
            if ($result) {
                // Check if any rows were returned
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $featuredProduct = $row['product'];
                } else {
                    echo "No products found";
                    $featuredProduct = "";
                }
            } else {
                echo "Error: " . mysqli_error($con);
            }
          ?>
            <div class="count" style="font-size:20px; color: #81bd43;"><?php echo $featuredProduct; ?></div>
            <div class="label">Featured Product</div>
          </div>
        </div>
          <div class="row">   
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">  
              <div class="table-responsive">
              <?php 
                $sql = "SELECT * FROM tbl_product ";
                                $result = $con->query($sql);
                                $product = array();
                ?>
                  <table>
                    <thead>
                      <tr style="color: white;">
                        <th style="padding-left:25px; color: #cfd1d2;">Product Name</th>
                        <th style="text-align: right; padding-right:25px; color: #cfd1d2;">Premium</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr>";
                          echo "<td style='padding-left:25px;'>";
                          // Check the product name and display the appropriate icon
                          switch ($row['name']) {
                              case 'Motor Car':
                                  echo "<img src='images/products/motor-car.png' class='icon' alt='Car' style='vertical-align: middle; margin-right: 15px;'>" ;
                                  break;
                              case 'Motor Cycle':
                                  echo "<img src='images/products/motor-bike.png' class='icon' alt='Car' style='vertical-align: middle; margin-right: 15px;'>";
                                  break;
                              case 'Hand Tractor':
                                  echo "<img src='images/products/hand-tractor.png' class='icon' alt='Car' style='vertical-align: middle; margin-right: 15px;'>";
                                  break;
                              case 'Tractor':
                                echo "<img src='images/products/tractor.png' class='icon' alt='Car' style='vertical-align: middle; margin-right: 15px;'>";
                                  break;
                              case 'Three Wheeler':
                                echo "<img src='images/products/tuktuk.png' class='icon' alt='Car' style='vertical-align: middle; margin-right: 15px;'>";
                                  break;
                              case 'Dual Purpose':
                                echo "<img src='images/products/dual-purpose.png' class='icon' alt='Car' style='vertical-align: middle; margin-right: 15px;'>";
                                  break;
                              case 'Lorry':
                                echo "<img src='images/products/lorry.png' class='icon' alt='Car' style='vertical-align: middle; margin-right: 15px;'>";
                                  break;
                              // Add more cases for other products if needed
                              default:
                                  echo "<img src='images/products/motor-car.png' class='icon' alt='Car' style='vertical-align: middle; margin-right: 15px;'>"; // Default icon if product name doesn't match any case
                                  break;
                          }
                          echo $row['name'] . "</td>";
                          echo "<td class='price align' >" . $row['value'] . "</td>";
                          echo "</tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                  </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin transparent">
              <div class="chart-pr">
              <div class="dash-right">
              <h5>Policy Overview</h5>
              </div>
              <?php include'pr_piechart.php'?>
              </div>
              </div>
            </div>
          </div>
        </div>
        

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
  <!-- Time Update Banner -->
  <script>
  function updateTime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // Handle midnight
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var timeString = hours + ':' + minutes + ' ' + ampm;
    document.getElementById('clock').textContent = timeString;
  }

  // Update time every second
  setInterval(updateTime, 1000);
  
      
</script>

  <!-- End of Time Update Banner -->
</body>

</html>
<?php } ?>
