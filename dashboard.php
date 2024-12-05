<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MEMBERSHIP MANAGEMENT SYSTEM FOR NGO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            min-height: 100vh;
            flex-direction: row;
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
            background-image: url('images/img/mem.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
        }

        .main-content h2 {
            color: #333;
            text-align: left;
        }

        .main-content p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .container:hover {
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.2);
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
        <h2>Dashboard</h2>
        <div class="container">
            <h3>Welcome to the Membership Management System for NGO</h3>
            <p>This system helps you manage memberships, track fees, and monitor activities efficiently. Use the sidebar to navigate through the different functionalities. Each section provides specific management tools for your NGO’s operations.</p>
            <p>For example, you can add new members, track their membership fees, or keep tabs on their participation in NGO activities. This centralized dashboard allows seamless management and provides quick access to essential features. Get started by using the menu on the left!</p>
        </div>
    </div>
</body>
</html>
