<?php
require_once __DIR__ .'/db_connect.php';
$db = new DB_CONNECT();
$conn = $db->connect();

$respnse = array();
$city = "toronto";
//check post data
if (isset($_GET["city"])) {
	$city = $_GET['city'];

	

	$result = $conn->query("SELECT * FROM `currentConditions` WHERE city = '$city'");

	//check for empty data
	if(!empty($result)) {

		if($result->num_rows > 0){


			$result = mysqli_fetch_array($result);

			$data = array();
			$data["city"] = $result["city"];
			$data["temp"] = $result["temp"];
			$data["apparantTemp"] = $result["apparantTemp"];
			$data["summary"] = $result["summary"];
			$data["icon"] = $result["icon"];
			$data["time"] = $result["time"];
			$data["pressure"] = $result["pressure"];
			$data["dewPoint"] = $result["dewPoint"];
			$data["humidity"] = $result["humidity"];
			$data["windSpeed"] = $result["windSpeed"];
			$data["windBearing"]= $result["windBearing"];
			$data["precipType"] = $result["precipType"];
			$data["precipProb"] = $result["precipProb"];
			$data["cloudCover"] = $result["cloudCover"];
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