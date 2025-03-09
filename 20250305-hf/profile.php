<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elítélt bűnözők listája</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Elítélt bűnözők listája</h1>

        <div class="gallery">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <img src="https://i.imgur.com/fS4TZDX.png" class="gallery-pic" alt="convicted murderer">
            <?php endfor; ?>
        </div>

        <p class="info">Bejelentkezve, mint: <span><?php echo $_SESSION['username']; ?></span></p>
        <a href="logout.php" class="button">Kijelentkezés</a>
    </div>
</body>
</html>