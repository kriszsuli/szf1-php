<?php
    session_start();
    $username = "";

    if(!isset($_COOKIE['username']) and !isset($_SESSION['username'])) {
        header('Location: login.php');
    } else {
        if(isset($_COOKIE['username'])) {
            $username = $_COOKIE['username'];
        } else {
            $username = $_SESSION['username'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm text-center">
        <h2 class="text-base/7 font-semibold text-pink-600">A PROFILOD</h2>
        <p class="mt-2 text-pretty text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl lg:text-balance">
            <?php echo $username; ?>
        </p>
        <div class="block mt-5">
            <a href="logout.php" class="rounded-md bg-pink-600 px-2.5 py-2 font-semibold tracking-tight text-gray-100">Kijelentkezés</a>
        </div>
    </div>
</body>
</html>