<?php
//require __DIR__ . '/vendor/autoload.php';
define('TOKEN', '<BOT_TOKEN>');
$data = file_get_contents('php://input');
$data = json_decode($data, true);
//Kodni qisqartirmasak bo`lmas ekan
$chat_id = $data['message']['chat']['id'];
$user_text = $data['message']['text'];
$username = ($data['message']['chat']['username']) ? : 'nousername';
$message_id = $data['message']['message_id'];
$last_name = ($data['message']['chat']['last_name']) ? : 'nolastname';
$first_name = ($data['message']['chat']['first_name']) ? : 'nofirstname';
$birgalikda = $first_name . " " . $last_name;
$chanel_name = '@tushuntirolmadim';
$groupid = '-1001297074263';
$keyboard = json_encode(['inline_keyboard' => [[['url' => 'https://t.me/Tushuntirolmadim', 'text' => 'Kanal (Tushuntirolmadim)'], ], [['url' => 'https://t.me/convertor_group', 'text' => 'Guruh (Conventor GROUP)'], ], [['url' => 'https://uzhackersw.uz/', 'text' => 'Saytga kirish (ixtoyoriy)'], ], ], ]);
function reponse($massiv) {
    $botpost = json_decode($massiv, true);
    return $botpost;
}
// Функция вызова методов API.
function sendTelegram($method, $response) {
    $ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}
function botpostid($input) {
    $botpost = json_decode($input, true);
    $input1 = $botpost['result']['message_id'];
    return $input1;
}
if (!empty($user_text == "/groupid")) {
    sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $chat_id));
    die;
}
if (!empty($user_text)) {
    $chanel = reponse(sendTelegram('getChatMember', array('chat_id' => $chanel_name, 'user_id' => $chat_id)));
    $group = reponse(sendTelegram('getChatMember', array('chat_id' => $groupid, 'user_id' => $chat_id)));
    if ($chanel['result']['status'] === 'left') {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Botdan foydalanish uchun avval kanalga azo bo`ling', 'reply_markup' => $keyboard));
        die;
    }
    if ($group['result']['status'] === 'left') {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Botdan foydalanish uchun avval guruhg azo bo`ling', 'reply_markup' => $keyboard));
        die;
    }
}
if (!empty($user_text == "/start")) {
    sendTelegram('sendMessage', array('chat_id' => $chat_id, 'reply_to_message_id' => $message_id, 'text' => "Salom siz botdan foydalanishingiz mumkun.", 'parse_mode' => 'html'));
    exit();
}
