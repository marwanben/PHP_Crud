<?php
require_once 'Database.php';
require_once 'Parfum.php';

$database = new Database();
$db = $database->getConnection();
$parfum = new Parfum($db);

// Fetch parfum data to edit
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $parfumID = $_GET['id'];
    $stmt = $parfum->readSingle($parfumID);
    $parfumData = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Parfum not found!";
    exit;
}

// Handle form submission for update
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $parfum->Name = $_POST['Name'];
    $parfum->Price = $_POST['Price'];
    $parfum->Gender = $_POST['Gender'];
    $parfum->Volume = $_POST['Volume'];
    $parfum->ParfumID = $_POST['ParfumID'];

    if (isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
        $targetFile = basename($_FILES['Image']['name']);
        if (move_uploaded_file($_FILES['Image']['tmp_name'], $targetFile)) {
            $parfum->ImageURL = $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $parfum->ImageURL = $parfumData['ImageURL'];
    }

    if ($parfum->update()) {
        // Redirect back to index.php after successful update
        header("Location: index.php");
        exit; // Stop further execution
    } else {
        echo "Unable to update parfum.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parfum</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1 class="title">Edit Parfum</h1>
    <form class="form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="ParfumID" value="<?php echo $parfumData['ParfumID']; ?>">
        <input type="text" name="Name" value="<?php echo $parfumData['Name']; ?>" required><br>
        <input type="number" name="Price" value="<?php echo $parfumData['Price']; ?>" required><br>
        <select name="Gender" required>
            <option value="Men" <?php echo ($parfumData['Gender'] == 'Men') ? 'selected' : ''; ?>>Men</option>
            <option value="Women" <?php echo ($parfumData['Gender'] == 'Women') ? 'selected' : ''; ?>>Women</option>
        </select><br>
        <input type="number" name="Volume" value="<?php echo $parfumData['Volume']; ?>" required><br>
        <input type="file" name="Image"><br>
        <button type="submit" name="action" value="update">Update Parfum</button>
    </form>
</body>
</html>
