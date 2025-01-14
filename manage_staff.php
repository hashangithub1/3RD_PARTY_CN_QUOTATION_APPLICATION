<?php session_start();
require_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

//Code for Registration 
if(isset($_POST['submit']))
{
    $uname=$_POST['username'];
    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
    $email=$_POST['email'];
    $contact=$_POST['contact'];
    $branch=$_POST['branch'];
    $role=$_POST['role'];
    $password=$_POST['password'];
$sql=mysqli_query($con,"select id from tbl_staff where username ='$uname'");
$row=mysqli_num_rows($sql);
if($row>0)
{
    echo "<script>alert('Username already exist with another account. Please try with other username');</script>";
} else{
    
    $stmt = $con->prepare("INSERT INTO tbl_staff(username, first_name, last_name, email, contact, branch, role, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $uname, $fname, $lname, $email, $contact, $branch, $role, $password);
    $msg = $stmt->execute();
    $stmt->close();

if($msg)
{
    echo "<script>alert('Registered successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'manage_staff.php'; </script>";
}
}
}
// Fetch data from staff table
$result = mysqli_query($con, "SELECT * FROM tbl_staff");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Plugin css for branch dropdown -->
  

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amana | Manage Staff</title>
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
  <script type="text/javascript">
    


function checkpass()
{
if(document.signup.password.value!=document.signup.confirmpassword.value)
{
alert(' Password and Confirm Password field does not match');
document.signup.confirmpassword.focus();
return false;
}
return true;
} 

</script>

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
    <button class="btn btn-primary mb-3" id="addNewEmployeeButton" data-toggle="modal" data-target="#addNewModal">Add New Staff Member</button>

    <!-- Filter/Search Input -->
    <input type="text" class="form-control mb-3" id="searchInput" placeholder="Search">

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="display expandable-table" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Address</th>
                <th>Mobile Number</th>
                <th>Branch</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Display data in DataTable
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['contact'] . "</td>";

            if (isset($row['branch'])) {
                $branchCodes = explode(",", $row['branch']);

                echo "<td>";
                foreach ($branchCodes as $branchCode) {
                    $query = "SELECT b_name FROM tbl_branch WHERE b_code = '$branchCode'";
                    $resultBranch = mysqli_query($con, $query);

                    if ($resultBranch) {

                        $rowBranch = mysqli_fetch_assoc($resultBranch);

                        if ($rowBranch) {
                            echo $rowBranch['b_name'] . "<br>";
                        } else {
                            echo "Branch not found<br>";
                        }
                    } else {
                        echo "Database error<br>";
                    }
                }
                echo "</td>";
            } else {
                // Print an empty cell if 'branch' column doesn't exist in $row
                echo "<td></td>";
            }
                echo "<td>" . $row['role'] . "</td>";    
                echo "<td>";
                //echo "<button class='btn btn-info btn-sm'>Edit</button>";
                echo "<button class='btn btn-danger btn-sm' onclick='deleteRecord(" . $row['id'] . ")'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <script>
    function deleteRecord(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            // Send an AJAX request to delete the record
            $.ajax({
                type: "POST",
                url: "delete_record.php",
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
                <h5 class="modal-title" id="addNewModalLabel">Add New Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form elements for adding new data -->
                <form method="post" id="employeeForm" name="adduser" onsubmit="return checkpass();">
                    <div class="form-group">
                        <label for="employeeName">Username *</label>
                        <input class="form-control" id="username"  name="username" type="text" placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                        <label for="employeeEmail">First Name *</label>
                        <input class="form-control" id="firstname" name="firstname" type="text" placeholder="Enter your first name" required>
                    </div>
                    <div class="form-group">
                        <label for="employeeEmail">Last Name *</label>
                        <input class="form-control" id="lastname" name="lastname" type="text" placeholder="Enter your last name" required>
                    </div>
                    <div class="form-group">
                        <label for="employeeEmail">Email Address</label>
                        <input class="form-control" id="email" name="email" type="email" placeholder="Enter your email address" >
                    </div>
                    <div class="form-group">
                        <label for="employeeEmail">Mobile Number *</label>
                        <input class="form-control" id="contact" name="contact" type="text" placeholder="1234567890" required pattern="[0-9]{10}" title="10 numeric characters only"  maxlength="10" required>
                    </div>
                    <?php 
                    $sql = "SELECT * FROM tbl_branch ";
                                    $result = $con->query($sql);
                                    $product = array();
                    ?>
                    <div class="form-group">
                        <label for="branch">Branch *</label>
                        <select class="form-control" id="branch" name="branch" required>
                        <option value="">Select</option>
                        <?php
                            while ($row = $result->fetch_assoc()) {
                            $B_id = $row['b_code'];
                            $B_name = $row['b_name'];
                            echo "<option value='$B_id'>$B_name</option>";
                        }
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="branch">Role *</label>
                        <select class="form-control" id="branch" name="role" required>
                        <?php 
                        $sql = "SELECT * FROM tbl_roll ";
                                    $resultrole = $con->query($sql);
                                    
                            while ($row = $resultrole->fetch_assoc()) {
                            $R_code = $row['role_id'];
                            $R_name = $row['role'];
                            echo "<option value='$R_code'>$R_name</option>";
                        }
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="employeeEmail">Password *</label>
                        <input class="form-control" id="password" name="password" type="password" placeholder="Create a password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="at least one number and one uppercase and lowercase letter, and at least 6 or more characters" required>
                    </div>
                    <div class="form-group">
                        <label for="employeeEmail">Confirm Password *</label>
                        <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" placeholder="Confirm password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="at least one number and one uppercase and lowercase letter, and at least 6 or more characters" required>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Add</button>

                </form>
            </div>
        </div>
    </div>
</div>




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