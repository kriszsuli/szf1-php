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
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Elítélt bűnözők listája</h1>
        </header>
        
        <section class="gallery">
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <figure>
                    <img src="static/img/goober.png" class="gallery-pic" alt="Elítélt bűnöző képe">
                </figure>
            <?php endfor; ?>
        </section>
        
        <footer>
            <p class="info">Bejelentkezve mint: <span><?php echo htmlspecialchars($_SESSION['username']); ?></span></p>
            <a href="logout.php" class="button">Kijelentkezés</a>
        </footer>
    </div>
</body>
</html>