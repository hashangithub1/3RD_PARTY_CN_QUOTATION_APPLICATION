<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="../dashboard.php"><img src="../images/header-logo.png" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="../dashboard.php"><img src="../images/logo-mini.jpg" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="../images/profile.png" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <!--a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Profile
              </a-->
              <a class="dropdown-item" href="#" onclick="logout()" >
                <i class="ti-power-off text-primary"></i>
                Logout
                
              </a>
            </div>
          </li>
          
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>

    <!-- JavaScript code to handle logout -->
<script language="javascript">
function logout() {
    // Make an AJAX request or perform any necessary client-side actions

    // Send a request to the server to destroy the PHP session
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "logout.php", true);
    xhr.send();

    // Redirect the user to the "index.php" page after session destruction
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.location = "../index.php";
        } else {
            // Handle any errors if needed
            console.error("Error during logout: " + xhr.status);
        }
    };
}
</script>
<style>
      .navbar .navbar-menu-wrapper {
        background: #1e1e1e;
      }
      .navbar .navbar-brand-wrapper {
        background: #1e1e1e;
      }
    </style>