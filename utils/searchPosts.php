<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST['searchTerm'];

    // Sanitize the input to prevent SQL injection
    $searchTerm = '%' . mysqli_real_escape_string($conn, $searchTerm) . '%';

    // Query to retrieve data from posts and users tables
    $stmt = $conn->prepare("SELECT posts.message, posts.datePosted, users.username, users.profilePicPath 
                            FROM posts 
                            INNER JOIN users ON posts.userID = users.userID 
                            WHERE LOWER(posts.message) LIKE LOWER(?)");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement
        $stmt->close();

        // Close the database connection
        $conn->close();

        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "data" => $data));
    } else {
        // No matching rows found
        header('Content-Type: application/json');
        echo json_encode(array("success" => false, "message" => "No matching rows found"));
    }
} else {
    // Invalid request method
    header('Content-Type: application/json');
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>
