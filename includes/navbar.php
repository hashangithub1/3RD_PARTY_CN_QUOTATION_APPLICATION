<?php
if (!isset($_SESSION['notifications'])) {
  $_SESSION['notifications'] = [];
}

$unreadCount = 0;
if (isset($_SESSION['notifications']) && !empty($_SESSION['notifications'])) {
foreach ($_SESSION['notifications'] as $notification) {
    if (!$notification['is_read']) {
        $unreadCount++;
    }
}
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="dashboard.php"><img src="images/header-logo.png" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="dashboard.php"><img src="images/logo-mini.jpg" alt="logo"/></a>
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
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="notificationDropdown">
                    <i class="fas fa-bell custom-icon"></i>
                    <span class="badge badge-pill badge-danger" id="notificationCount"><?= $unreadCount; ?></span> <!-- Notification Count -->
                </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
                  <h6 class="dropdown-header"><i class="fas fa-bell"></i>Notifications</h6>
                  <div class="dropdown-divider"></div>
                  <div class="dropdown-body" id="notificationsBody">
                      <?php
                      if (isset($_SESSION['notifications']) && !empty($_SESSION['notifications'])) {
                        echo '<ul>';
                        foreach ($_SESSION['notifications'] as $notification) {
                            $status = $notification['is_read'] ? 'read' : 'unread';
                            
                            echo '<li>';
                            echo '<strong>' . $notification['message'] . '</strong><br>';
                            echo '<small>' . $notification['time'] . '</small><br>';
                            echo '</li><br>';
                        }
                        echo '</ul>';
                    } else {
                        echo 'No notifications available.';
                    }
                      ?>
                  </div>
              </div>
          </li>


          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            <i class="fas fa-circle-user custom-icon"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <!--a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Profile
              </a-->
              <a class="dropdown-item" href="#" onclick="logout()">
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
                document.location = "index.php";
            } else {
                // Handle any errors if needed
                console.error("Error during logout: " + xhr.status);
            }
        };
    }

    function markAllAsRead() {
        // Send an AJAX request to mark notifications as read
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'include/mark_as_read.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Update the notification count to 0
                document.getElementById('notificationCount').innerText = '0';
                // Optionally, you can reload the notifications body to reflect the "read" status
                document.getElementById('notificationsBody').innerHTML = xhr.responseText;
            }
        };
        
        xhr.send(); // Send the request without any data
    }
    </script>
    <style>
      .navbar .navbar-menu-wrapper {
        background: #1e1e1e;
      }
      .navbar .navbar-brand-wrapper {
        background: #1e1e1e;
      }
      .custom-icon {
          font-size: 24px; /* Adjust the size as needed */
      }

      /* notifications */

      .custom-icon {
    font-size: 24px;
      }

      .badge-pill {
          position: absolute;
          top: 10px;
          right: 10px;
          font-size: 8px;
      }
      .dropdown-header {
        color: #DDDEDF;
      }
      .dropdown-body {
          max-height: 300px;
          overflow-y: auto;
      }

      .notification-item {
          padding: 10px;
          border-bottom: 1px solid #e0e0e0;
      }

      .notification-item:hover {
          background-color: #f1f1f1;
      }

      .dropdown-footer {
          padding: 10px;
      }
      .dropdown-menu {
        color: #DDDEDF;
        padding-left: 15px;
        padding-right: 15px;
        min-width: 15rem;
        background-color: #1e1e1e;
      }
      .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .navbar-dropdown .dropdown-item {
        color: #DDDEDF;
      }
      .dropdown-item:hover, .dropdown-item:focus {
        background-color: #2f2f31;
      }
      
      @media (max-width: 985px) {
        .badge-pill {
          right: 111px;
      }
    }

    </style>
