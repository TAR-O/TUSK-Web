<?php

require_once __DIR__ .'/db_connect.php';

$db = new DB_CONNECT();
$conn = $db->connect();

//sql to create weather table
$sql = "CREATE TABLE currentConditions (
id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
city VARCHAR(50) NOT NULL,
temp float(20) NOT NULL,
apparantTemp float(30) NOT NULL,
summary VARCHAR(50) not NULL,
icon VARCHAR(50) NOT NULL,
time float(50) NOT NULL,
pressure float(30) NOT NULL,
dewPoint float(50) not NULL,
humidity float(50) NOT NULL,
windSpeed float(50) NOT NULL,
windBearing float(30) NOT NULL,
precipType VARCHAR(50) not NULL,
precipProb float(50) NOT NULL,
cloudCover float(50) NOT NULL,
reg_date TIMESTAMP
)";



if ($conn->query($sql) === TRUE) {
    echo "Table  created successfully";
} else {
    echo "Error creating  weathertable: " . $conn->error;
}


// sql to create Locations table
$sql = "CREATE TABLE locations (
id INT(7) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
city VARCHAR(30) NOT NULL,
provState VARCHAR(30) NOT NULL,
country VARCHAR(50) not NULL,
latitude VARCHAR(50) NOT NULL,
longtitude VARCHAR(50) NOT NULL,
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table  created successfully";
} else {
    echo "Error creating locations table: " . $conn->error;
}



?>
