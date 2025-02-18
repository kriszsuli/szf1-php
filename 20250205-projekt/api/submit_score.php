<?php

require_once 'database.php';

if (!isset($_POST['name']) || !isset($_POST['time'])) {
    http_response_code(400);
    exit(json_encode(['error' => 'Hiányzó adatok.']));
}

$name = $conn->real_escape_string($_POST['name']);
$time = $conn->real_escape_string($_POST['time']);

// Tettem volna ide winning combo validationt, de felesleges. Reméljük nem él vissza senki vele :D

$stmt = $conn->prepare('INSERT INTO eredmenyek (name, score) VALUES (?, ?)');
$stmt->bind_param('si', $name, $time); // si => string, integer (formátum megadás)
$stmt->execute();

if ($stmt->affected_rows === 0) {
    http_response_code(500);
    exit(json_encode(['error' => 'Nem sikerült elmenteni az adatokat.']));
}

$conn->close();

exit(json_encode(['success' => true]));

?>