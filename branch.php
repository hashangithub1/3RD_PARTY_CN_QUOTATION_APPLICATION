<?php session_start();
require_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

    //Code for Registration 
if(isset($_POST['submit']))
{
    $bcode=$_POST['bcode'];
    $bname=$_POST['bname'];
    $bank_code=$_POST['bank_code'];
    $bank=$_POST['bank_name'];
    $acno=$_POST['bank_ac'];

$sql=mysqli_query($con,"select b_code from tbl_branch where b_code ='$bcode'");
$row=mysqli_num_rows($sql);
if($row>0)
{
    echo "<script>alert('Branch already exist.');</script>";
} else{
    
    $stmt = $con->prepare("INSERT INTO tbl_branch(b_name, b_code, bank_code, bank_name, bank_acc_no) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $bname, $bcode, $bank_code, $bank, $acno);
    $msg = $stmt->execute();
    $stmt->close();

if($msg)
{
        //Notification System
        $currentTime = date('Y-m-d H:i:s');
        $newNotification = [
            'message' => 'New Branch Added', 
            'time' => $currentTime,
            'is_read' => false
        ];
        $_SESSION['notifications'][] = $newNotification;
        //End
    echo "<script>alert('Registered successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'branch.php'; </script>";
}
}
}
// Fetch data from staff table
$result = mysqli_query($con, "SELECT * FROM tbl_branch");
?>


<!DOCTYPE html>
<html lang="en">

<head>
<link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amana | Manage Branches</title>
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


    <!-- Add New Button -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addNewModal">Add New Branch</button>

    <!-- Data Table -->
    <div class="table-responsive">
    <table  id="branchTable" class="display expandable-table" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Branch Code</th>
          <th>Branch Name</th>
          <th>Bank Name</th>
          <th>Ac. Number</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Display data in DataTable
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['b_code'] . "</td>";
          echo "<td>" . $row['b_name'] . "</td>";
          echo "<td>" . $row['bank_name'] . "</td>";
          echo "<td>" . $row['bank_acc_no'] . "</td>";
          echo "<td>";
          echo "<button class='btn btn-primary mr-2 btn-sm ml-2' onclick='editRecord(" . $row['id'] . ")'>Edit</button>";
          echo "<button class='btn btn-danger btn-sm' onclick='deleteRecord(" . $row['id'] . ")'>Delete</button>";
          echo "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
        </table>

        <style>
    .custom-thead {
    background-color: #81bd43;
    }
    </style>

    </div>
    <script>
    function deleteRecord(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            // Send an AJAX request to delete the record
            $.ajax({
                type: "POST",
                url: "delete_branch.php",
                data: { id: id },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert("Record deleted successfully");
                        // Reload the page
                        location.reload();
                    } else {
                        alert("Error deleting record: " + result.error);
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error deleting record: " + error);
                }
            });
        }
    }

    $(document).ready(function() {
        // Initialize DataTable
        $('#employeeTable').DataTable();

        // Add your JavaScript code for filtering/searching here
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

</div>

<!-- Add New Modal Staff-->
<div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewModalLabel">Add New Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form elements for adding new data -->
                <form method="post" name="adduser" onsubmit="return checkpass();">
                    <div class="form-group">
                        <label for="productCode">Branch Code *</label>
                        <input class="form-control" id="bcode"  name="bcode" type="text" placeholder="Enter product code" required>
                    </div>
                    <div class="form-group">
                        <label for="productName">Branch Name *</label>
                        <input class="form-control" id="bname" name="bname" type="text" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group">
                        <label for="productName">Bank Code</label>
                        <input class="form-control" id="bname" name="bank_code" type="text" placeholder="Enter product name" >
                    </div>
                    <div class="form-group">
                        <label for="productName">Bank Name </label>
                        <input class="form-control" id="bname" name="bank_name" type="text" placeholder="Enter product name" >
                    </div>
                    <div class="form-group">
                        <label for="productName">Acc. No </label>
                        <input class="form-control" id="bname" name="bank_ac" type="text" placeholder="Enter product name" >
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Add</button>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Branch Modal -->
<div class="modal fade" id="editBranchModal" tabindex="-1" role="dialog" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBranchModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form elements for editing the data -->
                <form method="post" name="editProductForm" action="update_branch.php">
                    <div class="form-group">
                        <label for="editProductCode">Branch Code</label>
                        <input class="form-control" id="editBranchCode" name="editBranchCode" type="text">
                    </div>
                    <div class="form-group">
                        <label for="editProductName">Branch Name</label>
                        <input class="form-control" id="editBranchName" name="editBranchName" type="text">
                    </div>
                    <div class="form-group">
                        <label for="editProductName">Bank Code</label>
                        <input class="form-control" id="editBankCode" name="editBankCode" type="text">
                    </div>
                    <div class="form-group">
                        <label for="editProductName">Bank Name</label>
                        <input class="form-control" id="editBankName" name="editBankName" type="text">
                    </div>
                    <div class="form-group">
                        <label for="editProductName">Acc. No</label>
                        <input class="form-control" id="editAcNo" name="editAcNo" type="text">
                    </div>
                    <input type="hidden" id="editBranchId" name="editBranchId">
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function editRecord(id) {
        // Fetch the product details using AJAX and populate the modal form
        $.ajax({
            type: "POST",
            url: "fetch_baranch_details.php", // Create a new PHP file to handle this AJAX request
            data: { id: id },
            success: function(response) {
                // Parse the JSON response and populate the modal form fields
                var branchDetails = JSON.parse(response);
                $("#editBranchCode").val(branchDetails.b_code);
                $("#editBranchName").val(branchDetails.b_name);
                $("#editBankCode").val(branchDetails.bank_code);
                $("#editBankName").val(branchDetails.bank_name);
                $("#editAcNo").val(branchDetails.bank_acc_no);
                $("#editBranchId").val(branchDetails.id);

                // Show the modal
                $("#editBranchModal").modal("show");
            },
            error: function(xhr, status, error) {
                alert("Error fetching product details: " + error);
            }
        });
    }

    function updateProduct() {
        // Implement the logic to update the product using AJAX
        // You can use a similar AJAX request as in the deleteRecord function
        // Handle the update logic on the server side (e.g., in update_product.php)
        
        // After successful update, you can close the modal
        $("#editBranchModal").modal("hide");
        
        return false; // Prevent the form from submitting in the traditional way
    }
</script>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


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
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>
        <!-- Script JS -->
        <script src="./js/script.js"></script>
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
    $(document).ready(function() {
    // Initialize DataTable with pagination
    $('#branchTable').DataTable({
        "paging": true
    });
});

  </script>
</body>
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