<?php 
// dataset for calculation form code
$prod_code = !empty($_SESSION['product']) ? $_SESSION['product'] : null;
$companyProductCode = !empty($_SESSION['companyProduct']) ? $_SESSION['companyProduct'] : null;
$companycode_form = !empty($_SESSION['companycode_form']) ? $_SESSION['companycode_form'] : null;
$seatingCapacity = !empty($_SESSION['seatingCapacity']) ? $_SESSION['seatingCapacity'] : null;


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
        AND pc.cover_code NOT IN ('cov-023', 'cov-024' , 'cov-025', 'cov-027', 'cov-028', 'cov-026', 'cov-048', 'cov-049', 'cov-050')
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
        AND pc.cover_code NOT IN ('cov-023', 'cov-024', 'cov-025', 'cov-028', 'cov-027', 'cov-026', 'cov-048', 'cov-049', 'cov-050')
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
    AND pc.cover_code NOT IN ('cov-023', 'cov-024', 'cov-025', 'cov-028', 'cov-027', 'cov-026', 'cov-048','cov-029','cov-030','cov-031','cov-032', 'cov-049', 'cov-021','cov-022', 'cov-050')
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
        AND pc.cover_code IN ('cov-023', 'cov-024', 'cov-025', 'cov-028', 'cov-048', 'cov-049', 'cov-050')
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
?>
