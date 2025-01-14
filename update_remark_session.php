<?php
session_start();

if (isset($_POST['input_id'])) {
    $inputId = $_POST['input_id']; 
    $amount  = $_POST['amount']; 
    $premium  = $_POST['premium']; 
    $remark  = $_POST['remark'];
    $sumins  = $_POST['sumins'];

    if($inputId === "cex-premium") {
        $_SESSION['comp_excesses'] = $amount;
        echo "Session updated";
    } elseif($inputId === "remark") {
        $_SESSION['remark'] = $remark;
        echo "Session updated";
    } elseif($inputId === "edit-sumins") {
        $_SESSION['sumInsured_edit'] = $sumins;
        echo "Session updated";
    }  elseif ($inputId === "cex-premium_rev") {
        $_SESSION['mqForm_comp_excesses'] = $amount;
        echo "Session updated";
    } elseif ($inputId === "remark_rev") {
        $_SESSION['mqForm_remark'] = $remark;
        echo "Session updated";
    } elseif ($inputId === "premium_matching") {
        $_SESSION['mqForm_premium_matching'] = $premium;
        echo "Session updated";
    }
    else {
            echo "Error: Missing parameters";
    }

} else {
    echo "Error: Missing parameters";
}
?>
