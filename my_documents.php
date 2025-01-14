<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
?>

<?php
if (isset($_POST['upload'])) {
    $insuranceId = $_POST['insurance_id'];

    // Check if both upload fields are empty
    if (empty($_FILES['document1']['name']) && empty($_FILES['document2']['name'])) {
        echo "<script>alert('Please attach at least one file.');</script>";
        echo "<script type='text/javascript'> document.location = 'my_documents.php'; </script>";
        // You may want to redirect or take any other action here
        exit();
    }

    $sql = "SELECT * FROM tbl_insurance WHERE id = '$insuranceId' ";
    $result = $con->query($sql);
    $product = array();
    while ($row = $result->fetch_assoc()) {
        $vehicleNO = $row['registration_number'];
    }

    $drNAME = $insuranceId . '-' . $vehicleNO;

    // Creating sub folder "CR" 
    $uploadDirectoryCR = 'assets/' . 'documents/' . $drNAME . '/' . 'CR/';
    if (!is_dir($uploadDirectoryCR)) {
        // Folder does not exist, create it
        if (!mkdir($uploadDirectoryCR, 0755, true)) {
            // Error creating folder
            echo "Error creating folder: " . error_get_last()['message'];
        }
    }

    // Creating sub folder "unknown" 
    $uploadDirectoryNN = 'assets/' . 'documents/' . $drNAME . '/' . 'proposal-form/';
    if (!is_dir($uploadDirectoryNN)) {
        // Folder does not exist, create it
        if (!mkdir($uploadDirectoryNN, 0755, true)) {
            // Error creating folder
            echo "Error creating folder: " . error_get_last()['message'];
        }
    }

    // File 1
    $document1Name = $_FILES['document1']['name'];
    $document1TmpName = $_FILES['document1']['tmp_name'];
    $document1Type = $_FILES['document1']['type'];
    $document1Size = $_FILES['document1']['size'];

    if (!empty($document1Name)) {  // Check if file1 is not empty
        if (move_uploaded_file($document1TmpName, $uploadDirectoryCR . $document1Name)) {
            // File 1 moved successfully

            // Insert data into the database for file 1
            $sqlInsertDocument1 = "INSERT INTO my_documents (insuranceID, doc_type, file_path)
            VALUES ('$insuranceId', 'CR', '$uploadDirectoryCR')";

            if ($con->query($sqlInsertDocument1)) {
                // Insertion for file 1 was successful
            } else {
                // Error inserting data for file 1
                echo "<script>alert('Error uploading file 1.');</script>";
                echo "<script type='text/javascript'> document.location = 'my_documents.php'; </script>";
            }

        } else {
            // Error moving file 1
            echo "<script type='text/javascript'> document.location = 'my_documents.php'; </script>";
            exit();
        }
    }

    // Check if file1 is empty before processing file2
    if (empty($document1Name)) {
            // File 2
    $document2Name = $_FILES['document2']['name'];
    $document2TmpName = $_FILES['document2']['tmp_name'];
    $document2Type = $_FILES['document2']['type'];
    $document2Size = $_FILES['document2']['size'];

    if (move_uploaded_file($document2TmpName, $uploadDirectoryNN . $document2Name)) {
      // File 2 moved successfully

      // Insert data into the database only if file 2 is not empty
      $sqlInsertDocument2 = "INSERT INTO my_documents (insuranceID, doc_type, file_path)
      VALUES ('$insuranceId', 'proposal-form', '$uploadDirectoryNN')";

      if ($con->query($sqlInsertDocument2)) {
          // Insertion for file 2 was successful
      } else {
          // Error inserting data for file 2
          echo "<script>alert('Error upload the file.');</script>";
          echo "<script type='text/javascript'> document.location = 'my_documents.php'; </script>";
      }
  } else {
      // Error moving file 2
      //echo "Error moving file 2: " . error_get_last()['message'];
      echo "<script type='text/javascript'> document.location = 'my_documents.php'; </script>";
      exit();
  }
      echo "<script type='text/javascript'> document.location = 'my_documents.php'; </script>";
        exit();
    }

    // File 2
    $document2Name = $_FILES['document2']['name'];
    $document2TmpName = $_FILES['document2']['tmp_name'];
    $document2Type = $_FILES['document2']['type'];
    $document2Size = $_FILES['document2']['size'];

    if (move_uploaded_file($document2TmpName, $uploadDirectoryNN . $document2Name)) {
      // File 2 moved successfully

      // Insert data into the database only if file 2 is not empty
      $sqlInsertDocument2 = "INSERT INTO my_documents (insuranceID, doc_type, file_path)
      VALUES ('$insuranceId', 'proposal-form', '$uploadDirectoryNN')";

      if ($con->query($sqlInsertDocument2)) {
          // Insertion for file 2 was successful
      } else {
          // Error inserting data for file 2
          echo "<script>alert('Error upload the file.');</script>";
          echo "<script type='text/javascript'> document.location = 'my_documents.php'; </script>";
      }
  } else {
      // Error moving file 2
      //echo "Error moving file 2: " . error_get_last()['message'];
      echo "<script type='text/javascript'> document.location = 'my_documents.php'; </script>";
      exit();
  }
}
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
  <title>Amana | My Documents</title>
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
  <!-- Previusly Upload Documents:css -->
  <link rel="stylesheet" href="vendors/css/prev_uploads.css">
    <!-- Upload Documents:css -->
    <link rel="stylesheet" href="vendors/css/uploads.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/fav-icon.jpg" />

