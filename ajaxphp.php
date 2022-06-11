<?php
$currentTime = time();
$location = $_POST['location'];
if (!empty($location)) {
	$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://community-open-weather-map.p.rapidapi.com/forecast?q=".$location."%2Cindia&units=metric&cnt=7",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: community-open-weather-map.p.rapidapi.com",
		"X-RapidAPI-Key: 6c4366e897mshd2af512d08d4660p13a2c0jsn2eaab5961a0b"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
		$div ="";
		$res = str_replace("test", "", $response);
		$res_fil = str_replace("(", "", $res);
		$res_fil = str_replace(")", "", $res_fil);
		$response_val = json_decode($res_fil,true);
		
		try {
			if (!empty($response_val)) {
				$i=0;
				foreach ($response_val['list'] as $key => $value) {
					$week = date('l',$value['dt']);
					$div .= "<p class='sat'>".date('l Y-m-d',$value['dt'])." <br><span>Temp - ".$value['main']['temp']."</span><br><span>Feels Like - ".$value['main']['feels_like']."</span><br><span>Max - ".$value['main']['temp_max']."</span><br><span>Min - ".$value['main']['temp_min']."</span><br><span>main - ".$value['main']['sea_level']."</p>";
				}
			}
			echo $div;
		} catch (Exception $e) {
			echo $e;
		}
	}
}
?>
