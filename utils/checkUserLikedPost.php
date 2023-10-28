<?php
    session_start();
    include("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $postID = $_GET['postID'];
        $userID = $_SESSION['currUser'];

        // Query to check if the current user has liked the post
        $stmt = $conn->prepare("SELECT * FROM likes WHERE postID = ? AND userID = ?");
        $stmt->bind_param("ss", $postID, $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // User has liked the post
            echo json_encode(array("liked" => true));
        } else {
            // User has not liked the post
            echo json_encode(array("liked" => false));
        }
    } else {
        // Invalid request method
        echo json_encode(array("success" => false, "message" => "Invalid request method"));
    }

    $conn->close();
?>
