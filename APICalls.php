<?php

//require_once __DIR__ .'/db_connect.php';
//$db = new DB_CONNECT();
//$conn = $db->connect();

$count = 0;

//query for city, latitude, longtitude (strings)
$sql = "SELECT  city, latitude, longtitude FROM locations";
$result = $conn->query($sql);

//$sql = "SELECT  TIME FROM currentCondtions";
//$lastUpdate = $conn->query($sql);

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
	//getting data array
	$arrayData = $forecast->getArray($Latitude[$tempCount], $Longtitude[$tempCount]);
	$temperature = $arrayData[0]->getTemperature();
	$ApparentTemperature = $arrayData[0]->getApparentTemperature();
	$Summary = $arrayData[0]->getSummary();
	$Icon = $arrayData[0]->getIcon();
	$Time = $arrayData[0]->getTime();
	$ressure = $arrayData[0]->getPressure();
	$DewPoint = $arrayData[0]->getDewPoint();
	$WindSpeed = $arrayData[0]->getWindSpeed();
	$WindBearing = $arrayData[0]->getWindBearing();
	$PrecipitationType = $arrayData[0]->getPrecipitationType();
	$PrecipitationProbability = $arrayData[0]->getPrecipitationProbability();
	$CloudCover  = $arrayData[0]->getCloudCover();

	/*if(empty($lastUpdate)){
	//inserting data into sql
	$sql = "INSERT INTO currentConditions (city, temp, apparantTemp, summary, icon, time,pressure,dewPoint ,humidity,windSpeed ,windBearing, precipType, precipProb, cloudCover)
	VALUES ('$city[$tempCount]','$temperature' ,'$ApparentTemperature' ,'$Summary','$Icon' ,'$Time' ,'$Pressure' ,'$DewPoint', '$humidity', '$windSpeed' ,'$WindBearing' ,'$PrecipitationType' ,'$PrecipitationProbability' ,'$CloudCover')";

		if ($conn->query($sql) === TRUE) 
		{
		    echo "successfully";
		} else {
		    echo "Error creating table: " . $conn->error;
		}
	} else { */
		//if($lastUpdate )
		$sql = "UPDATE currentConditions
		    		SET temp = '$temperature', apparantTemp = '$ApparantTemp', 
		    			summary = '$Summary', icon = '$Icon', time = '$Time' ,
		    			pressure = '$Pressure', dewPoint = '$DewPoint', humidity = '$Humidity' ,
		    			windSpeed = '$WindSpeed', windBearing = '$WindBearing', precipType = '$PrecipitationType',
		    			precipProb = '$PrecipitationProbability', cloudCover = '$CloudCover'   
		    		WHERE city = '$city[$tempCount]'";

		 $conn->query($sql);

		/*if ($conn->query($sql) === TRUE) 
		{
		    echo "successfully";
		} else {
		    echo "Error updating table: " . $conn->error;
		}*/
	//}
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