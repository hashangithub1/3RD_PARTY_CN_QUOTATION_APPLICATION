<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
$branchcode = !empty($_SESSION['branch']) ? $_SESSION['branch'] : null;
$userid = !empty($_SESSION['id']) ? $_SESSION['id'] : null;
$userrole = !empty($_SESSION['u_role']) ? $_SESSION['u_role'] : null;
$userName = !empty($_SESSION['u_name']) ? $_SESSION['u_name'] : null;
$formhandle = NULL;

$rowID = isset($_GET['id']) ? intval($_GET['id']) : 0;
$quoteNo = isset($_GET['quote_no']) ? $_GET['quote_no'] : null;

if (!empty($rowID)){
$formhandle = 1;
}else {
$formhandle = 0;
}
// Tab index handle
 if($formhandle == 0){
  $T1_status = "Quotations";
 }else{
  $T1_status = "Revisions";
 }
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
  <!-- DataTables CSS and JS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


  <style>
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
      margin-top: 25px;
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
        background-color: #5d6771;
        color: #fff;
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
        background-color: #81bd43;
        color: #fff;
      }
      h3 {
        font-size: 15px;
      }
    }
    /* Datagrid */
    .coverForm {
  width: 100%;
}

.table-responsive {
  width: 100%;
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
}

input[type="text"], input[type="email"], input[type="date"], input[type="checkbox"], select {
  width: 100%;
  padding: 5px;
  font-size: 13px;
  border: 1px solid #ccc;
  box-sizing: border-box;
  background: white;
  color: #5d6771;
}

tr{
  border-color: #81bd41;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.dt-orderable-asc th {
  background-color: #81bd43;
  font-size: 13px;
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
    .prodselect {
      width: 410px;
      margin-bottom: 10px;
    }

    /* Style for Alert Box */
    .alert {
    position: fixed;
    bottom: -100%;
    right: -100%; 
    transition: bottom 0.5s ease-in-out, right 0.5s ease-in-out; 
    }
    .alert.show {
        bottom: 10px; 
        right: 10px; 
    }
    /* Form Background Effect*/ 

    .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
      padding-left: calc(var(--bs-gutter-x) * .0);
    }
</style>

</head>

