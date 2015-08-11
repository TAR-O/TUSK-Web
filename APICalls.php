<?php

require_once __DIR__ .'/db_connect.php';
$db = new DB_CONNECT();
$conn = $db->connect();

$count = 0;

//query for city, latitude, longtitude (strings)
$sql = "SELECT  city, latitude, longtitude FROM locations";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
         $city[$count] = $row["city"];
         $Latitude[$count] = $row["latitude"];
         $Longtitude[$count] = $row["longtitude"];
         $count++;
    }
} 
else 
{
    echo "0 results";
}

//making api request
include('forecast.io.php');
$api_key = 'f823baf7f2ef7fdf8122040b3f7c8074';
$units = 'auto';  // Can be set to 'us', 'si', 'ca', 'uk' or 'auto' (see forecast.io API); default is auto
$lang = 'en'; // Can be set to 'en', 'de', 'pl', 'es', 'fr', 'it', 'tet' or 'x-pig-latin' (see forecast.io API); default is 'en'
$forecast = new ForecastIO($api_key, $units, $lang);

$tempCount=0;

while ($tempCount < $count)
{
	//getting data
	$condition = $forecast->getCurrentConditions($Latitude[$tempCount], $Longtitude[$tempCount]);
	$temperature = $condition->getTemperature();
	$ApparentTemperature = $condition->getApparentTemperature();
	$Summary = $condition->getSummary();
	$Icon = $condition->getIcon();
	$Time = $condition->getTime();
	$ressure = $condition->getPressure();
	$DewPoint = $condition->getDewPoint();
	$WindSpeed = $condition->getWindSpeed();
	$WindBearing = $condition->getWindBearing();
	$PrecipitationType = $condition->getPrecipitationType();
	$PrecipitationProbability = $condition->getPrecipitationProbability();
	$CloudCover  = $condition->getCloudCover();

	//inserting data into sql
	$sql = "INSERT INTO currentConditions (city, temp, apparantTemp, summary, icon, time,pressure,dewPoint ,humidity,windSpeed ,windBearing, precipType, precipProb, cloudCover)
	VALUES ('$city[$tempCount]','$temperature' ,'$ApparentTemperature' ,'$Summary','$Icon' ,'$Time' ,'$ressure' ,'$DewPoint', '$humidity', '$windSpeed' ,'$WindBearing' ,'$PrecipitationType' ,'$PrecipitationProbability' ,'$CloudCover')";

	if ($conn->query($sql) === TRUE) 
	{
	    echo "successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}

	$tempCount++;
}



/* //to show variable outputs
echo 'getTemperature : '.$temperature. "\n";
echo 'getApparentTemperature : '.$ApparentTemperature. "\n";
echo 'getSummary : '.$Summary. "\n";
echo 'getIcon : '.$Icon. "\n";
echo 'getTime : '.$Time. "\n";
echo 'getPressure : '.$Pressure. "\n";
echo 'getDewPoint : '.$DewPoint. "\n";
echo 'getWindSpeed : '.$WindSpeed. "\n";
echo 'getWindBearing : '.$WindBearing. "\n";
echo 'getPrecipitationType : '.$PrecipitationType. "\n";
echo 'getPrecipitationProbability : '.$PrecipitationProbability. "\n";
echo 'getCloudCover : '.$CloudCover. "\n";
*/


?>