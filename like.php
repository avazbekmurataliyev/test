<?php


$admin = '5222947163';
$token = '5612335745:AAFS-BXFlGdv0Gd3Rw0_ddrOZAgw7ErAeBk';

function bot($method,$datas=[]){
global $token;
    $url = "https://api.telegram.org/bot".$token."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}


$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$mid = $message->message_id;
$msgs = json_decode(file_get_contents('msgs.json'),true);

$type = $message->chat->type;
$text = $message->text;
$cid = $message->chat->id;
$uid= $message->from->id;
$gname = $message->chat->title;
$left = $message->left_chat_member;
$new = $message->new_chat_member;
$name = $message->from->first_name;
$repid = $message->reply_to_message->from->id;
$repname = $message->reply_to_message->from->first_name;
$newid = $message->new_chat_member->id;
$leftid = $message->left_chat_member->id;
$newname = $message->new_chat_member->first_name;
$leftname = $message->left_chat_member->first_name;
$username = $message->from->username;
$cusername = $message->chat->username;
$repmid = $message->reply_to_message->message_id; 

$data = $update->callback_query->data;
$cmid = $update->callback_query->message->message_id;
$ccid = $update->callback_query->message->chat->id;
$cuid = $update->callback_query->message->from->id;
$qid = $update->callback_query->id; 

$ctext = $update->callback_query->message->text; 
$callfrid = $update->callback_query->from->id; 
$callfname = $update->callback_query->from->first_name;  
$calltitle = $update->callback_query->message->chat->title; 
$calluser = $update->callback_query->message->chat->username; 
$message_id = $update->callback_query->message->message_id;
 
$channel = $update->channel_post; 
$channel_text = $channel->text;
$channel_mid = $channel->message_id; 
$channel_id = $channel->chat->id; 
$channel_user = $channel->chat->username; 

$chanel_doc = $channel->document; 
$chanel_vid = $channel->video; 
$chanel_mus = $channel->audio; 
$chanel_voi = $channel->voice; 
$chanel_gif = $channel->animation; 
$chanel_fot = $channel->photo; 
$caption=$channel->caption;
$cap=file_get_contents("baza/$channel_id.txt");

// xabar yuborish 

function joinchat($id){
	global $message_id;
$result=bot('getChatMember',[
"chat_id"=>"@NCbeginner",
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
[['text'=>"azo bo'lish","url"=>"https://t.me/NCbeginner"],],[["text"=>"✅Tekshirish",'callback_data'=>"tekshirish"],]
]
]),
]);
}
}
$text = $message->text;
$chat_id = $message->chat->id;
$message_id = $update->callback_query->message->message_id;
$callback = $update->callback_query->data;
$from_id = $update->callback_query->from->id;
$id = $update->callback_query->id;
$fromid = $message->from->id;

// obunani tekshirish

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


mkdir("like");
mkdir("baza");

if($text=="/start"){
  bot('sendmessage',[
   'chat_id'=>$cid,
   'text'=>"Salom <b>$name</b>, bu bot kanallardagi postlaringizga ulashish va like tugmalarini qo'yib beradi. Buning uchun botni kanalingizga qo'shib administratorlik huquqlarini berib qo'yishingiz kerak!

<code>#comment</code> va so'z - Har bir postingizga #comment so'zidan keyingi yozgan so'zingiz qo'shiladi
<code>#text</code> - #comment ga yozlilgan matningiz
<code>#clear</code> - #comment matnini o'chirib yuborish

<b>Yuqorida keltirilgan buyruqlar faqat kanallarda ishlaydi! Siz ham @Vertualprorobot bilan oʻz botingizni yarating</b>",
   'parse_mode' => 'html'
  ]);
}

if(isset($chanel_doc) or isset($chanel_vid) or isset($chanel_mus) or isset($chanel_voi) or isset($chanel_gif) or isset($chanel_fot)){

   bot('editmessagecaption',[
        'chat_id'=>$channel_id,
        'message_id'=>$channel_mid,
        'caption'=>"$caption

$cap",
        'parse_mode'=>'html',
      ]);
  
    $tokenn=uniqid("true");

    bot('editMessageReplyMarkup',[
        'chat_id'=>$channel_id,
        'message_id'=>$channel_mid,
        'inline_query_id'=>$qid, 
        'reply_markup'=>json_encode([ 
        'inline_keyboard'=>[ 
       [['text'=>"👍", 'callback_data'=>"$tokenn=👍"],['text'=>"👎",'callback_data'=>"$tokenn=👎"]],
       [['text'=>"Do'stlarga ulashish", "url"=>"https://telegram.me/share/url?url=https://telegram.me/$channel_user/$channel_mid"]], 
       ] 
       ]) 
       ]);
}


if(mb_stripos($data,"=")!==false){ 
$ex=explode("=",$data); 
$calltok=$ex[0]; 
$emoj=$ex[1]; 
$mylike=file_get_contents("like/$calltok.dat"); 
if(joinchat($from_id)=="true"){
if(mb_stripos($mylike,"$callfrid")!==false){ 
      bot('answerCallbackQuery',[ 
        'callback_query_id'=>$qid, 
        'text'=>"Kechirasiz siz ovoz berib bo'lgansiz!", 
        'show_alert'=>false, 
    ]); 
}else{ 
file_put_contents("like/$calltok.dat","$mylike\n$callfrid=$emoj"); 
$value=file_get_contents("like/$calltok.dat"); 
$lik=substr_count($value,"👍"); 
$des=substr_count($value,"👎"); 
     bot('editMessageReplyMarkup',[ 
        'chat_id'=>$ccid, 
        'message_id'=>$cmid,
        'inline_query_id'=>$qid,
        'reply_markup'=>json_encode([ 
        'inline_keyboard'=>[ 
       [['text'=>"👍 $lik", 'callback_data'=>"$calltok=👍"],['text'=>"👎 $des",'callback_data'=>"$calltok=👎"]], 
       [['text'=>"Do'stlarga ulashish", "url"=>"https://telegram.me/share/url?url=https://telegram.me/$calluser/$cmid"]], 
       ] 
       ]) 
       ]);
       bot('answerCallbackQuery',[ 
        'callback_query_id'=>$qid, 
        'text'=>"Ovozingiz qabul qilindi!", 
        'show_alert'=>false, 
    ]);  
  }
}
}
if(mb_stripos($channel_text,"#comment")!==false){
  $ex=explode("#comment", $channel_text);
  $exe=$ex[1];
  file_put_contents("baza/$channel_id.txt", "$exe");
  bot('deletemessage',[
    'chat_id'=>$channel_id,
    'message_id'=>$channel_mid,
  ]);
}

if($channel_text=="#text"){
  bot('deletemessage',[
    'chat_id'=>$channel_id,
    'message_id'=>$channel_mid,
  ]);
  bot('sendmessage',[
    'chat_id'=>$channel_id,
    'text'=>$cap,
    'parse_mode'=>'html',
  ]);
}

if($channel_text=="#clear"){
  unlink("baza/$channel_id.txt");
  bot('deletemessage',[
    'chat_id'=>$channel_id,
    'message_id'=>$channel_mid,
  ]);
}