</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include_once('includes/navbar.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php'); ?>
      <!-- partial -->

      <!-- Code here -->
      <div class="container mt-4">



      <!-- Code here -->
<!-- Data Table -->
<legend><br>
                <h3>My Documents - (Third Party)</h3>
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

      $userid = $_SESSION['id'];
      $userid = mysqli_real_escape_string($con, $userid);

      // Perform the query
      $query = mysqli_query($con, "SELECT username FROM tbl_staff WHERE id='$userid'");
      
      // Check if the query was successful
      if ($query) {
          // Fetch the result as an associative array
          $result = mysqli_fetch_assoc($query);
      
          // Check if a row was returned
          if ($result) {
              // Extract the username
              $username = $result['username'];
          } 
          // Free the result set
          mysqli_free_result($query);
      } else {
      }

      if ($userid === "19")
      {$username = NULL;

      }

      // Check if the form is submitted
      if (isset($_POST['search'])) {
          // Sanitize and assign values from the form
          $product = $con->real_escape_string($_POST['product']);
          $dateFrom = $con->real_escape_string($_POST['dateFrom']);
          $dateTo = $con->real_escape_string($_POST['dateTo']);
      }

      $sql = "SELECT * FROM tbl_insurance";

      // Append WHERE clause based on form input
      if (!empty($product) || !empty($dateFrom) || !empty($dateTo) || !empty($username) || !empty($branchcode)) {
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

        if (!empty($username)) {
          $conditions[] = "issued_by = '$username'";
        }

        if (!empty($branchcode)) {
          $conditions[] = "branch_added = '$branchcode'";
        }

        $sql .= " " . implode(" AND ", $conditions);
    } else {
        $sql = "SELECT * FROM tbl_insurance WHERE branch_added = '$branchcode'  AND issued_by = '$username' AND date_added >= '$startDate'";
    }

      $result = $con->query($sql);
      $con->close();
      ?>
<!-- Filter/Search Input -->
<div class="d-flex justify-content-end mb-3">
    <!-- input type="text" class="form-control mr-2" id="searchInput" placeholder="Search" -->
</div>

