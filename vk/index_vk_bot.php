<?php
//1 - Create application as "Site" on https://vk.com/apps?act=manage
//2 In the Settings - Address Site  =  site.com/myphpvk.php, Base domain - site.com, Open API - Enabled
//3 Get on the same page - APP ID, Secure key, Service token
include('config_vk.php');

$token = AuthorizationVK();
if(isset($token)){
echo "<p>Email: ".$token['email']."</p>";
echo "<p>User_id: ".$token['user_id']."</p>";

$response = GetVkUserData($token['user_id'],$token['access_token']);

echo "Photo: <p><img src='".$response['response'][0]['photo_max']."'></p>";
echo "<p>First name:"	.$response['response'][0]['first_name']."</p>";
echo "<p>Last name:"	.$response['response'][0]['last_name']."</p>";
echo "<p>Birth date:"	.$response['response'][0]['bdate']."</p>";
echo "<p>Country:"		.$response['response'][0]['country']['title']."</p>";
echo "<p>City:"			.$response['response'][0]['city']['title']."</p>";
echo "<p>Home town:"	.$response['response'][0]['home_town']."</p>";
echo "<p>Home phone:"	.$response['response'][0]['home_phone']."</p>";
}

//Call to Send Message
//SendDirectVkMessageFromGroup($token['user_id'],"Hello from script2");

//returns user individual token 
function AuthorizationVK(){
$ID= constant("_ID");//App id
$SECTRET= constant("_SECTRET");//Secure key,
$SERVICE_KEY= constant("_SERVICE_KEY"); // Service token
$URL='http://localhost/asu/vk_api.php';

$link = 'https://oauth.vk.com/authorize?client_id='.$ID.'&display=page&redirect_uri='.$URL.'&scope=email&response_type=code&v=5.126&state=123456';

echo '<p><a href='.$link.'>Authorization with Vk.com</a></p>';	

if(isset($_GET['code']))
	{
		$code = $_GET['code'];
		$link2 = 'https://oauth.vk.com/access_token?client_id='.$ID.'&client_secret='.$SECTRET.'&redirect_uri='.$URL.'&code='.$code;				
		$json = file_get_contents($link2);
		$token = json_decode($json,true);
		if(!$token['access_token']){ echo '<hr> error token'; }		
		else { return $token; }
	}
}

//returns user data 
function GetVkUserData($user_id,$token){
	$request_params = array(
	'user_ids' => $user_id
	,'fields'=>'bdate,city,country,home_town,photo_id,has_mobile,photo_max,contacts,home_phone'
	,'access_token' => $token
	,'v' => '5.126'
	);
$get_params = http_build_query($request_params);
$json = file_get_contents('https://api.vk.com/method/users.get?'. $get_params);
$response = json_decode($json, true);
return $response;
}

function SendDirectVkMessageFromGroup($user_id,$message){
$request_params = array(
'message' => $message,
'peer_id' => $user_id,
'access_token' => '00000000000000000', //GROUP ACCESS TOKEN, NOT USER TOKEN
'v' => '5.126',
'random_id' => '0' 
);
$get_params = http_build_query($request_params);
file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 
}
?>