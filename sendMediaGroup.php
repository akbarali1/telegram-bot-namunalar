<?php
/**
 * Created by PhpStorm.
 * Filename: sendMediaGroup.php
 * Project Name: botnode.loc
 * User: Akbarali
 * Date: 09/10/2021
 * Time: 11:52 AM
 * Github: https://github.com/akbarali1
 * Telegram: @kbarali
 * E-mail: akbarali@webschool.uz
 * https://t.me/ROOT_RU ga sendMedia da yordam bergani uchun rahmatlar aytib qolamiz! ))))
 */

$data = file_get_contents('php://input');
$data = json_decode($data, true);

define('TOKEN', '<BOT_TOKEN>');

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

$response = sendTelegram('sendMediaGroup', [
    'chat_id' => 414229140,
    'media' => json_encode([
        [
            "type" => "photo",
            "media" => "https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832__480.jpg",
        ],
        [
            "type" => "photo",
            "media" => "https://i.pinimg.com/originals/91/b5/cd/91b5cdab51e207263169904b227503b4.jpg"
        ],
        [
            "type" => "photo",
            "media" => "https://i.pinimg.com/originals/8a/58/da/8a58da46777660f46473ba5f4a3d9ae5.jpg"
        ],
        [
            "type" => "photo",
            "media" => "https://wallpapercave.com/wp/wp6835604.jpg"
        ],
        [
            "type" => "photo",
            "caption" => "😅<u>Akbarali test</u>",
            "parse_mode" => "HTML",
            "media" => "https://wallpaperaccess.com/full/31193.jpg",
        ],
    ])
]);

echo $response;