<div class="table-responsive">
        <table id="example" class="display expandable-table" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Cover Note Number</th>
                <th>Manual Cover Note Number</th>
                <th>Receipt Number</th>
                <th>Vehicle Number</th>
                <th>Issued Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
              <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['cover_note_number'] . "</td>";
                echo "<td>" . $row['manual_cn_number'] . "</td>";
                echo "<td>" . $row['receipt_number'] . "</td>";
                echo "<td>" . $row['registration_number'] . "</td>";
                echo "<td>" . $row['date_added'] . "</td>";
                echo "<td>";
                echo "<button class='viewBtn' data-row-id='" . $row['id'] . "'>View</button>";
                echo "<button class='uploadsBtn' data-row-id='" . $row['id'] . "'>Uploads</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table><br>
        <div class="uploadsSection" style="display: none;">
        <!--./file input example -->
        <p>&nbsp;</p>
        <hr>
        <h3 class="text-info">Upload Your Documents Here.</h3>
        <p style="color: aliceblue;"><strong>Note:</strong> Please upload documents only in 'pdf', 'docx', 'jpg', 'jpeg', 'png' format. </p>
        <!--image file upoad sample-->
        <form action="" method="POST" enctype="multipart/form-data">
        <div class="box">
          <!-- ./fileuploader view component -->
          <div class="row">

            <div class="col-sm-10">
            <h5>Registration certificate of the vehicle (CR)</h5>
              <span class="control-fileupload">
                <label for="file1" class="text-left">Please choose a file on your computer.</label>
                <input type="file" id="document1" name="document1">
                <input type="hidden" name="insurance_id" id="insurance_id" value="">
              </span>
            </div><br>

            <div class="col-sm-10">
              <h5>Proposal form</h5>
              <span class="control-fileupload">
                <label for="file1" class="text-left">Please choose a file on your computer.</label>
                <input type="file" id="document2" name="document2">
              </span>
            </div>

            <div class="col-sm-2">  
              <button type="" name="upload" class="btn btn-primary btn-block">
                <i class="icon-upload icon-white"></i> Upload
              </button>
            </div>
          </div>
        </div>
        </form>

        </div> 
     </div>

    <br><br>
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
  <script src="js/file-upload.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>
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

<script>
    $(document).ready(function () {
        // Initialize DataTable
        var table = $('#example').DataTable();

        // Add click event for "View" buttons
        $('#example').on('click', '.viewBtn', function () {
            var rowId = $(this).data('row-id');
            // Add your view logic here using the rowId
            //alert('View button clicked for row ID ' + rowId);
            storeRawIDInSession(rowId);
            
        });

        // Add click event for "Uploads" buttons
        $('#example').on('click', '.uploadsBtn', function () {
            var rowId = $(this).data('row-id');
            // Show the uploads section for the specific row
            $('.uploadsSection').show();
            // Send the rowId to the server to store in a session variable
        });
    });

    function storeRawIDInSession(rowId) {
        $.ajax({
            url: 'store_raw_id.php', // Update the URL to your server-side script
            method: 'POST',
            data: { rowId: rowId },
            success: function (response) {
                // Handle the server response if needed
                console.log(response);
                window.location.href = 'view.php';
            },
            error: function (xhr, status, error) {
                // Handle errors if any
                console.error(xhr.responseText);
            }
        });
    }
</script>

<script>
    $('#example').on('click', '.uploadsBtn', function () {
    var rowId = $(this).data('row-id');
    $('.uploadsSection').show();

    // Set the insurance ID for the file upload form
    $('input[name="insurance_id"]').val(rowId);

    //alert('Uploads button clicked for row ID ' + rowId);
});

</script>

<script>
    $(function() {
  $('input[type=file]').change(function(){
    var t = $(this).val();
    var labelText = 'File : ' + t.substr(12, t.length);
    $(this).prev('label').text(labelText);
  })
});
</script>

<style>
    /* Form Background Effect*/ 
.container {
background-color: #1e1e1e;
margin-bottom: 30px;
padding-bottom: 30px;
border-radius:10px;
}
.container-fluid {
    background-color: #24282d;
}

H3{
    color: yellowgreen;
}
.form-group {
    color: white;
}
.row {
    color:white;
}
table {
  & tbody {
    background: #353535;
    border: 1px solid rgba(0,0,0,.3);
  }
}
.text-info {
  color: yellowgreen !important;
}
.box {
  background: #353535;
}
#example tbody tr:hover {
        background-color: #212529;
        color: white;
    }
</style>
</html>
<?php } ?>