<?php
    session_start();
    include("connection.php"); // Include your database connection file

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and get the input values
        $userMessage = $_POST['message'];
        $userID = $_SESSION['currUser'];

        // Query to insert the message into the post table
        $stmt = $conn->prepare("INSERT INTO posts (message, userID) VALUES (?, ?)");
        $stmt->bind_param("ss", $userMessage, $userID);
        $stmt->execute();

        // Close the statement
        $stmt->close();

        // Provide a response back to the client
        echo "Post added successfully!";
    } else {
        // If the request is not a POST request, return an error message
        echo "Invalid request method!";
    }

    // Close the database connection
    $conn->close();
?>
