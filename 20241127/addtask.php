<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add task</title>
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

    <div class="form-container">
        <form action="index.php" method="post">
            <label for="title">Title</label>    
            <input type="text" name="title" id="title" placeholder="Watch Shrek movie" required>
            
            <label for="description">Description</label>    
            <textarea name="description" id="description" placeholder="Watch the Shrek movie later this day, idk" required></textarea>
            
            <input type="submit" value="Add task">
        </form>
    </div>

</body>
</html>
