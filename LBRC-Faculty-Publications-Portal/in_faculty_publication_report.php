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

// Fetch departments from faculty_login table
$departments_result = $conn->query("SELECT DISTINCT department FROM faculty_login");

$faculty_details = [];
$publications = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get selected department and faculty_id
    $department = $_POST['department'];
    $faculty_id = $_POST['faculty_id'];

    // Fetch selected faculty details
    $faculty_details_query = "SELECT * FROM faculty_login WHERE faculty_id = '$faculty_id'";
    $faculty_details_result = $conn->query($faculty_details_query);
    if ($faculty_details_result->num_rows > 0) {
        $faculty_details = $faculty_details_result->fetch_assoc();
    }

    // Fetch selected faculty's publications
    $publications_query = "SELECT * FROM faculty_publications WHERE faculty_id = '$faculty_id'";
    $publications_result = $conn->query($publications_query);
    while ($row = $publications_result->fetch_assoc()) {
        $publications[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile</title>
    <style>
        /* Include your existing CSS styles here */
        /* Ensure form styling is applied */
    </style>
</head>
<body>

<!-- Header -->
<div class="header-banner"></div>

<div class="container">
    <h2>Welcome, <?php echo $faculty_name; ?>!</h2>
    <form method="POST" action="">
        <label for="department">Select Department:</label>
        <select name="department" id="department" required>
            <option value="">--Select Department--</option>
            <?php while ($row = $departments_result->fetch_assoc()) { ?>
                <option value="<?php echo $row['department']; ?>"><?php echo $row['department']; ?></option>
            <?php } ?>
        </select><br><br>

        <label for="faculty_id">Select Faculty:</label>
        <select name="faculty_id" id="faculty_id" required>
            <option value="">--Select Faculty--</option>
            <?php
            // Fetch faculty based on selected department
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['department'])) {
                $selected_department = $_POST['department'];
                $faculty_result = $conn->query("SELECT faculty_id, name FROM faculty_login WHERE department = '$selected_department'");
                while ($faculty = $faculty_result->fetch_assoc()) {
                    echo '<option value="' . $faculty['faculty_id'] . '">' . $faculty['name'] . '</option>';
                }
            }
            ?>
        </select><br><br>

        <button type="submit">View Profile</button>
    </form>

    <?php if (!empty($faculty_details)) { ?>
        <h3>Faculty Details</h3>
        <p><strong>Name:</strong> <?php echo $faculty_details['name']; ?></p>
        <p><strong>Department:</strong> <?php echo $faculty_details['department']; ?></p>
        <p><strong>Faculty ID:</strong> <?php echo $faculty_details['faculty_id']; ?></p>

        <h3>Publications</h3>
        <?php if (count($publications) > 0) { ?>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Authors</th>
                    <th>Journal Title</th>
                    <th>Volume</th>
                    <th>Issue</th>
                    <th>Publish Date</th>
                    <th>DOI</th>
                    <th>Web Link</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($publications as $publication) { ?>
                    <tr>
                        <td><?php echo $publication['title']; ?></td>
                        <td><?php echo $publication['authors']; ?></td>
                        <td><?php echo $publication['journal_title']; ?></td>
                        <td><?php echo $publication['volume']; ?></td>
                        <td><?php echo $publication['issue']; ?></td>
                        <td><?php echo $publication['publish_date']; ?></td>
                        <td><?php echo $publication['doi']; ?></td>
                        <td>
                            <?php
                            if (!empty($publication['web_link'])) {
                                echo '<a href="' . $publication['web_link'] . '" target="_blank">View</a>';
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit_publication.php?id=<?php echo $publication['publication_id']; ?>">Edit</a> |
                            <a href="delete_publication.php?id=<?php echo $publication['publication_id']; ?>"
                               onclick="return confirm('Are you sure you want to delete this publication?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No publications found for this faculty.</p>
        <?php } ?>
    <?php } ?>

</div>

<!-- Footer Section -->
<footer>
    <p>&copy; <?php echo date("Y"); ?> All Rights Reserved.<br>Lakireddy Bali Reddy College of Engineering</p>
</footer>

</body>
</html>
