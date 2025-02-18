<?php

    // I am Proto, your security is my Motto
    $users = [
        ["admin", "Admin123"],
        ["libaskodo", "Bl4h4j:3"],
        ["fexer", "Bnuuy011"],
        ["afeke", "Sh1ba1Nu"],
        ["froli", "SziaHelloViszlat05"]
    ];

    if (isset($_COOKIE['username']) || isset($_SESSION['username'])) {
        header('Location: profile.php');
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();
    
        if(empty($_POST['username']) || empty($_POST['password'])) {
            $error = "A felhasználónév vagy jelszó nem lehet üres!";
        } else {
            $username = test_input($_POST['username']);
            $password = test_input($_POST['password']);

            if(!preg_match('/^[a-zA-Z0-9]+$/', $username) || strlen($username) < 5) {
                $error = "A felhasználónév csak alfanumerikus karaktereket tartalmazhat, és minimum 5 karakter hosszúnak kell lennie!";
            } elseif (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
                $error = "A jelszónak legalább 8 karakter hosszúnak kell lennie, valamint tartalmaznia kell számot és nagybetűt!";
            } else {
                foreach($users as $user) {
                    if($username != $user[0] || $password != $user[1]) {
                        continue;
                    }
                    
                    $_SESSION['username'] = $_POST['username'];
                    if (!is_null($_POST['remember'])) setcookie("username", $username, time() + 3600 * 24 * 7, "/"); // 7 nap (?)
                    // amúgy tudom hogy ezt simán át lehet írni devtoolsban, de egy ilyen oldalon szerintem nincs jelentőssége

                    header('Location: profile.php');
                    exit();
                }

                $error = "Érvénytelen felhasználónév vagy jelszó!";
            }
        }
    };

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Jelentkezz be a fiókodba</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Felhasználónév</label>
                    <div class="mt-2">
                        <input id="username" name="username" type="text" autocomplete="username" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Jelszó</label>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm/6">
                    </div>
                </div>
                
                <div>
                    <div class="flex items-center">
                        <input id="remember" name="remember" value="remember" type="checkbox" class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="remember" class="ml-3 min-w-0 flex-1 text-sm/6 font-medium text-gray-900">Emlékezz rám</label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-pink-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-pink-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600">Belépés</button>
                </div>

                <div>
                    <p class="block text-sm/6 font-medium text-red-900">
                        <?php if(!empty($error)) echo $error; ?>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
