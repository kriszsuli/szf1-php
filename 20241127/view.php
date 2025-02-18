<?php
    require_once('./cookman.php');

    $tasks = get_cookie_array();
    $error = "NOT_FOUND";

    if(!is_null($_GET["id"])) {
        $task = array();
        foreach($tasks as $itask) {
            if ($itask["id"] == $_GET["id"]) {
                $task = $itask;
                $error = "";
                break;
            }
        }
    } else {
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">dash</a></li>
            <li><a href="addtask.php">add task</a></li>
            <li><a href="stats.php">stats</a></li>
        </ul>
    </nav>

    <div class="container">
        <?php
            if($error == "NOT_FOUND") {
                echo "<p>Task not found.</p>";
                echo "<a href='index.php' class='link'>Go back</a>";
                exit();
            } else {
                echo "<h1" . (($task["completed"] === 1) ? ' class="complete"' : '') . ">" . $task["title"] . "</h1>";
                echo "<p class='description'>" . $task["description"] . "</p>";

                echo "
                    <div class='button-container'>
                        <a href='do.php?id=" . $task["id"] . "&task=complete&from=view' class='button green" . (($task["completed"] === 1) ? ' disabled' : '') . "'>Mark as complete</a>
                        <a href='do.php?id=" . $task["id"] . "&task=progress&from=view' class='button yellow" . (($task["completed"] === 0) ? ' disabled' : '') . "'>Mark as in progress</a>
                        <a href='do.php?id=" . $task["id"] . "&task=delete&from=index' class='button red'>Delete</a>
                    </div>
                ";
            }
        ?>
    </div>
</body>
</html>