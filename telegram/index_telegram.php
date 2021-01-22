<script type="text/javascript">(function() {var script=document.createElement("script");script.type="text/javascript";script.async =true;script.src="//telegram.im/widget-button/index.php?id=@NAME_YOUR_ACCOUNT";document.getElementsByTagName("head")[0].appendChild(script);})();</script>
<a href="https://telegram.im/@NAME_YOUR_ACCOUNT" target="_blank" class="telegramim_button telegramim_shadow" style="font-size:18px;width:217px;background:#38761d;box-shadow:1px 1px 5px #38761d;color:#eeeeee;border-radius:71px;" title=""><i></i> NAME_YOUR_ACCOUNT</a>

<?php
include('config_telegram.php');
$url = 'http://localhost/asu/telegram.php';
//getMe
//setWebhook?url=
//getUpdates
$token = constant('_token');//from config_telegram.php

$chat_id  = GetChatId($token,file_get_contents('last_update_id.txt','w'));
//print_r($chat_id);
$arr = json_decode(($chat_id),true);
$count  = count($arr['result']);
for($i=0;$i<=$count-1;$i++){
$text = $arr['result'][$i]['message']['text'];
$message_id = $arr['result'][$i]['message']['message_id'];
$username = $arr['result'][$i]['message']['chat']['username'];
$chat_id = $arr['result'][$i]['message']['chat']['id'];
$update_id = $arr['result'][$i]['update_id'];
	echo "<p>
<b>Text:</b> ".$text.
"<b> Message id:</b> ".$message_id.
"<b> username:</b> ".$username.
"<b> chat id:</b> ".$chat_id.
"<b> update id:</b> ".$update_id.
"</p>";

}
if($count==0) echo "<p>No new messages</p>";
else file_put_contents('last_update_id.txt', $update_id);
//SendMessage($token,'583507651','Hello, this text sended from bot :)');


//update_id is using for confirmation about read messages
function GetChatId($token,$last_update_id){
	$last_update_id+=1;
return file_get_contents("https://api.telegram.org/bot{$token}/getUpdates?offset={$last_update_id}");
}

function SendMessage($token,$chat_id,$text){
file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}?&text={$text}");
}

?>