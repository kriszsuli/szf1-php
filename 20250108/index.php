<?php
session_start();
$stages = [
    "


    
    
    
    
__________________
    ",
    "

    |
    |
    |
    |
    |
__________________
    ",
    "
    ________
    |
    |
    |
    |
    |
__________________
    ",
    "
    ________
    |      |
    |
    |
    |
    |
__________________
    ",
    "
    ________
    |      |
    |      o
    |
    |
    |
__________________
    ",
    "
    ________
    |      |
    |      o
    |      |
    |
    |
__________________
    ",
    "
    ________
    |      |
    |      o
    |     /|
    |
    |
__________________
    ",
    "
    ________
    |      |
    |      o
    |     /|\
    |
    |
__________________
    ",
    "
    ________
    |      |
    |      o
    |     /|\
    |     /
    |
__________________
    ",
    "
    ________
    |      |
    |      o
    |     /|\
    |     / \
    |
__________________
    "
];

if(!isset($_SESSION["szo"])) {
    $szavak = explode("\n", file_get_contents('5000-more-common.txt'));
    $szavak = mb_convert_encoding($szavak, 'UTF-8', 'auto');
    $_SESSION["szo"] = $szavak[array_rand($szavak)];

    $_SESSION["eltalalt"]  = [];
    $_SESSION["elrontott"] = 0;
}

$szo = $_SESSION["szo"];
$probak = 9;
$eltalalt = $_SESSION["eltalalt"];
$elrontott = $_SESSION["elrontott"];

$gameOver = $elrontott >= $probak || check($szo, $eltalalt);

function check($szo, $eltalalt) {
    foreach (str_split($szo) as $betu) {
        if (!in_array($betu, $eltalalt)) {
            return false;
        }
    };
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guess'])) {
    $guess = strtolower(trim($_POST['guess']));
    
    if (strlen($guess) === 1 && !in_array($guess, $eltalalt)) {
        if (strpos($szo, $guess) === false) {
            $_SESSION['elrontott']++;
        }
        $_SESSION['eltalalt'][] = $guess;
    }

    header("Refresh:0");
}

function displayWord($szo, $eltalalt) {
    $display = '';
    foreach (str_split($szo) as $betu) {
        if (in_array($betu, $eltalalt)) {
            $display .= $betu . ' ';
        } else {
            $display .= '_ ';
        }
    }
    return trim($display);
}

$currentStage = $stages[$elrontott];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akasztófa</title>
    <style>
        pre,code {
            width:fit-content;
            background-color:#efefef;
            color:#000;
            font-weight:bold;
            padding: 5px;
        }

        pre {
            padding: 30px;
            margin: 0 auto;
        }

        p, a, button, form {
            text-align:center;
            margin:0 auto;
        }

        form,.pad {
            margin: 35px;
        }

        html,body {
            margin:0;
            padding:0;
            box-sizing:border-box;
            height:100vh;
            font-family:sans-serif;
        }
        body {
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
        }
    </style>
</head>
<body>
    <pre><?php echo $currentStage; ?></pre>

    <p><?php echo displayWord($szo, $eltalalt); ?></p>

    <?php if (!$gameOver): ?>
        <form method="POST">
            <p>Tippelj egy betűt:</p>
            <input type="text" name="guess" maxlength="1" required autofocus>
            <button type="submit">Tipp</button>
        </form>
    <?php endif; ?>

    <?php if ($gameOver): ?>
        <p class="pad">
            <?php if (check($szo, $eltalalt)): ?>
                Nyertél! A szó: <b><?php echo $szo; ?></b>
            <?php else: ?>
                Vesztettél! A szó: <b><?php echo $szo; ?></b>
            <?php endif; ?>
        </p>
        <p><a href="reset.php">Új játék</a></p>
    <?php endif; ?>
    
    <?php if (!$gameOver): ?>
        <p>Tippjeid: <code><?php echo implode(', ', $eltalalt); ?></code></p>
        <p>Hátralevő próbák: <b><?php echo $probak - $elrontott; ?></b></p>    
    <?php endif; ?>
</body>
</html>