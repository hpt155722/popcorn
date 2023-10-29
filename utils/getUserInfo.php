<?php
    include("connection.php");

    // Check if the request method is GET
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Sanitize and get the input values
        $userID = $_GET['userID'];

        // Query to retrieve user information based on userID
        $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ?");
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $userInfo = $result->fetch_assoc();

            // Close the statement
            $stmt->close();

            // Close the database connection
            $conn->close();

            // Return user information as JSON
            header('Content-Type: application/json');
            echo json_encode(array("success" => true, "userInfo" => $userInfo));
        } else {
            // User not found
            header('Content-Type: application/json');
            echo json_encode(array("success" => false, "message" => "User not found"));
        }
    } else {
        // Invalid request method
        header('Content-Type: application/json');
        echo json_encode(array("success" => false, "message" => "Invalid request method"));
    }
?>
