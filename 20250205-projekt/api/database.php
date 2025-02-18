<?php

/*

Tábla struktúrája:

CREATE TABLE eredmenyek (
 	id MEDIUMINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL UNIQUE,
    score INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)

*/

$db_config = [
    'host' => 'localhost',
    'dbname' => 'amoba',
    'user' => 'root',
    'pass' => ''
];

$conn = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['dbname']);
if ($conn->connect_error) {
    http_response_code(500);
    exit(json_encode(['error' => 'Nem lehetett csatlakozni az adatbázishoz.']));
}

?>