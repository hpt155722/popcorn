<?php
    session_start();
    include("connection.php");

    $userID = $_SESSION['currUser'];

    // Query to retrieve a list of userID from posts, sorted by dateLiked in descending order
    $stmt = $conn->prepare("SELECT likes.userID 
                            FROM posts
                            INNER JOIN likes ON posts.postID = likes.postID
                            WHERE posts.userID = ?
                            ORDER BY likes.dateLiked DESC");
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
