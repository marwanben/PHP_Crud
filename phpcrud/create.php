<?php
require_once 'Database.php';
require_once 'Parfum.php';

$database = new Database();
$db = $database->getConnection();
$parfum = new Parfum($db);

// Handle form submission
if (isset($_POST['action']) && $_POST['action'] == 'create') {
    $parfum->Name = $_POST['Name'];
    $parfum->Price = $_POST['Price'];
    $parfum->Gender = $_POST['Gender'];
    $parfum->Volume = $_POST['Volume'];

    // Handle image upload
    if (isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
        $targetFile = basename($_FILES['Image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['Image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['Image']['tmp_name'], $targetFile)) {
                $parfum->ImageURL = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "The file is not an image.";
        }
    } else {
        $parfum->ImageURL = ''; // If no image is uploaded
    }

    if ($parfum->create()) {
        // Redirect to the index page after successful creation
        header("Location: index.php");
        exit; // Stop further execution
    } else {
        echo "Unable to create parfum.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Parfum</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="title">Create Parfum</h1>
    <form class="form" method="post" enctype="multipart/form-data">
        <input type="text" name="Name" placeholder="Parfum Name" required><br>
        <input type="number" name="Price" placeholder="Price" required><br>
        <select name="Gender" required>
        <option value="">Choose the Gender</option>
            <option value="Men">Men</option>
            <option value="Women">Women</option>
        </select><br>
        <input type="number" name="Volume" placeholder="Volume" required><br>
        <input type="file" name="Image" required><br>
        <button type="submit" name="action" value="create">Create Parfum</button>
    </form>
</body>
</html>
