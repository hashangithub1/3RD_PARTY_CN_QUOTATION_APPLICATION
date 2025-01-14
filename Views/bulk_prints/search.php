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

$sqlFetch = "SELECT id, cover_note_number, date_added FROM tbl_insurance";
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

            $sqlFetch = "SELECT id, cover_note_number, date_added FROM tbl_insurance WHERE cover_note_number IN (" . implode(",", $escapedPolicyNumbers) . ")";
            
            $resultFetch = $con->query($sqlFetch);

        } else {
            echo "No valid policy numbers found in the Excel file.";
        }
    } else {
        echo "File upload failed.";
    }
}
?>