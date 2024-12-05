<?php
// Include the database configuration file
include('config.php');

// Initialize a variable to hold any JavaScript code
$jsAlert = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $education = $_POST['education'];

    // Handle file upload
    $profile_picture = $_FILES['profile_picture']['name'];
    $target_dir = "uploads/"; // Specify your upload directory
    $target_file = $target_dir . basename($profile_picture);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['profile_picture']['tmp_name']);
    if ($check === false) {
        $jsAlert = "alert('File is not an image.');";
        $uploadOk = 0;
    }

    // Check file size (5MB limit)
    if ($_FILES['profile_picture']['size'] > 5000000) {
        $jsAlert = "alert('Sorry, your file is too large.');";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $jsAlert = "alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $jsAlert = "alert('Sorry, your file was not uploaded.');";
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            // Insert data into the database
            $stmt = $conn->prepare("INSERT INTO members (name, dob, city, phone, email, address, education, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $dob, $city, $phone, $email, $address, $education, $target_file])) {
                $jsAlert = "alert('New member added successfully.');";
            } else {
                $jsAlert = "alert('Error adding member.');";
            }
        } else {
            $jsAlert = "alert('Sorry, there was an error uploading your file.');";
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
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
            background-image: url('images/img/mem3.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
        }

        .container {
            max-width: 600px;
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

        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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
            <h2>Add Member</h2>
            <form action="add_member.php" method="post" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required><br>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" required><br>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required><br>

                <label for="education">Education:</label>
                <input type="text" id="education" name="education" required><br>

                <label for="profile_picture">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*"><br>

                <input type="submit" value="Add Member">
            </form>
            <a href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
