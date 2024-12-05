<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: index.php");
    exit;
}

require_once 'config.php'; // Include the database configuration file

// Check if user ID is provided in the URL
if (!isset($_GET['user_id'])) {
    echo "User ID not provided.";
    exit;
}

$user_id = $_GET['user_id'];

// Fetch payment history for the user
$sql = "SELECT amount, payment_date FROM fees WHERE member_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Payment History</title>
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
            background-image: url('images/img/mem5.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
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
            <h2>User Payment History</h2>
            <table>
                <tr>
                    <th>Amount</th>
                    <th>Payment Date</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>$" . number_format($row["amount"], 2) . "</td>
                                <td>" . $row["payment_date"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No payment history found for this user</td></tr>";
                }
                $stmt->close();
                $conn->close();
                ?>
            </table>
            <a href="view_fees_tracking.php">Back to View Fees Tracking</a>
        </div>
    </div>
</body>
</html>
