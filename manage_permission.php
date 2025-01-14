<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
?>

<?php
// Assuming you have established a database connection ($con)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['u-name']) && isset($_POST['dropdown'])) {
        $username = $_POST['u-name'];
        $branches = $_POST['dropdown'];

        foreach ($branches as $branch_info) {

            list($branch_code, $branch_name) = explode('|', $branch_info);

            $sql = "INSERT INTO tbl_access (username, branch_code, branch_name) VALUES (?, ?, ?)";
            
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sss", $username, $branch_code, $branch_name);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Registered successfully');</script>";
            } else {
                echo "<script>alert('Error inserting data');</script>";
            }

            $stmt->close();
        }

        echo "<script type='text/javascript'> document.location = 'manage_permission.php'; </script>";
    }
    else{
        echo "<script>alert('Something Went Wrong');</script>";
        echo "<script type='text/javascript'> document.location = 'manage_permission.php'; </script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Plugin css for branch dropdown -->
  

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amana | Permission</title>
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



      <!-- Code here -->
<!-- Data Table -->
<legend><br>
                <h3>Branch Access</h3>
            </legend><br>
<!-- search form-->

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include Select2 CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-WP/GJ6hW4m2iH0zL0tMNBO5Uv/hlOe5BhFXC0bFGsOq68y9PeYrPZlGJUOB3Jhx4bkG5FV6PV6i/G1V0jKqvow==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-BJQ+uMI3q4yYJg9KkhU/W2l9rUObq8aIBhi9q4ao3L6NXpzO0KwxgeC5cvBx5Jiy8RufaJG2H0Q19vq3XtMq8w==" crossorigin="anonymous"></script>


        <!-- Add form elements for adding new data -->
    <form action="#" method="post">
        <div class="form-row">
        <div class="form-column">
        <?php 
        $sql = "SELECT * FROM tbl_staff ";
                        $result = $con->query($sql);
                        $product = array();
        ?>
        <label>Username :</label>
        <select name="u-name" id="u-name" class="dropdown select1-dropdown" required>
            <option value="">Select</option>
            <?php
            while ($row = $result->fetch_assoc()) {
                $u_name = $row['username'];
                echo "<option value='$u_name'>$u_name</option>";
            }
            ?>
        </select>
        <script>
            $(document).ready(function() {
                $('#u-name').select2({
                    placeholder: 'Search for a username',
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
        </div>

            <div class="form-column">
                <?php 
                $sql = "SELECT * FROM tbl_branch ";
                                $result = $con->query($sql);
                                $product = array();
                ?>

                <label for="dropdown">Branches :</label>
                <select id="dropdown" name="dropdown[]" multiple>
                <?php
                    while ($row = $result->fetch_assoc()) {
                        $b_code = $row['b_code'];
                        $b_name = $row['b_name'];
                        echo "<option value='$b_code|$b_name'>$b_name</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <!-- Add another row here if needed -->
        </div>
        <button class="btn btn-primary mb-3" type="submit">Save</button>
    </form>
    <style>
        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .form-column {
            width: 48%;
        }

        .form-column input,
        .form-column select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .form-column label {
            display: block;
            margin-bottom: 5px;
        }
    </style>



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