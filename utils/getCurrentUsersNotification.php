<?php
    session_start();
    include("connection.php");

    $userID = $_SESSION['currUser'];

    // Query to retrieve data from likes, posts, and users tables
    $stmt = $conn->prepare("SELECT likes.*, posts.*, users.* FROM likes
                            INNER JOIN posts ON likes.postID = posts.postID
                            INNER JOIN users ON posts.userID = users.userID
                            WHERE posts.userID = ?");
    $stmt->bind_param("s", $userID);
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
?>
