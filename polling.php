<?php
declare(strict_types=1);

const ApiUrl = "https://api.telegram.org/botBOT_TOKEN/";

$lastUpdateId = 0;
function getUpdates($lastUpdateId): array
{
	$url      = ApiUrl."getUpdates?offset=$lastUpdateId&timeout=10";
	$response = file_get_contents($url);
	$result   = json_decode($response, true);
	
	return $result['result'] ?? [];
}

function messageExecute($message): void
{
	$chatId = $message['chat']['id'];
	$text   = $message['text'] ?? '';
	
	if ($text === "/start") {
		$reply = "Habar yozishingiz mumkin!";
	} else {
		$reply = "Siz yozgan habar: ".$text;
	}
	
	$url = ApiUrl."sendMessage?chat_id=$chatId&text=".urlencode($reply);
	file_get_contents($url);
}

echo 'Tinglash boshlandi'.PHP_EOL;


while (true) {
	$updates = getUpdates($lastUpdateId);
	
	if (!empty($updates)) {
		foreach ($updates as $update) {
			$lastUpdateId = $update['update_id'] + 1;
			
			if (isset($update['message'])) {
				messageExecute($update['message']);
				echo 'Xabar qabul qilindi: '.$lastUpdateId.PHP_EOL;
			}
		}
	}
	
	sleep(1);
}