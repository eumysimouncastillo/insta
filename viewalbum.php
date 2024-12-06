<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$album_id = isset($_GET['album_id']) ? $_GET['album_id'] : null;
if (!$album_id) {
    echo "<p>Album not found. Please go back and try again.</p>";
    exit;
}

$album_photos = getAllPhotos($pdo, null, $album_id);
$album_details = getAlbumByID($pdo, $album_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Album</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <h1>Album: <?php echo htmlspecialchars($album_details['album_name']); ?></h1>

    <?php if ($_SESSION['username'] == $album_details['username']): ?>
        <div class="edit-album" style="margin: 20px 0;">
            <form action="core/handleForms.php" method="POST">
                <input type="hidden" name="album_id" value="<?php echo $album_id; ?>">
                <input type="text" name="new_album_name" value="<?php echo htmlspecialchars($album_details['album_name']); ?>" required>
                <button type="submit" name="updateAlbumBtn">Update Album</button>
                <button type="submit" name="deleteAlbumBtn">Delete Album</button>
            </form>
        </div>
    <?php endif; ?>

    <h2>Photos in Album</h2>
    <?php if (count($album_photos) > 0): ?>
        <?php foreach ($album_photos as $photo): ?>
            <div class="photoContainer" style="margin: 20px auto; width: 80%; border: 1px solid #ccc; padding: 10px;">
                <img src="images/<?php echo $photo['photo_name']; ?>" alt="Photo" style="width: 100%;">
                <p><?php echo htmlspecialchars($photo['description']); ?></p>

                <?php if ($_SESSION['username'] == $photo['username']): ?>
                    <form action="core/handleForms.php" method="POST" style="margin-top: 10px;">
                        <input type="hidden" name="photo_id" value="<?php echo $photo['photo_id']; ?>">
                        <input type="hidden" name="photo_name" value="<?php echo $photo['photo_name']; ?>">
                        <input type="text" name="new_photo_description" value="<?php echo htmlspecialchars($photo['description']); ?>" required>
                        <button type="submit" name="updatePhotoBtn">Edit Photo</button>
                        <button type="submit" name="deletePhotoBtn">Delete Photo</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No photos in this album yet.</p>
    <?php endif; ?>
</body>
</html>
