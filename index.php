<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$albums = getAlbumsByUser($pdo, $_SESSION['username']);
$getAllPhotos = getAllPhotos($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCOSnaps</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="create-album-form" style="margin: 20px 0; text-align: center;">
    <h2>Create a New Album</h2>
    <form action="core/handleForms.php" method="POST">
        <input type="text" name="album_name" placeholder="Enter album name" required>
        <button type="submit" name="createAlbumBtn">Create Album</button>
    </form>
</div>

    <h1>Your Albums</h1>
    <div class="albums-section">
        <?php foreach ($albums as $album): ?>
            <div class="album">
                <h3><?php echo htmlspecialchars($album['album_name']); ?></h3>
                <a href="viewalbum.php?album_id=<?php echo $album['album_id']; ?>">View Album</a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="insertPhotoForm" style="display: flex; justify-content: center;">
        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
            <p>
                <label for="#">Description</label>
                <input type="text" name="photoDescription">
            </p>
            <p>
                <label for="#">Photo Upload</label>
                <input type="file" name="image">
                <input type="submit" name="insertPhotoBtn" style="margin-top: 10px;">
            </p>
        </form>
    </div>

    <h1>All Photos</h1>
    <?php foreach ($getAllPhotos as $row): ?>
        <div class="images" style="display: flex; justify-content: center; margin-top: 25px;">
            <div class="photoContainer" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 50%;">
                <img src="images/<?php echo $row['photo_name']; ?>" alt="" style="width: 100%;">
                <div class="photoDescription" style="padding:25px;">
                    <a href="profile.php?username=<?php echo $row['username']; ?>"><h2><?php echo $row['username']; ?></h2></a>
                    <p><i><?php echo $row['date_added']; ?></i></p>
                    <h4><?php echo $row['description']; ?></h4>

                    <?php if ($_SESSION['username'] == $row['username']): ?>
                        <a href="editphoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Edit </a>
                        <br><br>
                        <a href="deletephoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Delete</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>