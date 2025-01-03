<?php
require_once 'Database.php';
require_once 'Parfum.php';

$database = new Database();
$db = $database->getConnection();
$parfum = new Parfum($db);

// Fetch all parfums from the database
$parfums = $parfum->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parfum List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="title">Parfum List</h1>
    
    <table border="1">
    
        <thead>
        <a class="create" href="create.php">Create New Parfum</a>
            <tr>
               <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Gender</th>
                <th>Volume</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parfums as $parfumData): ?>
            <tr>
            <td><img src="<?php echo $parfumData['ImageURL']; ?>" alt="Image" width="50"></td>
                <td><?php echo $parfumData['Name']; ?></td>
                <td><?php echo $parfumData['Price']."$"; ?></td>
                <td><?php echo $parfumData['Gender']; ?></td>
                <td><?php echo $parfumData['Volume']."ml"; ?></td>
                
                <td>
                    <a class="edit" href="edit.php?id=<?php echo $parfumData['ParfumID']; ?>">Edit</a>
                    <a class="delete" href="delete.php?id=<?php echo $parfumData['ParfumID']; ?>" onclick="return confirm('Are you sure you want to delete this parfum?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
