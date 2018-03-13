<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function requestProcessor($request) {
	echo "Request received".PHP_EOL;

	if(!isset($request['type'])) {
		return "Error: unsupported message type";
	}

	switch ($request['type']) {

		case "apisearch":
			return searchApiBeer($request['searchAPI']);
	}

	return array("returnCode" => '0', 'message' => "Server received request and processed");
}

function searchApiBeer($apiBeerSearch) {

	$curl = curl_init();
	$apikey = '35ac36973944221658d74aee2f32bb0c';
	$beer_info = $apiBeerSearch;
	// $category_info = urlencode('North American Lager');
	$BASE_URL = "http://api.brewerydb.com/v2/";

	curl_setopt_array($curl, array(
		CURLOPT_URL => "$BASE_URL/beers/?name=$beer_info&key=$apikey",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));

	$response = curl_exec($curl);

	curl_close($curl);

	$response_format = json_decode($response, true);
	$result_array = array();

	foreach ($response_format as $key => $value) {
		if ($key === 'data') {
			for ($i = 0; $i < count($value); $i++) {
				foreach ($value[$i] as $data => $information) {
					if ($data === 'name') {
						$result_array['name'] = $information;
						

					}
					if ($data === 'description') {
						$result_array['description'] = $information;
						
					}
					if ($data === 'available') {
						foreach ($information as $availData => $availInformation) {
							if ($availData === 'name') {
								$result_array['available'] = $availInformation;
								
							}
						}
					}

					if ($data === 'style') {
						foreach ($information as $styleType => $styleInformation) {
							if ($styleType === 'name') {
								$result_array['type'] = $styleInformation;
								
							}
							if ($styleType === 'category') {
								foreach ($styleInformation as $category_type => $category_name) {
									if ($category_type === 'name') {
										$result_array['category'] = $category_name;
										
									
									}
								}
							}
						}
					}
				}
			} 
		}
	}
	print_r($result_array);
	return $result_array;
}

$server = new rabbitMQServer("testRabbitMQ.ini", "Backend");
$server->process_requests('requestProcessor');

exit();

?>
