<?php
// Require the database connection
$product = "";
$branch_code = "";
$datefrom = "";
$dateto = "";
$resultFetch = NULL;

if (isset($_POST['search'])) {
    $product = $con->real_escape_string($_POST['product']);
    $branch_code = $con->real_escape_string($_POST['branch_code']);
    $datefrom = $con->real_escape_string($_POST['datefrom']);
    $dateto = $con->real_escape_string($_POST['dateto']);
}

$sqlFetch = "SELECT i.id, i.cover_note_number, i.date_added, i.branch_added, br.b_name
             FROM tbl_insurance i 
             LEFT JOIN tbl_issued_cards bps 
             ON i.cover_note_number = bps.cn_no 
             JOIN tbl_branch br
             ON i.branch_added = br.b_code
             WHERE bps.cn_no IS NULL";
$conditions = [];

if (!empty($product)) {
    $conditions[] = "product = '$product'";
}
if (!empty($datefrom)) {
    $conditions[] = "date_added >= '$datefrom'";
}
if (!empty($dateto)) {
    $conditions[] = "date_added <= '$dateto'";
}
if (!empty($branch_code)) {
    $conditions[] = "branch_added = '$branch_code'";
}

if (!empty($conditions)) {
    $sqlFetch .= " WHERE " . implode(" AND ", $conditions);
}

if (isset($_POST['search'])) {
    $resultFetch = $con->query($sqlFetch);

    if (!$resultFetch) {
        die("Error in query: " . $con->error);
    }
}

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import'])) {

    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == 0) {
        $fileTmpPath = $_FILES['excelFile']['tmp_name'];
        $fileName = $_FILES['excelFile']['name'];

        if (file_exists($fileTmpPath)) {
            echo "File uploaded successfully: " . $fileName;
        } else {
            echo "File upload failed.";
            exit;
        }
        
        $spreadsheet = IOFactory::load($fileTmpPath);
        $sheet = $spreadsheet->getActiveSheet();
        $policyNumbers = [];
        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            
            foreach ($cellIterator as $cell) {
                if ($cell->getColumn() == 'A') {
                    $policyNumbers[] = $cell->getValue(); 
                }
            }
        }

        // echo "<pre>";
        // print_r($policyNumbers);
        // echo "</pre>";

        $policyNumbers = array_filter($policyNumbers);
        
        if (!empty($policyNumbers)) {
            $escapedPolicyNumbers = array_map(function ($policy) use ($con) {
                return "'" . $con->real_escape_string($policy) . "'";
            }, $policyNumbers);

            $sqlFetch = "SELECT i.id, i.cover_note_number, i.date_added, i.branch_added, br.b_name 
                         FROM tbl_insurance i 
                         LEFT JOIN tbl_issued_cards  bps 
                         ON i.cover_note_number = bps.cn_no 
                        JOIN tbl_branch br
                        ON i.branch_added = br.b_code
                         WHERE i.cover_note_number IN (" . implode(",", $escapedPolicyNumbers) . ")
                         AND bps.cn_no IS NULL";
                         
            $resultFetch = $con->query($sqlFetch);

        } else {
            echo "No valid policy numbers found in the Excel file.";
        }
    } else {
        echo "File upload failed.";
    }
}
?>
<!-- Search Function -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
      <!-- Code here -->
      <div class="container mt-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Bulk Card Printing Option</h3>
                    </div>
                    <div class="card-body">
                        <form id="grantAccessForm" action="" method="POST">

                        <div class="dropdown_flex">
                            <div class="mb-3">
                            <!-- <label for="userSelect" class="form-label">Select User</label> -->
                            <select class="form-select" id="userSelect" name="branch_code">
                            <option value="">All Branch</option>
                            <?php
                            $sqlbranch = "SELECT b_name, b_code FROM tbl_branch";
                            $resultbranch = $con->query($sqlbranch);
                                while ($row_branch = $resultbranch->fetch_assoc()) {
                                    $b_code = $row_branch['b_code'];
                                    $b_name = $row_branch['b_name'];
                                    echo "<option value='$b_code'>$b_name</option>";
                                }
                            ?>
                            </select>
                            </div>

                            <div class="mb-3">
                            <!-- <label for="userSelect" class="form-label">Select User</label> -->
                            <select class="form-select" id="Product" name="product">
                            <option value="">All Product</option>
                            <?php
                            $sqlproduct = "SELECT prod_code, name FROM tbl_product";
                            $resultproduct = $con->query($sqlproduct);
                                while ($row_product = $resultproduct->fetch_assoc()) {
                                    $P_code = $row_product['b_code'];
                                    $p_name = $row_product['name'];
                                    echo "<option value='$p_name'>$p_name</option>";
                                }
                            ?>
                            </select>
                            </div>

                            <div class="mb-3">
                                <label for="userSelect" class="form-label">From Date</label>
                                <input class="form-select" type="date" id="datefrom" name="datefrom">
                            </div>

                            <div class="mb-3">
                                <label for="userSelect" class="form-label">To Date</label>
                                <input class="form-select" type="date" id="dateto" name="dateto">
                            </div>
                            <div class="text-left">
                                <button type="submit" name="search" class="btn btn-custom">Search</button>
                            </div>
                            <div class="text-left">
                                <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                    <i class="fas fa-upload"></i>
                                </button>
                            </div>
                        </div>
                        </form>
                        
                        <!-- Modal Structure -->
                        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="uploadModalLabel">Upload Excel File</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form to upload Excel file -->
                                        <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="excelFile" class="form-label">Upload Excel File</label>
                                                <input type="file" class="form-control" id="excelFile" name="excelFile" accept=".xls,.xlsx" required>
                                            </div>
                                            <button type="submit" name="import" class="btn btn-custom">Import</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- data table -->
                        <form id="grantAccessForm" action="Views/bulk_prints/bulk_card.php" method="POST" target="_blank">

                        <div class="mb-3">
                            <div class="text-end mb-2">
                                <button type="button" id="selectAllBtn" class="btn btn-sm btn-secondary">Select All</button>
                            </div>
                            <div class="menu-list">
                                <table id="menuTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Policy No</th>
                                            <th>Branch</th>
                                            <th>Issued Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="menuTableBody">
                                    <?php
                                    if ($resultFetch && $resultFetch->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($resultFetch)) {
                                            echo "<tr>";
                                            echo '<td><input class="form-check-input menu-checkbox" type="checkbox" name="cover_note_numbers[]" value="' . $row['cover_note_number'] . '"></td>';
                                            echo "<td>" . $row['cover_note_number'] . "</td>";
                                            echo "<td>" . $row['b_name'] . "</td>";
                                            echo "<td>" . $row['date_added'] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else if ($resultFetch && $resultFetch->num_rows == 0) {
                                        echo "<tr><td colspan='3'>No records found.</td></tr>";
                                    } else {
                                        echo "<tr><td colspan='3'>No search results.</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            <div class="text-left">
                                <button type="submit" class="btn btn-custom">Print</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- JS includes -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
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
</script>

      <!-- Code here -->

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

    </style>