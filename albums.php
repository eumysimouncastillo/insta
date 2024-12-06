<?php
// albums.php - Display and manage albums
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
$username = $_SESSION['username'];
$albums = getAlbumsByUser($pdo, $username);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Albums</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h1>Your Albums</h1>
    <form action="core/handleForms.php" method="POST">
        <input type="text" name="album_name" placeholder="New Album Name" required>
        <button type="submit" name="createAlbumBtn">Create Album</button>
    </form>
    
    <?php foreach ($albums as $album): ?>
        <div class="album">
            <h2><?php echo htmlspecialchars($album['album_name']); ?></h2>
            <form action="core/handleForms.php" method="POST">
                <input type="hidden" name="album_id" value="<?php echo $album['album_id']; ?>">
                <input type="text" name="new_album_name" value="<?php echo htmlspecialchars($album['album_name']); ?>">
                <button type="submit" name="updateAlbumBtn">Update</button>
                <button type="submit" name="deleteAlbumBtn">Delete</button>
            </form>
            <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="album_id" value="<?php echo $album['album_id']; ?>">
                <input type="text" name="photo_description" placeholder="Photo Description" required>
                <input type="file" name="photo" required>
                <button type="submit" name="addPhotoToAlbumBtn">Add Photo</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
