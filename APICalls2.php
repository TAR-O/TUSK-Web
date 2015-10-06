<?php

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
	$arrayData = $forecast->getArray($Latitude[$tempCount], $Longtitude[$tempCount]);
	
	//weekly
	$weekly = $arrayData[2];
	$current = $arrayData[0];
	$day = 0;

		foreach($weekly as $current) {
	     $dateW = $current->getTime('Y-m-d');
	     $summaryW= $current->getSummary();
	     $maxTempW = $current->getMaxTemperature();
	     $minTempW = $current->getMinTemperature();
	     $iconW = $current->getIcon();
	     $sunRise = $current->getSunrise();
	     $sunSet = $current->getSunset();
	     $PressureW = $current->getPressure();
		 $DewPointW = $current->getDewPoint();
		 $WindSpeedW = $current->getWindSpeed();
		 $WindBearingW = $current->getWindBearing();
		 $PrecipitationTypeW = $current->getPrecipitationType();
		 $PrecipitationProbabilityW = $current->getPrecipitationProbability();
		 $CloudCoverW  = $current->getCloudCover();
		 $HumidityW = $current->getHumidity();
		 
	     $sql = "UPDATE weeklyConditions
				 SET dateW='$dateW', cloudCoverW='$CloudCoverW',
				     maxTemp='$maxTempW',minTempW= '$minTempW', 
			 	 WHERE city = '$city[$tempCount]'AND day = '$day'";

		$conn->query($sql);
		$day++;

		/* for testing sql statements
		
		echo ' date: '.$dateW."\n";
		echo ' city: '.$city[$tempCount]."\n";
		echo ' max: '. $maxTempW."\n";
		echo ' Day: '. $day."\n";
*/
		}

	$tempCount++;  
} 
?>