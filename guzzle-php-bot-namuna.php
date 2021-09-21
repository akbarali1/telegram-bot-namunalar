<?php
/**
Avval conloser orqali guzzlini o`rnatib olishingiz kerak bo`ladi
*/
require_once( 'vendor/autoload.php' );
use GuzzleHttp\Client;
$apiKey = '<TOKEN>'; // Put your bot's API key here
$apiURL = 'https://api.telegram.org/bot' . $apiKey . '/';
$client = new Client( array( 'base_uri' => $apiURL ) );
$update = json_decode(file_get_contents( 'php://input' ) );
 
$chatid = $update->message->chat->id;
$type = $update->message->chat->type;
$lastname = $update->message->chat->last_name;
$fristname = $update->message->chat->first_name;
$keyboard2 = json_encode(['inline_keyboard' => [[['url' => 'https://t.me/convertor_group', 'text' => 'Guruhga qo`shilish'], ], [['url' => 'https://uzhackersw.uz/', 'text' => 'Saytga kirish'], ], ], ]);
$keyboard = json_encode(['inline_keyboard' => [[['url' => 'https://t.me/convertor_group', 'text' => 'Guruhimiz'], ], [['url' => 'https://uzhackersw.uz/', 'text' => 'Saytga kirish'], ], ], ]);
$akbarali = '<ADMIN_ID>';
$guruhim = '<CHAT_ID>';
 
if ( $update->message->text == 'Hello' ){
 $client->post( 'sendChatAction', array( 'query' => array( 'chat_id' => $chatid, 'action' => "typing" ) ) );
$client->post( 'sendMessage', array( 'query' => array( 'chat_id' => $chatid, 'text' => "Bu Guzledan yuborilgan xabar" ) ) );
 
}
 
if ( $update->message->text == 'file' ){
 $client->post( 'sendChatAction', array( 'query' => array( 'chat_id' => $chatid, 'action' => "upload_video" ) ) );
$client->post( 'sendDocument', array( 'query' => array( 'chat_id' => $chatid, 'document' => "https://uzfor.uz/view.php?act=file&id=2472" ) ) );
 
}
 
 
if ( $update->message->text == '/start' ){
$client->post( 'sendMessage', array( 'query' => array( 
 'chat_id' => $chatid, 
 'text' => "Salom " . $fristname. " " .$lastname . ". Men JPG rasmni PDF qilish sizga tashlash uchun @kbarali tomonidan yozildim. Menga rasm tashlashdan oldin /boshla buyrug`ini bering. Keyin JPG rasmni PHOTO qilish tashlang (fil
