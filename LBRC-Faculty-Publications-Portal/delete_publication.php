<?php
session_start();
include('db.php');

if (!isset($_SESSION['faculty_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $publication_id = $_GET['id'];

    // Delete the publication
    $sql = "DELETE FROM faculty_publications WHERE publication_id = $publication_id AND faculty_id = '" . $_SESSION['faculty_id'] . "'";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error deleting publication: " . $conn->error;
    }
}
?>
