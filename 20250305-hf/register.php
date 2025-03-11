<?php
require 'database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    if (empty($username) || empty($password) || empty($email)) {
        $errors[] = "Tölts ki minden mezőt.";
    } else {
        $stmt = $conn->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            if ($row['username'] === $username) {
                $errors[] = "A felhasználónév már foglalt.";
            }
            if ($row['email'] === $email) {
                $errors[] = "Az e-mail cím már foglalt.";
            }
        }

        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $password, $email);
            $stmt->execute();

            header("Location: login.php?success=1");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
    <form action="register.php" method="post">
        <h1>Regisztráció</h1>

        <input type="email" id="email" name="email" placeholder="E-mail cím" required><br>
        <input type="text" id="username" name="username" placeholder="Felhasználónév" required><br>
        <input type="password" id="password" name="password" placeholder="••••••" required><br>

        <?php if (!empty($errors)): foreach ($errors as $error): ?>
            <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; endif; ?>

        <input type="submit" value="Regisztráció">
        <a href="login.php">Van már fiókom</a>
    </form>
</body>
</html>
