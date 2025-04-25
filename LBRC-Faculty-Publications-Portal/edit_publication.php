<?php
session_start();
include('db.php');

if (!isset($_SESSION['faculty_id'])) {
    header('Location: index.php');
    exit();
}

// Get the logged-in faculty's name from the session
$faculty_name = $_SESSION['name'];

if (isset($_GET['id'])) {
    $publication_id = $_GET['id'];
    // Fetch publication details
    $sql = "SELECT * FROM faculty_publications WHERE publication_id = $publication_id";
    $result = $conn->query($sql);
    $publication = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $title = $_POST['title'];
    $journal_title = $_POST['journal_title'];
    $volume = $_POST['volume'];
    $issue = $_POST['issue'];
    $page_start = $_POST['page_start'];
    $page_end = $_POST['page_end'];
    $publish_date = $_POST['publish_date'];
    $e_issn = $_POST['e_issn'];
    $print_issn = $_POST['print_issn'];
    $affiliation = $_POST['affiliation'];
    $doi = $_POST['doi'];
    $web_link = $_POST['web_link'];
    $article_link = $_POST['article_link'];
    $conference_proceeding = $_POST['conference_proceeding'];
    $scie_category = $_POST['scie_category'];
    $impact_factor = $_POST['impact_factor'];
    $quartile_category = $_POST['quartile_category'];
    $academic_year = $_POST['academic_year'];
    $calendar_year = $_POST['calendar_year'];

    $sql = "UPDATE faculty_publications SET 
            title = '$title', journal_title = '$journal_title', volume = '$volume', issue = '$issue', 
            page_start = '$page_start', page_end = '$page_end', publish_date = '$publish_date', 
            e_issn = '$e_issn', print_issn = '$print_issn', affiliation = '$affiliation', 
            doi = '$doi', web_link = '$web_link', article_link = '$article_link', 
            conference_proceeding = '$conference_proceeding', scie_category = '$scie_category', 
            impact_factor = '$impact_factor', quartile_category = '$quartile_category', 
            academic_year = '$academic_year', calendar_year = '$calendar_year'
            WHERE publication_id = $publication_id";

    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Publication</title>
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

        /* Form Styles */
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"], input[type="date"], input[type="number"], select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 8px;
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

            input[type="text"], input[type="number"], select {
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
    <h2>Welcome, <?php echo $faculty_name; ?>!</h2>
    <a href="logout.php"><button>Logout</button></a>

    <h3>Edit Publication</h3>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $publication['title']; ?>" required><br><br>

        <label for="journal_title">Journal Title:</label>
        <input type="text" name="journal_title" value="<?php echo $publication['journal_title']; ?>" required><br><br>

        <label for="volume">Volume:</label>
        <input type="text" name="volume" value="<?php echo $publication['volume']; ?>"><br><br>

        <label for="issue">Issue:</label>
        <input type="text" name="issue" value="<?php echo $publication['issue']; ?>"><br><br>

        <label for="page_start">Page Start:</label>
        <input type="number" name="page_start" value="<?php echo $publication['page_start']; ?>"><br><br>

        <label for="page_end">Page End:</label>
        <input type="number" name="page_end" value="<?php echo $publication['page_end']; ?>"><br><br>

        <label for="publish_date">Publish Date:</label>
        <input type="date" name="publish_date" value="<?php echo $publication['publish_date']; ?>"><br><br>

        <label for="e_issn">e-ISSN:</label>
        <input type="text" name="e_issn" value="<?php echo $publication['e_issn']; ?>"><br><br>

        <label for="print_issn">Print ISSN:</label>
        <input type="text" name="print_issn" value="<?php echo $publication['print_issn']; ?>"><br><br>

        <label for="affiliation">Affiliation:</label>
        <input type="text" name="affiliation" value="<?php echo $publication['affiliation']; ?>"><br><br>

        <label for="doi">DOI:</label>
        <input type="text" name="doi" value="<?php echo $publication['doi']; ?>"><br><br>

        <label for="web_link">Web Link:</label>
        <input type="text" name="web_link" value="<?php echo $publication['web_link']; ?>"><br><br>

        <label for="article_link">Article Link:</label>
        <input type="text" name="article_link" value="<?php echo $publication['article_link']; ?>"><br><br>

        <label for="conference_proceeding">Conference Proceeding:</label>
        <select name="conference_proceeding">
            <option value="Yes" <?php echo $publication['conference_proceeding'] == 'Yes' ? 'selected' : ''; ?>>Yes</option>
            <option value="No" <?php echo $publication['conference_proceeding'] == 'No' ? 'selected' : ''; ?>>No</option>
        </select><br><br>

        <label for="scie_category">SCIE Category:</label>
        <select name="scie_category">
            <option value="SCIE" <?php echo $publication['scie_category'] == 'SCIE' ? 'selected' : ''; ?>>SCIE</option>
            <option value="SCI" <?php echo $publication['scie_category'] == 'SCI' ? 'selected' : ''; ?>>SCI</option>
            <option value="ESCI" <?php echo $publication['scie_category'] == 'ESCI' ? 'selected' : ''; ?>>ESCI</option>
            <option value="Scopus" <?php echo $publication['scie_category'] == 'Scopus' ? 'selected' : ''; ?>>Scopus</option>
            <option value="UGC" <?php echo $publication['scie_category'] == 'UGC' ? 'selected' : ''; ?>>UGC</option>
            <option value="OA" <?php echo $publication['scie_category'] == 'OA' ? 'selected' : ''; ?>>OA</option>
        </select><br><br>

        <label for="impact_factor">Impact Factor:</label>
        <input type="number" name="impact_factor" step="0.01" value="<?php echo $publication['impact_factor']; ?>"><br><br>

        <label for="quartile_category">Quartile Category:</label>
        <select name="quartile_category">
            <option value="Q1" <?php echo $publication['quartile_category'] == 'Q1' ? 'selected' : ''; ?>>Q1</option>
            <option value="Q2" <?php echo $publication['quartile_category'] == 'Q2' ? 'selected' : ''; ?>>Q2</option>
            <option value="Q3" <?php echo $publication['quartile_category'] == 'Q3' ? 'selected' : ''; ?>>Q3</option>
            <option value="Q4" <?php echo $publication['quartile_category'] == 'Q4' ? 'selected' : ''; ?>>Q4</option>
			<option value="Other" <?php echo $publication['quartile_category'] == 'Other' ? 'selected' : ''; ?>>Other</option>
        </select><br><br>

        <label for="academic_year">Academic Year:</label>
        <!--<input type="text" name="academic_year" value="<?php echo $publication['academic_year']; ?>">-->
		<select name="academic_year">
            <option value="2025-26" <?php echo $publication['academic_year'] == '2025-26' ? 'selected' : ''; ?>>2025-26</option>
            <option value="2024-25" <?php echo $publication['academic_year'] == '2024-25' ? 'selected' : ''; ?>>2024-25</option>
            <option value="2023-24" <?php echo $publication['academic_year'] == '2023-24' ? 'selected' : ''; ?>>2023-24</option>            
        </select>
		<br><br>

        <label for="calendar_year">Calendar Year:</label>
        <!--<input type="number" name="calendar_year" value="<?php echo $publication['calendar_year']; ?>">-->
		<select name="calendar_year">
            <option value="2025" <?php echo $publication['calendar_year'] == '2025' ? 'selected' : ''; ?>>2025</option>
            <option value="2024" <?php echo $publication['calendar_year'] == '2024' ? 'selected' : ''; ?>>2024</option>
            <option value="2023" <?php echo $publication['calendar_year'] == '2023' ? 'selected' : ''; ?>>2023</option>            
        </select>
		<br><br>

        <button type="submit">Save Changes</button>
    </form>
</div>

<footer>
    <p>&copy; <script>document.write(new Date().getFullYear());</script> All Rights Reserved.<br>Lakireddy Bali Reddy College of Engineering</p>
</footer>

</body>
</html>
