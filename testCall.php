<?php //making api request
include('forecast.io.php');
$api_key = 'f823baf7f2ef7fdf8122040b3f7c8074';
$units = 'auto';  // Can be set to 'us', 'si', 'ca', 'uk' or 'auto' (see forecast.io API); default is auto
$lang = 'en'; // Can be set to 'en', 'de', 'pl', 'es', 'fr', 'it', 'tet' or 'x-pig-latin' (see forecast.io API); default is 'en'
$forecast = new ForecastIO($api_key, $units, $lang);


$arrayData = $forecast->getArray(43.7, 79.4);
$temperatureNow = $arrayData[0];
$temperatureWeekly = $arrayData[2];

echo $temperatureNow.getTemperature();
foreach($temperatureWeekly as $temperatureNow) {
    echo $temperatureNow->getTime('Y-m-d') . ': ' . $temperatureNow->getMaxTemperature() . "\n";
}
//echo $temperatureWeekly;

//while ($tempCount < $count)
//{
	//getting data array
	//$arrayData = $forecast->getArray(43.7, -79.4);
	//$temperatureNow = $arrayData[0]->getTemperature();

	//echo $temperatureNow;

	/*$temperature = $condition->getTemperature();
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
	*/

	

//	$tempCount++;
//}

?>
