<?php session_start();
include_once('includes/config.php');
require 'phpexcel/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
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
  <title>Amana | Quotation Report</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/fav-icon.jpg" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../partials/_navbar.html -->
    <?php include_once('includes/navbar.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php'); ?>
      <!-- partial -->

      <!-- Code here -->
      <div class="container mt-4">



      <!-- Code here -->
        <!-- Data Table -->
        <legend><br>
            <h3>Quotation Report - (Comprehensive)</h3>
        </legend><br>
        <!-- search form-->

        <style>
    /* Style for the form container */
    .form-inline-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 100%;
        margin: 20px auto;
    }

    /* Style for the select and input elements */
    .form-inline-flex select,
    .form-inline-flex input[type="date"] {
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 16px;
        width: 100%;
        max-width: 200px;
    }

    /* Style for the button */
    .form-inline-flex button {
        padding: 10px 20px;
        background-color: #5d6771;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .form-inline-flex button:hover {
        background-color: #81bd43;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
        .form-inline-flex {
            flex-direction: column;
        }

        .form-inline-flex select,
        .form-inline-flex input[type="date"] {
            max-width: 100%;
        }
    }

    /* Customize selected date background */
    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange {
        background-color: #81bd43 !important;  /* Selected date color */
        color: black !important;
        border-radius: 50%; 
    }

    .export-button {
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
</style>

<form class="form-inline" method="POST" action="">
    <div class="form-inline-flex">
        <div>
            <select name="company" id="company" required>
                <option value="">Select Company</option>
                <option value="NULL">All</option>
                <?php
                $sql = "SELECT code, name FROM tbl_company_mt";
                $result = $con->query($sql);
                while ($row = $result->fetch_assoc()) {
                $code = $row['code'];
                $name = $row['name'];
                echo "<option value='$code'>$name</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <select name="product" id="product" required>
                <option value="">Select Product</option>
                <?php
                $sql = "SELECT dep_code, product_des FROM tbl_product_mt";
                $result = $con->query($sql);
                while ($row = $result->fetch_assoc()) {
                $class = $row['dep_code'];
                $name = $row['product_des'];
                echo "<option value='$class'>$name</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <input type="text" id="dateRange" name="dateRange" placeholder="Select date range" required>
        </div>
        <button type="" name="search">Search</button>
    </div>
</form>

    <br><br>
<!-- end search form-->

<!-- Search and Export Function -->
<?php 
      // Check if the form is submitted
      if (isset($_POST['search'])) {
          // Sanitize and assign values from the form
          $company = $con->real_escape_string($_POST['company']);
          $product = $con->real_escape_string($_POST['product']);
          $dateRange = $con->real_escape_string($_POST['dateRange']);
          if (strpos($dateRange, ' to ') !== false) {
            list($startDate, $endDate) = explode(" to ", $dateRange);
        } else {
            $startDate = $dateRange;
            $endDate = $dateRange;
        }

        if ($company === 'NULL'){
            $sql = "SELECT q.*, p.product_des AS productname, c.code AS companycode, b.b_name AS branch_name FROM quotation_mt q LEFT JOIN tbl_product_mt p ON q.prod_code = p.product_code 
        LEFT JOIN tbl_company_mt c ON q.comp_codce = c.code LEFT JOIN tbl_branch b ON q.user_brnch = b.b_code
        WHERE q.dateadded >= '$startDate' AND q.dateadded <= '$endDate'";

        $sql1 = "SELECT q.*, p.product_des AS productname, c.code AS companycode, b.b_name AS branch_name FROM quotation_mt q LEFT JOIN tbl_product_mt p ON q.prod_code = p.product_code 
        LEFT JOIN tbl_company_mt c ON q.comp_codce = c.code LEFT JOIN tbl_branch b ON q.user_brnch = b.b_code
        WHERE q.dateadded >= '$startDate' AND q.dateadded <= '$endDate'";
        }
        else 
        {

        $sql = "SELECT q.*, p.product_des AS productname, c.code AS companycode, b.b_name AS branch_name FROM quotation_mt q LEFT JOIN tbl_product_mt p ON q.prod_code = p.product_code 
        LEFT JOIN tbl_company_mt c ON q.comp_codce = c.code LEFT JOIN tbl_branch b ON q.user_brnch = b.b_code
        WHERE
        q.comp_codce = '$company' AND q.prod_code >= '$product'
        AND q.dateadded >= '$startDate' AND q.dateadded <= '$endDate'";

        $sql1 = "SELECT q.*, p.product_des AS productname, c.code AS companycode, b.b_name AS branch_name FROM quotation_mt q LEFT JOIN tbl_product_mt p ON q.prod_code = p.product_code 
        LEFT JOIN tbl_company_mt c ON q.comp_codce = c.code LEFT JOIN tbl_branch b ON q.user_brnch = b.b_code
        WHERE
        q.comp_codce = '$company' AND q.prod_code >= '$product'
        AND q.dateadded >= '$startDate' AND q.dateadded <= '$endDate'";
        }

        $result = $con->query($sql);
        $export = $con->query($sql1);
        $con->close();
      }
?>
<!-- Filter/Search Input -->
<div class="d-flex justify-content-end mb-3">
    <!-- input type="text" class="form-control mr-2" id="searchInput" placeholder="Search" -->
</div>

    <div class="table-responsive">
    <button onclick="exportTableToCSV('search_results.csv')" class="export-button">Excel</button>

        <table id="example" class="display expandable-table" style="width:100%">
        </div>
            <thead>
            <tr>
                <th>ID</th>
                <th>Quotation No</th>
                <th>Product</th>
                <th>Usage</th>
                <th>Sum Insured</th>
                <th>Premium</th>
                <th>Issued By</th>
                <th>Issued Branch</th>
                <th>Issued Date</th>
            </tr>
            </thead>
            <tbody>
              <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['quote_no'] . "</td>";
                echo "<td>" . $row['productname'] . "</td>";
                echo "<td>" . $row['vehi_usage'] . "</td>";
                echo "<td>" . $row['sum_ins'] . "</td>";
                echo "<td>" . $row['tot_premium'] . "</td>";
                echo "<td>" . $row['user_ID'] . "</td>";
                echo "<td>" . $row['branch_name'] . "</td>";
                echo "<td>" . $row['dateadded'] . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>

        <!-- //export table -->
        <table id="exporttable" style="display:none">
        </div>
            <thead>
            <tr>
                <th>ID</th>
                <th>Quotation No</th>
                <th>Company</th>
                <th>Product</th>
                <th>Customer name</th>
                <th>Customer Address</th>
                <th>Customer Mobile</th>
                <th>Customer Email</th>
                <th>Vehicle Number</th>
                <th>Registration</th>
                <th>Make Model</th>
                <th>Seating Capacity</th>
                <th>Manufacture Year</th>
                <th>Fuel Type</th>
                <th>Usage</th>
                <th>Sum Insured</th>
                <th>NCB Rate</th>
                <th>NCB Amount</th>
                <th>MR Rate</th>
                <th>MR Amount</th>
                <th>Basic Premium</th>
                <th>VAT</th>
                <th>Admin Fee</th>
                <th>Compulsory Excess</th>
                <th>Age Excess</th>
                <th>Total Contribution</th>
                <th>Issued By</th>
                <th>Issued Branch</th>
                <th>Issued Date</th>
            </tr>
            </thead>
            <tbody>
              <?php
            if(!empty($export)){
            while ($row1 = mysqli_fetch_assoc($export)) {
                echo "<tr>";
                echo "<td>" . $row1['id'] . "</td>";
                echo "<td>" . $row1['quote_no'] . "</td>";
                echo "<td>" . $row1['companycode'] . "</td>";
                echo "<td>" . $row1['prod_code'] . "</td>";
                echo "<td>" . $row1['cus_name'] . "</td>";
                echo "<td>" . $row1['cus_address'] . "</td>";
                echo "<td>" . $row1['cus_mobile'] . "</td>";
                echo "<td>" . $row1['cus_email'] . "</td>";
                echo "<td>" . $row1['vehi_number'] . "</td>";
                echo "<td>" . $row1['vehi_reg_status'] . "</td>";
                echo "<td>" . $row1['vehi_make_model'] . "</td>";
                echo "<td>" . $row1['vehi_seating_capacity'] . "</td>";
                echo "<td>" . $row1['vehi_year_of_manu'] . "</td>";
                echo "<td>" . $row1['vehi_fuel_type'] . "</td>";
                echo "<td>" . $row1['vehi_usage'] . "</td>";
                echo "<td>" . $row1['sum_ins'] . "</td>";
                echo "<td>" . $row1['ncb_rate'] . "</td>";
                echo "<td>" . $row1['ncb_amt'] . "</td>";
                echo "<td>" . $row1['mr_rate'] . "</td>";
                echo "<td>" . $row1['mr_amt'] . "</td>";
                echo "<td>" . $row1['basic_premium'] . "</td>";
                echo "<td>" . $row1['vat_amt'] . "</td>";
                echo "<td>" . $row1['admin_fee'] . "</td>";
                echo "<td>" . $row1['comp_excesses'] . "</td>";
                echo "<td>" . $row1['age_exces'] . "</td>";
                echo "<td>" . $row1['tot_premium'] . "</td>";
                echo "<td>" . $row1['user_ID'] . "</td>";
                echo "<td>" . $row1['branch_name'] . "</td>";
                echo "<td>" . $row1['dateadded'] . "</td>";
                echo "</tr>";
            }
        }
            ?>
            </tbody>
        </table>
    </div>
    <br><br>
      <!-- main-panel ends -->
      </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../vendors/select2/select2.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../js/file-upload.js"></script>
  <script src="../js/typeahead.js"></script>
  <script src="../js/select2.js"></script>
  <!-- End custom js for this page-->

  <!-- Paggination -->
  <!-- jQuery -->
<script src='https://code.jquery.com/jquery-3.7.0.js'></script>
<!-- Data Table JS -->
<script src='https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js'></script>
<script src='https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js'></script>

<!-- Date Range Script -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

//Date Range
document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#dateRange", {
            mode: "range",             // Enables range selection
            dateFormat: "Y-m-d",       // Stored date format
            altInput: true,            // Alternate input with formatted date
            altFormat: "F j, Y"        // Displayed date format
        });
    });

    document.querySelector("form").addEventListener("submit", function (event) {
    const dateRange = document.getElementById("dateRange").value;

    if (!dateRange) {
        alert("Please Select Date Range.");
        event.preventDefault(); // Prevent form submission
    }
});

//Export Function
function exportTableToCSV(filename) {
    const csv = [];
    const rows = document.querySelectorAll("#exporttable tr");

    // Loop through each row and convert it to CSV
    for (const row of rows) {
        const rowData = [];
        for (const cell of row.querySelectorAll("td, th")) {
            rowData.push('"' + cell.innerText.replace(/"/g, '""') + '"');
        }
        csv.push(rowData.join(","));
    }

    // Create a CSV file and download it
    const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    const downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

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

/* datatable */
.dataTables_wrapper .dataTables_length select {
  min-width: 35px;
  margin-left: .25rem;
  margin-right: .25rem;
  width: -webkit-fill-available;
  border-radius: 4px;
  height: auto;
}

div.dataTables_wrapper div.dataTables_filter input {
  margin-left: .5em;
  display: inline-block;
  width: auto;
  height: 3px;
}
</style>
</html>
<?php } ?>