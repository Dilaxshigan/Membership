
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
            background-color: #f4f4f4;
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
        input[type="email"]
         {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="button"] {
    width: auto; /* Adjust width as needed */
    padding: 8px 15px; /* Reduce padding for smaller button */
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-align: center; /* Center-align text */
}

input[type="button"]:hover {
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
        <h2 class="text-center">My Profile</h2>
        <form action="add_member.php" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; align-items: center;">
            <div class="text-center">
                <label for="profile_img" 
                    style="border: 1px solid black; cursor: pointer; width: 180px; height: 180px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <img id="display-image" src="#" alt="Profile Image" 
                        style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </label>
                <input type="file" id="profile_img" name="profile_img" accept="image/*" style="display: none;" onchange="displayImage(this)">
            </div>
            <br>
            
            <!-- Center all form elements -->
            <div style="width: 100%; max-width: 600px;">
                <label for="name" class="semi-bold fs-5">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required><br>

                <label for="dob" class="semi-bold fs-5">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" required><br>

                <label for="city" class="semi-bold fs-5">City:</label>
                <input type="text" class="form-control" id="city" name="city" required><br>

                <label for="phone" class="semi-bold fs-5">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required><br>

                <label for="email" class="semi-bold fs-5">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required><br>

                <label for="address" class="semi-bold fs-5">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required><br>

                <label for="education" class="semi-bold fs-5">Education:</label>
                <input type="text" class="form-control" id="education" name="education" required><br>
            </div>

            <input type="button" value="Edit Profile" class="btn btn-primary mt-3">
        </form>
        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>

    <script>
function displayImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            // Display the image
            var img = document.getElementById('display-image');
            img.src = e.target.result;
            img.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]); // Read the image file as a data URL
    }
}
</script>
</body>
</html>