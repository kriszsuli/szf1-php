<?php
session_start();
require 'database.php';

$errors = [];
$success = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $errors[] = "Tölts ki minden mezőt.";
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $_SESSION['username'] = $username;
            header("Location: profile.php");
            exit();
        } else {
            $errors[] = "Hibás felhasználónév vagy jelszó.";
        }
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success[] = "Sikeres regisztráció!";
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="login.php" method="post">
        <h1>Bejelentkezés</h1>
        
        <input type="text" id="username" name="username" placeholder="Felhasználónév" required><br>
        <input type="password" id="password" name="password" placeholder="••••••" required><br>

        <?php if (!empty($success)): foreach ($success as $success): ?>
            <p class="response success"><?= htmlspecialchars($success) ?></p>
        <?php endforeach; endif; ?>

        <?php if (!empty($errors)): foreach ($errors as $error): ?>
            <p class="response error"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; endif; ?>

        <input type="submit" value="Bejelentkezés">
        <a href="register.php">Nincs még fiókom</a>
    </form>
</body>
</html>