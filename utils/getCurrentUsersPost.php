<?php
    session_start();
    include("connection.php");

    $userID = $_SESSION['currUser'];

    // Query to retrieve posts based on userID
    $stmt = $conn->prepare("SELECT * FROM posts WHERE userID = ? ORDER BY datePosted DESC");
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    $posts = array();

    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }

    // Close the statement
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Return posts as JSON
    header('Content-Type: application/json');
    echo json_encode(array("success" => true, "posts" => $posts));
?>
