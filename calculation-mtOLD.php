<?php session_start();
include_once('includes/config.php');

$SelectChannelCode = !empty($_SESSION['selected_channel_code']) ? $_SESSION['selected_channel_code'] : null;    
$SelectCompanyCode = !empty($_SESSION['companycode_form']) ? $_SESSION['companycode_form'] : null;
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data with checks for undefined keys
    $companyProduct         = isset($_POST['companyProduct']) ? $_POST['companyProduct'] : null;
    $product                = isset($_POST['product']) ? $_POST['product'] : null;
    $datefrom               = isset($_POST['datefrom']) ? $_POST['datefrom'] : null;
    $dateto                 = isset($_POST['dateto']) ? $_POST['dateto'] : null;
    $sumInsured             = isset($_POST['sum-insured']) ? $_POST['sum-insured'] : null;
    $clientName             = isset($_POST['client_name']) ? $_POST['client_name'] : null;
    $clientAddress          = isset($_POST['client_address']) ? $_POST['client_address'] : null;
    $mobileNumber           = isset($_POST['mobile_number']) ? $_POST['mobile_number'] : null;
    $emailAddress           = isset($_POST['email_address']) ? $_POST['email_address'] : null;
    $makeModel              = isset($_POST['make-model']) ? $_POST['make-model'] : null;
    $EngineCapacity         = isset($_POST['eng_cap']) ? $_POST['eng_cap'] : null;
    $fuelType               = isset($_POST['fuel_type']) ? $_POST['fuel_type'] : null;
    $registrationStatus     = isset($_POST['vehi_registration']) ? $_POST['vehi_registration'] : null;
    $regNo                  = isset($_POST['reg_no']) ? $_POST['reg_no'] : null;
    $usage                  = isset($_POST['usage']) ? $_POST['usage'] : null;
    $seatingCapacity        = isset($_POST['seating_capacity']) ? $_POST['seating_capacity'] : null;
    $manufactureYear        = isset($_POST['manf_year']) ? $_POST['manf_year'] : null;
    $businessChannel        = isset($_POST['buis_channel']) ? $_POST['buis_channel'] : null;
    //echo $businessChannel;
    //Sum Insured Without RS
    $coverWithoutRs = str_replace(array('Rs.', ','), '', $sumInsured);
    $sum_ins = (int)$coverWithoutRs;  // For integer

    if (empty($EngineCapacity)){

        if ($sum_ins >= 0 && $sum_ins <= 9500000) {
            $slab = '0000000-9500000';
        } elseif ($sum_ins > 9500000 && $sum_ins <= 10000000) {
            $slab = '9500000-10000000';
        } elseif ($sum_ins > 10000000 && $sum_ins <= 25000000) {
            $slab = '10000000-25000000';
        } elseif ($sum_ins > 25000000) {
            $slab = '25000000-above';
        } else {
           // echo "Condition not met";
            $basic_rate = 0.0;
        }
        
        if (isset($slab)) {
            // Debug: print the query and slab value
           // echo "Slab: $slab<br>";
            
            $sql = "SELECT rate FROM tbl_basicrate_mt WHERE slab = '$slab' AND vehi_type = '$product'";
            //echo "SQL Query: $sql<br>"; // Print the SQL query for verification
            
            $result = $con->query($sql);
        
            if ($result && $row = $result->fetch_assoc()) {
                $basic_rate = $row['rate'] / 100;
                //echo "Basic Rate: $basic_rate<br>";
                //echo "Sum: $sum_ins<br>"; // Print the basic rate for debugging
            } else {
                //echo "Error executing query: " . mysqli_error($con);
            }
        }

    } else
    {
        if ($EngineCapacity == 'A_250') {
            $eng_cap = $EngineCapacity;
        } elseif ($EngineCapacity == 'B_250') {
            $eng_cap = $EngineCapacity;
        } else {
           // echo "Condition not met";
            $basic_rate = 0.0;
        }
        
        if (isset($eng_cap)) {
            
            $sql = "SELECT rate FROM tbl_basicrate_mt WHERE engine_capacity = '$eng_cap' AND vehi_type = '$product'";
           // echo "SQL Query: $sql<br>"; // Print the SQL query for verification
            
            $result = $con->query($sql);
        
            if ($result && $row = $result->fetch_assoc()) {
                $basic_rate = $row['rate'] / 100;
              //  echo "Basic Rate: $basic_rate<br>";
              //  echo "Sum: $sum_ins<br>"; // Print the basic rate for debugging
            } else {
              //  echo "Error executing query: " . mysqli_error($con);
            }
        }
    }

    // Getting Rate for calculating Premium based on sum insured and make code
            function getPriceSlab($sum_ins) {
                if ($sum_ins < 5000000) {
                    return 'Below 5M';
                } elseif ($sum_ins < 6000000) {
                    return '5M to 6M';
                } elseif ($sum_ins < 7000000) {
                    return '6M to 7M';
                } elseif ($sum_ins < 8000000) {
                    return '7M to 8M';
                } elseif ($sum_ins < 9000000) {
                    return '8M to 9M';
                } elseif ($sum_ins < 10000000) {
                    return '9M to 10M';
                } elseif ($sum_ins < 11000000) {
                    return '10M to 11M';
                } elseif ($sum_ins < 12000000) {
                    return '11M to 12M';
                } elseif ($sum_ins < 13000000) {
                    return '12M to 13M';
                } elseif ($sum_ins < 14000000) {
                    return '13M to 14M';
                } elseif ($sum_ins < 15000000) {
                    return '14M to 15M';
                } elseif ($sum_ins < 16000000) {
                    return '15M to 16M';
                } elseif ($sum_ins <= 20000000) {
                    return '16M to 20M';
                } else {
                    return '20M & Above';
                }
            }
        // Get price slab
        $priceSlab = getPriceSlab($sum_ins);
    
        // First, find the category for the given make_code
        if ($SelectCompanyCode === "lb001") {
            $rate_table = "vehicle_rates_leasing";
        } elseif ($SelectCompanyCode === "vb002") {
            $rate_table = "vehicle_rates_leasing";
        } elseif ($SelectCompanyCode === "afl003") {
            $rate_table = "vehicle_rates_leasing_other";
        } elseif ($SelectCompanyCode === "ccl004") {
            $rate_table = "vehicle_rates_leasing_other";
        } elseif ($SelectCompanyCode === "of005") {
            $rate_table = "vehicle_rates_leasing_other";
        } elseif ($SelectCompanyCode === "amn-001") {
            $rate_table = "vehicle_rates_direct";
        } elseif ($SelectCompanyCode === "ab006") {
            $rate_table = "vehicle_rates_leasing_amanabank";
        } elseif ($SelectCompanyCode === "mi007") {
            $rate_table = "vehicle_rates_leasing";
        } elseif ($SelectCompanyCode === "otr008") {
            $rate_table = "vehicle_rates_leasing_other";
        } elseif ($SelectCompanyCode === "otr008-1") {
            $rate_table = "vehicle_rates_leasing_other";
        } elseif ($SelectCompanyCode === "hnb009") {
            $rate_table = "vehicle_rates_leasing_other";
        } elseif ($SelectCompanyCode === "ctlf010") {
            $rate_table = "vehicle_rates_leasing_other";
        } elseif ($SelectCompanyCode === "cbcf011") {
            $rate_table = "vehicle_rates_leasing_other";
        } else {
            header("Location: motor-quotation.php");
        }

        $categoryQuery = "SELECT category_id FROM vehicle_make_category WHERE make_code = ?";
        if ($stmt = mysqli_prepare($con, $categoryQuery)) {
            mysqli_stmt_bind_param($stmt, 's', $makeModel);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $categoryId);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
    
            if ($categoryId) {
                // Query to fetch rate based on category and price slab
                $rateQuery = "SELECT rate FROM $rate_table WHERE category_id = ? AND price_slab = ?";
                if ($stmt = mysqli_prepare($con, $rateQuery)) {
                    mysqli_stmt_bind_param($stmt, 'is', $categoryId, $priceSlab);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $rate);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
    
                    if ($rate !== null) {
                       // echo "The rate for make code $makeCode with sum insured $sumInsured is $rate.";
                        $vehi_rate = $rate / 100;
                    } else {
                        echo "No rate found for the given make code and sum insured.";
                        $vehi_rate = 0.0;
                    }
                }
            } else {
               // echo "No category found for the given make code.";
               $vehi_rate = 0.0;
            }
        } else {
           // echo "Failed to prepare the query.";
           $vehi_rate = 0.0;
        }

    // Store session data
    $_SESSION['companyProduct']         =       $companyProduct     ;
    $_SESSION['product']                =       $product            ;
    $_SESSION['datefrom']               =       $datefrom           ;
    $_SESSION['dateto']                 =       $dateto             ;
    $_SESSION['sumInsured']             =       $sumInsured         ;
    $_SESSION['clientName']             =       $clientName         ;
    $_SESSION['clientAddress']          =       $clientAddress      ;
    $_SESSION['mobile_number']          =       $mobileNumber       ;
    $_SESSION['email_address']          =       $emailAddress       ;
    $_SESSION['makeModel']              =       $makeModel          ;

    //search makemodel name form DB
    if(!empty($product)){
        $sqlmakemodel = "SELECT pmk_desc FROM tbl_makemodel_mt WHERE pmk_make_code = $makeModel";
        $resultMK = $con->query($sqlmakemodel);
    
        while ($rowMK = $resultMK->fetch_assoc()) {
            $mk_desc = $rowMK['pmk_desc'];
        }
    }
    
    $_SESSION['makeModelDesc']          =       $mk_desc            ;
    $_SESSION['fuelType']               =       $fuelType           ;

    //fuelType with name
    if($fuelType=="P")
    {
        $fuelTypeName = "Petrol";
    }
    elseif($fuelType == "D")
    {
        $fuelTypeName = "Diesel";
    }
    elseif($fuelType == "H")
    {
        $fuelTypeName = "Hybrid";
    }
    elseif($fuelType == "E")
    {
        $fuelTypeName = "Electric";
    }
    else
    {
        $fuelTypeName = NULL;
    }

    $_SESSION['fuelTypeName']           =       $fuelTypeName       ;
    $_SESSION['registrationStatus']     =       $registrationStatus ;
    $_SESSION['regNo']                  =       $regNo              ;
    $_SESSION['usage']                  =       $usage              ;
    $_SESSION['seatingCapacity']        =       $seatingCapacity    ;
    $_SESSION['EngineCapacity']         =       $EngineCapacity     ;
    $_SESSION['manufactureYear']        =       $manufactureYear    ;
    $_SESSION['vehicleRate']            =       $vehi_rate          ;
    $_SESSION['basicRate']              =       $basic_rate         ;


