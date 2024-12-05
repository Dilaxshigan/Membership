<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: index.php");
    exit;
}

require_once 'config.php'; // Include the database configuration file

// Handle form submission to add fees payment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];

    $sql = "INSERT INTO fees (member_id, amount, payment_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ids", $member_id, $amount, $payment_date);

    if ($stmt->execute()) {
        echo "Fees payment added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch all members for the dropdown
$members_sql = "SELECT id, name FROM members";
$members_result = $conn->query($members_sql);

// Fetch total payment received
$total_payment_sql = "SELECT SUM(amount) AS total FROM fees";
$total_payment_result = $conn->query($total_payment_sql);
$total_payment_row = $total_payment_result->fetch_assoc();
$total_payment = $total_payment_row['total'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees Tracking</title>
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
            background-image: url('images/img/fees.jpg'); 
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

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select,
        input[type="number"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h3 {
            margin-top: 20px;
            text-align: center;
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
            <h2>Fees Tracking</h2>
            <form action="fees_tracking.php" method="post">
                <label for="member_id">Member:</label>
                <select id="member_id" name="member_id" required>
                    <option value="">Select a member</option>
                    <?php
                    if ($members_result->num_rows > 0) {
                        while ($member = $members_result->fetch_assoc()) {
                            echo "<option value='" . $member['id'] . "'>" . $member['name'] . "</option>";
                        }
                    }
                    ?>
                </select><br>
                
                <label for="amount">Amount:</label>
                <input type="number" step="0.01" id="amount" name="amount" required><br>

                <label for="payment_date">Payment Date:</label>
                <input type="date" id="payment_date" name="payment_date" required><br>

                <input type="submit" value="Add Payment">
            </form>

            <h3>Total Payment Received: $<?php echo number_format($total_payment, 2); ?></h3>

            <a href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
