<?php

$data = file_get_contents('php://input');
$data = json_decode($data, true);

//if (empty($data['message']['chat']['id'])) {
//    exit();
//}

define('TOKEN', '1982435269:AAEJwXjdM0j9qncrq-0WoIVa66SBVPOe9HQ');

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

$photos = [
    'asaasas',
    'https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832__480.jpg',
    'https://i.pinimg.com/originals/91/b5/cd/91b5cdab51e207263169904b227503b4.jpg',
    'https://i.pinimg.com/originals/8a/58/da/8a58da46777660f46473ba5f4a3d9ae5.jpg',
    'https://wallpapercave.com/wp/wp6835604.jpg',
];
$response = sendTelegram('sendPhoto',
    [
        'chat_id' => 414229140,
        'sendMediaGroup' => json_encode([
            'InputMediaPhoto' => [
                'media' => 'https://wallpaperaccess.com/full/31193.jpg',
                'caption' => 'Rasmlar',
                'caption_entities' => 'Rasmlar uchun',
                'parse_mode' => "HTML"
            ]
        ])
    ]
);

echo $response;