if(!empty($manufactureYear))
{
    $currentYear = date("Y"); 
    $vehicleAge = $currentYear - $manufactureYear;
    $Age_Exces = 0;
    if ($vehicleAge >= 20 && $vehicleAge <= 30) {
        $Age_Exces += 5000; 
    }

    $_SESSION['Age_Exces']              =       $Age_Exces         ;
}


    //redirect to the default page
    //Notification System
    $currentTime = date('Y-m-d H:i:s');
    $newNotification = [
        'message' => 'Quotation Form Generated', 
        'time' => $currentTime,
        'is_read' => false
    ];
    $_SESSION['notifications'][] = $newNotification;
    //End

    //page reload
    $_SESSION['reload_count'] = 0;
    header("Location: motor-quotation.php");

    // Echo the session variables
    // echo 'Channel code: ' . $SelectChannelCode . '<br>';
    // echo 'Product: ' . $_SESSION['product'] . '<br>';
    // echo 'Date From: ' . $_SESSION['datefrom'] . '<br>';
    // echo 'Date To: ' . $_SESSION['dateto'] . '<br>';
    // echo 'Sum Insured: ' . $_SESSION['sumInsured'] . '<br>';
    // echo 'Client Name: ' . $_SESSION['clientName'] . '<br>';
    // echo 'Client Address: ' . $_SESSION['clientAddress'] . '<br>';
    // echo 'Mobile Number: ' . $_SESSION['mobile_number'] . '<br>';
    // echo 'Email Address: ' . $_SESSION['email_address'] . '<br>';
    // echo 'Make Model: ' . $_SESSION['makeModel'] . '<br>';
    // echo 'Fuel Type: ' . $_SESSION['fuelTypeName'] . '<br>';
    // echo 'Registration Status: ' . $_SESSION['registrationStatus'] . '<br>';
    // echo 'Registration Number: ' . $_SESSION['regNo'] . '<br>';
    // echo 'Usage: ' . $_SESSION['usage'] . '<br>';
    // echo 'Seating Capacity: ' . $_SESSION['seatingCapacity'] . '<br>';
    // echo 'Manufacture Year: ' . $_SESSION['manufactureYear'] . '<br>';
    // echo 'Vehicle Rate: ' . $_SESSION['vehicleRate'] . '<br>';
    // echo 'Basic Rate: ' . $_SESSION['basicRate'] . '<br>';
    
    exit();

} else {
    echo "Error: Form not submitted.";
}
?> 
