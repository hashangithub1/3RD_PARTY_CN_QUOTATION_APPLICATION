<?php
include_once('includes/config.php');
$userID = $_SESSION['id'];
$feature_userR = "user_report";
$feature_branchR = "branch_report";
$feature_allR = "all_branch_report";
$permission = 1;
$user_report = '';
$branch_report = '';
$all_report = '';
$add_staff = '';
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Insurance</span>
              <i class="menu-arrow"></i>
            </a>
            
            <div class="collapse" id="ui-basic">
              
              <ul class="nav flex-column sub-menu">
              <li class="nav-item">
            <a class="nav-link" data-toggle="" href="#error" aria-expanded="false" aria-controls="error">
              
              <span class="menu-title">Third Party</span>
              <i class=""></i>
            </a>
            <div class="" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a style="color:white;" href="../manage_thirdparty.php">Third Party</a></li>
                <li class="nav-item"> <a style="color:white;" href="../print_card.php">Card Print</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
          <a class="nav-link" data-toggle="" href="#error" aria-expanded="false" aria-controls="error">
              <span class="menu-title">Motor Quotation</span>
              <i class=""></i>
            </a>
            <div class="" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a style="color:white;" href="../comprehensive.php">Comprehensive</a></li>
                <?php 

                  $query = "SELECT role FROM tbl_staff WHERE id = '$userID'";
                  $result1 = $con->query($query);

                  if ($result1->num_rows > 0) {
                      $row1 = $result1->fetch_assoc();
                      if ($row1['role'] == 'user') {
                        $user_quotation = '';
                      }
                      elseif($row1['role'] == 'user-1') {
                        $user_quotation = '<li class="nav-item"> <a style="color:white;" href="../motor-quotation.php">Quotation</a></li>';
                      }
                      elseif($row1['role'] == 'admin') {
                        $user_quotation = '<li class="nav-item"> <a style="color:white;" href="../motor-quotation.php">Quotation</a></li>';
                      }
                      elseif($row1['role'] == 'manager') {
                        $user_quotation = '';
                      }
                      else {
                          $user_quotation = '';
                      }
                  } else {
                      $user_quotation = '';
                  }

                  echo $user_quotation ;
                ?>
                
              </ul>
            </div>
          </li>
                
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <i class="icon-bar-graph menu-icon"></i>
              <span class="menu-title">Utilities</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu">
                
                <li class="nav-item"> <?php 

                  $query = "SELECT role FROM tbl_staff WHERE id = '$userID'";
                  $result1 = $con->query($query);

                  if ($result1->num_rows > 0) {
                      $row1 = $result1->fetch_assoc();
                      if ($row1['role'] == 'user') {
                        $user_report = '<a class="nav-link" href="../my_documents.php">My Documents</a>';
                      }
                      elseif($row1['role'] == 'user-1') {
                        $user_report = '<a class="nav-link" href="../my_documents.php">My Documents</a>';
                      }
                      elseif($row1['role'] == 'admin') {
                        $user_report = '<a class="nav-link" href="../my_documents.php">My Documents</a>';
                      }
                      elseif($row1['role'] == 'manager') {
                        $user_report = '<a class="nav-link" href="../my_documents.php">My Documents</a>';
                      }
                      else {
                          $user_report = '';
                      }
                  } else {
                      $user_report = '';
                  }

                  echo $user_report ;
                ?></li>

                  <li class="nav-item"> <?php 

                  $query = "SELECT role FROM tbl_staff WHERE id = '$userID'";
                  $result1 = $con->query($query);

                  if ($result1->num_rows > 0) {
                      $row1 = $result1->fetch_assoc();
                      if ($row1['role'] == 'user') {
                        
                      }
                      elseif($row1['role'] == 'user-1') {
                        $user_report = '<a class="nav-link" href="../my_quotations.php">My Quotations</a>';
                      }
                      elseif($row1['role'] == 'admin') {
                        $user_report = '<a class="nav-link" href="../my_quotations.php">My Quotations</a>';
                      }
                      elseif($row1['role'] == 'manager') {
                        $user_report = '<a class="nav-link" href="../my_quotations.php">My Quotations</a>';
                      }
                      else {
                          $user_report = '';
                      }
                  } else {
                      $user_report = '';
                  }

                  echo $user_report ;
                  ?></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <i class="icon-bar-graph menu-icon"></i>
              <span class="menu-title">Reports</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                
                <li class="nav-item"> <?php 

                  $query = "SELECT role FROM tbl_staff WHERE id = '$userID'";
                  $result1 = $con->query($query);

                  if ($result1->num_rows > 0) {
                      $row1 = $result1->fetch_assoc();
                      if ($row1['role'] == 'user') {
                        $user_report = '<a class="nav-link" href="user_report.php">User Report</a>';
                      }
                      elseif($row1['role'] == 'user-1') {
                        $user_report = '<a class="nav-link" href="user_report.php">User Report</a>';
                      }
                      elseif($row1['role'] == 'admin') {
                        $user_report = '<a class="nav-link" href="user_report.php">User Report</a>';
                      }
                      elseif($row1['role'] == 'manager') {
                        $user_report = '<a class="nav-link" href="user_report.php">User Report</a>';
                      }
                      else {
                          $user_report = '';
                      }
                  } else {
                      $user_report = '';
                  }

                  echo $user_report ;
                ?></li>

                <li class="nav-item"> <?php 

                  $query = "SELECT role FROM tbl_staff WHERE id = '$userID'";
                  $result1 = $con->query($query);

                  if ($result1->num_rows > 0) {
                      $row1 = $result1->fetch_assoc();
                      if ($row1['role'] == 'admin') {
                        $branch_report = '<a class="nav-link" href="branch_report.php">Branch Report</a>';
                      }
                      elseif($row1['role'] == 'manager') {
                        $branch_report = '<a class="nav-link" href="branch_report.php">Branch Report</a>';
                      } 
                      else {
                          $branch_report = '';
                      }
                  } else {
                      $branch_report = '';
                  }

                  echo $branch_report;
                ?></li>

                <li class="nav-item"> <?php
                
                $query = "SELECT * FROM tbl_staff WHERE id = '$userID'";
                  $result1 = $con->query($query);

                  if ($result1->num_rows > 0) {
                      $row1 = $result1->fetch_assoc();
                      if ($row1['role'] == 'admin') {
                        $all_report = '<a class="nav-link" href="all_report.php">All Branch Report</a>';
                      }
                      elseif($row1['role'] == 'manager') {
                        $all_report = '<a class="nav-link" href="all_report.php">All Branch Report</a>';
                      } 
                      elseif($row1['username'] == 'automation') {
                        $all_report = '<a class="nav-link" href="reports/all_report.php">All Branch Report</a>';
                      }
                      else {
                          $all_report = '';
                      }
                  } else {
                      $all_report = '';
                  }

                  echo $all_report;
                ?></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="icon-columns menu-icon"></i>
              <span class="menu-title">Settings</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
            
          <li class="nav-item">
          <a class="nav-link" data-toggle="" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <span class="menu-title">Third Party</span>
              <i class=""></i>
            </a>
            <div class="" id="form-elements">
              <ul class="nav flex-column sub-menu">

                 

              <li class="nav-item">
                  <?php 
                    $query = "SELECT role FROM tbl_staff WHERE id = '$userID'";
                    $result1 = $con->query($query);
  
                    if ($result1->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                        if ($row1['role'] == 'admin') {
                          $add_staff = '<a style="padding-left: 0px;" class="nav-link" href="../products.php">Products</a>';
                        } else {
                            $add_staff = '';
                        }
                    } else {
                        $add_staff = '';
                    }
                    echo $add_staff;
                  ?></li>
                  
              <li class="nav-item">
                  <?php 
                    $query = "SELECT role FROM tbl_staff WHERE id = '$userID'";
                    $result1 = $con->query($query);
  
                    if ($result1->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                        if ($row1['role'] == 'admin') {
                          $add_staff = '<a style="padding-left: 0px;" class="nav-link" href="../branch.php">Branches</a>';
                        } else {
                            $add_staff = '';
                        }
                    } else {
                        $add_staff = '';
                    }
                    echo $add_staff;
                  ?></li>

              <li class="nav-item">
                  <?php 
                    $query = "SELECT role FROM tbl_staff WHERE id = '$userID'";
                    $result1 = $con->query($query);
  
                    if ($result1->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                        if ($row1['role'] == 'admin') {
                          $add_staff = '<a style="padding-left: 0px;" class="nav-link" href="../manage_permission.php">Permission</a>';
                        } else {
                            $add_staff = '';
                        }
                    } else {
                        $add_staff = '';
                    }
                    echo $add_staff;
                  ?></li>
              </ul>
            </div>
          </li>                 
                
          <?php
           $query = "SELECT role FROM tbl_staff WHERE id = '$userID'";
           $result1 = $con->query($query);
           if ($result1->num_rows > 0) {
            $row1 = $result1->fetch_assoc();
            if ($row1['role'] == 'user') {
             
            }
            elseif($row1['role'] == 'user-1') {
             echo ' <li class="nav-item">
              <a class="nav-link" data-toggle="" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                  <span class="menu-title">Motor Quotation</span>
                  <i class=""></i>
                </a>
                <div class="" id="form-elements">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a style="color:white;" href="../companies-motor.php">Companies</a></li>
                    <li class="nav-item"> <a style="color:white;" href="../products-motor.php">Products</a></li>
                    <li class="nav-item"> <a style="color:white;" href="../product-cover-motor.php">Product Cover</a></li>
                  </ul>
                </div>
              </li>';
            }
            elseif($row1['role'] == 'admin') {
             echo ' <li class="nav-item">
              <a class="nav-link" data-toggle="" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                  <span class="menu-title">Motor Quotation</span>
                  <i class=""></i>
                </a>
                <div class="" id="form-elements">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a style="color:white;" href="../companies-motor.php">Companies</a></li>
                    <li class="nav-item"> <a style="color:white;" href="../products-motor.php">Products</a></li>
                    <li class="nav-item"> <a style="color:white;" href="../product-cover-motor.php">Product Cover</a></li>
                  </ul>
                </div>
              </li>';
            }
            elseif($row1['role'] == 'manager') {
              
            }
            else {

            }
        } else {

        }

          ?>


          <li class="nav-item">
                  <?php 
                    $query = "SELECT role FROM tbl_staff WHERE id = '$userID'";
                    $result1 = $con->query($query);
  
                    if ($result1->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                        if ($row1['role'] == 'admin') {
                          $add_staff = '<a class="nav-link" href="../manage_staff.php">Staff</a>';
                        }elseif ($row1['role'] == 'admin-user'){
                          $add_staff = '<a class="nav-link" href="../manage_staff.php">Staff</a>';
                        } 
                        else {
                            $add_staff = '';
                        }
                    } else {
                        $add_staff = '';
                    }
                    echo $add_staff;
                  ?></li>

          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>

      