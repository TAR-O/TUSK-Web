<?php

//making connection to database
require_once __DIR__ .'/db_connect.php';
$db = new DB_CONNECT();
$conn = $db->connect();


//initializing response array
$response = array();

//default city value for testing web with out android post
$cityRetrived = "toronto";
//get post data for which city to select
if (isset($_GET["city"])) {
	$cityRetrived = $_GET['city'];

	require_once __DIR__ .'/APICalls2.php';

	//sql query
	$result2 = $conn->query("SELECT * FROM `weeklyConditions` WHERE city = '$cityRetrived'");

	//check for empty data
	if(!empty($result2)) {

		//check that there are more than one row
		if($result2->num_rows > 0){

			$data = array();
			
			//fetching all rows that match
			while($r = mysqli_fetch_assoc($result2)) {  
		    	$data[] = $r;
			}	

			//success
			$response["success"] = 1;

			// instead of array() because json would have double array output 
			$response["data"] = $data;

			//store retrieved data array into response array with name "data" so that android can pick out data
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