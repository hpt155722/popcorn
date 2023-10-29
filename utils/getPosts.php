<?php
    include("connection.php");

    // Query to retrieve posts sorted by datePosted (newest to oldest)
    $query = "SELECT * FROM posts ORDER BY datePosted DESC";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error retrieving posts: " . mysqli_error($conn));
    }

    $posts = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }

    // Close the database connection
    mysqli_close($conn);

    // Return posts as JSON
    header('Content-Type: application/json');
    echo json_encode($posts);
?>
