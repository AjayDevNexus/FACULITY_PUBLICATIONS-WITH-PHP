<?php
session_start();
include('db.php');

// Check if the faculty is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// Get the logged-in faculty's name from the session
$faculty_name = $_SESSION['name'];

// Initialize an array to hold the counts for each department
$department_counts = [
    'SCI' => [],
    'ESCI' => [],
    'Scopus' => [],
    'UGC' => [],
    'OA' => []
];

// Initialize total counts
$total_counts = [
    'SCI' => 0,
    'ESCI' => 0,
    'Scopus' => 0,
    'UGC' => 0,
    'OA' => 0
];

// Fetch department names from faculty_login table
$sql_departments = "SELECT DISTINCT department FROM faculty_login";
$departments_result = $conn->query($sql_departments);

// Check if the query is successful
if ($departments_result === false) {
    die("Error fetching departments: " . $conn->error);
}

// Loop through each department and get the publication counts for each category
while ($department = $departments_result->fetch_assoc()) {
    $dept_name = $department['department'];

    // Prepare the SQL to count publications for each department and category
    foreach ($department_counts as $category => $count_array) {
        // Prepare SQL query for counting publications based on category and department
        $sql_count = "
            SELECT COUNT(*) as count
            FROM faculty_publications
            JOIN faculty_login ON faculty_publications.faculty_id = faculty_login.faculty_id
            WHERE faculty_login.department = '$dept_name'
            AND faculty_publications.scie_category = '$category'
        ";

        // Execute the query
        $result = $conn->query($sql_count);

        // Check if the query is successful
        if ($result === false) {
            die("Error executing query: " . $conn->error);
        }

        // Get the result and store it in the array
        $row = $result->fetch_assoc();
        $department_counts[$category][$dept_name] = $row['count'];

        // Update total counts
        $total_counts[$category] += $row['count'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Publications Report</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensures footer is at the bottom */
        }
        
        /* Header Styles */
        .header-banner {
            width: 100%;
            height: 200px;  /* Adjust height as needed */
            background-image: url('./headern.png');  /* Replace with your image path */
            background-size: cover;
            background-position: center;
        }
        
        /* Main Content Area */
        .container {
            flex-grow: 1;  /* Makes the content area take available space */
            padding: 20px;
            width: 100%;  /* Makes container full width */
            box-sizing: border-box;  /* Ensures padding doesn't affect the full width */
        }

        /* Title and Subtitle */
        h2, h3 {
            color: #333;
            margin-top: 20px;
        }

        p {
            color: #555;
            font-size: 16px;
        }

        /* Button Styles */
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        td a {
            color: #1e90ff;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }

        /* Footer Styling */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            table {
                font-size: 14px;
            }

            button {
                width: 100%;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<!-- Header Banner -->
<div class="header-banner"></div>

<div class="container">
    <!-- Display welcome message and logout link -->
    <h2>Welcome, <?php echo $faculty_name; ?>!</h2>
	<a href="admindashboard.php"><button>Adimin Home</button></a> &nbsp;
    <a href="logout.php"><button>Logout</button></a><br><br>

    <h2>Faculty Publications Report</h2>

    <!-- Faculty Publications Table -->
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Dept.</th>
                <th>SCI</th>
                <th>ESCI</th>
                <th>Scopus</th>
                <th>UGC</th>
                <th>Open Access</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through each department to display counts
            foreach ($department_counts['SCI'] as $dept_name => $count) {
                echo "<tr>
                        <td>$dept_name</td>
                        <td>{$department_counts['SCI'][$dept_name]}</td>
                        <td>{$department_counts['ESCI'][$dept_name]}</td>
                        <td>{$department_counts['Scopus'][$dept_name]}</td>
                        <td>{$department_counts['UGC'][$dept_name]}</td>
                        <td>{$department_counts['OA'][$dept_name]}</td>
                      </tr>";
            }
            ?>
            <!-- Display Total row -->
            <tr>
                <td>Total</td>
                <td><?php echo $total_counts['SCI']; ?></td>
                <td><?php echo $total_counts['ESCI']; ?></td>
                <td><?php echo $total_counts['Scopus']; ?></td>
                <td><?php echo $total_counts['UGC']; ?></td>
                <td><?php echo $total_counts['OA']; ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Faculty Publications Details -->
    <h3>Detailed Publications for Each Category</h3>
    <?php
    // Fetch and display publications for each category
    foreach ($department_counts['SCI'] as $dept_name => $count) {
        echo "<h4>Department: $dept_name</h4>";

        // Loop through each publication category
        $categories = ['SCI', 'ESCI', 'Scopus', 'UGC', 'OA'];

        foreach ($categories as $category) {
            // Fetch publication details for the current department and category
            $sql_publications = "
                SELECT faculty_login.faculty_id, faculty_login.name as faculty_name, title, authors, journal_title, volume, 
                       issue, page_start, page_end, publish_date, e_issn, print_issn, affiliation, doi, 
                       web_link, article_link, conference_proceeding, impact_factor, quartile_category, 
                       academic_year, calendar_year
                FROM faculty_publications
                JOIN faculty_login ON faculty_publications.faculty_id = faculty_login.faculty_id
                WHERE faculty_login.department = '$dept_name'
                AND faculty_publications.scie_category = '$category'
            ";

            $publications_result = $conn->query($sql_publications);

            // Check if the query executed correctly
            if ($publications_result === false) {
                echo "<p>Error executing query: " . $conn->error . "</p>";
                continue;
            }

            // Check if publications are available
            if ($publications_result->num_rows > 0) {
                echo "<h5>$category Publications ($publications_result->num_rows)</h5>";
                echo "<ol type='1'>";
                // Loop through the publications and display them in paragraph format
                while ($pub = $publications_result->fetch_assoc()) {
                    echo "<li>{$pub['authors']}, <strong>{$pub['title']},</strong> {$pub['journal_title']}, 
                          {$pub['publish_date']}, <a href='{$pub['doi']}'>{$pub['doi']}</a><p style='color:red;'>                       
                          <strong>Quartile: {$pub['quartile_category']}</strong></p></li>";
                }
                echo "</ol>";
            }
        }
    }
    ?>
</div>

<!-- Footer -->
<footer>
    <p>&copy; <script>document.write(new Date().getFullYear());</script> All Rights Reserved.<br>Lakireddy Bali Reddy College of Engineering</p>
</footer>

</body>
</html>
