<?php
    //Include database connection
    include ("connection.php");

    session_start(); // Start the session

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the user's ID
            $row = $result->fetch_assoc();
            $userID = $row['userID'];

            // Store the user's ID in a session variable
            $_SESSION['currUser'] = $userID;

            echo "Login successful!";
        } else {
            echo "Invalid username or password";
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();
    }
?>
