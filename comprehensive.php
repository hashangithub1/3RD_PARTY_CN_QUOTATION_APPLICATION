<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
    $notificationcomp = !empty($_SESSION['notificationcomp']) ? $_SESSION['notificationcomp'] : null;   
    $notificationTriggercomp = !empty($_SESSION['notification_handlecomp']) ? $_SESSION['notification_handlecomp'] : null;   

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Plugin css for branch dropdown -->
  

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amana | Quotation Formats</title>
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
     <!-- Include Font Awesome -->  
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .d-flex {
    display: flex;
}

.justify-content-between {
    justify-content: space-between;
}

.align-items-center {
    align-items: center;
}


.app-downloads {
    text-align: center;
}

.app-downloads p {
    margin-bottom: 0;
}

.app-icon {
    width: 100px; /* Adjust as needed */
    margin-left: 10px; /* Adjust as needed */
}

</style>
    </head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include_once('includes/navbar.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php'); ?>
      <!-- partial -->

      <!-- grant permission for upload section -->
        <?php
        $query1 = "SELECT role FROM tbl_staff WHERE id = '$userID'";
        $result2 = $con->query($query1);

        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            if ($row2['role'] == 'admin') {
            $access = "1";
            }
            elseif($row2['role'] == 'user-1') {
                $access = "1";
            } 
            else {
                $access = null;
            }
        } else {
            $access = null;
        }
        ?>
      <!-- End grant permission for upload section -->

      <!-- Code here -->

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
          if ($notificationTriggercomp === "1") {
            $TriggerSVG = '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>';
            $TriggerClass = 'alert alert-success d-flex align-items-center';
          }
          elseif ($notificationTriggercomp === "2") {
            $TriggerSVG = '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
            $TriggerClass = 'alert alert-warning d-flex align-items-center';
          }
          elseif ($notificationTriggercomp === "3") {
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
        &nbsp; <?php echo $notificationcomp ?>
        </div>
      </div>

      <!-- End Alert Messages -->

      <div class="container mt-4">
        <br><br>
        <div class="notice">
            <h3>Quotation Formats</h3>
            <p class="lead">To download files, please use the links provided below:</p>
        </div>

        <div class="guidline">
        <i class="fas fa-list icon"></i><a class="mp-lable" href="guidline.php" >   Motor Package Guideline</a>
        <br><br>
        <div class="app-downloads">
            <p class="mp-lable">Download the Amana Takaful Mobile App</p>
            <a href="https://play.google.com/store/apps/details?id=com.amanatakaful.mobile" target="_blank">
                <img src="assets/images/googleplay.png" alt="Download on Google Play" class="app-icon">
            </a>
            <a href="https://apps.apple.com/lk/app/amana-takaful-insurance-app/id1620808625" target="_blank">
                <img src="assets/images/appsstore.png" alt="Download on the App Store" class="app-icon">
            </a>
        </div>    
    </div>

        
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Motor Package Guideline</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Add content of your guideline here -->
        <p>This is where your guideline content goes.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Model -->


<div class="tile" id="tile-1">

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-justified" role="tablist">
  <div class="slider"></div>
   <li class="nav-item">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"> Leasing-Broker (MC & TW)</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"> Other Packages</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"> Special Leasing 4W Quote</a>
    </li>
  <li class="nav-item">
      <a class="nav-link" id="setting-tab" data-toggle="tab" href="#setting" role="tab" aria-controls="setting" aria-selected="false"> Standard Quotes</a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <script>
        function openFolder1() {
            var folderPath = 'Quotation_Formats/Leasing-Broker%20(MC%20&%20TW)%20-%20%5bDont%20Share%5d/';
            window.open(folderPath);
        }
    </script>
    <br>
    <button type="submit" class = "btn btn-primary mr-2 btn-icon-text" onclick="openFolder1()">
            Open Folder
            <i class="ti-folder btn-icon-append"></i>
        </button>
  <!-- File uplaod button -->
  <!-- <button type="button" class="btn btn-primary mr-2 btn-icon-text" onclick="openModal('myModal1')">Upload
  <i class="fas fa-upload btn-icon-append"></i></button> -->
<?php
  if ($access === "1") {
    echo '<button type="button" class="btn btn-primary mr-2 btn-icon-text" onclick="openModal(\'myModal1\')">Upload
    <i class="fas fa-upload btn-icon-append"></i></button>';
}
?>
  <!-- File uplaod button -->

  <!-- File delete button -->
  <?php
  if ($access === "1"){
  echo '<button type="button" class="btn btn-primary mr-2 btn-icon-text" onclick="deletefiles1()">Delete All
    <i class="fas fa-trash-alt btn-icon-append"></i>
  </button>';
  }
  ?>
  <!-- File delete button -->
    
  <!-- Modal Template -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Upload Files and Folders</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadForm1" enctype="multipart/form-data">
                    <input type="file" id="fileInput1" name="files[]" multiple style="display:none;">
                    <div id="dropZone1">Drag & Drop Files/Folders Here or Click to Browse</div>
                    <p style="margin-top:10px;">* Uploaded files will overwrite the existing files.</p>
                    <div id="progressBarContainer1">
                        <div id="progressBar1">
                            <div id="progress1">0%</div>
                        </div>
                    </div>
                    
                    <div id="fileList1"></div>
                    <button class="btn btn-primary mr-2 btn-icon-text" id="btn-01" type="submit" style="margin-top: 10px;">Upload</button>
                </form>
                <div id="result1"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Template -->
  </div>
<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
<script>
        function openFolder2() {
            var folderPath = 'Quotation_Formats/Other%20Packages/';
            window.open(folderPath);
        }
    </script>
    <br>
    <button type="submit" class = "btn btn-primary mr-2 btn-icon-text" onclick="openFolder2()">
            Open Folder
            <i class="ti-folder btn-icon-append"></i>
        </button>
  
 <!-- File uplaod button -->
 <?php
if ($access === "1") {
    echo ' <button type="button" class="btn btn-primary mr-2 btn-icon-text" onclick="openModal(\'myModal2\')">Upload
    <i class="fas fa-upload btn-icon-append"></i></button>';
}
?>
 <!-- File uplaod button -->

 <!-- File delete button -->
 <?php
if ($access === "1") {
    echo '<button type="button" class="btn btn-primary mr-2 btn-icon-text" onclick="deletefiles2()" style="display: ">Delete All
    <i class="fas fa-trash-alt btn-icon-append"></i>
    </button>';
}
?>
 <!-- File delete button -->

  <!-- Modal Template -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Upload Files and Folders</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadForm2" enctype="multipart/form-data">
                    <input type="file" id="fileInput2" name="files[]" multiple style="display:none;">
                    <div id="dropZone2">Drag & Drop Files/Folders Here or Click to Browse</div>
                    <p style="margin-top:10px;">* Uploaded files will overwrite the existing files.</p>
                    <div id="progressBarContainer2">
                        <div id="progressBar2">
                            <div id="progress2">0%</div>
                        </div>
                    </div>
                    <div id="fileList2"></div>
                    <button class="btn btn-primary mr-2 btn-icon-text" id="btn-02" type="submit" style="margin-top: 10px;">Upload</button>
                </form>
                <div id="result2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Template -->

</div>
<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
<script>
        function openFolder3() {
            var folderPath = 'Quotation_Formats/Special%20Leasing%204W%20Quote/';
            window.open(folderPath);
        }
    </script>
    <br>
    <button type="submit" class = "btn btn-primary mr-2 btn-icon-text" onclick="openFolder3()">
            Open Folder
            <i class="ti-folder btn-icon-append"></i>
        </button>

<!-- File uplaod button -->
<?php
if ($access === "1") {
    echo '<button type="button" class="btn btn-primary mr-2 btn-icon-text" onclick="openModal(\'myModal3\')">Upload
    <i class="fas fa-upload btn-icon-append"></i></button>';
}
?>
<!-- File uplaod button -->

<!-- File delete button -->
<?php
if ($access === "1") {
    echo '<button type="button" class="btn btn-primary mr-2 btn-icon-text" onclick="deletefiles3()">Delete All
    <i class="fas fa-trash-alt btn-icon-append"></i>
    </button>';
}
?>
<!-- File delete button -->

  <!-- Modal Template -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Upload Files and Folders</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadForm3" enctype="multipart/form-data">
                    <input type="file" id="fileInput3" name="files[]" multiple style="display:none;">
                    <div id="dropZone3">Drag & Drop Files/Folders Here or Click to Browse</div>
                    <p style="margin-top:10px;">* Uploaded files will overwrite the existing files.</p>
                    <div id="progressBarContainer3">
                        <div id="progressBar3">
                            <div id="progress3">0%</div>
                        </div>
                    </div>
                    <div id="fileList3"></div>
                    <button class="btn btn-primary mr-2 btn-icon-text" id="btn-03" type="submit" style="margin-top: 10px;">Upload</button>
                </form>
                <div id="result3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Template -->

</div>
<div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">
<script>
        function openFolder4() {
            var folderPath = 'Quotation_Formats/Standard%20Quotes%20%20-%20Underwriters%20%5bDont%20Share%5d/';
            window.open(folderPath);
        }
    </script>
    <br>
    <button type="submit" class = "btn btn-primary mr-2 btn-icon-text" onclick="openFolder4()">
            Open Folder
            <i class="ti-folder btn-icon-append"></i>
        </button>

<!-- File uplaod button -->
<?php
if ($access === "1") {
    echo '<button type="button" class="btn btn-primary mr-2 btn-icon-text" onclick="openModal(\'myModal4\')">Upload
    <i class="fas fa-upload btn-icon-append"></i></button>';
}
?>

<!-- File uplaod button -->

<!-- File delete button -->
<?php
if ($access === "1") {
    echo '<button type="button" class="btn btn-primary mr-2 btn-icon-text" onclick="deletefiles4()">Delete All
    <i class="fas fa-trash-alt btn-icon-append"></i>
    </button>';
}
?>
<!-- File delete button -->

  <!-- Modal Template -->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Upload Files and Folders</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadForm4" enctype="multipart/form-data">
                    <input type="file" id="fileInput4" name="files[]" multiple style="display:none;">
                    <div id="dropZone4">Drag & Drop Files/Folders Here or Click to Browse</div>
                    <p style="margin-top:10px;">* Uploaded files will overwrite the existing files.</p>
                    <div id="progressBarContainer4">
                        <div id="progressBar4">
                            <div id="progress4">0%</div>
                        </div>
                    </div>
                    <div id="fileList4"></div>
                    <button class="btn btn-primary mr-2 btn-icon-text" id="btn-04" type="submit" style="margin-top: 10px;">Upload</button>
                </form>
                <div id="result4"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Template -->
</div>
</div>

</div>
      <!-- Code here -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include Select2 CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-WP/GJ6hW4m2iH0zL0tMNBO5Uv/hlOe5BhFXC0bFGsOq68y9PeYrPZlGJUOB3Jhx4bkG5FV6PV6i/G1V0jKqvow==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-BJQ+uMI3q4yYJg9KkhU/W2l9rUObq8aIBhi9q4ao3L6NXpzO0KwxgeC5cvBx5Jiy8RufaJG2H0Q19vq3XtMq8w==" crossorigin="anonymous"></script>

    <br><br>
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
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>
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
</body>
<script>
    // Add your JavaScript code for filtering/searching here
    $(document).ready(function () {
        $("#searchInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });


</script>

<style>
    body
{
  background-color:#f1f1f2;
}
.tile
{
  width:100%;
  margin:60px auto;
}
#tile-1 .tab-pane
{
  padding:15px;
  height:80px;
}
#tile-1 .nav-tabs
{
  position:relative;
  border:none!important;
  background-color:#fff;
/*   box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2); */
  border-radius:6px;
}
#tile-1 .nav-tabs li
{
  margin:0px!important;
}
#tile-1 .nav-tabs li a
{
  position:relative;
  margin-right:0px!important;
  padding: 20px 40px!important;
  font-size:16px;
  border:none!important;
  color:#333;
}
#tile-1 .nav-tabs a:hover
{
  background-color:#fff!important;
  border:none;
}
#tile-1 .slider
{
  /* display:inline-block; */
  width:30px;
  height:4px;
  border-radius:3px;
  background-color:#81bd43 ;
  position:absolute;
  z-index:1200;
  bottom:0;
  transition:all .4s linear;
  
}
#tile-1 .nav-tabs .active
{
  background-color:transparent!important;
  border:none!important;
  color:#81bd43!important;
}

.notice {
    background-color: #81bd44;
    color: #fff;
    padding: 15px;
    border-radius: 10px;
    text-align: center;
}

.notice h3 {
    margin-bottom: 10px;
}

/* Form Background Effect*/ 
.guidline {
    background-color: white;
    border-bottom: 1px solid #ddd;
    padding:15px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    text-align:center;

  }
  .icon{
   color: #81bd44;
  }
  .mp-lable{
    color: #81bd44;
  }
  .slider {
    display:none;
  }

/* Upload Section */

#dropZone1 , #dropZone2 , #dropZone3 , #dropZone4 {
    border: 2px dashed #ccc;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    color: #aaa;
    font-family: Arial, sans-serif;
    cursor: pointer;
}
#dropZone1.hover , #dropZone2.hover , #dropZone3.hover , #dropZone4.hover {
    border-color: #333;
    color: #333;
}
#fileList1 , #fileList2 {
    margin-top: 20px;
}
#fileList1 ul , #fileList2 ul , #fileList3 ul , #fileList4 ul {
    list-style-type: none;
    padding: 0;
}
#fileList1 li , #fileList2 li , #fileList3 li , #fileList4 li {
    margin: 5px 0;
}
#progressBarContainer1 , #progressBarContainer2 , #progressBarContainer3 , #progressBarContainer4 {
    margin-top: 20px;
}
#progressBar1 , #progressBar2 , #progressBar3 , #progressBar4 {
    width: 100%;
    height: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
}
#progress1 , #progress2 , #progress3 , #progress4 {
    height: 100%;
    width: 0;
    background-color: #81bd44;
    text-align: center;
    color: white;
    white-space: nowrap;
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
</style>
<script>
    $("#tile-1 .nav-tabs a").click(function() {
  var position = $(this).parent().position();
  var width = $(this).parent().width();
    $("#tile-1 .slider").css({"left":+ position.left,"width":width});
});
var actWidth = $("#tile-1 .nav-tabs").find(".active").parent("li").width();
var actPosition = $("#tile-1 .nav-tabs .active").position();
$("#tile-1 .slider").css({"left":+ actPosition.left,"width": actWidth});


