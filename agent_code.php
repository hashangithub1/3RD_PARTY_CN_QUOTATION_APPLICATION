<?php session_start();
require_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

    //Code for Registration 
if(isset($_POST['submit']))
{
    $ag_code=$_POST['ag_code'];
    $ag_desc=$_POST['ag_desc'];
    $status=$_POST['status'];

$sql=mysqli_query($con,"select ag_code from tbl_agent_codes where ag_code ='$ag_code'");
$row=mysqli_num_rows($sql);
if($row>0)
{
    echo "<script>alert('Agent Code Already Exist.');</script>";
} else{
    
    $stmt = $con->prepare("INSERT INTO tbl_agent_codes(ag_code, ag_desc, status) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $ag_code, $ag_desc, $status);
    $msg = $stmt->execute();
    $stmt->close();

if($msg)
{
        //Notification System
        $currentTime = date('Y-m-d H:i:s');
        $newNotification = [
            'message' => 'New Agent Code Added', 
            'time' => $currentTime,
            'is_read' => false
        ];
        $_SESSION['notifications'][] = $newNotification;
        //End
    echo "<script>alert('Registered successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'agent_code.php'; </script>";
}
}
}
// Fetch data from staff tbl_agent_codes
$result = mysqli_query($con, "SELECT * FROM tbl_agent_codes");

// Fetch menu items from the database
$sql = "SELECT * FROM tbl_agent_codes";
$result2 = mysqli_query($con, $sql);

if (!$result2) {
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
  <title>Amana | Manage Agent Codes</title>
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
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addNewModal">Add Agent Code</button>
    <!-- Map Code Button -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#mapcodemodel">Agent Code Mapping</button>

    <!-- Data Table -->
    <div class="table-responsive">
    <table id="branchTable" class="display expandable-table" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Agent Code</th>
          <th>Description</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr data-id="<?php echo $row['id']; ?>">
            <td><?php echo $row['id']; ?></td>
            <td class="ag_code"><?php echo $row['agent_code']; ?></td>
            <td class="ag_desc"><?php echo $row['ag_desc']; ?></td>
            <td class="status"><?php echo $row['status']; ?></td>
            <td>
                <button class="btn-edit">Edit</button>
                <button class="btn-save" style="display:none;">Save</button>
                <button class="btn-cancel" style="display:none;">Cancel</button>
                <a href="delete_agent_code.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this code?');">Delete</a>
            </td>
            </tr>
        <?php } ?>
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
                url: "delete_product.php",
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
                <h5 class="modal-title" id="addNewModalLabel">Agent Code Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form elements for adding new data -->
                <form method="post" name="adduser" onsubmit="return checkpass();">
                    <div class="form-group">
                        <label for="productCode">Agent Code *</label>
                        <input class="form-control" id="pcode"  name="ag_code" type="text" placeholder="Agent Code Here" required>
                    </div>
                    <div class="form-group">
                        <label for="productName">Code Description</label>
                        <input class="form-control" id="pname" name="ag_desc" type="text" placeholder="Description Here" >
                    </div>
                    <div class="form-group">
                        <label for="productPremium">Status *</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Map code to user Modal-->
<div class="modal fade" id="mapcodemodel" tabindex="-1" role="dialog" aria-labelledby="mapcodemodelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:150%">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewModalLabel">Map Agent Codes to User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form elements for adding new data -->
                <div class="card" >
                    <div class="card-header text-center">
                        <h3>Agent Codes Map to Branch</h3>
                    </div>
                    <div class="card-body">
                        <form id="grantAccessForm" action="grant_agentcode_map.php" method="POST">

                        <div class="dropdown_flex">
                            <div class="mb-3">
                            <!-- <label for="userSelect" class="form-label">Select User</label> -->
                            <select class="form-select" id="userSelect" name="username"  onchange="loadAccess('username', this.value)">
                            <option value="">Choose a Branch...</option>
                            <?php
                            $sqlusername = "SELECT b_code,b_name FROM tbl_branch";
                            $resultusers = $con->query($sqlusername);
                                while ($row_users = $resultusers->fetch_assoc()) {
                                    $username = $row_users['b_code'];
                                    $branch_name = $row_users['b_name'];
                                    echo "<option value='$username'>$branch_name</option>";
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
                                            <th>Agent Code</th>
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
                <!-- End -->
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

  <script>
    $(document).ready(function() {
    // Initialize DataTable with pagination
    $('#branchTable').DataTable({
        "paging": true
    });
});

//Edit Function
$(document).ready(function () {
        $('.btn-edit').click(function () {
            var $row = $(this).closest('tr');
            $row.find('td:not(:last-child)').each(function () {
                var content = $(this).text();
            $(this).html('<input type="text" class="editable" value="' + content + '" />');
            });
            $row.find('.btn-edit').hide();
            $row.find('.btn-delete').hide();
            $row.find('.btn-save, .btn-cancel').show();
        });

        $('.btn-cancel').click(function () {
            var $row = $(this).closest('tr');
            $row.find('td:not(:last-child)').each(function () {
                var content = $(this).find('input').val();
                $(this).text(content);
            });
            $row.find('.btn-save, .btn-cancel').hide();
            $row.find('.btn-edit').show();
            $row.find('.btn-delete').show();
        });

        $('.btn-save').click(function () {
            var $row = $(this).closest('tr');
            var id = $row.data('id');
            var ag_code = $row.find('.ag_code input').val();
            var ag_desc = $row.find('.ag_desc input').val();
            var status = $row.find('.status input').val();

            // Send data to server via AJAX
            $.ajax({
                url: 'update_agent_code.php',
                type: 'POST',
                data: {
                    id: id,
                    ag_code: ag_code,
                    ag_desc: ag_desc,
                    status: status,
                },
                success: function (response) {
                    console.log(response); // Add this line
                    // Handle response from server
                    if (response.trim() == 'success') {
                        $row.find('td:not(:last-child)').each(function () {
                            var content = $(this).find('input').val();
                            $(this).text(content);
                        });
                        $row.find('.btn-save, .btn-cancel').hide();
                        $row.find('.btn-edit').show();
                        alert('Data saved successfully.');
                    } else {
                        alert('Failed to update. Please try again.');
                    }
                },
                error: function () {
                    alert('Failed to update. Please try again.');
                }
            });
        });
    });

    // Load existing access via AJAX
    function loadAccess(type, value) {
    if (type === 'username' && value !== '') {
        // Make an AJAX request to get agent codes and mapped codes for the selected username
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'load_access_agent_code.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Parse the JSON response
                const response = JSON.parse(xhr.responseText);
                const agentCodes = response.agentCodes;
                const mappedCodes = response.mappedCodes;

                // Clear the table body
                const tableBody = document.getElementById('menuTableBody');
                tableBody.innerHTML = '';

                // Populate the table with agent codes and check the ones that are mapped
                agentCodes.forEach(function(agentCode) {
                    const row = document.createElement('tr');

                    const selectCell = document.createElement('td');
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'agent_codes[]';
                    checkbox.value = agentCode;

                    // Automatically check the checkbox if the agent code is mapped
                    if (mappedCodes.includes(agentCode)) {
                        checkbox.checked = true;
                    }

                    selectCell.appendChild(checkbox);

                    const codeCell = document.createElement('td');
                    codeCell.textContent = agentCode;

                    row.appendChild(selectCell);
                    row.appendChild(codeCell);
                    tableBody.appendChild(row);
                });
            }
        };

        // Send the username in the request
        xhr.send('username=' + encodeURIComponent(value));
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
.btn-edit {
    background-color: #5B5B5B;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
}
.btn-save {
    background-color: #80bb41;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
}
.btn-delete, .btn-cancel {
    background-color: #bb2b2b;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
}

/* code mapping form */
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
</style>
</html>
<?php } ?>