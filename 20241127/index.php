<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dash</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php
        require_once('./cookman.php');
        $task_arr=array();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tasks = get_cookie_array();

            $title = htmlspecialchars($_POST['title']);
            $description = htmlspecialchars($_POST['description']);
            $id = 1;
            
            $last = (count($tasks) > 0) ? end($tasks) : array();
            if(!empty($last) and $last["title"] == $title and $last["description"] == $description) {
                echo "<div class='alert error'>Task already exists!</div>";
            } else {
                if (count($tasks) > 0) {
                    $id = $last["id"] + 1;
                }
                
                $task_arr = array(
                    'id' => $id,
                    'title' => $title,
                    'description' => $description,
                    'completed' => 0,
                );

                add_task($task_arr);
                
                echo "<div class='alert'>Task added successfully!</div>";
            }
        }
    ?>

    <nav>
        <ul>
            <li><a href="index.php">dash</a></li>
            <li><a href="addtask.php">add task</a></li>
            <li><a href="stats.php">stats</a></li>
        </ul>
    </nav>

    <div class="task-container">
        <?php
            $tasks = get_cookie_array();
            if(!empty($task_arr)) array_push($tasks, $task_arr);

            if (count($tasks) > 0) {
                foreach ($tasks as &$task) {
                    echo ("<a href='view.php?id=". $task["id"] . "'>
                        <div class='task" . (($task["completed"] === 1) ? ' disabled' : '') . "'>
                            <p class='title" . (($task["completed"] === 1) ? ' complete' : '') . "'>" . substr(htmlspecialchars($task['title']), 0, 20) . ((strlen($task["title"]) > 20) ? "..." : "") . "</p>
                            <p class='description'>" . substr(htmlspecialchars($task['description']), 0, 30) . ((strlen($task["description"]) > 30) ? "..." : "") . "</p>
                        </div>
                    </a>");
                }
            } else {
                echo "<a href='addtask.php'>
                        <div class='task disabled'>
                            <p class='title'>No tasks yet</p>
                            <p class='description'>Click the 'Add Task' page in the navigation bar to add a new task.</p>
                        </div>
                    </a>";
            }
        ?>
    </div>
</body>
</html>
