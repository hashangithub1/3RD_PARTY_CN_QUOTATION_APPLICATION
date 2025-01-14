<?php 
session_start();
ob_start(); // Start output buffering
include_once('includes/config.php');
$error_msg = "";

// Code for login 
if (isset($_POST['login'])) {
    $password = $_POST['password'];
    $dec_password = $password;
    $useremail = $_POST['username'];
    $branch = "";
    $ret = mysqli_query($con, "SELECT id, first_name, username, role FROM tbl_staff WHERE username='$useremail' and password='$dec_password'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $query = mysqli_query($con, "SELECT branch FROM tbl_staff WHERE username='$useremail'");       
        $result = mysqli_fetch_array($query);
        $branch = $result['branch'];

        $_SESSION['id'] = $num['id'];
        $_SESSION['u_name'] = $num['username'];
        $_SESSION['name'] = $num['first_name'];
        $_SESSION['u_role'] = $num['role'];
        $_SESSION['branch'] = $branch;
        header("Location: dashboard.php");
        exit(); // Make sure to exit after the header call
    } else {
        $error_msg = "Invalid Username or Password";
    }
}
ob_end_flush(); // End output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Amana Takaful Insurance - Third Party System</title>
    <link rel="icon" href="assets/images/fav-icon.jpg" type="image/x-icon">
    <!-- amana font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="assets/images/header-logo.png" alt="Logo" class="logo">
        </div>
        <div class="login-form bai-jamjuree-regular">
            <h2 style="font-size: 20px;">Sign in to your account</h2>

            <!-- Display error message if it exists -->
            <?php if ($error_msg): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form method="post" class="bai-jamjuree-light">
                <input type="text" placeholder="Username" name="username" class="input-field" required>
                <input type="password" placeholder="Password" name="password" class="input-field" required>
                <button class="login-button bai-jamjuree-medium" name="login" id="login" type="submit">Login</button>
            </form>
        </div>
    </div>
    <footer class="app-footer">
        <div class="footer bai-jamjuree-medium">
            <small class="copyright">
                <a class="app-link" href="https://takaful.lk" target="_blank">Amana Takaful Insurance</a> 2025 © Developed by Information Technology
            </small>
        </div>
    </footer>
</body>
<style>
    /* Your CSS styles */
        /* Base styles */
body, html {
    height: 100%;
    margin: 0;
    font-family: 'Helvetica Neue', Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #24282d;
}
/* Container styling */
.container {
    text-align: center;
    background: #1e1e1e;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    width: 90%;
    max-width: 400px;
    transition: transform 0.3s ease-in-out;
    opacity: 85%;
}

.container:hover {
    transform: translateY(-10px);
}

/* Logo styling */
.logo-container {
    margin-bottom: 20px;
}

.logo {
    width: 200px;
    animation: logoAnimation 3s infinite alternate ease-in-out;
}

@keyframes logoAnimation {
    0% {
        transform: scale(1);
    }
    100% {
        transform: scale(1.2);
    }
}

/* Form styling */
.login-form h2 {
    margin-bottom: 15px;
    color: #8d9189;
}

.input-field {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 25px;
    font-size: 16px;
    transition: border-color 0.3s, box-shadow 0.3s;
    box-sizing: border-box;
}

.input-field:focus {
    border-color: #81BD43;
    box-shadow: 0 0 10px rgba(129, 189, 67, 0.5);
    outline: none;
}

.login-button {
    width: 100%;
    padding: 12px;
    background-color: #81BD43;
    color: white;
    border: none;
    border-radius: 25px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.3s;
    margin-top: 20px;
}

.login-button:hover {
    background-color: #5d6771;
    box-shadow: 0 0 10px rgba(93, 103, 113, 0.5);
}

/* Alert styling */
.alert {
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 5px;
        font-size: 16px;
        text-align: center;
    }

    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }

/* Footer styling */
.app-footer {
        width: 100%;
        text-align: center;
        /* background: #2c3e50; */
        padding: 10px 0;
        position: absolute;
        bottom: 0;
        left: 0;
        color: white;
    }

    .footer .copyright {
        font-size: 14px;
    }

    .app-link {
        color: #81BD43;
        text-decoration: none;
    }

    .app-link:hover {
        text-decoration: underline;
    }

/* Responsive design */
@media (max-width: 600px) {
    .container {
        padding: 10px;
    }

    .logo {
        width: 200px;
    }

    .input-field, .login-button {
        padding: 10px;
    }
}

.bai-jamjuree-extralight {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 200;
  font-style: normal;
}

.bai-jamjuree-light {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 300;
  font-style: normal;
}

.bai-jamjuree-regular {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 400;
  font-style: normal;
}

.bai-jamjuree-medium {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 500;
  font-style: normal;
}

.bai-jamjuree-semibold {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 600;
  font-style: normal;
}

.bai-jamjuree-bold {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 700;
  font-style: normal;
}

.bai-jamjuree-extralight-italic {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 200;
  font-style: italic;
}

.bai-jamjuree-light-italic {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 300;
  font-style: italic;
}

.bai-jamjuree-regular-italic {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 400;
  font-style: italic;
}

.bai-jamjuree-medium-italic {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 500;
  font-style: italic;
}

.bai-jamjuree-semibold-italic {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 600;
  font-style: italic;
}

.bai-jamjuree-bold-italic {
  font-family: "Bai Jamjuree", sans-serif;
  font-weight: 700;
  font-style: italic;
}

  
</style>

</html>
