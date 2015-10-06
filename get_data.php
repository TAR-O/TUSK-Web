<?php
//make database connection
require_once __DIR__ .'/db_connect.php';
$db = new DB_CONNECT();
$conn = $db->connect();

//initializing response array
$response = array();

//default city value for testing web without android post
$cityRetrived = "toronto";

//get post data city
if (isset($_GET["city"])) {

	$cityRetrived = $_GET['city'];

	require_once __DIR__ .'/APICalls.php';
	//sql query for current conditions
	$result2 = $conn->query("SELECT * FROM `currentConditions` WHERE city = '$cityRetrived'");

	//check for empty data
	if(!empty($result2)) {

		if($result2->num_rows > 0){

			//getting row array from database
			$result2 = mysqli_fetch_array($result2);

			//storing row into data arrary
			$data = array();
			$data["city"] = $result2["city"];
			$data["temp"] = $result2["temp"];
			$data["apparantTemp"] = $result2["apparantTemp"];
			$data["summary"] = $result2["summary"];
			$data["icon"] = $result2["icon"];
			$data["time"] = $result2["time"];
			$data["pressure"] = $result2["pressure"];
			$data["dewPoint"] = $result2["dewPoint"];
			$data["humidity"] = $result2["humidity"];
			$data["windSpeed"] = $result2["windSpeed"];
			$data["windBearing"]= $result2["windBearing"];
			$data["precipType"] = $result2["precipType"];
			$data["precipProb"] = $result2["precipProb"];
			$data["cloudCover"] = $result2["cloudCover"];
			//success
			$response["success"] = 1;

			$response["data"] = array();

			array_push($response["data"], $data);

			echo json_encode($response);
			
		} else {
			//no data found
			$response["success"] = 0;
			$response["message"] = "no data found 1";

			echo json_encode($response);
		}

	} else {
		//no data found
		$response["success"] = 0;
		$response["message"] = "no data found 2";

		echo json_encode($response);

	}
	
} else {
		//no data found
		$response["success"] = 0;
		$response["message"] = "required fields is missing";
  
		echo json_encode($response);

	}



?>