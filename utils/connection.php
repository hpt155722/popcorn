<?php
    $servername = "localhost"; 
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "popcorn";
    $port = 3307; // Port is set to 3307

    try {
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname, $port);

        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
?>
