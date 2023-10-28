<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postID = $_POST['postID'];
    $userID = $_SESSION['currUser']; // Assuming you have a session variable for the current user

    // Query to check if the current user owns the post
    $stmt = $conn->prepare("SELECT * FROM posts WHERE postID = ? AND userID = ?");
    $stmt->bind_param("ss", $postID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Delete the post if the user owns it
        $stmt = $conn->prepare("DELETE FROM posts WHERE postID = ?");
        $stmt->bind_param("s", $postID);
        $stmt->execute();

        // Provide a success response
        echo json_encode(array("success" => true));
    } else {
        // User does not own the post, return an error response
        echo json_encode(array("success" => false, "message" => "You do not have permission to delete this post."));
    }
} else {
    // Invalid request method
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}

$conn->close();
?>
