<?php
$sayturl = "webschool.uz";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Подключение к ДБ.
$dbh = new PDO('mysql:host=localhost;dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);

require __DIR__ . "/TelegramBot.php";
$config = require __DIR__ . "/_config.php";
###########
$bot = new TelegramBot($config['bot_token']);
$update = $bot->getData();
//file_put_contents(__DIR__ . '/post.txt', json_encode($update));
###########
function get($name)
{
    $get = file_get_contents($name);
    return $get;
}

function put($name, $nima)
{
    file_put_contents($name, $nima);
}

###########
$text = $update['message']['text'];
$mesid = $update['message']['message_id'];
$chat_id = $update['message']['chat']['id'];
$type = $update['message']['chat']['type'];
###########
$ruid = $update['message']['reply_to_message']['from']['id'];
$rname = $update['message']['reply_to_message']['from']['first_name'];
$rmid = $update['message']['reply_to_message']['from']['message_id'];
$rlogin = $update['message']['reply_to_message']['from']['username'];
###########
$ufname = str_replace(["[", "]", "(", ")", "*", "_", "`"], ["", "", "", "", "", "", ""], $update['message']['from']['first_name']);
$uname = $update['message']['from']['last_name'];
$ulogin = $update['message']['from']['username'];
$uid = $update['message']['from']['id'];
###########
$cqid = $update['callback_query'];
$id = $update['callback_query']['id'];
$mid2 = $update['callback_query']['message']['message_id'];
$uid2 = $update['callback_query']['from']['id'];
$cid2 = $update['callback_query']['message']['chat']['id'];
$data = $update['callback_query']['data'];
###########
$inline = $update['inline_query']['query'];

$keyboard = json_encode(['inline_keyboard' => [[['url' => 'https://uzhackersw.uz/blog/yangliklar/saytimiz-logotipi-ozgartirildi.html', 'text' => 'Maqolani ko`rish'],]],]);

##########
if ($text == "/start") {
    if ($type == "private") {
        $bot->sendMessage(['chat_id' => $chat_id, 'text' => "Salom *$ufname*!
Bu bot yozilgan porucheniyalarni tekshirish uchun qilingan.
Teshirish uchun: To'lov topshiriqnomasida yozilgan raqamni menga jo'nating.
Misol uchun: *160321422745*", 'parse_mode' => "markdown"]);
        exit;
    }
}

if ($text == "/chanel") {
    $bot->SendPhoto(['chat_id' => $chat_id, 'photo' => "https://uzhackersw.uz/rasmlar/241.png", 'caption' => "📝 <b>Saytimiz logotipi o'zgartirildi</b>",
        'parse_mode' => 'html', 'reply_markup' => $keyboard]);
    exit;
}

if ($inline) {
    $sth = $dbh->prepare("SELECT * FROM `topshiriqnoma` WHERE `tg` = '" . $inline . "' LIMIT 1 ");
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $boshliq = $row['bosh'];
        $xisobchi = $row['bux'];
        $bosh = ($boshliq) ? "\n      <i>Rahbar F.I: </i><b>" . $row['bosh'] . "</b>" : "";
        $xisob = ($xisobchi) ? "\n      <i>Xisobchi: </i><b>" . $row['bux'] . "</b>" : "";
        $inlinetext = "To`lov topshiriqnoma yozilgan!
      <b>Tekshirish kodi: " . $row['tg'] . "</b>
      <i>To'lov topshiriqnoma raqami:</i> № <b>" . $row['no'] . "</b>
      <i>Yozilgan vaqti: </i> <b>" . $row['sana'] . "</b>
      <b><i>Pul chiqargan tashkilot haqida ma'lumotlar</i></b>
      <i>Nomi:</i> <b>" . $row['chiqnm'] . " " . shakluzun($row['chiqsh']) . "</b>
      <i>Xisob raqami: </i><b>" . $row['chiqxr'] . "</b>
      <i>INN raqmi: </i><b>" . $row['chiqinn'] . "</b>
      <i>Bank nomi: </i><b>" . $row['chiqbk'] . "</b>
      <i>Bank MFO: </i><b>" . $row['chimfo'] . "</b>" . $bosh . $xisob . "
      <i>Qancha pul chiqarilgan: </i><b> " . number_format($summahamma, 2, ',', ' ') . " so'm</b>
      <i>Summa so`z bilan: </i><b> " . convertNumber($summahamma) . " so'm</b>
      <i>To'lov maqsadi: </i><b> " . oy($row['maqsad']) . "</b>
      <b><i>Pul tushgan tashkilot haqida ma'lumot</i></b>
      <i>Nomi: </i><b> " . $row['kirnm'] . " " . shakluzun($row['kirsh']) . "</b>
      <i>Xisob raqami: </i><b> " . $row['kirxr'] . "</b>
      <i>INN raqami: </i><b> " . $row['kirinn'] . "</b>
      <i>Bank nomi: </i><b> " . $row['kirbk'] . "</b>
      <i>Bank MFO: </i><b> " . $row['kirmfo'] . "</b>
      <b><i>To'lov topshiriqnoma yozib bergan odam: " . $row['yozodam'] . "</i></b>";

        $inlinejson = json_encode(
            [
                [
                    'type' => 'article',
                    'id' => base64_encode(1),
                    'title' => "№" . $row['no'] . " | " . $row['chiqnm'] . " " . shaklqisqa($row['chiqsh']),
                    'description' => "Maqsadi: " . oy($row['maqsad']) . "\nPul tushgan: " . $row['chiqnm'] . " " . shaklqisqa($row['chiqsh']),
                    'input_message_content' =>
                        [
                            'disable_web_page_preview' => true,
                            'parse_mode' => 'html', 'message_text' => $inlinetext
                        ]
                ]
            ]
        );

        $bot->answerInlineQuery(['inline_query_id' => $update['inline_query']['id'], 'cache_time' => 1, 'results' => $inlinejson]);
        exit;
    } else {
        $inlinejson = json_encode(
            [
                [
                    'type' => 'article',
                    'id' => base64_encode(1),
                    'title' => "Ushbu ID raqamga ega to`lov topshiriqnomani topib bo`lmadi",
                    'input_message_content' =>
                        [
                            'disable_web_page_preview' => true,
                            'parse_mode' => 'html', 'message_text' => 'Ushbu ID raqamga ega to`lov topshiriqnomani topib bo`lmadi'
                        ]
                ]
            ]
        );

        $bot->answerInlineQuery(['inline_query_id' => $update['inline_query']['id'], 'cache_time' => 1, 'results' => $inlinejson]);
    }
}

if ($text == "xisobot") {
    $bugun = date("d.m.Y");
    $sth = $dbh->prepare("SELECT COUNT(*) AS num FROM topshiriqnoma WHERE `sana` = '" . $bugun . "'");
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    $jamisum = $row['num'] * 1000;

    $overdraft = $dbh->prepare("SELECT COUNT(*) AS num FROM akbardraft WHERE `sana` = '" . date("Ymd") . "'");
    $overdraft->execute();
    $overdraft1 = $overdraft->fetch(PDO::FETCH_ASSOC);
    $jamisumover = $overdraft1['num'] * 6000;

    $agrobank = $dbh->prepare("SELECT COUNT(*) AS num FROM kredit WHERE `sana` = '" . date("Ymd") . "'");
    $agrobank->execute();
    $agrobank1 = $agrobank->fetch(PDO::FETCH_ASSOC);
    $jamiagro = $agrobank1['num'] * 10000;

    $bot->sendMessage(['chat_id' => $chat_id, 'text' => "Bugun sana $bugun
Jami yozilgan porucheniya: <b> " . $row['num'] . " dona </b>
Jami summasi: <b>" . $jamisum . " so'm</b>\n" . $akbsumm . $botirbeksum . $oysum . $husum . $qolganodam . "
Jami yozilgan овердрафт: <b> " . $overdraft1['num'] . " dona </b>
Jami summasi: <b>" . $jamisumover . " so'm</b>

Jami yozilgan Agrobank: <b> " . $agrobank1['num'] . " dona </b>
Jami summasi: <b>" . $jamiagro . " so'm</b>", 'parse_mode' => "html"]);
    exit();
}

if (!empty($text == 'dell')) {
    $bot->deleteMessage(['chat_id' => $chat_id, 'message_id' => $update['message']['reply_to_message']['message_id']]);
    $bot->deleteMessage(['chat_id' => $chat_id, 'message_id' => $mesid]);
    exit;
}

if (!empty($text)) {
    $bot->sendChatAction(['chat_id' => $chat_id, 'action' => 'typing']);
    // Получение статей из БД.
    $sth = $dbh->prepare("SELECT * FROM `topshiriqnoma` WHERE `tg` = '" . $text . "' LIMIT 1 ");
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    if ($row['no']) {
        $Cal = new Field_calculate();
        $summahamma = $Cal->calculate(str_replace(" ", "", $row['sum'])); // 70
        if ($uid == "414229140" or $uid == "490887175") {
            $bot->sendMessage(['chat_id' => $chat_id, 'reply_to_message_id' => $mesid, 'text' => "Bu to'lov topshitiqnomasi xaqiqatda bizda yozilgan.
      <i>To'lov topshiriqnoma raqami:</i> № <b>" . $row['no'] . "</b>
      <i>Yozilgan vaqti: </i> <b>" . $row['sana'] . "</b>
      <b><i>Pul chiqargan tashkilot haqida ma'lumotlar</i></b>
      <i>Nomi:</i> <b>" . $row['chiqnm'] . " " . shakluzun($row['chiqsh']) . "</b>
      <i>Xisob raqami: </i><b>" . $row['chiqxr'] . "</b>
      <i>INN raqmi: </i><b>" . $row['chiqinn'] . "</b>
      <i>Bank nomi: </i><b>" . $row['chiqbk'] . "</b>
      <i>Bank MFO: </i><b>" . $row['chimfo'] . "</b>
      <i>Rahbar F.I: </i><b>" . $row['bosh'] . "</b>
      <i>Xisobchi: </i><b>" . $row['bux'] . "</b>
      <i>Qancha pul chiqarilgan: </i><b> " . number_format($summahamma, 2, ',', ' ') . " so'm</b>
      <i>Summa so`z bilan: </i><b> " . convertNumber($summahamma) . " so'm</b>
      <i>To'lov maqsadi: </i><b> " . oy($row['maqsad']) . "</b>
      <b><i>Pul tushgan tashkilot haqida ma'lumot</i></b>
      <i>Nomi: </i><b> " . $row['kirnm'] . " " . shakluzun($row['kirsh']) . "</b>
      <i>Xisob raqami: </i><b> " . $row['kirxr'] . "</b>
      <i>INN raqami: </i><b> " . $row['kirinn'] . "</b>
      <i>Bank nomi: </i><b> " . $row['kirbk'] . "</b>
      <i>Bank MFO: </i><b> " . $row['kirmfo'] . "</b>
      <b><i>To'lov topshiriqnoma yozib bergan odam: " . $row['yozodam'] . "</i></b> \n
      <a href=\"" . $sayturl . "/porucheniya/porucheniya.php?id=" . $row['id'] . "\">Ko`rish (Chiqarish)</a> | <a href=\"" . $sayturl . "/porucheniya/edit.php?id=" . $row['id'] . "\">Taxrirlash</a> ",
                'parse_mode' => "html",
                'reply_markup' => json_encode(['inline_keyboard' => [[['switch_inline_query' => $row['tg'], 'text' => "Boshqa odamga jo`natish"]]]])]);
            // $keyboard = ['inline_keyboard' => [['text' => 'forward me to groups'], 'switch_inline_query' => '@check_porucheniya_robot'],];
            exit;
        } else {
            $bot->sendMessage(['chat_id' => $chat_id, 'reply_to_message_id' => $mesid, 'text' => "Bu to'lov topshitiqnomasi xaqiqatda bizda yozilgan.
      <i>To'lov topshiriqnoma raqami:</i> № <b>" . $row['no'] . "</b>
      <i>Yozilgan vaqti: </i> <b>" . $row['sana'] . "</b>
      <b><i>Pul chiqargan tashkilot haqida ma'lumotlar</i></b>
      <i>Nomi:</i> <b>" . $row['chiqnm'] . " " . shakluzun($row['chiqsh']) . "</b>
      <i>Xisob raqami: </i><b>" . $row['chiqxr'] . "</b>
      <i>INN raqmi: </i><b>" . $row['chiqinn'] . "</b>
      <i>Bank nomi: </i><b>" . $row['chiqbk'] . "</b>
      <i>Bank MFO: </i><b>" . $row['chimfo'] . "</b>
      <i>Rahbar F.I: </i><b>" . $row['bosh'] . "</b>
      <i>Xisobchi: </i><b>" . $row['bux'] . "</b>
      <i>Qancha pul chiqarilgan: </i><b> " . number_format($summahamma, 2, ',', ' ') . " so'm</b>
      <i>Summa so`z bilan: </i><b> " . convertNumber($summahamma) . " so'm</b>
      <i>To'lov maqsadi: </i><b> " . oy($row['maqsad']) . "</b>
      <b><i>Pul tushgan tashkilot haqida ma'lumot</i></b>
      <i>Nomi: </i><b> " . $row['kirnm'] . " " . shakluzun($row['kirsh']) . "</b>
      <i>Xisob raqami: </i><b> " . $row['kirxr'] . "</b>
      <i>INN raqami: </i><b> " . $row['kirinn'] . "</b>
      <i>Bank nomi: </i><b> " . $row['kirbk'] . "</b>
      <i>Bank MFO: </i><b> " . $row['kirmfo'] . "</b>
      <b><i>To'lov topshiriqnoma yozib bergan odam: " . $row['yozodam'] . "</i></b>", 'parse_mode' => "html",
                'reply_markup' => json_encode(['inline_keyboard' => [[['switch_inline_query' => $row['tg'], 'text' => "Boshqa odamga jo`natish"]]]])]);
            exit;
        }
    } else {
        if ($type == "private") {
            $bot->sendMessage(['chat_id' => $chat_id, 'reply_to_message_id' => $mesid, 'text' => "Bunday raqamdagi to'lov topshiriqnomasi mavjud emas. Xato kiritmaganmisiz ? Yan bir bor tekshiring", 'parse_mode' => "html"]);
        }
        if ($chat_id = '-1001395930334') {
            $bot->deleteMessage(['chat_id' => '-1001395930334', 'message_id' => $mesid, 'parse_mode' => "html"]);
            exit;
        }

    }
}

if ($text == "xisobotakbarali") {
    $stmt = $dbh->query("SELECT * FROM users");
    $bazasql = [];
    ob_start();
    while ($row = $stmt->fetch()) {
        $bugun = date("d.m.Y");
        $akb = $dbh->prepare("SELECT COUNT(*) AS num FROM topshiriqnoma WHERE `sana` = '" . $bugun . "' AND `yozodam` = '" . $row['name'] . "'");
        $akb->execute();
        $akbarali = $akb->fetch(PDO::FETCH_ASSOC);
        $akbarsum = $akbarali['num'] * 1000;
        if ($akbarsum != '0') {
            $bazasql[] = $row['name'] . " yozgan " . $akbarali['num'] . " dona <br>Jami summasi: " . $akbarsum . " so`m <br>";
        }
    }
    $resultakb = ob_get_clean();
    $bot->sendMessage(['chat_id' => $chat_id, 'text' => $resultakb, 'parse_mode' => "html"]);
    exit();
}

?>
