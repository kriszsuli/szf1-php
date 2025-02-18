<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>stats</title>
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

    <div class="task-container">
        <div class="task">
            <p class="title">Task Stats</p>
            <?php
                require_once('./cookman.php');
                
                $tasks = get_cookie_array();
                
                $total_tasks = count($tasks);
                echo "<p>Total tasks: " . $total_tasks . "</p>";
                
                if ($total_tasks > 0) {
                    $completed_tasks = 0;

                    foreach ($tasks as $task) {
                        if (isset($task['completed']) && $task['completed'] === 1) {
                            $completed_tasks++;
                        }
                    }
                    
                    echo "<p>Completed tasks: " . $completed_tasks . "</p>";
                    echo "<p>Pending tasks: " . ($total_tasks - $completed_tasks) . "</p>";
                } else {
                    echo "<p>No tasks have been added yet.</p>";
                }
            ?>
        </div>
    </div>

</body>
</html>
