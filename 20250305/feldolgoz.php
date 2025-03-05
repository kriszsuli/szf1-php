<?php

$db_config = [
    'host' => 'localhost',
    'dbname' => 'felhasznalo_db',
    'user' => 'root',
    'pass' => ''
];

$conn = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['dbname']);
if ($conn->connect_error) {
    http_response_code(500);
    exit(json_encode(['error' => 'Nem lehetett csatlakozni az adatbázishoz.', 'conn_error' => $conn->connect_error]));
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $nev = $_POST['nev'];
    if(!$nev) {
        http_response_code(400);
        die(json_encode(['error' => 'Nem adtál meg nevet.']));
    }
    $email = $_POST['email'];

    $stmt = $conn->prepare('INSERT INTO ugyfelek (nev, email) VALUES (?, ?)');
    $stmt->bind_param('ss', $nev, $email);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        http_response_code(500);
        die(json_encode(['error' => 'Nem lehetett elmenteni az adatokat.']));
    }

    $conn->close();

    exit(json_encode(['success' => true]));
} else {
    die("Hiba");
}

?>