<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
$notification = !empty($_SESSION['notification']) ? $_SESSION['notification'] : null;   
$notificationTrigger = !empty($_SESSION['notification_handle']) ? $_SESSION['notification_handle'] : null;   
$SelectProductCode = !empty($_SESSION['selected_product_code']) ? $_SESSION['selected_product_code'] : null; 
$SelectProductClass = !empty($_SESSION['selected_product_class']) ? $_SESSION['selected_product_class'] : null; 
$SelectProductName = !empty($_SESSION['selected_product_name']) ? $_SESSION['selected_product_name'] : null; 
$SelectCompanyCode = !empty($_SESSION['selected_company_code']) ? $_SESSION['selected_company_code'] : null;   
$SelectCompanyName = !empty($_SESSION['selected_company_name']) ? $_SESSION['selected_company_name'] : null;  
$SelectChannelCode = !empty($_SESSION['selected_channel_code']) ? $_SESSION['selected_channel_code'] : null;     
$SelectChannelName = !empty($_SESSION['selected_channel_name']) ? $_SESSION['selected_channel_name'] : null;        

//Condition for channel name
if (!isset($SelectChannelName) || $SelectChannelName === "") {
  $chnlName = "Select a Channel";
} else {
  $chnlName = $SelectChannelName;
}
//Condition for product name
 if (!isset($SelectProductName) || $SelectProductName === "") {
  $prodName = "Select a Product";
} else {
  $prodName = $SelectProductName;
}

//Condition for Company name
if (!isset($SelectCompanyName) || $SelectCompanyName === "") {
  $compName = "Select a Company - Optional";
  $ProdPackage = "S";
} else {
  $compName = $SelectCompanyName;
  $ProdPackage = "P";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amana | Motor Quotation</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/select2/select2.min.css">
  <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/fav-icon.jpg" />

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link href="path/to/select2.min.css" rel="stylesheet" />
  <script src="path/to/jquery.min.js"></script>
  <script src="path/to/select2.min.js"></script>

  <style>
    /* Tab */
    ul.tabs {
      margin: 0;;
      float: left;
      list-style: none;
      height: 32px;
      width: 100%;
    }

    ul.tabs li {
      float: left;
      margin-right: 5px;
      cursor: pointer;
      padding: 0px 21px;
      line-height: 31px;
      background-color: #5d6771;
      color: #ccc;
      overflow: hidden;
      position: relative;
    }

    ul.tabs li:hover {
      background-color: #81bd43;
      color: #333;
    }

    ul.tabs li.active {
      background-color: #81bd43;
      color: #333;
      border-bottom: 1px solid #fff;
      display: block;
    }

    .tab_container {
      clear: both;
      float: left;
      width: 100%;
      background: #fff;
      overflow: auto;
    }
    .tab_content {
      padding: 20px;
      display: none;
    }

    .tab_drawer_heading { display: none; }

    @media screen and (max-width: 480px) {
      .tabs {
        display: none;
      }
      .tab_drawer_heading {
        background-color: #5d6771;
        color: #fff;
        margin: 0;
        padding: 5px 20px;
        display: block;
        cursor: pointer;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .d_active {
        background-color: #81bd43;
        color: #fff;
      }
    }
    /* Datagrid */
    .coverForm {
      width: max-content;
    }
    table {
      width: auto;
      border-collapse: collapse;
    }

    input[type="text"], input[type="email"], input[type="date"], input[type="checkbox"], select {
        width: 100%;
        padding: 5px;
        font-size: 13px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        background: white;
        color:#5d6771;
    }
    select:focus {
    border-color: #81bd41; 
    }
    input:focus {
    border-color: #81bd41; 
    }
    
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    
    th {
      background-color: #81bd43;
      font-size:13px;
    }
    
    @media only screen and (max-width: 600px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      
      thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
      }
      
      tr {
        margin-bottom: 15px;
        border: 1px solid #ccc;
      }
      
      td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
      }
      
      td:before {
        position: absolute;
        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        content: attr(data-label);
        font-weight: bold;
      }

      .coverForm {
      width:100%;
    }
    }
    
    .add-button, .remove-button, .save-button {
      display: inline-block;
      background-color: #81bd43;
      margin-top: 10px;
      border-radius: 0px;
      padding-top: 2px;
      padding-left: 10px;
      padding-right: 10px;
      padding-bottom: 2px;
    }
    button:hover {
      background-color: #81bd43;
    }
    .prodselect {
      width: 410px;
      margin-bottom: 10px;
    }

    /* Style for Alert Box */
    .alert {
    position: fixed;
    bottom: -100%;
    right: -100%; 
    transition: bottom 0.5s ease-in-out, right 0.5s ease-in-out; 
    }
    .alert.show {
        bottom: 10px; 
        right: 10px; 
    }
