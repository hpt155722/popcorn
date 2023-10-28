<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION['currUser'];
    $postID = $_POST['postID'];

    // Check if the user has already liked the post
    $stmt = $conn->prepare("SELECT * FROM likes WHERE postID = ? AND userID = ?");
    $stmt->bind_param("ii", $postID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User has already liked the post, so unlike it
        $stmt = $conn->prepare("DELETE FROM likes WHERE postID = ? AND userID = ?");
        $stmt->bind_param("ii", $postID, $userID);
        $stmt->execute();

        // Provide a response back to the client
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "message" => "Post unliked"));
    } else {
        // User has not liked the post yet, so like it
        $stmt = $conn->prepare("INSERT INTO likes (postID, userID) VALUES (?, ?)");
        $stmt->bind_param("ii", $postID, $userID);
        $stmt->execute();

        // Provide a response back to the client
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "message" => "Post liked"));
    }

    $stmt->close();
    $conn->close();
} else {
    // Invalid request method
    header('Content-Type: application/json');
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>
