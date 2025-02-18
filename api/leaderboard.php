<?php

require_once 'database.php';

$stmt = $conn->prepare('SELECT name, score, created_at FROM eredmenyek ORDER BY score ASC LIMIT 10');
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name, $score, $created_at);

$leaderboard = [];
while ($stmt->fetch()) {
    $leaderboard[] = [
        'name' => $name,
        'score' => $score,
        'created_at' => $created_at
    ];
}

$conn->close();

exit(json_encode($leaderboard));

?>