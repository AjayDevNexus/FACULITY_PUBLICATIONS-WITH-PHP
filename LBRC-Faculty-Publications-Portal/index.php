<?php
session_start();
include('db.php');  // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];  // Get the selected role (faculty or admin)

    // Prepare SQL query based on the selected role
    if ($role == 'faculty') {
        // Query the faculty_login table using faculty_id
        $sql = "SELECT * FROM faculty_login WHERE faculty_id = ? LIMIT 1";
    } else {
        // Query the admin_login table using admin_id
        $sql = "SELECT * FROM admin_login WHERE admin_id = ? LIMIT 1";
    }

    // Prepare statement to avoid SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);  // Bind the username parameter
        $stmt->execute();
        $result = $stmt->get_result();

        // Debugging: Check the query result
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Debugging: Check the row data
            var_dump($row);

            // Direct password comparison (not using password_verify)
            if ($password === $row['password']) {
                // Password is correct, login successful
                if ($role == 'faculty') {
                    // Store session data for faculty login
                    $_SESSION['faculty_id'] = $row['faculty_id']; // Store faculty ID
                    $_SESSION['name'] = $row['name']; // Store name
                    $_SESSION['department'] = $row['department']; // Store department
                    $_SESSION['role'] = $role;  // Store role as 'faculty'

                    // Redirect to the faculty dashboard
                    header('Location: dashboard.php');
                    exit();
                } else {
                    // Store session data for admin login
                    $_SESSION['admin_id'] = $row['admin_id']; // Store admin ID
                    $_SESSION['name'] = $row['name']; // Store name
                    $_SESSION['department'] = $row['department']; // Store department
                    $_SESSION['role'] = $role;  // Store role as 'admin'

                    // Redirect to the admin dashboard
                    header('Location: admindashboard.php');
                    exit();
                }
            } else {
                // Invalid password
                $error = "Invalid username or password.";
            }
        } else {
            // No user found with the given username
            $error = "No user found with the given username. Invalid username or password.";
        }

        $stmt->close();  // Close the statement
    } else {
        // Query preparation failed
        $error = "Database query failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Make sure the body takes up the full height of the screen */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        /* Ensure the main content section takes up all available space */
        body > .form-container {
		
		   flex: 0;
        }

        /* Add some styling for the header banner */
        .header-banner {
            width: 100%;
            height: 200px;  /* Adjust the height of the banner */
            background-image: url('path_to_your_image.jpg');  /* Replace with your image path */
            background-size: cover;
            background-position: center;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;  /* Light background color */
            color: #333;  /* Dark text color for contrast */
        }

        /* Styling for the form container */
        .form-container {
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;  /* White background for the form */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Footer styling */
        footer {
            background-color: #333;  /* Dark background for footer */
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        footer .tmshisfb {
            margin-bottom: 10px;
        }

        footer .tmshisfb p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- Header Banner -->
<div class="header-banner">
    <img src="./headern.png" alt="Header Image">
</div>
<h1 style="text-align: center; margin-top: 20px;">Research Publications</h1>
<h2 style="text-align: center; margin-top: 20px;">Login Page</h2>

<?php
if (isset($error)) {
    echo "<p style='color: red; text-align: center;'>$error</p>";  // Display error message if any
}
?>

<div class="form-container">
    <form method="POST" action="">
		 <label for="role">Login as:</label>
        <input type="radio" name="role" value="faculty" checked> Faculty
        <input type="radio" name="role" value="admin"> Admin<br><br>
		
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>   

        <button type="submit">Login</button>&nbsp;&nbsp;&nbsp;
		<p><a href="register.php" targer="_self">Register Here</a></p>
    </form>
</div>

<!-- Footer Section -->
<footer>
    <section class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tmshifb">
        <div class="container">
            <div class="row">
                <div class="tmshisfb col-lg-4 col-md-2 col-sm-4 col-xs-12">
                    <!-- Add content here if needed -->
                </div>

                <div class="tmshisfb col-lg-4 col-md-6 col-sm-4 col-xs-12">
                    <p style="color:#FFFFFF">
                        @ <script>
                            var today = new Date()
                            var year = today.getFullYear()
                            document.write(year)
                        </script>
                        All Rights Reserved. <br/> 
                        Lakireddy Bali Reddy College of Engineering
                    </p>
                </div>

                <div class="tmshisfb col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <!-- Add content here if needed -->
                </div>
            </div>
        </div>
    </section>
</footer>

</body>
</html>
