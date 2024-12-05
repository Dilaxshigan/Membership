<?php
session_start();
require_once 'config.php'; // Include the database configuration file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password != $confirm_password) {
        $signup_error = "Passwords do not match.";
    } else {
        // Check if the username already exists in `ngo_members`
        $sql = "SELECT * FROM ngo_members WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $signup_error = "Username already exists.";
        } else {
            // Encrypt the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert into `ngo_members` table
            $sql1 = "INSERT INTO ngo_members (username, password) VALUES (?, ?)";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("ss", $username, $password_hash);

            // Insert into `users` table
            $sql2 = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("ss", $username, $password_hash);

            if ($stmt1->execute() && $stmt2->execute()) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: index.php");
                exit;
            } else {
                $signup_error = "Error in creating account. Please try again.";
            }
        }

        $stmt->close();
        $stmt1->close();
        $stmt2->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up - MEMBERSHIP MANAGEMENT SYSTEM FOR NGO</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <meta name="robots" content="noindex, follow">

    <style>
        /* Add background image */
        body {
            background: url('images/img/bg2.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
        }

        /* Optional styling to make the form container stand out */
        .container-login100 {
            background: rgba(255, 255, 255, 0.5); /* Slight transparency */
            border-radius: 10px;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
            <form class="login100-form validate-form" action="signup.php" method="post">
                <span class="login100-form-title p-b-33">Create Account</span>
                <div style="text-align: center;">
                    <?php
                    if (isset($signup_error)) {
                        echo "<p style='color: red;'>$signup_error</p>";
                    }
                    ?>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Username is required">
                    <input class="input100" type="text" id="username" name="username" required placeholder="Username">
                    <span class="focus-input100-1"></span>
                    <span class="focus-input100-2"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <input class="input100" type="password" id="password" name="password" required placeholder="Password">
                    <span class="focus-input100-1"></span>
                    <span class="focus-input100-2"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password confirmation is required">
                    <input class="input100" type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm Password">
                    <span class="focus-input100-1"></span>
                    <span class="focus-input100-2"></span>
                </div>

                <div class="container-login100-form-btn m-t-20">
                    <input type="submit" value="Sign Up" class="login100-form-btn">
                </div>

                <div class="text-center">
                    <span class="txt1">Already have an account?</span>
                    <a href="index.php" class="txt2 hov1">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="vendor/animsition/js/animsition.min.js"></script>
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<script src="vendor/countdowntime/countdowntime.js"></script>
<script src="js/main.js"></script>
</body>
</html>
