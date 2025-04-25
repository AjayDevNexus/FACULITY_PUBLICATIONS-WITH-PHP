<?php
session_start();
include('db.php');  // Include the database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $mobileno = mysqli_real_escape_string($conn, $_POST['mobileno']);
    
    // Prepare the SQL query to insert data into the faculty_login table
    $sql = "INSERT INTO faculty_login (faculty_id, name, password, department, mobileno) 
            VALUES (?, ?, ?, ?, ?)";

    // Prepare statement to avoid SQL injection
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sssss", $faculty_id, $name, $password, $department, $mobileno);
        
        // Execute the query
        if ($stmt->execute()) {
            $success_message = "Registration successful! You can now log in.";
        } else {
            $error_message = "Error: Could not register. Please try again.";
        }
        
        $stmt->close();  // Close the statement
    } else {
        // Query preparation failed
        $error_message = "Database query failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Registration</title>
    <style>
        /* Basic Reset */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Flexbox Layout */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Header Styling */
        .header-banner {
            text-align: center;
            background-color: #f4f4f4;
            padding: 30px;  /* Increased padding for header */
        }

        .header-banner img {
            max-width: 100%;
            height: auto;
        }

        h1, h2 {
            font-size: 2.5em;  /* Increased header font size */
        }

        /* Form Container Styling */
        .form-container {
            max-width: 600px;  /* Reduced width */
            padding: 20px;  /* Reduced padding */
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            flex-grow: 1;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;  /* Increased font size */
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
            font-size: 1.1em;  /* Slightly smaller font size */
        }

        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container input[type="tel"],
        .form-container select {
            width: 100%;
            padding: 8px;  /* Reduced padding */
            margin-bottom: 15px;  /* Reduced margin */
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;  /* Slightly smaller font size */
        }

        .form-container button {
            width: 100%;
            padding: 10px;  /* Reduced padding */
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;  /* Slightly smaller font size */
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 1.2em;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        /* Footer Styling */
        footer {
            text-align: center;
            background-color: #333;
            color: white;
            padding: 20px;
        }
    </style>
</head>
<body>

<!-- Header Banner -->
<div class="header-banner">
    <img src="./headern.png" alt="Header Image">
</div>
<h3 style="text-align: center; ">Faculty Registration</h3>
<!-- Display Success or Error Messages -->
<?php
if (isset($success_message)) {
    echo "<p class='message success'>$success_message</p>";
} elseif (isset($error_message)) {
    echo "<p class='message error'>$error_message</p>";
}
?>

<div class="form-container">    
    <form method="POST" action="">
        <label for="faculty_id">Faculty ID:</label>
        <input type="text" name="faculty_id" required><br>

        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="department">Department:</label>
        <select name="department" required>
            <option value="ASE">ASE</option>
            <option value="AI&DS">AI&DS</option>
            <option value="CIVIL">CIVIL</option>
            <option value="CSE">CSE</option>
            <option value="CSE(AI&ML)">CSE(AI&ML)</option>
            <option value="EEE">EEE</option>
            <option value="ECE">ECE</option>
            <option value="IT">IT</option>
            <option value="MECH">MECH</option>
            <option value="MBA">MBA</option>
        </select><br>

        <label for="mobileno">Mobile No:</label>
        <input type="tel" name="mobileno" required pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number"><br>

        <button type="submit">Register</button>
    </form>

    <p class="message">Already have an account? <a href="index.php">Login here</a></p>
</div>

<!-- Footer Section -->
<footer>
    <section>
        <p>&copy; <script>
            var today = new Date()
            var year = today.getFullYear()
            document.write(year)
        </script> All Rights Reserved.<br/> 
        Lakireddy Bali Reddy College of Engineering</p>
    </section>
</footer>

</body>
</html>