// File Upload Section //
function openModal(modalId) {
        $('#' + modalId).modal('show');
    }

    function setupUpload(modalIndex) {
        const dropZone = document.getElementById('dropZone' + modalIndex);
        const fileInput = document.getElementById('fileInput' + modalIndex);
        const uploadForm = document.getElementById('uploadForm' + modalIndex);
        const fileList = document.getElementById('fileList' + modalIndex);
        const progressBarContainer = document.getElementById('progressBarContainer' + modalIndex);
        const progress = document.getElementById('progress' + modalIndex);

        dropZone.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            handleFiles(event.target.files, modalIndex);
        });

        dropZone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropZone.classList.add('hover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('hover');
        });

        dropZone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropZone.classList.remove('hover');
            handleFiles(event.dataTransfer.items, modalIndex);
        });

        let filesToUpload = new Map();

        function handleFiles(items, modalIndex) {
            filesToUpload.clear(); // Clear previous files
            resetProgressBar(modalIndex); // Reset progress bar

            for (let i = 0; i < items.length; i++) {
                if (items[i] instanceof File) {
                    let file = items[i];
                    filesToUpload.set(file.name, file);
                    displayFile(file.name, modalIndex);
                } else {
                    let item = items[i].webkitGetAsEntry();
                    if (item) {
                        traverseFileTree(item, modalIndex);
                    }
                }
            }
        }

        function traverseFileTree(item, modalIndex, path = "") {
            if (item.isFile) {
                item.file(file => {
                    let relativePath = path + file.name;
                    filesToUpload.set(relativePath, file);
                    displayFile(relativePath, modalIndex);
                });
            } else if (item.isDirectory) {
                let dirReader = item.createReader();
                dirReader.readEntries(entries => {
                    for (let entry of entries) {
                        traverseFileTree(entry, modalIndex, path + item.name + "/");
                    }
                });
            }
        }

        function displayFile(fileName, modalIndex) {
            if (!fileList.querySelector('ul')) {
                fileList.innerHTML = '<ul></ul>';
            }
            let li = document.createElement('li');
            li.textContent = fileName;
            fileList.querySelector('ul').appendChild(li);
        }

        function resetProgressBar(modalIndex) {
            progress.style.width = '0%';
            progress.textContent = '0%';
        }

        document.getElementById('btn-0' + modalIndex).addEventListener('click', function(event) {
            event.preventDefault();
            let formData = new FormData();
            filesToUpload.forEach((file, relativePath) => {
                formData.append('files[]', file);
                formData.append('paths[]', relativePath);
            });

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload-quotations-0' + modalIndex + '.php', true);

            xhr.upload.onprogress = function(event) {
                if (event.lengthComputable) {
                    const percentComplete = (event.loaded / event.total) * 100;
                    progress.style.width = percentComplete + '%';
                    progress.textContent = Math.round(percentComplete) + '%';
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('result' + modalIndex).innerText = xhr.responseText;
                } else {
                    document.getElementById('result' + modalIndex).innerText = 'Upload failed!';
                }
            };

            xhr.onerror = function() {
                document.getElementById('result' + modalIndex).innerText = 'Upload failed!';
            };

            xhr.send(formData);
        });
    }

    // Initialize all upload sections
    ['1', '2', '3', '4'].forEach(setupUpload);

    //File delete section 
    // Reusable function to delete files in the specified folder
function deleteFiles(folder) {
  if (confirm('Are you sure you want to delete all files?')) {
    $.ajax({
      url: 'delete_files.php',
      type: 'POST',
      data: { folder: folder },
      success: function(response) {
        //alert(response);
        location.reload();
        
      },
      error: function(xhr, status, error) {
        alert('An error occurred: ' + xhr.responseText);
      }
    });
  }
}

// Functions to delete files in specific folders
function deletefiles1() { deleteFiles('Quotation_Formats/Leasing-Broker (MC & TW) - [Dont Share]'); }
function deletefiles2() { deleteFiles('Quotation_Formats/Other Packages'); }
function deletefiles3() { deleteFiles('Quotation_Formats/Special Leasing 4W Quote'); }
function deletefiles4() { deleteFiles('Quotation_Formats/Standard Quotes - Underwriters [Dont Share]'); }

// Code for Error handling notification message

document.addEventListener('DOMContentLoaded', function() {
    const alert = document.getElementById('alert');
    alert.classList.add('show');
    setTimeout(function() {
        alert.classList.remove('show');
    }, 4500);
});
</script>
</html>
<?php } ?>