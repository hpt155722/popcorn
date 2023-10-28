<?php
    session_start();
    include("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $currentUsername = $_SESSION['currUser'];
        $croppedData = $_POST['croppedData'];

        // Extract just the base64 encoded data from the URI
        $data = explode(',', $croppedData);
        $croppedImage = base64_decode($data[1]);

        if ($croppedImage !== false && $currentUsername) {
            $filename = uniqid() . '.webp';
            $filepath = '../resources/pfp/' . $filename;

            $source = imagecreatefromstring($croppedImage);

            if ($source !== false) {
                imagewebp($source, $filepath);
                imagedestroy($source);

                $stmt = $conn->prepare("UPDATE users SET profilePicPath = ? WHERE userID = ?");
                $stmt->bind_param("ss", $filename, $currentUsername);
                $stmt->execute();
                $stmt->close();

                echo "Image uploaded successfully!";
            } else {
                echo "Error creating image resource.";
            }
        } else {
            echo "Missing data or error decoding image data.";
        }
    } else {
        echo "Invalid request method!";
    }

    $conn->close();
?>
