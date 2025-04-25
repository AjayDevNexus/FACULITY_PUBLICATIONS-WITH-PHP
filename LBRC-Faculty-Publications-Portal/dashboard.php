<?php
session_start();
include('db.php');

// Check if the faculty is logged in
if (!isset($_SESSION['faculty_id'])) {
    header('Location: index.php');
    exit();
}

// Get the logged-in faculty ID
$faculty_id = $_SESSION['faculty_id'];

// Query to get all publications for the logged-in faculty
$sql = "SELECT fp.*, fl.name AS faculty_name, fl.department
        FROM faculty_publications fp
        JOIN faculty_login fl ON fp.faculty_id = fl.faculty_id
        WHERE fp.faculty_id = '$faculty_id'";

$result = $conn->query($sql);

// If there are no publications, display a message
if ($result->num_rows === 0) {
    $message = "No publications found for your profile.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
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
            max-width: 1200px;
            margin: 0 auto;
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

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table, th, td {
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td a {
            color: #4CAF50;
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

            table, th, td {
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
    <h2>Welcome, <?php echo $_SESSION['name']; ?></h2>
    <p>Department: <?php echo $_SESSION['department']; ?></p>
    <a href="logout.php"><button>Logout</button></a>

    <h3>Your Publications</h3>
    <a href="add_publication.php"><button>Add New Publication</button></a>

    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

    <table>
        <caption>List of Publications</caption>
        <tr>
			<th>S.No</th>
            <th>Title</th>
            <th>Authors</th>
            <th>Journal Title</th>
            <th>Volume</th>
            <th>Issue</th>
            <th>Pages</th>
            <th>Publish Date</th>
            <th>e-ISSN</th>
            <th>Print ISSN</th>
            <th>Affiliation of Institute<br><b style='color:red'>(As in Publucation)</b></th>
            <th><b style='color:blue'>DOI Link</b> of the Publication</th>
            <th><b style='color:blue'>Weblink</b> of the Publication</th>
            <th><b style='color:blue'>Article Link</b> in Elsevier/ <b style='color:pink'>Scopus Database</b></th>
            <th>Conference Proceeding</th>
            <th>SCIE Category</th>
            <th>Impact Factor</th>
            <th>Quartile Category</th>
            <th>Academic Year</th>
            <th>Calendar Year</th>
            <th>Actions</th>
        </tr>

        <?php
        $i = 1;
        while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['authors']; ?></td>
                <td><?php echo $row['journal_title']; ?></td>
                <td><?php echo $row['volume']; ?></td>
                <td><?php echo $row['issue']; ?></td>
                <td><?php echo $row['page_start'] . ' - ' . $row['page_end']; ?></td>
                <td><?php echo $row['publish_date']; ?></td>
                <td><?php echo $row['e_issn']; ?></td>
                <td><?php echo $row['print_issn']; ?></td>
                <td><?php echo $row['affiliation']; ?></td>
                <td><?php echo $row['doi']; ?></td>
                <td>
                    <?php 
                    if (!empty($row['web_link'])) {
                        echo '<a href="' . $row['web_link'] . '" target="_blank" rel="noopener noreferrer">' . $row['web_link'] . '</a>';
                    } else {
                        echo 'N/A';
                    }
                    ?>
                </td>
                <td>
                    <?php 
                    if (!empty($row['article_link'])) {
                        echo '<a href="' . $row['article_link'] . '" target="_blank" rel="noopener noreferrer">' . $row['article_link'] . '</a>';
                    } else {
                        echo 'N/A';
                    }
                    ?>
                </td>
                <td><?php echo $row['conference_proceeding']; ?></td>
                <td><?php echo $row['scie_category']; ?></td>
                <td><?php echo $row['impact_factor']; ?></td>
                <td><?php echo $row['quartile_category']; ?></td>
                <td><?php echo $row['academic_year']; ?></td>
                <td><?php echo $row['calendar_year']; ?></td>
                <td>
                    <a href="edit_publication.php?id=<?php echo $row['publication_id']; ?>">Edit</a> | 
                    <a href="delete_publication.php?id=<?php echo $row['publication_id']; ?>" onclick="return confirm('Are you sure you want to delete this publication?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<!-- Footer Section -->
<footer>
    <p>&copy; <script>document.write(new Date().getFullYear());</script> All Rights Reserved.<br>Lakireddy Bali Reddy College of Engineering</p>
</footer>

</body>
</html>
