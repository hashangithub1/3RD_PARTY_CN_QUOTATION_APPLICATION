<?php session_start();
//header("Cache-Control: public, max-age=86400");
require_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
$username = $_SESSION['u_name'] ;
$br_code = $_SESSION['branch'];
    //Code for Registration 
if(isset($_POST['submit']))
{
    $rcpt_no  =$_POST['rcpt_no'];
    $desc =$_POST['description'];
    $rcpt_amt =$_POST['rcpt_amt'];
    $rcpt_date = $_POST['date'];
    $spent_amt = 0;
    $rcpt_amt = str_replace(array('Rs.', ','), '', $rcpt_amt);
    $rcpt_amt = (int)$rcpt_amt;  // For integer

$sql=mysqli_query($con,"select receipt_no from tbl_receipt where receipt_no ='$rcpt_no'");
$row=mysqli_num_rows($sql);
if($row>0)
{
    echo "<script>alert('Receipt Number Already Exist.');</script>";
} else{
    
     $stmt = $con->prepare("INSERT INTO tbl_receipt(receipt_no, description, receipt_date, total, spent_amount, available_amount, user_added, branch_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdddss", $rcpt_no, $desc, $rcpt_date, $rcpt_amt, $spent_amt, $rcpt_amt, $username, $br_code);
    $msg = $stmt->execute();
    $stmt->close();

if($msg)
{
    //Notification System
    $currentTime = date('Y-m-d H:i:s');
    $newNotification = [
        'message' => 'New Receipt Number Added', 
        'time' => $currentTime,
        'is_read' => false
    ];
    $_SESSION['notifications'][] = $newNotification;
    //End

    echo "<script>alert('Registered successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'receipt_option.php'; </script>";
}
}
}
// Fetch data from staff table
if ($username === 'admin'){
    $result = mysqli_query($con, "SELECT * FROM tbl_receipt WHERE status = 1");
    } else {
        $result = mysqli_query($con, "SELECT * FROM tbl_receipt WHERE branch_code = '$br_code'  AND status = 1");
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
  <title>Amana | Receipt Options</title>
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
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addNewModal">Add Receipt Number</button>

    <!-- Data Table -->
    <div class="table-responsive">
    <table id="branchTable" class="display expandable-table" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Receipt Number</th>
          <th>Description</th>
          <th>Total Amount</th>
          <th>Spent Amount</th>
          <th>Available Amount</th>
          <?php if ($username == 'admin'): ?>
          <th>Action</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr data-id="<?php echo $row['id']; ?>">
            <td><?php echo $row['id']; ?></td>
            <td class="receipt_no"><?php echo $row['receipt_no']; ?></td>
            <td class="description"><?php echo $row['description']; ?></td>
            <td class="total"><?php echo $row['total']; ?></td>
            <td class="spent_amount"><?php echo $row['spent_amount']; ?></td>
            <td class="available_amount"><?php echo $row['available_amount']; ?></td>
            <?php if ($username == 'admin'): ?>
            <td>
                <button class="btn-edit">Edit</button>
                <button class="btn-save" style="display:none;">Save</button>
                <button class="btn-cancel" style="display:none;">Cancel</button>
                <a href="delete_receipt_code.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this code?');">Delete</a>
            </td>
            <?php endif; ?>
            </tr>
        <?php } ?>
      </tbody>
    </table>
        </table>
    </div>
    <script>

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
                <h5 class="modal-title" id="addNewModalLabel">Receipt Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form elements for adding new data -->
                <form method="post" name="adduser" onsubmit="return checkpass();">
                    <div class="form-group">
                        <label for="productCode">Receipt Number *</label>
                        <input class="form-control" id="rcpt_no"  name="rcpt_no" type="text" placeholder="Enter Receipt Code" required>
                    </div>
                    <div class="form-group">
                        <label for="productName">Receipt Amount *</label>
                        <input class="form-control" id="rcpt_amt" name="rcpt_amt" type="text" placeholder="Rs." required>
                    </div>

                    <div class="form-group">
                        <label for="productName">Receipt Date *</label>
                        <input class="form-control" id="date" name="date" type="date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="productCode">Description</label>
                        <input class="form-control" id="rcpt_no"  name="description" type="text" placeholder="Enter Receipt Code" >
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

//Receipt Amount RS
$(document).ready(function() {
setDefaultamount();

$('#rcpt_amt').on('input', formatamounttInput);

function setDefaultamount() {
var AmountInput = $('#rcpt_amt');

}

function formatamounttInput() {
var AmountInput = $('#rcpt_amt');
var AmountValue = AmountInput.val();
var numericValue = AmountValue.replace(/\D/g, '');

console.log('Original Value:', AmountValue);
console.log('Numeric Value:', numericValue);

var formattedValue = 'Rs. ' + parseInt(numericValue, 10).toLocaleString();

console.log('Formatted Value:', formattedValue);
AmountInput.val(formattedValue);
}
});

//Edit Function
$(document).ready(function () {
$('.btn-edit').click(function () {
var $row = $(this).closest('tr');
$row.find('td:not(:last-child):not(:first-child)').each(function () {
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
var receipt_no = $row.find('.receipt_no input').val();
var description = $row.find('.description input').val();
var total = $row.find('.total input').val();
var spent_amount = $row.find('.spent_amount input').val();
var available_amount = $row.find('.available_amount input').val();

// Send data to server via AJAX
$.ajax({
url: 'update_receipt_number.php',
type: 'POST',
data: {
id: id,
receipt_no: receipt_no,
description: description,
total: total,
spent_amount: spent_amount,
available_amount: available_amount,
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
$row.find('.btn-delete').show();
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
</style>
</html>
<?php } ?>