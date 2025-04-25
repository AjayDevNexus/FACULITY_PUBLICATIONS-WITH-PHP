<?php
session_start();
include('db.php');

// Check if the faculty is logged in
if (!isset($_SESSION['faculty_id'])) {
    header('Location: index.php');
    exit();
}

// Get the logged-in faculty's name from the session
$faculty_name = $_SESSION['name'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty_id = $_SESSION['faculty_id'];
    $title = $_POST['title'];
    $authors = $_POST['authors'];
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

    // SQL query to insert publication data
    $sql = "INSERT INTO faculty_publications (faculty_id, title, authors, journal_title, volume, issue, page_start, page_end, publish_date, e_issn, print_issn, affiliation, doi, web_link, article_link, conference_proceeding, scie_category, impact_factor, quartile_category, academic_year, calendar_year) 
            VALUES ('$faculty_id', '$title', '$authors', '$journal_title', '$volume', '$issue', '$page_start', '$page_end', '$publish_date', '$e_issn', '$print_issn', '$affiliation', '$doi', '$web_link', '$article_link', '$conference_proceeding', '$scie_category', '$impact_factor', '$quartile_category', '$academic_year', '$calendar_year')";

    // Check if the query was successful
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
    <title>Add Publication</title>
    <!--<style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Header Styles */
        .header-banner {
            width: 100%;
            height: 200px;
            background-image: url('./headern.png');  /* Replace with your image path */
            background-size: cover;
            background-position: center;
        }

        /* Main Content Area */
        .container {
            flex-grow: 1;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

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

        /* Form Styling */
        form {
            margin-top: 20px;
        }

        label {
            display: inline-block;
            width: 150px;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
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

            button {
                width: 100%;
                padding: 12px;
            }
        }
    </style>
	-->
	<style>
	/* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Header Styles */
.header-banner {
    width: 100%;
    height: 200px;
    background-image: url('./headern.png');  /* Replace with your image path */
    background-size: cover;
    background-position: center;
}

/* Main Content Area */
.container {
    flex-grow: 1;
    padding: 20px;
    width: 100%; /* Ensure it takes up 100% width */
    max-width: 1200px; /* Limit the maximum width */
    margin: 0 auto; /* Center the container */
}

/* Form Styling */
form {
    margin-top: 20px;
}

label {
    display: inline-block;
    width: 150px;
    margin-bottom: 8px;
}

input[type="text"], input[type="number"], input[type="date"], select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
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

    /* Ensure form elements take full width */
    label {
        width: 100%;
    }

    input[type="text"], input[type="number"], input[type="date"], select {
        width: 100%;
        box-sizing: border-box; /* To include padding in width calculation */
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
    <a href="logout.php"><button>Logout</button></a><br><br>

    <h3>Add New Publication</h3>

    <!-- Display the publication form -->
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br><br>
        
        <label for="authors">Authors:</label>
        <input type="text" name="authors" required><br><br>

        <label for="journal_title">Journal Title:</label>
        <input type="text" name="journal_title" required><br><br>

        <label for="volume">Volume:</label>
        <input type="text" name="volume"><br><br>

        <label for="issue">Issue:</label>
        <input type="text" name="issue"><br><br>

        <label for="page_start">Page Start:</label>
        <input type="number" name="page_start"><br><br>

        <label for="page_end">Page End:</label>
        <input type="number" name="page_end"><br><br>

        <label for="publish_date">Publish Date:</label>
        <input type="date" name="publish_date"><br><br>

        <label for="e_issn">e-ISSN:</label>
        <input type="text" name="e_issn"><br><br>

        <label for="print_issn">Print ISSN:</label>
        <input type="text" name="print_issn"><br><br>

        <label for="affiliation">Affiliation of Institute<br><b style='color:red'>(As in Publucation)</b>:</label>
        <input type="text" name="affiliation"><br><br>

		
        <label for="doi"><b style='color:blue'>DOI Link</b> of the Publication:</label>
        <input type="text" name="doi"><br><br>

        <label for="web_link"><b style='color:blue'>Weblink</b> of the Publication:</label>
        <input type="text" name="web_link"><br><br>

        <label for="article_link"><b style='color:blue'>Article Link</b> in Elsevier/ <strong style='color:pink'>Scopus Database:</strong></label>
        <input type="text" name="article_link"><br><br>

        <label for="conference_proceeding">Conference Proceeding:</label>
        <select name="conference_proceeding">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select><br><br>

        <label for="scie_category">SCIE Category:</label>
        <select name="scie_category">
            <option value="SCIE">SCIE</option>
            <option value="SCI">SCI</option>
            <option value="ESCI">ESCI</option>
            <option value="Scopus">Scopus</option>
            <option value="UGC">UGC</option>
            <option value="OA">OA</option>
        </select><br><br>

        <label for="impact_factor">Impact Factor:</label>
        <input type="number" name="impact_factor" step="0.01"><br><br>

        <label for="quartile_category">Quartile Category:</label>
        <select name="quartile_category">
            <option value="Q1">Q1</option>
            <option value="Q2">Q2</option>
            <option value="Q3">Q3</option>
            <option value="Q4">Q4</option>
			<option value="Other">Other</option>
        </select><br><br>

        <label for="academic_year">Academic Year:</label>
        <!--<input type="text" name="academic_year">-->
		 <select name="academic_year">
			<option value=""> </option>
            <option value="2025-26">2025-26</option>
            <option value="2024-25">2024-25</option>
            <option value="2023-24">2023-24</option>            
        </select>
		<br><br>

        <label for="calendar_year">Calendar Year:</label>
        <!--<input type="number" name="calendar_year">-->
		 <select name="calendar_year">
			<option value=""> </option>
            <option value="2025">2025</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>            
        </select>
		<br><br>

        <button type="submit">Add Publication</button>
    </form>

    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
</div>

<!-- Footer Section -->
<footer>
    <p>&copy; <script>document.write(new Date().getFullYear());</script> All Rights Reserved.<br>Lakireddy Bali Reddy College of Engineering</p>
</footer>

</body>
</html>
