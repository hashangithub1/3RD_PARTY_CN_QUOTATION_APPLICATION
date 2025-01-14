<?php session_start();
require_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

// Fetch menu items from the database
$sql = "SELECT id, menu_name FROM tbl_sidebar_menu";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Plugin css for branch dropdown -->
  <link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amana | User Access Menu</title>
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
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Grant Menu Access to Users</h3>
                    </div>
                    <div class="card-body">
                        <form id="grantAccessForm" action="grant_access.php" method="POST">

                        <div class="dropdown_flex">
                            <div class="mb-3">
                            <!-- <label for="userSelect" class="form-label">Select User</label> -->
                            <select class="form-select" id="userSelect" name="username"  onchange="loadAccess('username', this.value)">
                            <option value="">Choose a user...</option>
                            <?php
                            $sqlusername = "SELECT username FROM tbl_staff";
                            $resultusers = $con->query($sqlusername);
                                while ($row_users = $resultusers->fetch_assoc()) {
                                    $username = $row_users['username'];
                                    echo "<option value='$username'>$username</option>";
                                }
                            ?>
                            </select>
                            </div>

                            <div class="mb-3">
                            <!-- <label for="userSelect" class="form-label">Select User</label> -->
                            <select class="form-select" id="roleSelect" name="role" onchange="loadAccess('role', this.value)">
                            <option value="">Choose a role...</option>
                            <?php
                            $sqlrole = "SELECT * FROM tbl_roll";
                            $resultrole = $con->query($sqlrole);
                                while ($rol_users = $resultrole->fetch_assoc()) {
                                    $role = $rol_users['role'];
                                    $role_ID = $rol_users['role_id'];
                                    echo "<option value='$role_ID'>$role</option>";
                                }
                            ?>
                            </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="menuSelect" class="form-label">Select Menus</label>
                            <div class="text-end mb-2">
                                <button type="button" id="selectAllBtn" class="btn btn-sm btn-secondary">Select All</button>
                            </div>
                            <div class="menu-list">
                                <table id="menuTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Menu Name</th>
                                        </tr>
                                    </thead>
                                    <tbody id="menuTableBody">
                                        <!-- Menu items will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-custom">Grant Access</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
// Load existing access via AJAX
function loadAccess(type, value) {
    if (value) {
        $.ajax({
            url: 'load_access.php',
            type: 'POST',
            data: { type: type, value: value },
            success: function(response) {
                // Populate the menu table body with the received data
                $('#menuTableBody').html(response);

                // Destroy the current DataTable instance before reinitializing
                if ($.fn.DataTable.isDataTable('#menuTable')) {
                    $('#menuTable').DataTable().clear().destroy();
                }

                // Reinitialize DataTable after new data is loaded
                $('#menuTable').DataTable({
                    paging: false,
                    searching: false,
                    scrollY: '300px',
                    scrollX: true,
                    scrollCollapse: true,
                    columnDefs: [
                        { width: '10%', targets: 0 } // Adjust checkbox column width
                    ],
                    fixedColumns: true
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    }
}

$(document).ready(function() {
    // Initialize DataTables
    $('#menuTable').DataTable({
        paging: false,
        searching: false
    });

    // Select All / Deselect All functionality
    $('#selectAllBtn').on('click', function() {
        let checkboxes = $('.menu-checkbox');
        // Toggle select all or deselect all
        let allChecked = checkboxes.length === checkboxes.filter(':checked').length;
        checkboxes.prop('checked', !allChecked);
    });
});


</script>
<!-- JS includes -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- <script>
  $(document).ready(function() {
    // Initialize DataTables
    $('#menuTable').DataTable({
        paging: false,
        searching: false
    });

    // Select All / Deselect All button functionality
    $('#selectAllBtn').on('click', function() {
        let checkboxes = $('.menu-checkbox');
        let allChecked = checkboxes.length === checkboxes.filter(':checked').length;
        
        // Toggle between select all and deselect all
        if (allChecked) {
            checkboxes.prop('checked', false);
            $(this).text('Select All');
        } else {
            checkboxes.prop('checked', true);
            $(this).text('Deselect All');
        }
    });
  });
</script> -->

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
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #81bd43;
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .btn-custom {
            background-color: #34495E;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #81bd43;
        }
        .menu-list {
            max-height: 400px;
            overflow-y: auto;
        }
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        .table thead th {
            background-color: #34495E;
            color: #fff;
            font-weight: bold;
        }
        .table thead th, .table tbody td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .table tbody tr:hover {
            background-color: #747577;
        }
        .form-check-input {
            margin: 0;
        }
        /* Style for the select element */
        .form-select {
        background-color: #ffffff;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        color: #495057;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }

        /* Style for options inside the select dropdown */
        .form-select option {
        background-color: #ffffff;
        color: #495057;
        padding: 0.5rem 1rem;
        }

        /* Style for the select dropdown when opened */
        .form-select::-ms-expand {
        display: none;
        }

        .form-select::after {
        content: "\f078"; /* FontAwesome down arrow icon */
        font-family: 'FontAwesome';
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #495057;
        pointer-events: none;
        }

        /* Custom styling for the dropdown list */
        .form-select {
        position: relative;
        }

        .form-select option:hover {
        background-color: #e9ecef;
        color: #495057;
        }

        .form-select option:checked {
        background-color: #007bff;
        color: #ffffff;
        }

        /* Style for the select dropdown in focus state */
        .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }

        /* Remove default styling for the select */
        .form-select::-webkit-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        }
        .dropdown_flex{
        display : flex;
        column-gap: 10px
        }
        @media (max-width: 767px) {
        .dropdown_flex {
        display: block; 
        column-gap: 0;
        }
}
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
    </style>
</html>
<?php } ?>