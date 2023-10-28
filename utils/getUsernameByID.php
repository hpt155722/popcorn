<?php
    session_start();
    include("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Sanitize and get the input value
        $userID = $_GET['userID'];

        // Query to retrieve username based on userID
        $stmt = $conn->prepare("SELECT username FROM users WHERE userID = ?");
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();

        // Close the database connection
        $conn->close();

        // Return username as JSON
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "username" => $username));
    } else {
        // Invalid request method
        header('Content-Type: application/json');
        echo json_encode(array("success" => false, "message" => "Invalid request method"));
    }
?>