<body>
  <div class="container-scroller">
    <!-- partial:../partials/_navbar.html -->
    <?php include_once('includes/navbar.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper" style="background-color: #24282d !important;">
      <!-- partial:../partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php'); ?>
      <!-- partial -->

      <!-- Code here -->
      <div class="container mt-4" style="max-width:1100px">
        <div class="tabform-container">
          <ul class="tabs">
            <li class="active" rel="tab1"><?php echo $T1_status ?></li>
          </ul>
          
          <div class="tab_container">
            <h3 class="d_active tab_drawer_heading" rel="tab1"><?php echo $T1_status ?></h3>
            <!-- <h3 class="tab_drawer_heading" rel="tab2">Revisions</h3> -->
            <div id="tab1" class="tab_content">
              <?php
              
                if($userName === "admin" || $userName === "sithija" || $userName === "BUDDHIKA.JAYAWEERA" || $userName === "MOHAMED.FAHIM" || $userName === "RIDMI.WIJAYABANDARA" || $userName === "VISHWA.VIJAN" || $userName === "CHANAKA.KULIYAPITIYA" || $userName === "ADEESHA.SAHAN"){
    
                  if (!empty($rowID)) {

                    $sql = "SELECT 
                    r.id, 
                    r.old_quote_no,
                    r.new_quote_no,  
                    r.prod_code, 
                    p.product_des,
                    r.sum_ins, 
                    r.tot_premium,
                    r.dateadded,
                    r.user_ID
                FROM 
                    rev_quotation_mt r
                JOIN 
                    tbl_product_mt p ON r.prod_code = p.product_code
                WHERE 
                    p.product_stat = 1
                AND r.old_quote_no = '$quoteNo'
                 AND
                 r.dateadded > '2024-12-26'";
                
        $result = $con->query($sql);
    
        echo '<div class="table-responsive">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th style="background-color: #81bd43;">ID</th>
                    <th style="background-color: #81bd43;">Quotation NO</th>
                    <th style="background-color: #81bd43;">Product</th>
                    <th style="background-color: #81bd43;">Sum Insured</th>
                    <th style="background-color: #81bd43;">Total Premium</th>
                    <th style="background-color: #81bd43;">Date Added</th>
                    <th style="background-color: #81bd43;">Edit By</th>
                    <th style="background-color: #81bd43;">Action</th>
                </tr>
            </thead>
            <tbody id="coverTable">';
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['new_quote_no'] . "</td>";
            echo "<td>" . $row['product_des'] . "</td>";
            echo "<td>" . $row['sum_ins'] =  number_format($row['sum_ins'], 2). "</td>";
            echo "<td>" . $row['tot_premium'] =  number_format($row['tot_premium'], 2). "</td>";
            echo "<td>" . date("Y-m-d", strtotime($row['dateadded'])) . "</td>";
            echo "<td>" . $row['user_ID'] . "</td>";
            echo "<td>";
            echo "<button class='viewBtn' data-id='" . $row['id'] . "'><i class='fas fa-eye'></i></button>";
            echo "</td>";
            echo "</tr>";
        }
        
        echo '</tbody>
        </table>
        </div>';
                }
                  else{
                      $sql = "SELECT 
                                  q.id, 
                                  q.quote_no, 
                                  q.prod_code, 
                                  p.product_des,
                                  q.sum_ins, 
                                  q.tot_premium,
                                  q.edit_status,
                                  q.dateadded,
                                  q.user_ID
                              FROM 
                                  quotation_mt q
                              JOIN 
                                  tbl_product_mt p ON q.prod_code = p.product_code
                              WHERE 
                                  p.product_stat = 1
                               AND
                               q.dateadded > '2024-12-26'";
                              
                      $result = $con->query($sql);
                  
                      echo '<div class="table-responsive">
                      <table id="example" class="table table-striped" style="width:100%">
                          <thead>
                              <tr>
                                  <th style="background-color: #81bd43;">ID</th>
                                  <th style="background-color: #81bd43;">Quotation NO</th>
                                  <th style="background-color: #81bd43;">Product</th>
                                  <th style="background-color: #81bd43;">Sum Insured</th>
                                  <th style="background-color: #81bd43;">Total Premium</th>
                                  <th style="background-color: #81bd43;">Date Added</th>
                                  <th style="background-color: #81bd43;">Issued By</th>
                                  <th style="background-color: #81bd43;">Action</th>
                              </tr>
                          </thead>
                          <tbody id="coverTable">';
                      
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr>";
                          echo "<td>" . $row['id'] . "</td>";
                          echo "<td>" . $row['quote_no'] . "</td>";
                          echo "<td>" . $row['product_des'] . "</td>";
                          echo "<td>" . $row['sum_ins'] =  number_format($row['sum_ins'], 2). "</td>";
                          echo "<td>" . $row['tot_premium'] =  number_format($row['tot_premium'], 2). "</td>";
                           "<td>" . $row['edit_status'] . "</td>";
                          echo "<td>" . date("Y-m-d", strtotime($row['dateadded'])) . "</td>";
                          echo "<td>" . $row['user_ID'] . "</td>";
                          echo "<td>";
                          echo "<button class='viewBtn' data-id='" . $row['id'] . "' data-edit_status='" . $row['edit_status'] . "'><i class='fas fa-eye'></i></button>";
                          echo " <button class='historyBtn' data-id='" . $row['id'] . "' data-quote_no='" . $row['quote_no'] . "'><i class='fas fa-history'></i></button>";
                          echo "</td>";
                          echo "</tr>";
                      }
                      
                      echo '</tbody>
                      </table>
                      </div>';
                }

                }
                else
                {
                if (!empty($rowID)) {

                $sql = "SELECT 
                              r.id, 
                              r.old_quote_no,
                              r.new_quote_no, 
                              r.prod_code, 
                              p.product_des,
                              r.sum_ins, 
                              r.tot_premium,
                              r.dateadded,
                              r.user_ID
                          FROM 
                              rev_quotation_mt r
                          JOIN 
                              tbl_product_mt p ON r.prod_code = p.product_code
                          WHERE 
                              p.product_stat = 1
                          AND r.old_quote_no = '$quoteNo'
                          -- AND 
                          --     r.user_ID = '$userName'
                              AND
                                  r.dateadded > '2024-12-26'";
                  $result1 = $con->query($sql);

                echo '<div class="table-responsive">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th style="background-color: #81bd43;">ID</th>
                            <th style="background-color: #81bd43;">Quotation NO</th>
                            <th style="background-color: #81bd43;">Product</th>
                            <th style="background-color: #81bd43;">Sum Insured</th>
                            <th style="background-color: #81bd43;">Total Premium</th>
                            <th style="background-color: #81bd43;">Date Added</th>
                            <th style="background-color: #81bd43;">Edit By</th>
                            <th style="background-color: #81bd43;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="coverTable">';
                
                while ($row = mysqli_fetch_assoc($result1)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['new_quote_no'] . "</td>";
                    echo "<td>" . $row['product_des'] . "</td>";
                    echo "<td>" . $row['sum_ins'] =  number_format($row['sum_ins'], 2). "</td>";
                    echo "<td>" . $row['tot_premium'] =  number_format($row['tot_premium'], 2). "</td>";
                    echo "<td>" . date("Y-m-d", strtotime($row['dateadded'])) . "</td>";
                    echo "<td>" . $row['user_ID'] . "</td>";
                    echo "<td>";
                    echo "<button class='viewBtn' data-id='" . $row['id'] . "'><i class='fas fa-eye'></i></button>";
                    echo "</td>";
                    echo "</tr>";
                }
                
                echo '</tbody>
                </table>
                </div>';
            }
              else{
                  $sql = "SELECT 
                              q.id, 
                              q.quote_no, 
                              q.prod_code, 
                              p.product_des,
                              q.sum_ins, 
                              q.tot_premium,
                              q.edit_status,
                              q.dateadded,
                              q.user_ID
                          FROM 
                              quotation_mt q
                          JOIN 
                              tbl_product_mt p ON q.prod_code = p.product_code
                          WHERE 
                              p.product_stat = 1
                          AND 
                              q.user_ID = '$userName'
                               AND
                               q.dateadded > '2024-12-26'";
                  $result = $con->query($sql);
              
                  echo '<div class="table-responsive">
                  <table id="example" class="table table-striped" style="width:100%">
                      <thead>
                          <tr>
                              <th style="background-color: #81bd43;">ID</th>
                              <th style="background-color: #81bd43;">Quotation NO</th>
                              <th style="background-color: #81bd43;">Product</th>
                              <th style="background-color: #81bd43;">Sum Insured</th>
                              <th style="background-color: #81bd43;">Total Premium</th>
                              <th style="background-color: #81bd43;">Date Added</th>
                              <th style="background-color: #81bd43;">Issued By</th>
                              <th style="background-color: #81bd43;">Action</th>
                          </tr>
                      </thead>
                      <tbody id="coverTable">';
                  
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td>" . $row['id'] . "</td>";
                      echo "<td>" . $row['quote_no'] . "</td>";
                      echo "<td>" . $row['product_des'] . "</td>";
                      echo "<td>" . $row['sum_ins'] =  number_format($row['sum_ins'], 2). "</td>";
                      echo "<td>" . $row['tot_premium'] =  number_format($row['tot_premium'], 2). "</td>";
                       "<td>" . $row['edit_status'] . "</td>";
                      echo "<td>" . date("Y-m-d", strtotime($row['dateadded'])) . "</td>";
                      echo "<td>" . $row['user_ID'] . "</td>";
                      echo "<td>";
                      echo "<button class='viewBtn' data-id='" . $row['id'] . "' data-edit_status='" . $row['edit_status'] . "'><i class='fas fa-eye'></i></button>";
                      echo " <button class='historyBtn' data-id='" . $row['id'] . "' data-quote_no='" . $row['quote_no'] . "'><i class='fas fa-history'></i></button>";
                      echo "</td>";
                      echo "</tr>";
                  }
                  
                  echo '</tbody>
                  </table>
                  </div>';
            }
                }
             
              ?>
              <!-- Product Cover Form -->
               
              
              <!-- End Product Cover Form -->
            </div>
            <!-- #tab1 -->
            <!-- #tab2 -->
            <div id="tab2" class="tab_content">
              <!-- #end tab2 -->
              <!-- Product Cover Form -->
              
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

  <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- Optional: Include DataTables Bootstrap Integration -->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>


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
	
    // View button click event handling
    $('.viewBtn').click(function () {
            var id = $(this).data('id');
            var editStatus = $(this).data('edit_status');
            window.location.href = 'mtq_view.php?id=' + id + '&es=' + editStatus;
          });

    // View button click event handling
    $('.historyBtn').click(function () {
            var id = $(this).data('id');
            var quoteNo = $(this).data('quote_no');
            window.location.href = 'my_quotations.php?id=' + id + '&quote_no=' + quoteNo;
          });

          new DataTable('#example');
  </script>
 
</body>

</html>
<?php } ?>