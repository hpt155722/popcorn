<?php
    session_start();
    include("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $currentUsername = $_SESSION['currUser'];
        $croppedData = $_POST['croppedData'];

        //extract just the base64 encoded data from the URI
        if (strpos($croppedData, 'data:image/jpeg;base64,') !== false) {
            $croppedData = str_replace('data:image/jpeg;base64,', '', $croppedData);
        }
        

        // Check if the data is valid
        if ($croppedData && $currentUsername) {
            // Decode the base64 encoded image data
            $croppedImage = base64_decode($croppedData);

            // Check if the decoding was successful
            if ($croppedImage !== false) {
                // Generate a unique filename
                $filename = uniqid() . '.webp';

                // Specify the file path
                $filepath = '../resources/pfp/' . $filename;

                // Create a GD image resource from the uploaded data
                $source = imagecreatefromstring($croppedImage);

                // Check if the image resource was created
                if ($source !== false) {
                    // Save the image in webp format
                    imagewebp($source, $filepath);

                    // Free up memory
                    imagedestroy($source);

                    // Insert the image information into your database
                    $stmt = $conn->prepare("UPDATE users SET profilePicPath = ? WHERE username = ?");
                    $stmt->bind_param("ss", $filename, $currentUsername);
                    $stmt->execute();
                    $stmt->close();

                    echo "Image uploaded successfully!";
                } else {
                    echo "Error creating image resource.";
                }
            } else {
                echo "Error decoding image data.";
            }
        } else {
            echo "Missing data.";
        }
    }
    else {
        echo "Invalid request method!";
    }

    $conn->close();
?>
