<?php

require_once __DIR__ . '/db_connect.php';

$db = new DB_CONNECT();
$conn = $db ->connect();

$sql = "INSERT INTO LOCATIONS (city, provState, country, latitude, longtitude)
VALUES ('Toronto', 'Ontario', 'Canada', 43.7, 79.4)";

if ($conn->query($sql) === TRUE) {
    echo "Toronto data inserted successfully";
} else {
    echo "Error inserting toronto into LOCATIONS table: " . $conn->error;
}

$sql = "INSERT INTO LOCATIONS (city, provState, country, latitude, longtitude)
VALUES ('Hamiton', 'Ontario', 'Canada', 43.25, 79.8667)";

if ($conn->query($sql) === TRUE) {
    echo "Hamiton data inserted successfully";
} else {
    echo "Error inserting hamiton into LOCATIONS table: " . $conn->error;
}

?>