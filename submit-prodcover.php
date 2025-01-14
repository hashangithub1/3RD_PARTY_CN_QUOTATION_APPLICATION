<?php
session_start();
include_once('includes/config.php');

$prodCOdeSelected = !empty($_SESSION['selected_product_code']) ? $_SESSION['selected_product_code'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["product_class"]) && isset($_POST["cover_code"]) && isset($_POST["tax_stat"]) &&
        isset($_POST["basic_stat"]) && isset($_POST["default_stat"]) && isset($_POST["calc_seq"]) &&
        isset($_POST["calc_type"]) && isset($_POST["initial_amt"]) && isset($_POST["cover_formula"]) &&
        isset($_POST["code_block"]) && isset($_POST["max_limit"]) && isset($_POST["free_upto"]) &&
        isset($_POST["cover_ex_per"]) && isset($_POST["cover_ex_amt"]) && isset($_POST["dis_seq"]) &&
        isset($_POST["print_seq"]) && isset($_POST["cover_rate"]) && isset($_POST["edit_flag"]) &&
        isset($_POST["company"]) && isset($_POST["product"]) && isset($_POST["is_process"]) &&
        isset($_POST["placement"]) && isset($_POST["packages"]) && isset($_POST["displayCover"])
        && isset($_POST["variation_amt"]) ) {

        // Get form data
        $a = $_POST["product_class"];
        $b = $_POST["cover_code"];
        $c = $_POST["tax_stat"];
        $d = $_POST["basic_stat"];
        $e = $_POST["default_stat"];
        $f = $_POST["calc_seq"];
        $g = $_POST["calc_type"];
        $h = $_POST["initial_amt"];
        $icvf = $_POST["cover_formula"];
        $j = $_POST["code_block"];
        $k = $_POST["max_limit"];
        $l = $_POST["cover_ex_per"];
        $m = $_POST["cover_ex_amt"];
        $n = $_POST["dis_seq"];
        $o = $_POST["print_seq"];
        $p = $_POST["cover_rate"];
        $q = $_POST["edit_flag"];
        $r = $_POST["product"];
        $s = $_POST["is_process"];
        $t = $_POST["placement"];
        $u = $_POST["company"];
        $v = $_POST["free_upto"];
        $w = $_POST["packages"];
        $x = $_POST["id"];
        $y = $_POST["displayCover"];
        $z = $_POST["variation_amt"];

        $_SESSION["cover_data"] = [
            "product" => $r,
            "product_class" => $a,
            "cover_code" => $b,
            "tax_stat" => $c,
            "basic_stat" => $d,
            "default_stat" => $e,
            "calc_seq" => $f,
            "calc_type" => $g,
            "initial_amt" => $h,
            "cover_formula" => $icvf,
            "code_block" => $j,
            "max_limit" => $k,
            "cover_ex_per" => $l,
            "cover_ex_amt" => $m,
            "dis_seq" => $n,
            "print_seq" => $o,
            "cover_rate" => $p,
            "edit_flag" => $q,
            "is_process" => $s,
            "placement" => $t,
            "company" => $u,
            "free_upto" => $v,
            "packages" => $w,
            "displayCover" => $y,
            "id" => $x,
            "variation_amt" => $z
        ];

        // Prepare and bind the SQL statement for insert or update
        $insert_stmt = $con->prepare("INSERT INTO tbl_product_cover_mt (comp_code, prod_class, prod_code, cover_code, tax_stat, basic_stat, default_stat, initial_amt, variation_amounts, edit_flag, calc_seq, calc_type, cov_formula, code_block, max_limit, free_upto, cover_ex_per, cover_ex_amt, cover_dis_seq, cover_prt_seq, cover_rate, is_process, cover_cal_area, display_cover, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("ssssiissssssssiiiississss", $comp_code, $prod_class, $prod_code, $cover_code, $tax_stat, $basic_stat, $default_stat, $initial_amt, $variation_amt, $edit_flag, $calc_seq, $calc_type, $cov_formula, $code_block, $max_limit, $free_upto, $cover_ex_per, $cover_ex_amt, $cover_dis_seq, $cover_prt_seq, $cover_rate, $isProcess, $placement, $displayCover, $package);

        $update_stmt = $con->prepare("UPDATE tbl_product_cover_mt SET comp_code=?, prod_class=?, prod_code=?, cover_code=?, tax_stat=?, basic_stat=?, default_stat=?, initial_amt=?, variation_amounts=?, edit_flag=?, calc_seq=?, calc_type=?, cov_formula=?, code_block=?, max_limit=?, free_upto=?, cover_ex_per=?, cover_ex_amt=?, cover_dis_seq=?, cover_prt_seq=?, cover_rate=?, is_process=?, cover_cal_area=?, display_cover=?, remark=? WHERE id=?");
        $update_stmt->bind_param("ssssiissssssssiiiissdssssi", $comp_code, $prod_class, $prod_code, $cover_code, $tax_stat, $basic_stat, $default_stat, $initial_amt, $variation_amt, $edit_flag, $calc_seq, $calc_type, $cov_formula, $code_block, $max_limit, $free_upto, $cover_ex_per, $cover_ex_amt, $cover_dis_seq, $cover_prt_seq, $cover_rate, $isProcess, $placement, $displayCover, $package, $id);

        // Insert or update each row of data in the database
        for ($i = 0; $i < count($b); $i++) {
            $id = $x[$i];
            $comp_code = $u[$i];
            $prod_code = $r[$i];
            $prod_class = $a[$i];
            $cover_code = $b[$i];
            $tax_stat = $c[$i];
            $basic_stat = $d[$i];
            $default_stat = $e[$i];
            $initial_amt = $h[$i];
            $edit_flag = $q[$i];
            $calc_seq = $f[$i];
            $calc_type = $g[$i];
            $cov_formula = $icvf[$i];
            $code_block = $j[$i];
            $max_limit = $k[$i];
            $free_upto = $v[$i];
            $cover_ex_per = $l[$i];
            $cover_ex_amt = $m[$i];
            $cover_dis_seq = $n[$i];
            $cover_prt_seq = $o[$i];
            $cover_rate = $p[$i];
            $isProcess = $s[$i];
            $placement = $t[$i];
            $package = $w[$i];
            $displayCover =  $y[$i];
            $variation_amt =  $z[$i];

            if($edit_flag=="yes"){
                $edit_flag = 1;
            }else{
                $edit_flag = 0;
            }

            if (!empty($id)) {
                $update_stmt->execute();
            } else {
                $insert_stmt->execute();
            }
        }

        // Close statements
        $insert_stmt->close();
        $update_stmt->close();

        // Close connection
        $con->close();

        //Notification System
        $currentTime = date('Y-m-d H:i:s');
        $newNotification = [
            'message' => 'Product Cover added to the Comprehensive', 
            'time' => $currentTime,
            'is_read' => false
        ];
        $_SESSION['notifications'][] = $newNotification;
        //End

        $_SESSION["notification"] = "Data saved successfully !";
        $_SESSION["notification_handle"] = "1";
        $_SESSION['selected_product_code'] = "";
        $_SESSION['selected_product_name'] = "";
        echo "<script type='text/javascript'> document.location = 'product-cover-motor.php'; </script>";

    } else {
        $_SESSION["notification"] = "Form data is missing !";
        $_SESSION["notification_handle"] = "2";
        $_SESSION['selected_product_code'] = "";
        $_SESSION['selected_product_name'] = "";
        echo "<script type='text/javascript'> document.location = 'product-cover-motor.php'; </script>";
    }
} else {
    $_SESSION["notification"] = "Form is not submitted !";
    $_SESSION["notification_handle"] = "3";
    $_SESSION['selected_product_code'] = "";
    $_SESSION['selected_product_name'] = "";
    echo "<script type='text/javascript'> document.location = 'product-cover-motor.php'; </script>";
}
?>
