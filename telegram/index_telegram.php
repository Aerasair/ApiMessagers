<?php
include('config_telegram.php');
$url = 'http://localhost/asu/telegram.php';
//getMe
//setWebhook?url=
//getUpdates
$token = constant('_token');//from config_telegram.php

$chat_id  = GetChatId($token);

$arr = json_decode(($chat_id),true);
$count  = count($arr['result']);
for($i=0;$i<=$count-1;$i++){
$text = $arr['result'][$i]['message']['text'];
$message_id = $arr['result'][$i]['message']['message_id'];
$username = $arr['result'][$i]['message']['chat']['username'];
$chat_id = $arr['result'][$i]['message']['chat']['id'];
	echo "<p>
<b>Text:</b> ".$text.
"<b> Message id:</b> ".$message_id.
"<b> username:</b> ".$username.
"<b> chat id:</b> ".$chat_id.
"</p>";
}

//SendMessage($token,'583507651','Hello, this text sended from bot :)');



function GetChatId($token){
return file_get_contents("https://api.telegram.org/bot{$token}/getUpdates");
}

function SendMessage($token,$chat_id,$text){
file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}?&text={$text}");
}
?>