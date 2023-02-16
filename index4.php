<?php
ob_start();
error_reporting(0);
date_default_timezone_set("Asia/Tashkent");
define('bot','5786109291:AAHVSRQn1TsIluuutLsaIbU3ew24Qk7g7n0');

function bot($method,$steps=[]){
$url = "https://api.telegram.org/bot".bot."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$steps);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}
}

function joinchat($id){
	global $message_id;
$result=bot('getChatMember',[
"chat_id"=>"@telefondadasturlash",
"user_id"=>$id,
])->result->status;

if($result=="member" or $result=="administrator" or $result=="creator"){
return true;
}else{
bot("sendMessage",[
     "chat_id"=>"$id",
     "text"=>"Kanalimizga obuna bo'ling!",
     "parse_mode"=>"html",
     "reply_markup"=>json_encode([
'inline_keyboard'=>[
[['text'=>"azo bo'lish","url"=>"https://t.me/telefondadasturlash"],],[["text"=>"✅Tekshirish",'callback_data'=>"tekshirish"],]
]
]),
]);
}
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$chat_id = $message->chat->id;
$message_id = $update->callback_query->message->message_id;
$callback = $update->callback_query->data;
$from_id = $update->callback_query->from->id;
$id = $update->callback_query->id;
$fromid = $message->from->id;

if($callback=="tekshirish"){
if(joinchat($from_id)=="true"){
  bot("sendMessage",[
  "chat_id"=>"$from_id",
  "text"=>"Salom qalaysiz",
  "parse_mode"=>"html",
  "reply_markup"=>json_encode([
   "inline_keyboard"=>[
   [["text"=>"Resize",'callback_data'=>"resize"],["text"=>"Inline",'callback_data'=>"inline"],],
]
]),
]);
}
}

if($text=="/start"){
	if(joinchat($fromid)=="true"){
  bot("sendMessage",[
  "chat_id"=>"$chat_id",
  "text"=>"Salom qalaysiz",
  "parse_mode"=>"html",
  "reply_markup"=>json_encode([
   "inline_keyboard"=>[
   [["text"=>"Resize",'callback_data'=>"resize"],["text"=>"Inline",'callback_data'=>"inline"],],
]
]),
]);
}
}

if($callback=="resize"){
bot("sendMessage",[
"chat_id"=>$from_id,
"text"=>"Siz Inline tugmasiga bosdingiz👍",
"parse_mode"=>"html",
]);
}

if($callback=="inline"){
bot("sendMessage",[
"chat_id"=>$from_id,
"text"=>"Siz Tugma tugmasiga bosdingiz👍",
"parse_mode"=>"html",
]);
}



?>