<?php               
$b_code = $_SESSION['branch'];
//$startDate = date('Y-m-d', strtotime('-30 days'));

$sql = "
    SELECT * FROM tbl_insurance WHERE product = 'Motor Car' AND branch_added = '$b_code' ;
    SELECT * FROM tbl_insurance WHERE product = 'Motor Cycle' AND branch_added = '$b_code';
    SELECT * FROM tbl_insurance WHERE product = 'Hand Tractor' AND branch_added = '$b_code';
    SELECT * FROM tbl_insurance WHERE product = 'Tractor' AND branch_added = '$b_code';
    SELECT * FROM tbl_insurance WHERE product = 'Three Wheeler' AND branch_added = '$b_code';
    SELECT * FROM tbl_insurance WHERE product = 'Dual Purpose' AND branch_added = '$b_code';
    SELECT * FROM tbl_insurance WHERE product = 'Lorry' AND branch_added = '$b_code';

";

// Execute the multi-query
$rn = $con->multi_query($sql);

// Check if the first query is successful
if ($rn) {
    // Initialize variables to store row counts


    // Initialize variable to track query number
    $queryNumber = 1;

    // Fetch and store the results
    do {
        if ($result = $con->store_result()) {
            switch ($queryNumber) {
                case 1:
                    $num_rows_motorcar = mysqli_num_rows($result);
                    break;
                case 2:
                    $num_rows_motorcycle = mysqli_num_rows($result);
                    break;
                case 3:
                    $num_rows_HandTractor = mysqli_num_rows($result);
                    break;
                case 4:
                    $num_rows_Tractor = mysqli_num_rows($result);
                    break;
                case 5:
                    $num_rows_ThreeWheeler = mysqli_num_rows($result);
                    break;
                case 6:
                    $num_rows_DualPurpose = mysqli_num_rows($result);
                    break;
                case 7:
                    $num_rows_Lorry = mysqli_num_rows($result);
                    break;
                        
            }

            $result->free();
        }

        $queryNumber++;
    } while ($con->more_results() && $con->next_result());
} else {
    // Handle the case where the multi-query fails
    echo "Error executing multi-query: " . $con->error;
}

//////echo $num_rows_motorcar;
//echo $num_rows_motorcycle;
?>
