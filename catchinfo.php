<?php


	foreach ($_POST as $key=>$val)
	{
		$formData[$key] = $val;
	}

	//print_r($formData);


	$siteCode = $formData[siteCode]; //'LS24'; 
	$fishermanId = $formData[fishermanId]; //'LS24'; 
	$numbFish = $formData[numbFish];

	//FOR TESTING
	//$siteCode = 'LS18'; 
	//$fishermanId = 'F04'; 
	//$numbFish = 5; 

	//CartoDB user name
	$cartodb_username = "tobagoborn";

	//API Key (https://examples.cartodb.com/your_apps/api_key)
	$api_key= "48cd827d9163b44d9f1ced544bcc2aa5cc5d4bee";

	//QUERY
	$sql = "INSERT INTO catch (site_code, have_catch, number_of_species, catch_date, fisherman_id) VALUES ('$siteCode', 1, $numbFish, now(), '$fishermanId')";


//---------------
// Initializing curl
$ch = curl_init( "https://".$cartodb_username.".cartodb.com/api/v2/sql" );
$query = http_build_query(array('q'=>$sql,'api_key'=>$api_key));
// Configuring curl options
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$result_not_parsed = curl_exec($ch);
//----------------

$result = json_decode($result_not_parsed);

echo(print_r($result));

?>