/* Style for dropdown section */
    .form-container-dropdown {
  display: flex;
  flex-wrap: wrap;
}
.form-container > div {
  flex: 1;
  min-width: 200px;
}

.prodselect {
  width: 250px;
  padding: 8px;
  box-sizing: border-box;
}

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

</style>
</style>

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
      <div class="container mt-4" style="max-width:1100px"> 
      <div class="tabform-container">
      <ul class="tabs">
        <li class="active" rel="tab1">Product Cover</li> 
        <li class="" rel="tab2">Instructions (Formula and Code BLocks)</li> 
      </ul>
      <div class="tab_container">
        <h3 class="d_active tab_drawer_heading" rel="tab1">Product Cover</h3>
        <h3 class="tab_drawer_heading" rel="tab2">Instructions (Formula and Code BLocks)</h3>
      <div id="tab1" class="tab_content">
 
      <!-- Alert Messages -->
      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
      </svg>
      <!-- Trigger Message -->
          <?php
          if ($notificationTrigger === "1") {
            $TriggerSVG = '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>';
            $TriggerClass = 'alert alert-success d-flex align-items-center';
          }
          elseif ($notificationTrigger === "2") {
            $TriggerSVG = '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
            $TriggerClass = 'alert alert-warning d-flex align-items-center';
          }
          elseif ($notificationTrigger === "3") {
            $TriggerSVG = '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
            $TriggerClass = 'alert alert-danger d-flex align-items-center';
          }
          else {    
            $TriggerSVG = "";
            $TriggerClass = "";
          } 
          ?>
      <!-- Message Box -->
      <div id="alert" class="<?php echo $TriggerClass ?>" role="alert">
        <?php echo $TriggerSVG ?>
        <div>
        &nbsp; <?php echo $notification ?>
        </div>
      </div>

      <!-- End Alert Messages -->

        <!-- Product Cover Form -->
        <form class="coverForm" id="coverForm" action="submit-prodcover.php" method="POST">
        <div class="form-container-dropdown"> <!-- dropdown section  -->
        <div>
            <select class = "prodselect" name="channelCode" id="channel_select">
              <option value=""><?php echo $chnlName ?></option>
              <?php
              $sqlchnl = "SELECT * FROM tbl_business_channel_mt WHERE status = 1";
              $resultchnl = $con->query($sqlchnl);

              while ($rowchnl = $resultchnl->fetch_assoc()) {
                  $chnlCode = $rowchnl['code'];
                  $chnlName = $rowchnl['name'];
                  echo "<option value='$chnlCode'>$chnlName</option>";
              }
              ?>
            </select>
          </div>  
        
        <div>
            <select class = "prodselect" name="compCode" id="company_select">
              <option value=""><?php echo $compName ?></option>
              <?php
              $sqlcomp = "SELECT * FROM tbl_company_mt WHERE bus_channel = '$SelectChannelCode'";
              $resultcomp = $con->query($sqlcomp);

              while ($rowcomp = $resultcomp->fetch_assoc()) {
                  $compCode = $rowcomp['code'];
                  $compName = $rowcomp['name'];
                  echo "<option value='$compCode'>$compName</option>";
              }
              ?>
            </select>
          </div>

          <div>
            <select class = "prodselect" name="prodcode" id="product_select">
                  <option value=""><?php echo $prodName ?></option>
                  <?php
                    $sqlProduct = "SELECT * FROM tbl_product_mt WHERE product_stat = 1";
                    $resultProduct = $con->query($sqlProduct);

                    while ($rowProduct = $resultProduct->fetch_assoc()) {
                        $productClass = $rowProduct['product_calss'];
                        $productDes = $rowProduct['product_des'];
                        echo "<option value='$productClass'>$productDes</option>";
                    }
                  ?>
            </select>
          </div> 
          </div> <!-- End of dropdown section  -->
        <div class="table-responsive">
        <table class="custom-table">
          <thead>
            <tr>
              <th>Company Code</th>
              <th>Product Code</th>
              <th>Product Class</th>
              <th>Cover Code</th>
              <th>Tax Stat</th>
              <th>Basic Stat</th>
              <th>Default Stat</th>
              <th>Calculation Seq</th>
              <th>Calculation Type</th>
              <th>Initial Amount</th>
              <th>Variation Amounts</th>
              <th>Cover Formula</th>
              <th>Code Block</th>
              <th>Max Limit</th>
              <th>Free Up To</th>
              <th>Cover Ex Persentage</th>
              <th>Cover Ex Amount</th>
              <th>Display Seq</th>
              <th>Print Seq</th>
              <th>Rate</th>
              <th>Edit Flag</th>
              <th>Is Process</th>
              <th>Placement</th>
              <th>Display Cover</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="coverTable">
          <?php
            $prod_code = 'V001';
            // $sql = "SELECT tbl_product_cover_mt.*, tbl_covers_mt.cover_description
            //         FROM tbl_product_cover_mt
            //         JOIN tbl_covers_mt
            //         ON tbl_product_cover_mt.cover_code = tbl_covers_mt.cover_code
            //         WHERE tbl_product_cover_mt.prod_code = '$prod_code'
            //         AND tbl_product_cover_mt.remark = 'P'";
            if(!empty($SelectProductClass)){
            $sql = "SELECT tbl_product_cover_mt.*, tbl_covers_mt.cover_description
                    FROM tbl_product_cover_mt
                    JOIN tbl_covers_mt
                    ON tbl_product_cover_mt.cover_code = tbl_covers_mt.cover_code
                    WHERE tbl_product_cover_mt.prod_class = '$SelectProductClass'
                    AND tbl_product_cover_mt.remark = 'P'
                    AND tbl_product_cover_mt.comp_code = '$SelectCompanyCode'";

            
            $result = $con->query($sql);
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                <td data-label='ID' style='display:none;'><input type='text' name='id[]' value='{$row['id']}' readonly></td>
                <td data-label='Company Code'><input type='text' name='company[]' value='{$row['comp_code']}' readonly></td>
                <td data-label='Product Code'><input type='text' name='product[]' value='{$row['prod_code']}' readonly></td>
                <td data-label='Product Class'><input type='text' name='product_class[]' value='{$row['prod_class']}' readonly></td>
                <td data-label='Cover Code'><select name='cover_code[]'><option value='{$row['cover_code']}' selected>{$row['cover_description']}</option></select></td>
                <td data-label='Tax Stat'><input type='text' name='tax_stat[]' value='{$row['tax_stat']}'></td>
                <td data-label='Basic Stat'><input type='text' name='basic_stat[]' value='{$row['basic_stat']}'></td>
                <td data-label='Default Stat'><select name='default_stat[]'><option value='y' " . ($row['default_stat'] == 'y' ? 'selected' : '') . ">Yes</option><option value='n' " . ($row['default_stat'] == 'n' ? 'selected' : '') . ">No</option></select></td>
                <td data-label='Calculation Seq'><select name='calc_seq[]'><option value='{$row['calc_seq']}' selected>{$row['calc_seq']}</option></select></td>
                <td data-label='Calculation Type'><select name='calc_type[]'><option value='{$row['calc_type']}' selected>{$row['calc_type']}</option></select></td>
                <td data-label='Initial Amount'><input type='text' name='initial_amt[]' value='{$row['initial_amt']}'></td>
                <td data-label='Initial Amount'><input type='text' name='variation_amt[]' value='{$row['variation_amounts']}'></td>
                <td data-label='Cover Formula'><input type='text' name='cover_formula[]' value='" . htmlspecialchars($row['cov_formula'], ENT_QUOTES, 'UTF-8') . "'></td>
                <td data-label='Code Block'><input type='text' name='code_block[]' value='" . htmlspecialchars($row['code_block'], ENT_QUOTES, 'UTF-8') . "'></td>
                <td data-label='Max Limit'><input type='text' name='max_limit[]' value='{$row['max_limit']}'></td>
                <td data-label='Free Up To'><input type='text' name='free_upto[]' value='{$row['free_upto']}'></td>
                <td data-label='Cover Ex Percentage'><input type='text' name='cover_ex_per[]' value='{$row['cover_ex_per']}'></td>
                <td data-label='Cover Ex Amount'><input type='text' name='cover_ex_amt[]' value='{$row['cover_ex_amt']}'></td>
                <td data-label='Display Seq'><select name='dis_seq[]'><option value='{$row['cover_dis_seq']}' selected>{$row['cover_dis_seq']}</option></select></td>
                <td data-label='Print Seq'><select name='print_seq[]'><option value='{$row['cover_prt_seq']}' selected>{$row['cover_prt_seq']}</option></select></td>
                <td data-label='Rate'><input type='text' name='cover_rate[]' value='{$row['cover_rate']}'></td>
                <td data-label='Edit Flag'><select name='edit_flag[]'><option value='yes' " . ($row['edit_flag'] == 'yes' ? 'selected' : '') . ">Yes</option><option value='no' " . ($row['edit_flag'] == 'no' ? 'selected' : '') . ">No</option></select></td>
                <td data-label='Is Process'><select name='is_process[]'><option value='yes' " . ($row['is_process'] == 'yes' ? 'selected' : '') . ">Yes</option><option value='no' " . ($row['is_process'] == 'no' ? 'selected' : '') . ">No</option></select></td>
                <td data-label='Placement'><select name='placement[]' required><option value='{$row['cover_cal_area']}' selected>{$row['cover_cal_area']}</option></select></td>
                <td data-label='Display Cover'>
                    <select name='displayCover[]' required>
                        <option value='1' " .($row['display_cover'] == '1' ? 'selected' : '') . ">Yes</option>
                        <option value='0' " .($row['display_cover'] == '0' ? 'selected' : '') . ">No</option>
                    </select>
                </td>
                <td style='display:none;' data-label='Packages'><select name='packages[]' required><option value='{$row['remark']}' selected>{$row['remark']}</option></select></td>
                <td data-label='Action'><button class='remove-button' onclick='removeCoverRow(this)'>-</button></td>
              </tr>";
            }
          }
          ?>
        </tbody>
        </table>

        <button class="add-button" type="button" onclick="addCoverRow()">+</button>
        <a href="reset-productCoverMotor.php" class="save-button" style="color: black;">Rest Form</a>
        <button class="save-button" type="submit">Save</button>

      </div>
      </form>
      <script>

        function addCoverRow() {
          var tableBody = document.getElementById("coverTable");
          var newRow = document.createElement("tr");

          newRow.innerHTML = `
          <td data-lable= "Company Code" style="display:none;">
                <input type="text" name="id[]" value="" readonly>
          </td>
          <td data-lable= "Company Code">
                <input type="text" name="company[]" value="<?php echo $SelectCompanyCode ?>" readonly>
          </td>
          <td data-lable= "Product Code">
                <input type="text" name="product[]" value="<?php echo $SelectProductCode ?>" readonly>
              </td>
          <td data-label="Product Class">
                <input type="text" name="product_class[]" value="<?php echo $SelectProductClass ?>" readonly>
              </td>
              <td data-label="Cover Code">
                <select name="cover_code[]" required>
                  <option value="">Select</option>
                  <?php
                    $sqlCovers = "SELECT * FROM tbl_covers_mt WHERE cover_stat = 1";
                    $resultCovers = $con->query($sqlCovers);

                    while ($rowCovers = $resultCovers->fetch_assoc()) {
                        $coverCode = $rowCovers['cover_code'];
                        $coverDesc = $rowCovers['cover_description'];
                        echo "<option value='$coverCode'>$coverDesc</option>";
                    }
                  ?>
                </select>
              </td>
              <td data-label="Tax Stat">
                <input type="text" name="tax_stat[]">
              </td>
              <td data-label="Basic Stat">
                <input type="text" name="basic_stat[]">
              </td>
              <td data-label="Default Stat">
                <select name="default_stat[]">
                  <option value="y">Yes</option>
                  <option value="n">No</option>
                </select>
              </td>
              <td data-label="Calculation Seq">
                <select name="calc_seq[]">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                </select>
              </td>
              <td data-label="Calculation Type">
                <select name="calc_type[]">
                  <option value="sql-formula">Sql + Formula</option>
                  <option value="cal">Calculation</option>
                  <option value="rate">Rate</option>
                  <option value="fixed">Fixed</option>
                  <option value="user-input">User Input</option>
                </select>
              </td>
              <td data-label="Initial Amount">
                <input type="text" name="initial_amt[]">
              </td>
              <td data-label="Variation Amount">
                <input type="text" name="variation_amt[]">
              </td>
              <td data-label="Cover Formula (sql query)">
                <input type="text" name="cover_formula[]">
              </td>
              <td data-label="Code Block">
                <input type="text" name="code_block[]">
              </td>
              <td data-label="Max Limit">
                <input type="text" name="max_limit[]">
              </td>
              <td data-label="Free Up To">
                <input type="text" name="free_upto[]">
              </td>
              <td data-label="Cover Ex Persentage">
                <input type="text" name="cover_ex_per[]">
              </td>
              <td data-label="Cover Ex Amount">
                <input type="text" name="cover_ex_amt[]">
              </td>
              <td data-label="Display Seq">
                <select name="dis_seq[]">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                </select>
              </td>
              <td data-label="Print Seq">
              <select name="print_seq[]">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
              </select>
              </td>
              <td data-label="Rate">
                <input type="text" name="cover_rate[]">
              </td>
              <td data-label="Edit Flag">
                <select name="edit_flag[]">
                  <option value="yes">Yes</option>
                  <option value="no" selected>No</option>
                </select>
              </td>
              <td data-label="Is Process">
                <select name="is_process[]">
                  <option value="yes"selected>Yes</option>
                  <option value="no">No</option>
                </select>
              </td>
              <td data-label="Placement">
                <select name="placement[]" required>
                  <option value="">Select</option>
                  <option value="T"selected>Top</option>
                  <option value="B">Bottom</option>
                </select>
              </td>
              <td data-label="Display Cover">
                <select name="displayCover[]" required>
                  <option value="">Select</option>
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
              </td>
              <td style='display:none;' data-label="Packages">
                <select name="packages[]" required>
                  <option value="P">Package</option>
                </select>
              </td>
              <td data-label="Action">
                <button class="remove-button" onclick="removeCoverRow(this)">-</button>
              </td>
          `;
          
          tableBody.appendChild(newRow);
        }

        function removeCoverRow(button) {
          var row = button.parentNode.parentNode;
          row.parentNode.removeChild(row);
        }
      </script>

        <!-- End Product Cover Form -->
  </div>

  <!-- #tab1 -->
