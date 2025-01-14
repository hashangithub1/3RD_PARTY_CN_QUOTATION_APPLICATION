<?php session_start();
require_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

    //Code for Registration 
if(isset($_POST['submit']))
{
    $class=$_POST['pclass'];
    $code=$_POST['pcode'];
    $desc=$_POST['pdesc'];
    $type=$_POST['ptype'];
    $pstat = 1;
    $deptcode = 13;

$sql=mysqli_query($con,"select product_code from tbl_product_mt where product_code ='$code'");
$row=mysqli_num_rows($sql);
if($row>0)
{
    echo "<script>alert('Product already exist.');</script>";
} else{
    
    $stmt = $con->prepare("INSERT INTO tbl_product_mt(dep_code, product_calss, product_code, product_des, product_stat, product_type ) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss",$deptcode ,$class, $code, $desc, $pstat, $type);
    $msg = $stmt->execute();
    $stmt->close();

if($msg)
{
    //Notification System
    $currentTime = date('Y-m-d H:i:s');
    $newNotification = [
        'message' => 'New Product added to the Comprehensive', 
        'time' => $currentTime,
        'is_read' => false
    ];
    $_SESSION['notifications'][] = $newNotification;
    //End
    echo "<script>alert('Registered successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'products-motor.php'; </script>";
}
}
}
// Fetch data from staff table
$result = mysqli_query($con, "SELECT * FROM tbl_product_mt WHERE product_stat = 1");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Plugin css for branch dropdown -->
  
  <link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amana | Manage Products</title>
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
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addNewModal">Add New Product</button>

    <!-- Data Table -->
    <div class="table-responsive">
    <table id="branchTable" class="display expandable-table" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Product Class</th>
          <th>Product Code</th>
          <th>Description</th>
          <th>Product Type</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Display data in DataTable
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['product_calss'] . "</td>";
          echo "<td>" . $row['product_code'] . "</td>";
          echo "<td>" . $row['product_des'] . "</td>";
          echo "<td>" . $row['product_type'] . "</td>";
          echo "<td>";
          echo "<button class='btn btn btn-primary mr-2 btn-sm ml-2' onclick='editRecord(" . $row['id'] . ")'>Edit</button>";
          echo "<button class='btn btn-danger btn-sm' onclick='deleteRecord(" . $row['id'] . ")'>Delete</button>";
          echo "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
        </table>
    </div>
    <script>
    function deleteRecord(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            // Send an AJAX request to delete the record
            $.ajax({
                type: "POST",
                url: "delete_company.php",
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
                <h5 class="modal-title" id="addNewModalLabel">Create Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form elements for adding new data -->
                <form method="post" name="adduser" onsubmit="return checkpass();">
                    <div class="form-group">
                        <label for="productCode">Product Class *</label>
                        <input class="form-control" id="pcode"  name="pclass" type="text" placeholder="Enter product code" required>
                    </div>
                    <div class="form-group">
                        <label for="productName">Product Code *</label>
                        <input class="form-control" id="pname" name="pcode" type="text" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group">
                        <label for="productPremium">Description *</label>
                        <input class="form-control" id="premium" name="pdesc" type="text" placeholder="Enter product Description" required>
                    </div>
                    <div class="form-group">
                        <label for="productPremium">Product Type *</label>
                        <select class="form-control" name="ptype" id="prod_type" required>
                            <option value="thirdparty"> Third Party</option>
                            <option value="comprehensive">Comprehensive</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Add</button>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form elements for editing the data -->
                <form method="post" name="editProductForm" action="update_company.php">
                    <div class="form-group">
                        <label for="editProductCode">Company Code</label>
                        <input class="form-control" id="editCode" name="editCode" type="text">
                    </div>
                    <div class="form-group">
                        <label for="editProductName">Company Name</label>
                        <input class="form-control" id="editName" name="editName" type="text">
                    </div>
                    <div class="form-group">
                        <label for="editProductPremium">Description</label>
                        <input class="form-control" id="editDesc" name="editDescription" type="text">
                    </div>
                    <input type="hidden" id="editId" name="editId">
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
            url: "fetch_company_details.php", // Create a new PHP file to handle this AJAX request
            data: { id: id },
            success: function(response) {
                // Parse the JSON response and populate the modal form fields
                var companyDetails = JSON.parse(response);
                $("#editCode").val(companyDetails.code);
                $("#editName").val(companyDetails.name);
                $("#editDesc").val(companyDetails.description);
                $("#editId").val(companyDetails.id);

                // Show the modal
                $("#editProductModal").modal("show");
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
        $("#editProductModal").modal("hide");
        
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