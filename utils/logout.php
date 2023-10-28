<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['currUser'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Provide a response back to the client
    header('Content-Type: application/json');
    echo json_encode(array("success" => true, "message" => "Logout successful"));
} else {
    // If the user is not logged in, return an error message
    header('Content-Type: application/json');
    echo json_encode(array("success" => false, "message" => "User not logged in"));
}
?>
