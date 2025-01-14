<?php
require 'phpoffice/vendor/autoload.php'; // Include PhpSpreadsheet autoload file

use PhpOffice\PhpSpreadsheet\IOFactory;

// Load the Excel file
$spreadsheet = IOFactory::load('test.xlsx');

// Get the active sheet
$sheet = $spreadsheet->getActiveSheet();

// Get the highest row and column in the sheet
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

// Generate HTML table from Excel data
$html = '<table border="1">';
for ($row = 1; $row <= $highestRow; ++$row) {
    $html .= '<tr>';
    for ($col = 'A'; $col <= $highestColumn; ++$col) {
        $cell = $sheet->getCell($col.$row);
        $html .= '<td><input type="text" name="cell['.$row.']['.$col.']" value="'.$cell->getValue().'"></td>';
    }
    $html .= '</tr>';
}
$html .= '</table>';

// Output HTML table
echo $html;
?>