</div>
<!-- .tab_container -->

      <!-- Code here -->
   
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/file-upload.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>
  <!-- End custom js for this page-->

  <!-- Tab Content -->
  <script>
    // tabbed content
    // http://www.entheosweb.com/tutorials/css/tabs.asp
    $(".tab_content").hide();
    $(".tab_content:first").show();

  /* if in tab mode */
    $("ul.tabs li").click(function() {
		
      $(".tab_content").hide();
      var activeTab = $(this).attr("rel"); 
      $("#"+activeTab).fadeIn();		
		
      $("ul.tabs li").removeClass("active");
      $(this).addClass("active");

	  $(".tab_drawer_heading").removeClass("d_active");
	  $(".tab_drawer_heading[rel^='"+activeTab+"']").addClass("d_active");
	  
    });
	/* if in drawer mode */
	$(".tab_drawer_heading").click(function() {
      
      $(".tab_content").hide();
      var d_activeTab = $(this).attr("rel"); 
      $("#"+d_activeTab).fadeIn();
	  
	  $(".tab_drawer_heading").removeClass("d_active");
      $(this).addClass("d_active");
	  
	  $("ul.tabs li").removeClass("active");
	  $("ul.tabs li[rel^='"+d_activeTab+"']").addClass("active");
    });
	
	
	/* Extra class "tab_last" 
	   to add border to right side
	   of last tab */
	$('ul.tabs li').last().addClass("tab_last");
	

  // Display selected Channel Code from the channel dropdown on the table fileds.

  $(document).ready(function(){
    $('#channel_select').change(function(){
        var selectedChannel = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'store_selected_channel.php',
            data: { selectedChannel: selectedChannel },
            success: function(response){
                console.log(response);
                $('.channel-code').val(response); 
                location.reload(); 
            }
        });
    });
});

// Display selected Product Code from the product dropdown on the table fileds.

$(document).ready(function(){
    $('#product_select').change(function(){
        var selectedProduct = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'store_selected_product.php',
            data: { selectedProduct: selectedProduct },
            success: function(response){
                console.log(response);
                $('.product-code').val(response); 
                location.reload(); 
            }
        });
    });
});


// Display selected Company Code from the company dropdown on the table fileds.

$(document).ready(function(){
    $('#company_select').change(function(){
        var selectedCompany = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'store_selected_company.php',
            data: { selectedCompany: selectedCompany },
            success: function(response){
                console.log(response);
                $('.company-code').val(response); 
                location.reload(); 
            }
        });
    });
});

// Code for Error handling notification message

document.addEventListener('DOMContentLoaded', function() {
    const alert = document.getElementById('alert');
    alert.classList.add('show');
    setTimeout(function() {
        alert.classList.remove('show');
    }, 4500);
});
  </script>
</body>

</html>
<?php } ?>