<?php session_start();
include_once('includes/config.php');
require 'phpexcel/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
    //export function
if (isset($_POST['export'])) {
    // Define the core part of the SQL query with placeholders
    $sql = "
        SELECT DISTINCT
            ti.*, 
            tp.prod_code,
            tp.seating_capacity,
            tu.code,
            tm.m_code,
            tm.country_of_origin,
            br.bank_code,
            br.bank_gl_code,
            NULL as category,
            NULL as cont_ag_code,
            1 as sum_covered
        FROM 
            tbl_insurance ti
        LEFT JOIN 
            tbl_product tp 
            ON ti.product = tp.name
        LEFT JOIN
            tbl_usage_type tu
            ON ti.usage_type = tu.type
        LEFT JOIN
            tbl_model tm
            ON ti.make_model = tm.model
        LEFT JOIN
            tbl_staff ts
            ON ti.issued_by = ts.username
        LEFT JOIN
            tbl_branch br
            ON ti.branch_added = br.b_code
        WHERE 
           ti.cover_note_number NOT IN (
                SELECT coverNoteNumber 
                FROM tbl_policy_updates 
                WHERE status = 1
            )
            AND ti.date_added >= '2024-11-01'
            AND branch_added <> '10613'
            ORDER BY ti.date_added DESC

    ";

    $result = $con->query($sql);


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['ID', 'Prefix', 'Name', 'Reg type', 'Reg No', 'Mobile Number', 'Address 01',
                    'Address 02', 'City Code', 'Product', 'Category', 'Cover Note Number', 'Manual CN Number', 
                    'Business Class Code', 'Make Model Code', 'Usage Type', 'Fuel Type', 'Cubic Capacity',
                    'Registered Owner', 'Registration Number', 'Engine Number', 'Chassis Number', 'Engine Capacity',
                    'Seating Capacity', 'Year of Manufacture', 'Country of Origin', 'Receipt Number', 'Valid Period',
                    'Issued Date', 'Issued Time', 'Branch Added', 'Issued By', 'Date Added', 'Commence Date', 'Policy Post',
                    'Agent Code', 'Contribution Account Agent Code', 'Sum Covered', 'cash_recieved', 'instrument_date', 'bank_code', 'bank_gl_code'];

        // Set header cells
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Populate data rows
        $rowNumber = 2;
        while ($row = mysqli_fetch_assoc($result)) {
            $sheet->setCellValue('A' . $rowNumber, $row['id']);
            $sheet->setCellValue('B' . $rowNumber, $row['prefix']);
            $sheet->setCellValue('C' . $rowNumber, $row['name']);
            $sheet->setCellValue('D' . $rowNumber, $row['reg_type']);
            $sheet->setCellValue('E' . $rowNumber, $row['reg_no']);
            $sheet->setCellValue('F' . $rowNumber, $row['mobile_number']);
            $sheet->setCellValue('G' . $rowNumber, $row['address_01']);
            $sheet->setCellValue('H' . $rowNumber, $row['address_02']);
            $sheet->setCellValue('I' . $rowNumber, $row['city_code']);
            $sheet->setCellValue('J' . $rowNumber, $row['product']);
            $sheet->setCellValue('K' . $rowNumber, $row['category']);
            $sheet->setCellValue('L' . $rowNumber, $row['cover_note_number']);
            $sheet->setCellValue('M' . $rowNumber, $row['manual_cn_number']);
            $sheet->setCellValue('N' . $rowNumber, $row['prod_code']);
            $sheet->setCellValue('O' . $rowNumber, $row['m_code']);
            $sheet->setCellValue('P' . $rowNumber, $row['usage_type']);
            $sheet->setCellValue('Q' . $rowNumber, $row['fuel_type']);
            $sheet->setCellValue('R' . $rowNumber, $row['engine_capacity']);
            $sheet->setCellValue('S' . $rowNumber, $row['registered_owner']);
            $sheet->setCellValue('T' . $rowNumber, $row['registration_number']);
            $sheet->setCellValue('U' . $rowNumber, $row['engine_number']);
            $sheet->setCellValue('V' . $rowNumber, $row['chassis_number']);
            $sheet->setCellValue('W' . $rowNumber, $row['engine_capacity']);
            $sheet->setCellValue('X' . $rowNumber, $row['seating_capacity']);
            $sheet->setCellValue('Y' . $rowNumber, $row['year_of_manufac']);
            $sheet->setCellValue('Z' . $rowNumber, $row['country_of_origin']);
            $sheet->setCellValue('AA' . $rowNumber, $row['receipt_number']);
            $sheet->setCellValue('AB' . $rowNumber, $row['valid_period']);
            $sheet->setCellValue('AC' . $rowNumber, $row['issued_date']);
            $sheet->setCellValue('AD' . $rowNumber, $row['issued_time']);
            $sheet->setCellValue('AE' . $rowNumber, $row['branch_added']);
            $sheet->setCellValue('AF' . $rowNumber, $row['issued_by']);
            $sheet->setCellValue('AG' . $rowNumber, $row['date_added']);
            $sheet->setCellValue('AH' . $rowNumber, $row['issued_date']);
            $sheet->setCellValue('AI' . $rowNumber, $row['policy_post']);
            $sheet->setCellValue('AJ' . $rowNumber, $row['agent_code']);
            $sheet->setCellValue('AK' . $rowNumber, $row['cont_ag_code']);
            $sheet->setCellValue('AL' . $rowNumber, $row['sum_covered']);
            $sheet->setCellValue('AM' . $rowNumber, $row['cash_recieved']);
$receiptDate = !empty($row['receipt_date']) && strtotime($row['receipt_date']) 
    ? date('d/m/Y', strtotime($row['receipt_date'])) 
    : ''; // Leave blank or set to 'N/A'

$sheet->setCellValue('AN' . $rowNumber, $receiptDate);

            $sheet->setCellValue('AO' . $rowNumber, $row['bank_code']);
            $sheet->setCellValue('AP' . $rowNumber, $row['bank_gl_code']);
            $rowNumber++;
        }

        // Close the database connection
        $con->close();

        // Output the Excel file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="report.xlsx"');
        header('Cache-Control: max-age=0');

        // Clear output buffer to prevent corrupt file
        if (ob_get_length() > 0) {
            ob_end_clean();
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
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
  <title>Amana | All Branch Report</title>
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

  <!-- Pagination -->
  
</head>

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
                <h3>All Branch Report  - (Third Party)</h3>
            </legend><br>
<!-- search form-->

    <form class="form-inline" method="POST" action="" style="width=110%;">
        <!-- Column 1 - Selection -->
        <?php 
        $sql = "SELECT * FROM tbl_branch ";
                        $result = $con->query($sql);
                        $product = array();
        ?>
        
        <div class="form-group mx-2">
            <label for="select1">Branch : &ensp;</label>
            <select class="form-control" id="select1" name="branch">
            <option value="">Select Branch</option>
            <?php
                while ($row = $result->fetch_assoc()) {
                $_id = $row['b_code'];
                $_name = $row['b_name'];
                echo "<option value='$_id'>$_name</option>";
            }
            ?>
            </select>
        </div>

        <?php 
        $sql = "SELECT * FROM tbl_product ";
                        $result = $con->query($sql);
                        $product = array();
        ?>
        <div class="form-group mx-2">
            <label for="select2">Product : &ensp;</label>
            <select class="form-control" id="select2" name="product">
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
        <button type="" class="btn btn-primary" name="export">Export</button>
        <!-- a href="./clients" class="btn btn-info">Reload</a-->
    </form> 
    <br><br>
<!-- end search form-->

<!-- Filter/Search Input -->
<!-- input type="text" class="form-control mb-3" id="searchInput" placeholder="Search" -->

<!-- Search Function -->
<?php 
      // require the database connection
      $product = "";
      $dateFrom = "";
      $dateTo = "";
      $startDate = date('Y-m-d', strtotime('-30 days'));
      $branchcode = "";

      // Check if the form is submitted
      if (isset($_POST['search'])) {
          // Sanitize and assign values from the form
          $branchcode = $con->real_escape_string($_POST['branch']);
          $product = $con->real_escape_string($_POST['product']);
          $dateFrom = $con->real_escape_string($_POST['dateFrom']);
          $dateTo = $con->real_escape_string($_POST['dateTo']);
      }

      $sql = "SELECT * FROM tbl_insurance";

      // Append WHERE clause based on form input
      if (!empty($branchcode) || !empty($product) || !empty($dateFrom) || !empty($dateTo)) {
          $sql .= " WHERE ";
          $conditions = [];

          if (!empty($branchcode)) {
            $conditions[] = "branch_added = '$branchcode'";
          }

          if (!empty($product)) {
            $conditions[] = "product = '$product'";
          }
          if (!empty($dateFrom)) {
              $conditions[] = "date_added >= '$dateFrom'";
          }

          if (!empty($dateTo)) {
              $conditions[] = "date_added <= '$dateTo'";
          }

          $sql .= " " . implode(" AND ", $conditions);
      } else {
          $sql = "SELECT * FROM tbl_insurance WHERE date_added >= '$startDate'";
      }

      $sql2 = $sql;
      $result = $con->query($sql);
      $result2 = $con->query($sql2);
      
     
      ?>

<div class="table-responsive">
<button onclick="exportTableToCSV('search_results.csv')" class="export-button">Excel</button>
        <table id="example" class="display expandable-table" style="width:100%">    
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Reg Type</th>
                <th>Reg No</th>
                <th>Address 1</th>
                <th>Address 2</th>
                <th>City</th>
                <th>Product</th>
                <th>Cover Note Number</th>
                <th>Manual Cover Note Number</th>
                <th>Receipt Number</th>
                <th>Model</th>
                <th>Usage Type</th>
                <th>Reg. Owner</th>
                <th>Reg. Number</th>
                <th>Engine Number</th>
                <th>Chassis Number</th>
                <th>Engine Capacity</th>
                <th>Period of Takaful (Insurance)</th>
                <th>Issued Branch</th>
                <th>Issued By</th>
                <th>Issued Date</th>
            </tr>
            </thead>
            <tbody>
              <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['reg_type'] . "</td>";
                echo "<td>" . $row['reg_no'] . "</td>";
                echo "<td>" . $row['address_01'] . "</td>";
                echo "<td>" . $row['address_02'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                echo "<td>" . $row['product'] . "</td>";
                echo "<td>" . $row['cover_note_number'] . "</td>";
                echo "<td>" . $row['manual_cn_number'] . "</td>";
                echo "<td>" . $row['receipt_number'] . "</td>";
                echo "<td>" . $row['make_model'] . "</td>";
                echo "<td>" . $row['usage_type'] . "</td>";
                echo "<td>" . $row['registered_owner'] . "</td>";
                echo "<td>" . $row['registration_number'] . "</td>";
                echo "<td>" . $row['engine_number'] . "</td>";
                echo "<td>" . $row['chassis_number'] . "</td>";
                echo "<td>" . $row['engine_capacity'] . "</td>";
                echo "<td>" . $row['valid_period'] . "</td>";

                // Retrieve branch name using a JOIN query
    $branchQuery = "SELECT b_name FROM tbl_branch WHERE b_code = '" . $row['branch_added'] . "'";
    $branchResult = mysqli_query($con, $branchQuery);

    if ($branchResult) {
        $branchRow = mysqli_fetch_assoc($branchResult);

        if ($branchRow) {
            echo "<td>" . $branchRow['b_name'] . "</td>";
        } else {
            echo "<td>Unknown Branch</td>"; // Handle cases where the branch is not found
        }
    } else {
        echo "<td>Error fetching branch</td>"; // Handle query execution error
    }
                echo "<td>" . $row['issued_by'] . "</td>";
                echo "<td>" . $row['date_added'] . "</td>";
                echo "</tr>";

            }
            ?>
            </tbody>
        </table> 
        
        <!-- Export Table -->
        <table id="export_table" class="display expandable-table" style="width:100%; display:none">    
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Reg Type</th>
                <th>Reg No</th>
                <th>Mobile Number</th>
                <th>Address 1</th>
                <th>Address 2</th>
                <th>City</th>
                <th>Product</th>
                <th>Cover Note Number</th>
                <th>Manual Cover Note Number</th>
                <th>Receipt Number</th>
                <th>Model</th>
                <th>Manufacture Year</th>
                <th>Usage Type</th>
                <th>Fuel Type</th>
                <th>Reg. Owner</th>
                <th>Reg. Number</th>
                <th>Engine Number</th>
                <th>Chassis Number</th>
                <th>Engine Capacity</th>
                <th>Period of Takaful (Insurance)</th>
                <th>Issued Branch</th>
                <th>Issued Date</th>
                <th>Issued Time</th>
                <th>Issued By</th>
                <th>Receipt No</th>
                <th>Cash Received</th>
                <th>Agent Code</th>
                <th>Date Added</th>
            </tr>
            </thead>
            <tbody>
              <?php
            while ($row = mysqli_fetch_assoc($result2)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['reg_type'] . "</td>";
                echo "<td>" . $row['reg_no'] . "</td>";
                echo "<td>" . $row['mobile_number'] . "</td>";
                echo "<td>" . $row['address_01'] . "</td>";
                echo "<td>" . $row['address_02'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                 // Retrieve product code
                $prodQuery = "SELECT prod_code FROM tbl_product WHERE name = '" . $row['product'] . "'";
                $prodResult = mysqli_query($con, $prodQuery);

                if ($prodResult) {
                    $prodRow = mysqli_fetch_assoc($prodResult);

                    if ($prodRow) {
                        echo "<td>" . $prodRow['prod_code'] . "</td>";
                    } else {
                        echo "<td>Unknown Product</td>";
                    }
                } else {
                    echo "<td>Error fetching branch</td>"; 
                }
                echo "<td>" . $row['cover_note_number'] . "</td>";
                echo "<td>" . $row['manual_cn_number'] . "</td>";
                echo "<td>" . $row['receipt_number'] . "</td>";
                echo "<td>" . $row['make_code'] . "</td>";
                echo "<td>" . $row['year_of_manufac'] . "</td>";
                echo "<td>" . $row['usage_type'] . "</td>";
                echo "<td>" . $row['fuel_type'] . "</td>";
                echo "<td>" . $row['registered_owner'] . "</td>";
                echo "<td>" . $row['registration_number'] . "</td>";
                echo "<td>" . $row['engine_number'] . "</td>";
                echo "<td>" . $row['chassis_number'] . "</td>";
                echo "<td>" . $row['engine_capacity'] . "</td>";
                echo "<td>" . $row['valid_period'] . "</td>";
                echo "<td>" . $row['branch_added'] . "</td>";
                echo "<td>" . $row['issued_date'] . "</td>";
                echo "<td>" . $row['issued_time'] . "</td>";
                echo "<td>" . $row['issued_by'] . "</td>";
                echo "<td>" . $row['receipt_number'] . "</td>";
                echo "<td>" . $row['cash_recieved'] . "</td>";
                echo "<td>" . $row['agent_code'] . "</td>";
                echo "<td>" . $row['date_added'] . "</td>";
                echo "</tr>";
            }
            $con->close();
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
    
//Export Function
function exportTableToCSV(filename) {
const csv = [];
const rows = document.querySelectorAll("#export_table tr");

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
.export-button {
    display: inline-block;
    background-color: #81bd43;
    margin-top: 10px;
    margin-bottom: 10px;
    border-radius: 0px;
    padding-top: 2px;
    padding-left: 10px;
    padding-right: 10px;
    padding-bottom: 2px;
    }
    button:hover {
    background-color: #81bd43;
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