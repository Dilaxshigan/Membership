<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: index.php");
    exit;
}

require_once 'config.php'; // Include the database configuration file

// Define variables and initialize with empty values
$new_username = $new_password = $confirm_password = "";
$new_username_err = $new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate new username
    if (empty(trim($_POST["new_username"]))) {
        $new_username_err = "Please enter the new username.";
    } else {
        $new_username = trim($_POST["new_username"]);
    }

    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";     
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have at least 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if (empty($new_username_err) && empty($new_password_err) && empty($confirm_password_err)) {
        
        // Prepare a SQL statement to update username and password
        $sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssi", $param_username, $param_password, $param_id);
            
            // Set parameters
            $param_username = $new_username;
            $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the password
            $param_id = $_SESSION['id'];
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: index.php");
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: row;
            min-height: 100vh;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background-color: #007bff;
            padding-top: 20px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #0056b3;
        }

        .sidebar a::after {
            content: '';
            display: block;
            width: 100%;
            height: 2px;
            background-color: #fff;
            margin-top: 5px;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .sidebar a:hover::after {
            transform: scaleX(1);
        }

        /* Main content styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
            background-image: url('images/img/user.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form div {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        span {
            color: red;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: #007bff;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="add_member.php">Add Members</a></li>
            <li><a href="view_members.php">View Members</a></li>
            <li><a href="view_users.php">User Profile</a></li>
            <li><a href="fees_tracking.php">Fees Tracking</a></li>
            <li><a href="view_fees_tracking.php">View Fees Tracking</a></li>
            <li><a href="activity_tracking.php">Activity Tracking</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="container">
            <h2>Change Username and Password</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label>New Username:</label>
                    <input type="text" name="new_username" value="<?php echo $new_username; ?>">
                    <span><?php echo $new_username_err; ?></span>
                </div>    
                <div>
                    <label>New Password:</label>
                    <input type="password" name="new_password" value="<?php echo $new_password; ?>">
                    <span><?php echo $new_password_err; ?></span>
                </div>
                <div>
                    <label>Confirm Password:</label>
                    <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                    <span><?php echo $confirm_password_err; ?></span>
                </div>
                <div>
                    <input type="submit" value="Submit">
                    <a href="dashboard.php">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
