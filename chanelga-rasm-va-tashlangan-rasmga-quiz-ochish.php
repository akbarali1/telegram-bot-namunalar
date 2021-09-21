<?php
/*
Botga rasm tashlaysiz u rasmni kanalga tashlab rasm yaxshi yoki yomonligi haqida quiz tashlaydi
*/
define('TOKEN', '<BOT_TOKEN>');

$chanel_name = '@asdasdasdasdawqe';

$chanel = '@Karikaturada';

// Функция вызова методов API.
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

$data = file_get_contents('php://input');
if (!empty($data)) {
    file_put_contents(__DIR__ . '/post.txt', $data);
    $data = json_decode($data, true);
    $chat_id = $data['message']['chat']['id'];
    $user_text = ($data['message']['text']) ?: 'nousertext';
    $username = $data['message']['chat']['username'];
    $message_id = $data['message']['message_id'];
    $last_name = $data['message']['chat']['last_name'];
    $first_name = $data['message']['chat']['first_name'];
    $birgalikda = $first_name . " " . $last_name;
    $akbaralichanel = '@kbarali';
    $groupid = '-1001297074263';
    $type = $data['message']['chat']['type'];
    $language_code = ($data['message']['from']['language_code']) ?: 'eng';


    if ($chat_id == '414229140') {

        // Ответ на текстовые сообщения.
        if (!empty($user_text == "/start")) {
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'ishladim', 'parse_mode' => 'html'));
            $user_text;
            //  sendTelegram('sendMessage', array('chat_id' => $chat_id, 'reply_to_message_id' => $message_id, 'text' => $lang['start'], 'parse_mode' => 'html'));
            exit();
        }

        // Прислали фото.
        if (!empty($data['message']['photo'])) {

            $photo = array_pop($data['message']['photo']);
            $res = sendTelegram('getFile', array('file_id' => $photo['file_id']));
            $res = json_decode($res, true);
            if ($res['ok']) {
                $src = 'https://api.telegram.org/file/bot' . TOKEN . '/' . $res['result']['file_path'];

                $idxabar = botpostid(sendTelegram('sendPhoto', array(
                    'chat_id' => $chanel,
                    'caption' => "<b>Kanal: " . $chanel . "</b>",
                    'photo' => $photo['file_id'],
                    'parse_mode' => 'html',
                )));
                sendTelegram('sendPoll', [
                    'chat_id' => $chanel,
                    'reply_to_message_id' => $idxabar,
                    'question' => 'Rasmda birornima tushundingizmi ?',
                    'options' => json_encode(['Ha tushundim', 'Yo\'q tushunmadim', 'Odatiy rasm', "Qanday ma'noli rasm", "Buncha zerikarli..."]),
                    'disable_notification' => true,
                    'allow_sending_without_reply' => true
                ]);


                sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Rasm tashlandi https://t.me/karikaturada/' . $idxabar, 'reply_to_message_id' => $message_id, 'parse_mode' => 'html'));
//        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Rasm tashlandi',	'reply_to_message_id' => $message_id, 'parse_mode' => 'html'));
                die;

            }
        }
        $idxabar = botpostid(sendTelegram('sendPhoto', array(
            'chat_id' => $chanel,
            'caption' => "<b>Kanal: " . $chanel . "</b>",
            'photo' => $user_text,
            'parse_mode' => 'html',
        )));
        sendTelegram('sendPoll', [
            'chat_id' => $chanel,
            'reply_to_message_id' => $idxabar,
            'question' => 'Rasmda birornima tushundingizmi ?',
            'options' => json_encode(['Ha tushundim', 'Yo\'q tushunmadim', 'Odatiy rasm', "Qanday ma'noli rasm", "Buncha zerikarli..."]),
            'disable_notification' => true,
            'allow_sending_without_reply' => true
        ]);

        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Rasm tashlandi', 'reply_to_message_id' => $message_id, 'parse_mode' => 'html'));
        die;

    }
}

