<?php
    // Include database connection
    include ("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and get the input values
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT username FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $dupcount = $stmt->num_rows;
        $stmt->close();

        if($username == "" || $password == "") {
            echo "error: credentials cannot be empty";
        } else if($dupcount > 0) {
            echo "username already exists. please choose a different username.";
        } else {
            // Create new user in database
            $stmt = $conn->prepare("INSERT INTO users (username, password, userID) VALUES (?, ?, NULL)");
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()) {
                // Start session and set current user
                session_start();
                $_SESSION['currUser'] = $username;
                echo "Signup successful!";
            } else {
                echo "error: Error signing up. Please try again.";
            }
            $stmt->close();
        }
    }
?>
