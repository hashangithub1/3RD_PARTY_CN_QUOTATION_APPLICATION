<?php session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include_once('includes/config.php');
$SelectChannelCode = "L/B";
$SelectCompanyCode = "lb001";
$dis_price_table = NULL;
$_ncb_price = 0;
// Check if the form was submitted

// Get JSON input
try {
    // Validate DB connection
    if (!$con) {
        throw new Exception("Database connection failed.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        $requiredFields = ['product_type', 'make_model', 'fuel_type', 'registration_number', 'usage', 'seating_capacity', 'year_of_manufacture', 'sum_insured'];
        foreach ($requiredFields as $field) {
            if (!isset($input[$field]) || empty($input[$field])) {
                throw new Exception("Missing or empty field: $field");
            }
        }

  /// POST DATA
  $productType = $input['product_type'];
  $makeModel = $input['make_model'];
  $fuelType = $input['fuel_type'];
  $registrationNumber = $input['registration_number'];
  $usage = $input['usage'];
  $seatingCapacity = $input['seating_capacity'];
  $yearOfManufacture = $input['year_of_manufacture'];
  $sumInsured = $input['sum_insured'];
  ////
  
      /////////////  Premium calculation code //////////////////
      // Retrieve form data with checks for undefined keys
    $companyProduct         = "V001";
    $product                = "V001";
    $datefrom               = "2024-12-02";
    $dateto                 = "2025-12-01";
    $sumInsured             = $sumInsured;
    $clientName             = "Test User";
    $clientAddress          = "test 13/test";
    $mobileNumber           = "0771510041";
    $emailAddress           = "test@email.com";
    $makeModel              = "02949";
    $EngineCapacity         = null;
    $fuelType               = $fuelType;
    $registrationStatus     = "registered";
    $regNo                  = $registrationNumber;
    $usage                  = $usage;
    $seatingCapacity        = $seatingCapacity;
    $manufactureYear        = $yearOfManufacture;
    $businessChannel        = "L/B";
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


/////////////////////////////////////////////////////////////////////////////////
        // Getting Discount Price from table "vehicle_price_discount"
        function getPricediscountSlab($sum_ins) {
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
        $priceSlab = getPricediscountSlab($sum_ins);

         // First, find the category for the given make_code
         if ($SelectCompanyCode === "afl003") {
            $dis_price_table = "vehicle_price_discount";
        } elseif ($SelectCompanyCode === "ccl004") {
            $dis_price_table = "vehicle_price_discount";
        } elseif ($SelectCompanyCode === "of005") {
            $dis_price_table = "vehicle_price_discount";
        } elseif ($SelectCompanyCode === "otr008") {
            $dis_price_table = "vehicle_price_discount";
        } elseif ($SelectCompanyCode === "otr008-1") {
            $dis_price_table = "vehicle_price_discount";
        } elseif ($SelectCompanyCode === "hnb009") {
            $dis_price_table = "vehicle_price_discount";
        } elseif ($SelectCompanyCode === "ctlf010") {
            $dis_price_table = "vehicle_price_discount";
        } elseif ($SelectCompanyCode === "cbcf011") {
            $dis_price_table = "vehicle_price_discount";
        } else {
             $amount = 0.0;
        }
    
        if ($dis_price_table !== null){
        $categoryQuery = "SELECT category_id FROM vehicle_make_category WHERE make_code = ?";
        if ($stmt = mysqli_prepare($con, $categoryQuery)) {
        mysqli_stmt_bind_param($stmt, 's', $makeModel);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $categoryId);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        
        if ($categoryId) {
            // Query to fetch rate based on category and price slab
            $rateQuery = "SELECT amount FROM $dis_price_table WHERE category_id = ? AND price_slab = ?";
            if ($stmt = mysqli_prepare($con, $rateQuery)) {
                mysqli_stmt_bind_param($stmt, 'is', $categoryId, $priceSlab);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $amount);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
        
                if ($amount !== null) {
                // echo "The rate for make code $makeCode with sum insured $sumInsured is $rate.";
                    $amount = $amount;
                } else {
                    //echo "No amount found for the given make code and sum insured.";
                    $amount = 0.0;
                }
            }
        } else {
        // echo "No category found for the given make code.";
        $amount = 0.0;
        }
        } else {
        // echo "Failed to prepare the query.";
        $amount = 0.0;
        }
    }
/////////////////////////////////////////////////////////////////////////////////

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
    $_SESSION['amount']                 =       $amount             ;

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
    //header("Location: motor-quotation.php");
    
    ////////////////////////////////////////////////////////////////////////////////////////
    // sql query covers
    // dataset for calculation form code
$prod_code = $product;
$companyProductCode = $companyProduct;
$companycode_form = $SelectCompanyCode;
$seatingCapacity = $seatingCapacity;

if ($companycode_form === null) {
    // Queries for standard covers between NCB and MR
    $sqlTop = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
        pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
        pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
        pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
        FROM tbl_product_cover_mt pc
        JOIN tbl_covers_mt cv
        ON pc.cover_code = cv.cover_code
        WHERE pc.prod_code = '$prod_code'
        AND pc.cover_cal_area = 'T'
        AND pc.remark = 'S'
        AND pc.cover_code NOT IN ('cov-023', 'cov-024' , 'cov-025', 'cov-027', 'cov-028', 'cov-026', 'cov-048', 'cov-049')
        ORDER BY pc.calc_seq;
    ";
    $result_prcTop = $con->query($sqlTop);

    $sqlBottum = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
        pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
        pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
        pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
        FROM tbl_product_cover_mt pc
        JOIN tbl_covers_mt cv
        ON pc.cover_code = cv.cover_code
        WHERE pc.prod_code = '$prod_code'
        AND pc.cover_cal_area = 'B'
        AND pc.remark = 'S'
        AND pc.cover_code NOT IN ('cov-023', 'cov-024', 'cov-025','cov-028', 'cov-027', 'cov-026', 'cov-048')
        ORDER BY pc.calc_seq;
    ";
    $result_prcBottom = $con->query($sqlBottum);

    $sqlBottumAdminCharges = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
        pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
        pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
        pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
        FROM tbl_product_cover_mt pc
        JOIN tbl_covers_mt cv
        ON pc.cover_code = cv.cover_code
        WHERE pc.prod_code = '$prod_code'
        AND pc.cover_code IN ('cov-023', 'cov-024', 'cov-025', 'cov-028', 'cov-048')
        AND pc.cover_cal_area = 'B'
        AND pc.remark = 'S'
        ORDER BY pc.calc_seq;
    ";
    $result_prcBottom_ADC = $con->query($sqlBottumAdminCharges);

    $sqlBottumOtherCharges = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
        pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
        pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
        pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
        FROM tbl_product_cover_mt pc
        JOIN tbl_covers_mt cv
        ON pc.cover_code = cv.cover_code
        WHERE pc.prod_code = '$prod_code'
        AND pc.cover_code IN ('cov-026')
        AND pc.cover_cal_area = 'B'
        AND pc.remark = 'S'
        ORDER BY pc.calc_seq;
    ";
    $result_prcBottom_ADCO = $con->query($sqlBottumOtherCharges);

    $sqlBottumOtherCharges = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
        pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
        pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
        pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
        FROM tbl_product_cover_mt pc
        JOIN tbl_covers_mt cv
        ON pc.cover_code = cv.cover_code
        WHERE pc.prod_code = '$prod_code'
        AND pc.cover_code IN ('cov-027')
        AND pc.cover_cal_area = 'B'
        AND pc.remark = 'S'
        ORDER BY pc.calc_seq;
    ";
    $result_prcBottom_ADCO1 = $con->query($sqlBottumOtherCharges);

} else {
    // Queries for package covers between NCB and MR
    $sqlTop = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
        pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
        pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
        pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
        FROM tbl_product_cover_mt pc
        JOIN tbl_covers_mt cv
        ON pc.cover_code = cv.cover_code
        WHERE pc.prod_code = '$prod_code'
        AND pc.comp_code = '$companycode_form'
        AND pc.cover_cal_area = 'T'
        AND pc.remark = 'P'
        AND pc.cover_code NOT IN ('cov-023', 'cov-024', 'cov-025', 'cov-028', 'cov-027', 'cov-026', 'cov-048', 'cov-049')
        ORDER BY pc.calc_seq;
    ";
    $result_prcTop = $con->query($sqlTop);

    $sqlBottum = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
        pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
        pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
        pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
        FROM tbl_product_cover_mt pc
        JOIN tbl_covers_mt cv
        ON pc.cover_code = cv.cover_code
        WHERE pc.prod_code = '$prod_code'
        AND pc.comp_code = '$companycode_form'
        AND pc.cover_cal_area = 'B'
        AND pc.remark = 'P'
        AND pc.cover_code IN ('cov-029','cov-030','cov-031','cov-032','cov-021','cov-022')
        ORDER BY pc.calc_seq;
    ";
    $result_prcBottom_1 = $con->query($sqlBottum);

    $sqlBottum_1 = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
    pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
    pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
    pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
    FROM tbl_product_cover_mt pc
    JOIN tbl_covers_mt cv
    ON pc.cover_code = cv.cover_code
    WHERE pc.prod_code = '$prod_code'
    AND pc.comp_code = '$companycode_form'
    AND pc.cover_cal_area = 'B'
    AND pc.remark = 'P'
    AND pc.cover_code NOT IN ('cov-023', 'cov-024', 'cov-025', 'cov-028', 'cov-027', 'cov-026', 'cov-048','cov-029','cov-030','cov-031','cov-032', 'cov-049', 'cov-021','cov-022')
    ORDER BY pc.calc_seq;
";
$result_prcBottom_2 = $con->query($sqlBottum_1);

    $sqlBottumAdminCharges = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
        pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
        pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
        pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
        FROM tbl_product_cover_mt pc
        JOIN tbl_covers_mt cv
        ON pc.cover_code = cv.cover_code
        WHERE pc.prod_code = '$prod_code'
        AND pc.comp_code = '$companycode_form'
        AND pc.cover_code IN ('cov-023', 'cov-024', 'cov-025', 'cov-028', 'cov-048', 'cov-049')
        AND pc.cover_cal_area = 'B'
        AND pc.remark = 'P'
        ORDER BY pc.calc_seq;
    ";
    $result_prcBottom_ADC = $con->query($sqlBottumAdminCharges);

    $sqlBottumOtherCharges = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
        pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
        pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
        pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
        FROM tbl_product_cover_mt pc
        JOIN tbl_covers_mt cv
        ON pc.cover_code = cv.cover_code
        WHERE pc.prod_code = '$prod_code'
        AND pc.comp_code = '$companycode_form'
        AND pc.cover_code IN ('cov-026')
        AND pc.cover_cal_area = 'B'
        AND pc.remark = 'P'
        ORDER BY pc.calc_seq;
    ";
    $result_prcBottom_ADCO = $con->query($sqlBottumOtherCharges);

    $sqlBottumOtherCharges = "SELECT pc.id, pc.cover_code, cv.cover_description, pc.tax_stat, pc.basic_stat,
        pc.default_stat, pc.initial_amt, pc.variation_amounts, pc.edit_flag, pc.calc_seq, pc.calc_type,
        pc.cov_formula, pc.code_block, pc.min_limit, pc.max_limit, pc.free_upto, pc.cover_ex_per, pc.cover_ex_amt,
        pc.cover_dis_seq, pc.cover_prt_seq, pc.cover_rate, pc.is_process, pc.is_cal, pc.display_cover, pc.print_flag
        FROM tbl_product_cover_mt pc
        JOIN tbl_covers_mt cv
        ON pc.cover_code = cv.cover_code
        WHERE pc.prod_code = '$prod_code'
        AND pc.comp_code = '$companycode_form'
        AND pc.cover_code IN ('cov-027')
        AND pc.cover_cal_area = 'B'
        AND pc.remark = 'P'
        ORDER BY pc.calc_seq;
    ";
    $result_prcBottom_ADCO1 = $con->query($sqlBottumOtherCharges);
}
    //Getting NCB and MR rate if have
    $sqlTopMRNCB = "SELECT cover_code, cover_rate 
           FROM tbl_product_cover_mt 
           WHERE prod_code = '$prod_code'
           AND comp_code = '$companycode_form' 
           AND cover_code IN ('cov-046', 'cov-047') 
           AND cover_cal_area = 'T' 
           AND remark = 'P' 
           LIMIT 2";
    $resultMRNCB = $con->query($sqlTopMRNCB);

    $cover_rate_ncb = null;
    $cover_rate_mr = null;

    if ($resultMRNCB->num_rows > 0) {
        while ($rowMRNCB = $resultMRNCB->fetch_assoc()) {
            if ($rowMRNCB['cover_code'] == 'cov-047') {
                $cover_rate_ncb = $rowMRNCB['cover_rate'];
            } elseif ($rowMRNCB['cover_code'] == 'cov-046') {
                $cover_rate_mr = $rowMRNCB['cover_rate'];
            } else {
                $cover_rate_ncb = null;
                $cover_rate_mr = null;
            }
        }
    }

    // Now you have $cover_rate_ncb and $cover_rate_mr with their respective rates.

    /////////////////////////////////////////////////////////////////////////////////////////////
    // NCB MR


////////////////////////////////////
              //calculation to get ncb mr 
              
              
              //$rate = 0.01409;
              
              $our_cont         = NULL;
              $sum_ins          = NULL;
              $total2           = NULL;
              $total3           = NULL;
              $total4           = NULL;
              $total5           = NULL;
              $totvat           = NULL;
              $tot2             = NULL;
              //  NEW TOTALS VARIABLES
              $T  = NULL;
              $T1 = NULL;
              $T2 = NULL;
              $T3 = NULL;
              $T4 = NULL;
              $T5 = NULL;
              $T6 = NULL;
              // $basicrate = 0;
              // $basicrate_cont = 0;
              //Sum Insured Without RS
              
              //calculate Our contribution based on Rate
              if ($rate !== null && !empty($rate)) {
              $our_cont     =   $sum_ins * $rate;
              $our_contRS   =   number_format($our_cont). '.00';
              $_SESSION['our_contribution'] = $our_cont;
              //echo 'our Pre:'. $our_cont . '<br>';
              }


              $count = 1;
              $free_covers = array();
              $front_covers = array();
              // Calculation Algorithm Cover - Top //
              if ($result_prcTop->num_rows > 0) {
                  while ($row = $result_prcTop->fetch_assoc()) {
                      // Store values for calculation
                      $id = $row['id'];
                      $calcProcess = $row['is_process'];
                      $cover_code = $row['cover_code'];
                      $initialAmount = $row['initial_amt'];
                      $initialVariable = $row['variation_amounts'];
                      $coverRate = $row['cover_rate'];
                      $calculationType = $row['calc_type'];
                      $coverFormula = $row['cov_formula'];
                      $calculationBlock = $row['code_block'];
                      $free_upto = $row['free_upto'];
                      $edit_flag = $row['edit_flag'];
                      $display_cover = $row['display_cover'];
                      
                      // Hide free covers from the form
                      if ($display_cover === '0') {
                          $_SESSION['FreeCovers'] = $free_covers;
                          continue;
                      }
              
                      // Initialize the premium field
                      $row['premium'] = "";
              
                  // Handle comma-separated initial amounts
                  if (!empty($initialVariable)){

                    if (strpos($initialVariable, ',') !== false) {
                      $amounts = explode(',', $initialVariable);
                      $firstAmount = trim($amounts[0]); 
                      $remainingAmounts = array_slice($amounts, 1); 
          
                      // Use the first amount for calculations
                      $initialAmount = $firstAmount;
                      $row['initial_amt'] = $row['variation_amounts'];
                  } else {
                      $remainingAmounts = []; 
                  }
                  
                  }
                      // Calculation code based on calc_type
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                              if ($calcProcess === "yes") {
                                  $coverFormula = $row['cov_formula'];
                                  $result_sqlblock = $con->query($coverFormula);
                                  if ($result_sqlblock !== false) {
                                    echo $cover_code;
                                      eval($row['code_block']);
                                      $row['premium'] = round((float)$PAB_VALUE, 2);
                                      $T += $row['premium'];
                                  } else {
                                      echo "Error executing SQL formula: " . $con->error . "<br>";
                                  }
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          case 'cal':
                              if ($calcProcess === "yes") {
                                  eval($row['code_block']);
                                  $row['premium'] = round((float)$calValue, 2);
                                  $T += $row['premium'];
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          case 'rate':
                              if ($calcProcess === "yes") {
                                  eval($row['code_block']);
                              } else {
                                  $row['premium'] = 0;
                              }
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T += $row['premium'];
                              break;
                          case 'fixed':
                              if ($calcProcess === "yes") {
                                  $row['premium'] = round((float)$initialAmount, 2);
                                  $T += $row['premium'];
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                              if ($calcProcess === "yes") {
                                  $row['premium'] = round((float)$initialAmount, 2);
                                  $T += $row['premium'];
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          default:
                              break;
                      }
              
                      $row['cover_area'] = "CTNM";

                         // Add details to admin chargers array
                    $front_covers[] = array(
                      'cover' => $row['cover_description'],
                      'printflag' => $row['print_flag'],
                      'initialamt' => $row['initial_amt'],
                      'premium' => $row['premium']
                    );

            
                      // Determine readonly attribute based on edit_flag
                      $readonly = ($edit_flag == 0) ? "readonly" : "";
                      $count++;
                  }
                  $_SESSION['front_covers'] = $front_covers;
              } else {
                  echo "No results found.";
              }

            
              
               
                
              //$count = 1;
              $T1 = $T;
              $other_cover_chargers = array();
              $srccTC_chargers = array();
              $free_covers = array();
              $free_covers_CBT01 = array();
              //Calculation Algorythm  Cover - Bottom//
                if ($result_prcBottom_1->num_rows > 0) {
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_1->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $initialVariable    =     $row['variation_amounts'];
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;
                  $display_cover      =     $row['display_cover'] ;

                  //hide free covers from the form
                  if ($display_cover === '0') {
                    // Add details to free covers array
                    $free_covers_CBT01[] = array(
                      'cover' => $row['cover_description'],
                      'coverCode' => $row['cover_code'],
                      'coverType' => $row['calc_type'],
                      'coverAmt'  => $row['initial_amt'],
                      'calSequence' => $row['calc_seq'],
                      'printSquence' => $row['cover_prt_seq'],
                      'dis_area' => "CBT01"
                    );
                    $_SESSION['FreeCovers'] = $free_covers_CBT01;
                    continue;
                  }

                  // Handle comma-separated initial amounts
                  if (!empty($initialVariable)){

                    if (strpos($initialVariable, ',') !== false) {
                      $amounts = explode(',', $initialVariable);
                      $firstAmount = trim($amounts[0]); 
                      $remainingAmounts = array_slice($amounts, 1); 
          
                      // Use the first amount for calculations
                      $initialAmount = $firstAmount;
                      $row['initial_amt'] = $row['variation_amounts'];
                  } else {
                      $remainingAmounts = []; 
                  }

                  }

                
            // Check conditions based on $sum_ins to hide or show covers
            if ($SelectCompanyCode === 'lb001' || $SelectCompanyCode === 'amn-001'
            || $SelectCompanyCode === 'afl003' || $SelectCompanyCode === 'vb002'
            || $SelectCompanyCode === 'ccl004' || $SelectCompanyCode === 'of005'
            || $SelectCompanyCode === 'ab006' || $SelectCompanyCode === 'otr008') {
              if ($sum_ins <= 15000000) {
                  if ($cover_code === 'cov-021' || $cover_code === 'cov-022' ||  $cover_code === 'cov-030' ||  $cover_code === 'cov-031' ) {
                      continue; 
                  }
                  // Show 'cov-032'
                  if ($cover_code === 'cov-032') {
                  }
              }
              elseif ($sum_ins >= 15000000) {
                  if ($cover_code === 'cov-032') {
                      continue; 
                  }
                  // Show 'cov-021' and 'cov-022'
                  if ($cover_code === 'cov-021' || $cover_code === 'cov-022' ||  $cover_code === 'cov-030' ||  $cover_code === 'cov-031' ) {
                  }
              }
            }

              // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  $PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = $PAB_VALUE;
                                  $T1 += (float)$row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = 0;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                
                              $row['premium'] = round((float)$calValue, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $T1 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                              $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;
                          case 'free':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;  
                          default:
                             
                      }
                      $row['cover_area'] = "CBT00";


                    //End Calculation Code
                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                    // Add details to admin chargers array
                    $other_cover_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'printflag' => $row['print_flag'],
                      'initialamt' => $row['initial_amt'],
                      'premium' => $row['premium']
                    );

                      // Add details to admin chargers array
                      $srccTC_chargers[] = array(
                        'cover' => $row['cover_description'],
                        'printflag' => $row['print_flag'],
                        'premium' => $row['premium']
                    );
                      
                      $count++;
                  }
                  $_SESSION['other_cover_chargers'] = $other_cover_chargers;
                  $_SESSION['FreeCoversCBT01'] = $free_covers_CBT01;
                  $_SESSION['srccTC_chargers'] = $srccTC_chargers;
              } else {
                  //echo "No results found.";
              }

              $_SESSION['T1'] = $T1;
              //$T1 += $Tot_01_;


                  $T1RS = number_format($T1, 2); $_SESSION['T1_total01'] = $T1;
                  ///////////////////////







   

$vehirate_  = $vehi_rate;
//echo 'vehicleRate: ' . $vehirate_ . '<br>';
$basicrate_ = $basic_rate;
//echo 'basicRate: ' . $basicrate_ . '<br>';
$sum_insured_ = $sumInsured;
$sum_insured_Edit = !empty($_SESSION['sumInsured_edit']) ? $_SESSION['sumInsured_edit'] : null;
$COV_TOT = $T1;
$discount_amount = $amount;
//echo 'Cover Total: ' . $COV_TOT . '<br>';

//SRCC TC Crages
$srccTC = !empty($_SESSION['srccTC']) ? $_SESSION['srccTC'] : null;
        //Extract values
        if (isset($srccTC)) {
            $SRCCTC_ = $srccTC;
            // Initialize variables to store the premiums
            $loading = 0;
    
            foreach ($SRCCTC_ as $SRCCTC_premium) {
                $status = $SRCCTC_premium['status'];
                $premium = $SRCCTC_premium['premium'];
                $premium = str_replace(',', '', $premium);
    
                if ($status == 0) {
                    $loading += (float)$premium;
                }
            }
            //cover total with loading
            $loading /= 2;
            $COV_TOT += $loading;
            //echo 'loading: ' . $loading . '<br>';
            //echo 'cover total with loading: ' . $COV_TOT . '<br>';
        }
        //ENd
//END
$Our_premium_ = NULL;
$Basic_premium = NULL;
$mr_rate_ = NULL;
$ncb_rate_ = NULL;
$_mr_price = NULL;
$_ncb_price = NULL;
$result_ = NULL;
$flood = NULL;

if (!empty($vehirate_) || !empty($basicrate_) || !empty($sum_insured_)) {
// Sum Insured Without 'Rs' and commas
if ($sum_insured_ !== null && !empty($sum_insured_)) {
    $converted = str_replace(array('Rs.', ','), '', $sum_insured_);
    $_suminsured_ = (int)$converted; 
    //echo 'Sum Insured: ' . $_suminsured_ . '<br>';
}

// New Sum Insured Without 'Rs' and commas
if ($sum_insured_Edit !== null && !empty($sum_insured_Edit)) {
    $converted = str_replace(array('Rs.', ','), '', $sum_insured_Edit);
    $sum_insured_Edit = (int)$converted; 
    $_SESSION['sumInsured'] = $sum_insured_Edit; //Replace current sum insured
    //echo 'Sum Insured New: ' . $sum_insured_Edit . '<br>';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////

// Represent new Suminsured as actual sum insured
if (!empty($sum_insured_Edit)){
    $_suminsured_ = $sum_insured_Edit;
    
// Getting Basic Rate for calculating Premium based on sum insured
if (empty($EngineCapacity)){

    if ($_suminsured_ >= 0 && $_suminsured_ <= 9500000) {
        $slab = '0000000-9500000';
    } elseif ($_suminsured_ > 9500000 && $_suminsured_ <= 10000000) {
        $slab = '9500000-10000000';
    } elseif ($_suminsured_ > 10000000 && $_suminsured_ <= 25000000) {
        $slab = '10000000-25000000';
    } elseif ($_suminsured_ > 25000000) {
        $slab = '25000000-above';
    } else {
       // echo "Condition not met";
        $basicrate_ = 0.0;
    }
    
    if (isset($slab)) {
        // Debug: print the query and slab value
       // echo "Slab: $slab<br>";
        
        $sql = "SELECT rate FROM tbl_basicrate_mt WHERE slab = '$slab' AND vehi_type = '$product'";
        //echo "SQL Query: $sql<br>"; // Print the SQL query for verification
        
        $result = $con->query($sql);
    
        if ($result && $row = $result->fetch_assoc()) {
            $basicrate_ = $row['rate'] / 100;
            //echo "Basic Rate After Recal: $basicrate_<br>";
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
        $basicrate_ = 0.0;
    }
    
    if (isset($eng_cap)) {
        
        $sql = "SELECT rate FROM tbl_basicrate_mt WHERE engine_capacity = '$eng_cap' AND vehi_type = '$product'";
       // echo "SQL Query: $sql<br>"; // Print the SQL query for verification
        
        $result = $con->query($sql);
    
        if ($result && $row = $result->fetch_assoc()) {
            $basicrate_ = $row['rate'] / 100;
          //echo "Basic Rate After Recal: $basicrate_<br>";
          //  echo "Sum: $sum_ins<br>"; // Print the basic rate for debugging
        } else {
          //  echo "Error executing query: " . mysqli_error($con);
        }
    }
}

// Getting Vehicle Rate for calculating Premium based on sum insured and make code
function getPriceSlab($_suminsured_) {
    if ($_suminsured_ < 5000000) {
        return 'Below 5M';
    } elseif ($_suminsured_ < 6000000) {
        return '5M to 6M';
    } elseif ($_suminsured_ < 7000000) {
        return '6M to 7M';
    } elseif ($_suminsured_ < 8000000) {
        return '7M to 8M';
    } elseif ($_suminsured_ < 9000000) {
        return '8M to 9M';
    } elseif ($_suminsured_ < 10000000) {
        return '9M to 10M';
    } elseif ($_suminsured_ < 11000000) {
        return '10M to 11M';
    } elseif ($_suminsured_ < 12000000) {
        return '11M to 12M';
    } elseif ($_suminsured_ < 13000000) {
        return '12M to 13M';
    } elseif ($_suminsured_ < 14000000) {
        return '13M to 14M';
    } elseif ($_suminsured_ < 15000000) {
        return '14M to 15M';
    } elseif ($_suminsured_ < 16000000) {
        return '15M to 16M';
    } elseif ($_suminsured_ <= 20000000) {
        return '16M to 20M';
    } else {
        return '20M & Above';
    }
}
// Get price slab
$priceSlab = getPriceSlab($_suminsured_);

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
            $vehirate_ = $rate / 100;
            echo "Vehicle Rate After Recal: $vehirate_<br>";
        } else {
            echo "No rate found for the given make code and sum insured.";
            $vehirate_ = 0.0;
        }
    }
} else {
   // echo "No category found for the given make code.";
   $vehirate_ = 0.0;
}
} else {
// echo "Failed to prepare the query.";
$vehirate_ = 0.0;
}
//End of rate part.

}

        // Custom Rate
        // $rate = 1.3200634;
        // $vehirate_ = $rate / 100;
        //End
/////////////////////////////////////////////////////////////////////////////////////

// Calculate Our contribution based on Rate
if ($vehirate_ !== null && !empty($vehirate_)) {
    $Our_premium_ = $_suminsured_ * $vehirate_;
    $Our_premium_ = round((float)$Our_premium_, 2);
    //echo 'Our Premium: ' . $Our_premium_ . '<br>';
}

// Calculate Basic contribution based on Rate
if ($basicrate_ !== null && !empty($basicrate_)) {
    $Basic_premium = $_suminsured_ * $basicrate_;
    $Basic_premium = round((float)$Basic_premium, 2);
    //echo 'Basic Premium: ' . $Basic_premium . '<br>';
}

// Calculate the Total after reducing Cover Total from Our Premium
$Tot_01_ = ($Our_premium_ - $COV_TOT);
  //Discount if yes
  $Tot_01_ -= $discount_amount;
  //
//echo 'Total after Cover Deduction: ' . $Tot_01_ . '<br>';

// Calculate Difference between Basic Premium and Total
$different = ($Basic_premium - $Tot_01_);
//echo 'Difference: ' . $different . '<br>';

// Calculate MR and NCB Price (Splitting Difference equally)
$_mr_price = ($different / 2);
$_ncb_price = ($different / 2);

// Calculate MR Rate based on the formula
$mr_rate_ = ($_mr_price / $Basic_premium) * 100;
//echo 'MR Price: ' . $_mr_price . '<br>';
//echo 'MR Rate: ' . number_format(abs($mr_rate_), 3) . '%<br>'; // Using abs() to match Excel behavior

// Calculate NCB Rate using the correct formula
$_cal = $Basic_premium + abs($_mr_price); // Ensure adding absolute value
//echo 'Basic Premium + MR Price: ' . $_cal . '<br>';

$result_ = abs($_mr_price) / $_cal; // Correct handling of percentage
$ncb_rate_ = $result_ * 100; // Convert to percentage
//echo 'NCB Price: ' . $_ncb_price . '<br>';
//echo 'NCB Rate: ' . number_format($ncb_rate_, 3) . '%<br>';

//Gross Premium Calculation
        // Retrieve the SRCC TC chargers array from the session
        if (isset($_SESSION['srccTC_chargers'])) {
            $SRCCTC_chargers = $_SESSION['srccTC_chargers'];
            $flood = 0;

            foreach ($SRCCTC_chargers as $srtccharger) {
                $cover_des_B = $srtccharger['cover'];
                $premium = $srtccharger['premium'];
                $premium = str_replace(',', '', $premium);

                // Check cover description and assign premium to corresponding variable
                if ($cover_des_B == "Flood & Natural Disaster Perils") {
                    $flood = $premium;
                }
            }
        } 
        //echo $flood;
        // End
$gross_premium = $Tot_01_ + $flood;
//echo 'Gross Premium: ' . $gross_premium . '<br>';

//Passing Session Data
$_SESSION['Tot_01_'] = $Tot_01_;
$_SESSION['_mr_price'] = $_mr_price;
$_SESSION['_ncb_price'] = $_ncb_price;
$_SESSION['mr_rate_'] = number_format(abs($mr_rate_), 3);
$_SESSION['ncb_rate_'] = number_format($ncb_rate_, 3);
$_SESSION['gross_premium_'] = number_format($gross_premium, 2);

//Restore Rates on Session
$_SESSION['vehicleRate']            =       $vehirate_          ;
$_SESSION['basicRate']              =       $basicrate_         ;

//Redirect
}else {
}
//Passing Session Data

    //////////////////////////////////////////////////////////////////////////////////////////////
    // Quotation form

              //calculation to get ncb mr 
              $sum_insured      = !empty($_SESSION['sumInsured']) ? $_SESSION['sumInsured'] : null;
              $rate             = !empty($_SESSION['vehicleRate']) ? $_SESSION['vehicleRate'] : null;
              $basicrate        = !empty($_SESSION['basicRate']) ? $_SESSION['basicRate'] : null;
              $seatingCapacity  = !empty($_SESSION['seatingCapacity']) ? $_SESSION['seatingCapacity'] : null;
              
              //$rate = 0.01409;
              
              $our_cont         = NULL;
              $sum_ins          = NULL;
              $total2           = NULL;
              $total3           = NULL;
              $total4           = NULL;
              $total5           = NULL;
              $totvat           = NULL;
              $tot2             = NULL;
              //  NEW TOTALS VARIABLES
              $T  = NULL;
              $T1 = NULL;
              $T2 = NULL;
              $T3 = NULL;
              $T4 = NULL;
              $T5 = NULL;
              $T6 = NULL;
              // $basicrate = 0;
              // $basicrate_cont = 0;
              //Sum Insured Without RS
              if ($sum_insured !== null && !empty($sum_insured)) {
              $coverWithoutRs =   str_replace(array('Rs.', ','), '', $sum_insured);
              $sum_ins        =   (int)$coverWithoutRs;  // For integer
              //$sum_ins = number_format($sum_ins, 2);
              }
              //calculate Our contribution based on Rate
              if ($rate !== null && !empty($rate)) {
              $our_cont     =   $sum_ins * $rate;
              $our_contRS   =   number_format($our_cont). '.00';
              $_SESSION['our_contribution'] = $our_cont;
              //echo 'our Pre:'. $our_cont . '<br>';
              }

              //calculate basic contribution based on Rate
              if ($basicrate !== null && !empty($basicrate)) {
                  $basicrate_cont   =   $sum_ins * $basicrate;
                  $basicrate_contRS =   number_format($basicrate_cont, 2);
                  //$basicrate_contRS = round((float)$basicrate_cont, 2);
                  $_SESSION['basic_premium'] = $basicrate_cont;
                  //echo 'basic pre:'.$basicrate_cont;
              }

              $count = 1;
              $free_covers = array();
              $front_covers = array();
              // Calculation Algorithm Cover - Top //
              if ($result_prcTop->num_rows > 0) {
                  while ($row = $result_prcTop->fetch_assoc()) {
                      // Store values for calculation
                      $id = $row['id'];
                      $calcProcess = $row['is_process'];
                      $cover_code = $row['cover_code'];
                      $initialAmount = $row['initial_amt'];
                      $initialVariable = $row['variation_amounts'];
                      $coverRate = $row['cover_rate'];
                      $calculationType = $row['calc_type'];
                      $coverFormula = $row['cov_formula'];
                      $calculationBlock = $row['code_block'];
                      $free_upto = $row['free_upto'];
                      $edit_flag = $row['edit_flag'];
                      $display_cover = $row['display_cover'];
                      
                      // Hide free covers from the form
                      if ($display_cover === '0') {
                          $_SESSION['FreeCovers'] = $free_covers;
                          continue;
                      }
              
                      // Initialize the premium field
                      $row['premium'] = "";
              
                  // Handle comma-separated initial amounts
                  if (!empty($initialVariable)){

                    if (strpos($initialVariable, ',') !== false) {
                      $amounts = explode(',', $initialVariable);
                      $firstAmount = trim($amounts[0]); 
                      $remainingAmounts = array_slice($amounts, 1); 
          
                      // Use the first amount for calculations
                      $initialAmount = $firstAmount;
                      $row['initial_amt'] = $row['variation_amounts'];
                  } else {
                      $remainingAmounts = []; 
                  }
                  
                  }
                      // Calculation code based on calc_type
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                              if ($calcProcess === "yes") {
                                  $coverFormula = $row['cov_formula'];
                                  $result_sqlblock = $con->query($coverFormula);
                                  if ($result_sqlblock !== false) {
                                    echo $cover_code;
                                      eval($row['code_block']);
                                      $row['premium'] = round((float)$PAB_VALUE, 2);
                                      $T += $row['premium'];
                                  } else {
                                      echo "Error executing SQL formula: " . $con->error . "<br>";
                                  }
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          case 'cal':
                              if ($calcProcess === "yes") {
                                  eval($row['code_block']);
                                  $row['premium'] = round((float)$calValue, 2);
                                  $T += $row['premium'];
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          case 'rate':
                              if ($calcProcess === "yes") {
                                  eval($row['code_block']);
                              } else {
                                  $row['premium'] = 0;
                              }
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T += $row['premium'];
                              break;
                          case 'fixed':
                              if ($calcProcess === "yes") {
                                  $row['premium'] = round((float)$initialAmount, 2);
                                  $T += $row['premium'];
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                              if ($calcProcess === "yes") {
                                  $row['premium'] = round((float)$initialAmount, 2);
                                  $T += $row['premium'];
                              } else {
                                  $row['premium'] = 0;
                              }
                              break;
                          default:
                              break;
                      }
              
                      $row['cover_area'] = "CTNM";

                         // Add details to admin chargers array
                    $front_covers[] = array(
                      'cover' => $row['cover_description'],
                      'printflag' => $row['print_flag'],
                      'initialamt' => $row['initial_amt'],
                      'premium' => $row['premium']
                    );

            
                      // Determine readonly attribute based on edit_flag
                      $readonly = ($edit_flag == 0) ? "readonly" : "";

                      $count++;
                  }
                  $_SESSION['front_covers'] = $front_covers;
              } else {
                  echo "No results found.";
              }

            
              
               $_ncb_price = number_format($_ncb_price, 2);
                
              //$count = 1;
              $T1 = $T;
              $other_cover_chargers = array();
              $srccTC_chargers = array();
              $free_covers = array();
              $free_covers_CBT01 = array();
              //Calculation Algorythm  Cover - Bottom//
                if ($result_prcBottom_1->num_rows > 0) {
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_1->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $initialVariable    =     $row['variation_amounts'];
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;
                  $display_cover      =     $row['display_cover'] ;

                  //hide free covers from the form
                  if ($display_cover === '0') {
                    // Add details to free covers array
                    $free_covers_CBT01[] = array(
                      'cover' => $row['cover_description'],
                      'coverCode' => $row['cover_code'],
                      'coverType' => $row['calc_type'],
                      'coverAmt'  => $row['initial_amt'],
                      'calSequence' => $row['calc_seq'],
                      'printSquence' => $row['cover_prt_seq'],
                      'dis_area' => "CBT01"
                    );
                    $_SESSION['FreeCovers'] = $free_covers_CBT01;
                    continue;
                  }

                  // Handle comma-separated initial amounts
                  if (!empty($initialVariable)){

                    if (strpos($initialVariable, ',') !== false) {
                      $amounts = explode(',', $initialVariable);
                      $firstAmount = trim($amounts[0]); 
                      $remainingAmounts = array_slice($amounts, 1); 
          
                      // Use the first amount for calculations
                      $initialAmount = $firstAmount;
                      $row['initial_amt'] = $row['variation_amounts'];
                  } else {
                      $remainingAmounts = []; 
                  }

                  }

                
            // Check conditions based on $sum_ins to hide or show covers
            if ($SelectCompanyCode === 'lb001' || $SelectCompanyCode === 'amn-001'
            || $SelectCompanyCode === 'afl003' || $SelectCompanyCode === 'vb002'
            || $SelectCompanyCode === 'ccl004' || $SelectCompanyCode === 'of005'
            || $SelectCompanyCode === 'ab006' || $SelectCompanyCode === 'otr008') {
              if ($sum_ins <= 15000000) {
                  if ($cover_code === 'cov-021' || $cover_code === 'cov-022' ||  $cover_code === 'cov-030' ||  $cover_code === 'cov-031' ) {
                      continue; 
                  }
                  // Show 'cov-032'
                  if ($cover_code === 'cov-032') {
                  }
              }
              elseif ($sum_ins >= 15000000) {
                  if ($cover_code === 'cov-032') {
                      continue; 
                  }
                  // Show 'cov-021' and 'cov-022'
                  if ($cover_code === 'cov-021' || $cover_code === 'cov-022' ||  $cover_code === 'cov-030' ||  $cover_code === 'cov-031' ) {
                  }
              }
            }

              // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  $PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = $PAB_VALUE;
                                  $T1 += (float)$row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = 0;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                
                              $row['premium'] = round((float)$calValue, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $T1 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                              $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;
                          case 'free':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $T1 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;  
                          default:
                             
                      }
                      $row['cover_area'] = "CBT00";


                    //End Calculation Code
                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                    // Add details to admin chargers array
                    $other_cover_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'printflag' => $row['print_flag'],
                      'initialamt' => $row['initial_amt'],
                      'premium' => $row['premium']
                    );

                      // Add details to admin chargers array
                      $srccTC_chargers[] = array(
                        'cover' => $row['cover_description'],
                        'printflag' => $row['print_flag'],
                        'premium' => $row['premium']
                    );
                      
                      $count++;
                  }
                  $_SESSION['other_cover_chargers'] = $other_cover_chargers;
                  $_SESSION['FreeCoversCBT01'] = $free_covers_CBT01;
                  $_SESSION['srccTC_chargers'] = $srccTC_chargers;
              } else {
                  //echo "No results found.";
              }

              $_SESSION['T1'] = $T1;
              $T1 += $Tot_01_;


                  $T1RS = number_format($T1, 2); $_SESSION['T1_total01'] = $T1;
                
              //$count = 1;
              $other_cover_chargers = array();
              $free_covers = array();
              //Calculation Algorythm  Cover - Bottom//
                if ($result_prcBottom_2->num_rows > 0) {
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_2->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $initialVariable    =     $row['variation_amounts'];
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;
                  $display_cover      =     $row['display_cover'] ;

                  //hide free covers from the form
                  if ($display_cover === '0') {
                    // Add details to free covers array
                    $free_covers_CBT01[] = array(
                      'cover' => $row['cover_description'],
                      'coverCode' => $row['cover_code'],
                      'coverType' => $row['calc_type'],
                      'coverAmt'  => $row['initial_amt'],
                      'calSequence' => $row['calc_seq'],
                      'printSquence' => $row['cover_prt_seq'],
                      'dis_area' => "CBT01"
                    );
                    $_SESSION['FreeCovers'] = $free_covers_CBT01;
                    continue;
                  }

                  // Handle comma-separated initial amounts
                  if (!empty($initialVariable)){

                    if (strpos($initialVariable, ',') !== false) {
                      $amounts = explode(',', $initialVariable);
                      $firstAmount = trim($amounts[0]); 
                      $remainingAmounts = array_slice($amounts, 1); 
          
                      // Use the first amount for calculations
                      $initialAmount = $firstAmount;
                      $row['initial_amt'] = $row['variation_amounts'];
                  } else {
                      $remainingAmounts = []; 
                  }

                  }
                
                  // Check conditions based on $sum_ins to hide or show covers
                  if ($SelectCompanyCode === 'lb001' || $SelectCompanyCode === 'amn-001'
                      || $SelectCompanyCode === 'afl003' || $SelectCompanyCode === 'vb002'
                      || $SelectCompanyCode === 'ccl004' || $SelectCompanyCode === 'of005'
                      || $SelectCompanyCode === 'ab006') {
                    if ($sum_ins <= 15000000) {
                        if ($cover_code === 'cov-021' || $cover_code === 'cov-022') {
                            continue; 
                        }
                        // Show 'cov-032'
                        if ($cover_code === 'cov-032') {
                        }
                    }
                    elseif ($sum_ins >= 15000000) {
                        if ($cover_code === 'cov-032') {
                            continue; 
                        }
                        // Show 'cov-021' and 'cov-022'
                        if ($cover_code === 'cov-021' || $cover_code === 'cov-022') {
                        }
                    }
                  }

                  // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  $PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = $PAB_VALUE;
                                  $total2 += (float)$row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = 0;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                
                              $row['premium'] = round((float)$calValue, 2);
                              $total2 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total2 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total2 += (float)$row['premium'];
                              } 
                              else {
                              $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total2 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;
                          case 'free':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total2 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;  
                          default:
                             
                      }
                      $row['cover_area'] = "CBT01";
                    //End Calculation Code
                    // Add details to admin chargers array
                    $other_cover_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'printflag' => $row['print_flag'],
                      'initialamt' => $row['initial_amt'],
                      'premium' => $row['premium'] 
                    );
                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";

                      $count++;
                  }
                  $_SESSION['other_cover_chargers'] = $other_cover_chargers;
                  $_SESSION['FreeCoversCBT01'] = $free_covers_CBT01;
              } else {
                  //echo "No results found.";
              }
              
              //End Calculation Algorythm //
                

                 $tot2 += $total2 + $T1;
                 $total2NUMBER = number_format($tot2, 2);
                $_SESSION['GrossContribution_tot02'] = $tot2; 
                
              //$count = 1;
              $admin_chargers = array(); // Initialize the admin chargers array
              //Calculation Algorythm  Cover - Other Chargers under Total 03//
                if ($result_prcBottom_ADC->num_rows > 0) {
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_ADC->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;
                  $display_cover      =     $row['display_cover'] ;
                  $maxLimit           =     $row['max_limit']     ;
                  //hide free covers from the form
                  if ($display_cover === '0') {
                    $_SESSION['FreeCovers'] = $free_covers;
                    continue;
                  }
              // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  //$PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = round((float)$PAB_VALUE, 2);
                                  $total3 += (float)$row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = 0;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $row['premium'] = round((float)$calValue, 2);
                                $total3 = $total3 + $calValue;
                              } 
                              else {
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total3 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total3 = $total3 + $initialAmount;
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total3 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;
                            
                          default:
                             
                      }
                      $row['cover_area'] = "CBT02";
                    //End Calculation Code
                    // Add details to admin chargers array
                    $admin_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['premium'] 
                    );

                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";
                      // Output HTML table row
                      
                      $count++;
                  }
                  $_SESSION['admin_chargers'] = $admin_chargers;
              } else {
                  //echo "No results found.";
              }
              
              //End Calculation Algorythm //
                
             $tot3 = $total3 + $tot2;  $total3NUMBER = number_format($tot3, 2); 
                
              //$count = 1;
                
              //Calculation Algorythm  Cover - Admin Chargers//
                if ($result_prcBottom_ADCO->num_rows > 0) {
                  $SSCL_chargers = array(); // Initialize the SSCL chargers array
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_ADCO->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;
                  $display_cover      =     $row['display_cover'] ;

                  //hide free covers from the form
                  if ($display_cover === '0') {
                    $_SESSION['FreeCovers'] = $free_covers;
                    continue;
                  }

              // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  //$PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = round((float)$PAB_VALUE, 2);
                                  $total4 += (float)$row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = 0;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $calValue1 = number_format($calValue, 2);
                                $row['premium'] = $calValue1;
                                $total4 = $total4 + $calValue;
                              } 
                              else {
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total4 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total4 = $total4 + $initialAmount;
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total4 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;
                            
                          default:
                             
                      }
                      $row['cover_area'] = "CBT03";
                    //End Calculation Code
                    // Add details to VAT chargers array
                    $SSCL_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['premium']
                    );
                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";
                      // Output HTML table row
                      
                      $count++;
                  }
                  $_SESSION['sscl_chargers'] = $SSCL_chargers;
              } else {
                  //echo "No results found.";
              }
              
              //End Calculation Algorythm //
                
                 $tot4 = $total4 + $tot3;  $total4NUMBER = number_format($tot4, 2); 
                
              //$count = 1;
                
              //Calculation Algorythm  Cover - Admin Chargers//
                if ($result_prcBottom_ADCO1->num_rows > 0) {
                  $vat_chargers = array(); // Initialize the VAT chargers array
                  // Counter for numbering rows
                  while ($row = $result_prcBottom_ADCO1->fetch_assoc()) {
                     // store values on following variables for calculation process  
                
                  $id                 =     $row['id']            ;
                  $calcProcess        =     $row['is_process']    ;
                  $cover_code         =     $row['cover_code']    ;
                  $initialAmount      =     $row['initial_amt']   ;
                  $coverRate          =     $row['cover_rate']    ;
                  $calculationType    =     $row['calc_type']     ;
                  $coverFormula       =     $row['cov_formula']   ;
                  $calculationBlock   =     $row['code_block']    ;
                  $free_upto          =     $row['free_upto']     ;
                  $edit_flag          =     $row['edit_flag']     ;
                  $display_cover      =     $row['display_cover'] ;

                  //hide free covers from the form
                  if ($display_cover === '0') {
                    $_SESSION['FreeCovers'] = $free_covers;
                    continue;
                  }

              // set new array row to store calculated price.
                  $row['premium'] = "";
                  //Calculation Code between NCB and MR
                      switch ($row['calc_type']) {
                          case 'sql-formula':
                            // Check this cover should process or not.
                            if ($calcProcess === "yes" ){
                              $coverFormula = $row['cov_formula'];
                              $result_sqlblock = $con->query($coverFormula);
                              if ($result_sqlblock !== false) {
                                  // Execute code block
                                  eval($row['code_block']);
                                  //$PAB_VALUE = number_format($PAB_VALUE, 2);
                                  $row['premium'] = round((float)$PAB_VALUE, 2);
                                  $total5 += $row['premium'];
                              } else {
                                  echo "Error executing SQL formula: " . $con->error . "<br>";
                              }
                            } 
                            else {
                              $row['premium'] = 0;
                            }
                              break;
                          case 'cal':
                          
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                //$calValue1 = number_format($calValue, 2);
                              $row['premium'] = round((float)$calValue, 2);
                              $total5 = $total5 + $calValue;
                              } 
                              else {
                                $row['premium'] = 0;
                              }

                              break;
                          case 'rate':
                              if ($calcProcess === "yes"){
                                eval($row['code_block']);
                                $total5 += (float)$row['premium'];
                                } 
                                else {
                                  $row['premium'] = 0;
                                }
                              //$row['premium'] = $initialAmount;
                              break;
                          case 'fixed':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total5 = $total5 + $initialAmount;
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                              break;
                          case 'user-input':
                            if ($calcProcess === "yes"){
                              $row['premium'] = round((float)$initialAmount, 2);
                              $total5 += (float)$row['premium'];
                              } 
                              else {
                                $row['premium'] = 0;
                              }
                            break;
                            
                          default:
                             
                      }
                      $row['cover_area'] = "CBT04";
                    //End Calculation Code
                    
                    // Add details to VAT chargers array
                    $vat_chargers[] = array(
                      'cover' => $row['cover_description'],
                      'premium' => $row['premium']
                    );

                    // Determine readonly attribute based on edit_flag
                    $edit_flag = 0;
                    $readonly = ($edit_flag == 0) ? "readonly" : "";
                      // Output HTML table row
                      
                      $count++;
                  }
                  $_SESSION['vat_chargers'] = $vat_chargers;
              } else {
                  //echo "No results found.";
              }
              
              //End Calculation Algorythm //
                
                 $tot5 = $total5 + $tot4;
                //echo 'Final Premium: '. $total5NUMBER = number_format($tot5, 2);
                $_SESSION['TotalContribution'] = $tot5; 
      //////////////////////   end    /////////////////////////
            
             
        // Return the response
        http_response_code(200);
        echo json_encode([
            "message" => "Premium calculated successfully",
            "premium" => number_format($tot5, 2)
        ]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Handle GET requests (e.g., page refresh)
        http_response_code(200);
        echo json_encode([
            "message" => "This is a response to a GET request",
            "note" => "No data was processed."
        ]);
    } else {
        // Invalid method
        throw new Exception("Invalid request method. Please use POST or GET.");
    }
} catch (Exception $e) {
    // Handle exceptions and send error response
    http_response_code(400); // Bad Request
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}
 
