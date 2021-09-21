<?php
/*
phpofiseni o`rnatishingiz kerak kodga qarab tushunib olarsiz
*/

require __DIR__ . '/vendor/autoload.php';
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

require '../db.php';
define('TOKEN', '<BOT_TOKEN>');
$data = file_get_contents('php://input');
$data = json_decode($data, true);
 ob_start();
print_r($data);
$out = ob_get_clean();
file_put_contents(__DIR__ . '/post.txt', $out);
//Kodni qisqartirmasak bo`lmas ekan
$chat_id = $data['message']['chat']['id'];
$user_text = $data['message']['text'];
$username = ($data['message']['chat']['username']) ? : 'nousername';
$message_id = $data['message']['message_id'];
$last_name = ($data['message']['chat']['last_name']) ? : 'nolastname';
$first_name = ($data['message']['chat']['first_name']) ? : 'nofirstname';
$birgalikda = $first_name . " " . $last_name;
$chanel_name = '@tushuntirolmadim';
$akbaralichanel = '@kbarali';
$groupid = '-1001297074263';
function reponse($massiv) {
    $botpost = json_decode($massiv, true);
    return $botpost;
}
$keyboard = json_encode(['inline_keyboard' => [[['url' => 'https://t.me/Tushuntirolmadim', 'text' => 'Chanel (Tushuntirolmadim)'], ], [['url' => 'https://t.me/convertor_group', 'text' => 'GROUP (Conventor GROUP)'], ], [['url' => 'https://t.me/kbarali', 'text' => 'Chanel (Akbarali Blog chanel)'], ], [['url' => 'https://uzhackersw.uz/', 'text' => 'Saytga kirish (ixtoyoriy)'], ], ], ]);
/*
if (!empty($user_text == "/groupid")) {
    sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $chat_id));
    die;
}*/
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
if (!empty($user_text == "/start@jpgtopdfrobot")) {
 sendTelegram('deleteMessage', array('chat_id' => $chat_id, 'message_id' => $message_id));
 exit;
}
if (!empty($user_text == "/boshla@jpgtopdfrobot")) {
 sendTelegram('deleteMessage', array('chat_id' => $chat_id, 'message_id' => $message_id));
 exit;
}
if (!empty($user_text == "/toxta@jpgtopdfrobot")) {
 sendTelegram('deleteMessage', array('chat_id' => $chat_id, 'message_id' => $message_id));
 exit;
}
if (!empty($data['message']['new_chat_members'])) {
    $bockid = $data['message']['from']['id'];
    sendTelegram('sendMessage', array('chat_id' => $bockid, 'text' => 'Thank you for subscribing to our group. Keep going', 'parse_mode' => 'html'));
    exit;
}


if (!empty($user_text == "/idasas")) {
    $bockid = $data['message']['from']['id'];
    sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $chat_id, 'parse_mode' => 'html'));
    exit;
}
if (!empty($data['message']['left_chat_member'])) {
    $bockid = $data['message']['from']['id'];
    $sth = $pdo->prepare("SELECT * FROM `wordtopdf` WHERE `userid` = '" . $bockid . "' LIMIT 1 ");
    $sth->execute();
    $blockid1 = $sth->fetch(PDO::FETCH_ASSOC);
    if ($blockid1['status'] == 'block') {
        sendTelegram('sendMessage', array('chat_id' => $bockid, 'text' => 'Don’t go back to our group at all', 'parse_mode' => 'html'));
        sendTelegram('deleteMessage', array('chat_id' => $chat_id, 'message_id' => $message_id));
        exit;
    }
    sendTelegram('sendChatAction', array('chat_id' => $bockid, 'action' => 'typing'));
    $dataof = ['userid' => $bockid, 'status' => 'block'];
    $sql = "UPDATE userstg SET  status=:status WHERE userid=:userid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($dataof);
    sendTelegram('sendMessage', array('chat_id' => $bockid, 'text' => "I blocked you forever. Don't worry, I won't take the block from you. Find another bot that will make your next quality photos a PDF</b>", 'parse_mode' => 'html'));
    sendTelegram('deleteMessage', array('chat_id' => $chat_id, 'message_id' => $message_id));
    exit;
}

if (!empty($data)) {
    $chanel = reponse(sendTelegram('getChatMember', array('chat_id' => $chanel_name, 'user_id' => $chat_id)));
    $group = reponse(sendTelegram('getChatMember', array('chat_id' => $groupid, 'user_id' => $chat_id)));
    $kbarali = reponse(sendTelegram('getChatMember', array('chat_id' => $akbaralichanel, 'user_id' => $chat_id)));
    if ($chanel['result']['status'] === 'left') {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Subscribe to @tushuntirolmadim channel to use the bot', 'reply_markup' => $keyboard));
        die;
    }
    if ($group['result']['status'] === 'left') {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'To use the bot, subscribe to our @convertor_group group', 'reply_markup' => $keyboard));
        die;
    }
    if ($kbarali['result']['status'] === 'left') {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Subscribe to @kbarali channel to use the bot', 'reply_markup' => $keyboard));
        die;
    }
}
if (!empty($user_text == "/start")) {
    $sth = $pdo->prepare("SELECT `userid` FROM `wordtopdf` WHERE `userid` = '" . $chat_id . "' LIMIT 1");
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        $dbdata = ['userid' => $chat_id, 'time' => time(), 'username' => $username, 'lastname' => $last_name, 'firstname' => $first_name];
        $sql = "INSERT INTO wordtopdf (userid, time, username, lastname, firstname) VALUES (:userid, :time, :username, :lastname, :firstname)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($dbdata);
    }
    sendTelegram('sendMessage', array('chat_id' => $chat_id, 'reply_to_message_id' => $message_id, 'text' => "Please drop me the Word document you want to convert to PDF.", 'parse_mode' => 'html'));
    exit();
}

if (!empty($data['message']['document'])) {
    sendTelegram('sendChatAction', array('chat_id' => $chat_id, 'action' => 'upload_document'));
    $file_id = $data['message']['document']['file_id'];
    $ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/getFile');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('file_id' => $file_id));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);
    $res = json_decode($res, true);
    if ($res['ok']) {
        $src  = 'https://api.telegram.org/file/bot' . TOKEN . '/' . $res['result']['file_path'];
        $pathinfo = pathinfo($src);
		$dest = __DIR__ . '/files/' . $chat_id.'.'.$pathinfo['extension'];
		if ($pathinfo['extension'] == 'docx' OR $pathinfo['extension'] == 'doc') {
		    copy($src, $dest);
		    Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
            Settings::setPdfRendererPath('.');
            $phpWord = IOFactory::load($dest);
        $tayyor =     $phpWord->save($chat_id.'.pdf', 'PDF');
        if ($tayyor) {
        //    sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $chat_id, 'parse_mode' => 'html'));
            sendTelegram('sendDocument', array('chat_id' => $chat_id, 'document' => curl_file_create($chat_id.'.pdf')));
            unlink($chat_id.'.pdf');
            unlink($dest);
        }
		}else {
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'reply_to_message_id' => $message_id, 'text' => "Faqatgina word hujjatlarga mumkun", 'parse_mode' => 'html'));
		}
    }
}
