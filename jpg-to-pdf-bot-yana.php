<?php
$db_user = "botlar_conventer";
$db_pass = "conventer";
$pdo = new PDO('mysql:host=localhost;dbname=botlar_conventer;charset=utf8', $db_user, $db_pass);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('TOKEN', '<BOT_TOKEN>');
$chanel_name = '@tushuntirolmadim';

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

if ($_POST) {
    if ($_POST['TOKEN']) {
        $getme = json_decode(file_get_contents("https://api.telegram.org/bot" . $_POST['TOKEN'] . "/getme"), true);
        sendTelegram('sendMessage', array('chat_id' => '-524167744', 'text' => "Botga start boshishdi\nBot username @" . $getme['result']['username'] . "\n <a href='tg://user?id=" . $_POST['tekshir'] . "'>O`sha user</a>", 'parse_mode' => 'html'));
    }
    $ITspeciallessons = '@ITspeciallessons';
    $chanel = reponse(sendTelegram('getChatMember', array('chat_id' => $chanel_name, 'user_id' => $_POST['tekshir'])));
    $itspes = reponse(sendTelegram('getChatMember', array('chat_id' => $ITspeciallessons, 'user_id' => $_POST['tekshir'])));
    if ($chanel['result']['status'] == 'left') {
        echo 'tushuntir';
        die;
    }
    if ($itspes['result']['status'] == 'left') {
        echo 'uzhackersw';
        die;
    }
    echo 'yaxshi';
    die;
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
    if (empty($chat_id)) {
        exit();
    }

    if ($language_code == 'uz') {
        $lang = array('start' => 'Salom ' . $birgalikda . '. Men JPG rasmni PDF qilish sizga tashlash uchun @kbarali tomonidan yozildim. Menga rasm tashlashdan oldin /boshla buyrug`ini bering. Keyin JPG rasmni PHOTO qilish tashlang (file qilib emas)!', 'boshla' => 'Siz umuman menga bu buyruqni bermagan ekansiz 😁 men xotiramni maksimal ishlatishni boshladim. Tezroq menga rasmlarni tashlang men xotiramga saqlab olaman va tugatganigizdan so`ng menga /toxta ni jo`nating', 'boshla2' => 'Siz ilgari menga shunday buyruq bergansiz. Qayta buyruq berib chalkashtirmasdan iloji boricha tezroq rasmlarimni tashlang', 'toxtaerror' => 'Rasm tashlashni to`xtaring. Rasmni mewnga tashlashdan oldin menga /boshla buyrug`ini berishingiz kerak. Yo`qsa men rasmlarni hotiramga saqlay olmayman. Menga hozir /boshla buyrug`ini bering', 'toxtatashlanmagan' => 'Siz umuman rasm tashlamagansiz yoki avval rasm tashlagan bo`lsangiz menga Foward qilib yana tashlang', 'toxta' => 'Men PDF qilishni va sizga jo`natish uchun Telegramga yuklashni boshladim.', 'pulli' => 'Siz botdan foydalanish to`lovini @kbarali ga to`lamagansiz. @kbarali ga botdan foydalanish to`lovini to`lang. Shunda men sizga faylni tashlab beraman. Botdan foydalanish 1 oyga atiga 5000 so`m. To`lovni amalga oshiring va 1 oy muddat men sizning xizmatingizda bo`laman. Unutmang: Men ham sifatli hizmat ko`rsatish uchun sifatli serverda joylashganman. Sifatli server narxi qimmat bo`lganligi sababli hozirda bepul ishlay olmayman', 'toxtaerror1' => 'Qandaydur xatolik bo`lgan shekli @kbarali bilan bog`laning', 'phototext' => 'Men hotiramga saqlab qoldim. Rasmni hammasini tashlaganingizdan so`ng menga /toxta buyrug`ini bering. Ungacha menga rasm tashlashda davom eting', 'reklama' => "Agarda men sizga rasmlaringizni sifatli tarzda PDFga o`tkazib bera olgan bo`lsam iltimos men hoqimda guruhimizga yozing xato kamchiliklarim haqida ham yozing shunda meni albatta yanada yaxshi ishlashim uchun tuzatishadi. Foydali saytni ham albatta ko`ring. U saytda kompyuter bo`yicha foydali ma'lumotlar bepul ravishda yozib boriladi", 'reklama2' => "Rasmlarni tashlashdan oldin guruhimizga kirishingiz kerak. Aks holda bot to`liq ishlamaydi. Rasmni tashlashdan oldin tezda guruhga qoshilib rasm tashlashni boshlang. \n \n <b>Shuni unutmangki, agar siz bizning guruhimizga qo'shilsangiz, rasmingizning PDF formatini yaratib bo`lganingizdan so`ng keyin guruhdan chiqsangiz, bot sizni abadiy to'sib qo'yadi. Bu to`siqni umuman ochishning imkoni yo`q. </b>",
            'startboshla' => "Guruhga qo'shilganingiz bilan tabriklayman. Yodingizda bo'lsin, agar siz bizning guruhdan chiqsangiz, sizni abadiy to'sib qo'yaman. Shunday ekan, iltimos, guruhdan chiqmang va guruhga har xil ahmoqona narsalarni yozmang",
            'blocked' => "<b>Men seni abadiy to'sib qo'ydim. Xavotir olmang, blokni sizdan olmayman. Keyingi sifatli fotosuratlarni PDF formatiga aylantiradigan boshqa bot toping</b>",
            'rasmyoq' => 'Sizga jo`natagidan rasmim yo`q. Yoki avval menga rasm tashlamagansiz');
        $keyboard2 = json_encode(['inline_keyboard' => [
            [['url' => 'https://socpublic.com/?i=3397782&slide=1', 'text' => 'Make good money'],],
            [['url' => 'https://socpublic.com/?i=3397782&slide=1', 'text' => 'Bot sponsor'],],
            [['url' => 'https://t.me/convertor_group', 'text' => 'Guruhga qo`shilish'],],
            [['url' => 'https://uzhackersw.uz/', 'text' => 'Saytga kirish'],],],]);


        $keyboard = json_encode(['inline_keyboard' => [[['url' => 'https://socpublic.com/?i=3397782&slide=1', 'text' => 'Make good money'],],
            [['url' => 'https://socpublic.com/?i=3397782&slide=1', 'text' => 'Bot sponsor'],],
            [['url' => 'https://t.me/convertor_group', 'text' => 'Guruhimiz'],], [['url' => 'https://uzhackersw.uz/', 'text' => 'Saytga kirish'],],],]);
    } else {
        $lang = array('start' => 'Hi ' . $birgalikda . '. I will make a PDF of the JPG image. Give the /boshla command. To make a JPG PDF, drop me a picture as a photo (not in file format)!', 'boshla' => 'I started to memorize the pictures you left. Throw me pictures faster and give me the /toxta command when you\'re done shooting', 'boshla2' => 'You have given me such an order before. Throw me pictures as soon as possible without confusing me by giving again', 'toxtaerror' => 'Stop shooting. I can\'t save your pictures. Give me the /boshla command before taking a picture', 'toxtatashlanmagan' => 'You didn’t throw a picture at all for me to save. If you have taken a picture before, please send it back to me', 'toxta' => 'I have prepared a PDF to send to you and am uploading it to Telegram', 'pulli' => 'Forgive me. ou don\'t seem to have paid me. I work on a powerful server. Powerful servers are more expensive. So I can’t serve for free right now. Contact @kbarali to make a payment. If you need it for free, ask https://t.me/convertor_group to drop your file and convert it to PDF.', 'toxtaerror1' => 'Contact @kbarali if there is any error', 'phototext' => 'I remembered your picture. When you\'re done shooting, give me the /toxta command. If you have not finished, continue painting', 'reklama' => 'If I was able to create a quality PDF format of your documents, please let me know what you think of me.', 'reklama2' => "You must join our group before starting work. Otherwise the bot will not work. The group provides information about additional features added to the bot. \n \n<b>Don't forget that if you join our group, make a PDF of your picture and then leave the group, the bot will block you forever. we will not lift this ban later</b>",
            'blocked' => "<b>I blocked you forever. Don't worry, I won't take the block from you. Find another bot that will make your next quality photos a PDF</b>",

            'startboshla' => 'Congratulations on joining the group. Remember I will block you forever if you leave our group. So please don’t leave the group and don’t write all sorts of stupid things in the group',
            'rasmyoq' => 'You didn’t give me a picture. Or you didn\'t give the /boshla command before you took the picture');
        $keyboard2 = json_encode(['inline_keyboard' => [
            [['url' => 'https://socpublic.com/?i=3397782&slide=1', 'text' => 'Make good money'],],
            [['url' => 'https://socpublic.com/?i=3397782&slide=1', 'text' => 'Bot sponsor'],],
            [['url' => 'https://t.me/convertor_group', 'text' => 'Join the group'],], [['url' => 'https://uzhackersw.uz/', 'text' => 'Useful site'],],],]);
        $keyboard = json_encode(['inline_keyboard' => [
            [['url' => 'https://socpublic.com/?i=3397782&slide=1', 'text' => 'Make good money'],],
            [['url' => 'https://socpublic.com/?i=3397782&slide=1', 'text' => 'Bot sponsor'],],
            [['url' => 'https://t.me/convertor_group', 'text' => 'Our group'],], [['url' => 'https://uzhackersw.uz/', 'text' => 'Useful site'],],],]);
    }


    $keyboard3 = json_encode(['inline_keyboard' => [[['url' => 'https://t.me/Tushuntirolmadim', 'text' => 'Chanel (Tushuntirolmadim)'],], [['url' => 'https://t.me/convertor_group', 'text' => 'GROUP (Conventor GROUP)'],], [['url' => 'https://t.me/kbarali', 'text' => 'Chanel (Akbarali Blog chanel)'],], [['url' => 'https://uzhackersw.uz/', 'text' => 'Saytga kirish (ixtoyoriy)'],],],]);


    if (!empty($data)) {
        $chanel = reponse(sendTelegram('getChatMember', array('chat_id' => $chanel_name, 'user_id' => $chat_id)));
        $group = reponse(sendTelegram('getChatMember', array('chat_id' => $groupid, 'user_id' => $chat_id)));
        $kbarali = reponse(sendTelegram('getChatMember', array('chat_id' => $akbaralichanel, 'user_id' => $chat_id)));
        if ($chanel['result']['status'] === 'left') {
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Subscribe to @tushuntirolmadim channel to use the bot', 'reply_markup' => $keyboard3));
            die;
        }
        if ($group['result']['status'] === 'left') {
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'To use the bot, subscribe to our @convertor_group group', 'reply_markup' => $keyboard3));
            die;
        }
        if ($kbarali['result']['status'] === 'left') {
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => 'Subscribe to @kbarali channel to use the bot', 'reply_markup' => $keyboard3));
            die;
        }
    }
}


if (!empty($data['message']['left_chat_member'])) {
    $bockid = $data['message']['from']['id'];
    $sth = $pdo->prepare("SELECT * FROM `userstg` WHERE `tgid` = '" . $bockid . "' LIMIT 1 ");
    $sth->execute();
    $blockid1 = $sth->fetch(PDO::FETCH_ASSOC);
    if ($blockid1['promo'] == 'block') {
        sendTelegram('sendMessage', array('chat_id' => $bockid, 'text' => 'Don’t go back to our group at all', 'parse_mode' => 'html'));
        sendTelegram('deleteMessage', array('chat_id' => $chat_id, 'message_id' => $message_id));
        exit;
    }
    sendTelegram('sendChatAction', array('chat_id' => $bockid, 'action' => 'typing'));
    $dataof = ['holat' => '0', 'tgid' => $bockid, 'promo' => 'block'];
    $sql = "UPDATE userstg SET holat=:holat, promo=:promo WHERE tgid=:tgid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($dataof);
    sendTelegram('sendMessage', array('chat_id' => $bockid, 'text' => $lang['blocked'], 'parse_mode' => 'html'));
    sendTelegram('deleteMessage', array('chat_id' => $chat_id, 'message_id' => $message_id));
    exit;
}
if (!empty($data['message']['new_chat_members'])) {
    $bockid = $data['message']['from']['id'];
    $sth = $pdo->prepare("SELECT * FROM `userstg` WHERE `tgid` = '" . $bockid . "' LIMIT 1 ");
    $sth->execute();
    $blockid1 = $sth->fetch(PDO::FETCH_ASSOC);
    if ($blockid1['promo'] == 'block') {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'reply_to_message_id' => $message_id, 'text' => 'I told you to find another bot and now it\'s useless to join the group. You first disrespected my work, joined the group and left after your work was over. That’s why I’ve blocked you forever. Please leave the group', 'parse_mode' => 'html'));
        sendTelegram('restrictChatMember', array('chat_id' => $chat_id, 'user_id' => $bockid, 'permissions' => json_encode(['ChatPermissions' => [[['can_send_messages' => 'false']]]])));
        exit;
    }
    sendTelegram('sendChatAction', array('chat_id' => $bockid, 'action' => 'typing'));
    sendTelegram('sendMessage', array('chat_id' => $bockid, 'text' => $lang['startboshla'], 'parse_mode' => 'html'));
    sendTelegram('sendMessage', array('chat_id' => $bockid, 'text' => $lang['start'], 'parse_mode' => 'html'));
    exit;
}

if (!empty($type = "private")) {
    if (!empty($user_text)) {
        $sth = $pdo->prepare("SELECT * FROM `userstg` WHERE `tgid` = '" . $bockid . "' LIMIT 1 ");
        $sth->execute();
        $blockid1 = $sth->fetch(PDO::FETCH_ASSOC);

    }
}

if (!empty($type == "private")) {
    if (!empty($data['message']['chat']['id'])) {
        $sth = $pdo->prepare("SELECT * FROM `userstg` WHERE `tgid` = '" . $chat_id . "' LIMIT 1 ");
        $sth->execute();
        $blockid = $sth->fetch(PDO::FETCH_ASSOC);
        if ($blockid['promo'] == 'block') {
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => "I blocked you forever because you joined our group and then left. If you have a lot of money, pay @kbarali a fine of $ 10.", 'parse_mode' => 'html'));
            exit;
        }
    }
    // Ответ на текстовые сообщения.
    if (!empty($user_text == "/start")) {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $lang['reklama2'], 'parse_mode' => 'html', 'reply_markup' => $keyboard2));
        $user_text;
        //  sendTelegram('sendMessage', array('chat_id' => $chat_id, 'reply_to_message_id' => $message_id, 'text' => $lang['start'], 'parse_mode' => 'html'));
        exit();
    }
    // die("tugadi");
    // Ответ на текстовые сообщения.
    if (!empty($user_text == "/boshla")) {
        $sth = $pdo->prepare("SELECT * FROM `userstg` WHERE `tgid` = '" . $chat_id . "' LIMIT 1 ");
        $sth->execute();
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            $dbdata = ['tgid' => $chat_id, 'holat' => '1', 'username' => 'nousername', 'time' => time()];
            $sql = "INSERT INTO userstg (tgid, holat, username, time) VALUES (:tgid, :holat, :username, :time)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($dbdata);
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'reply_to_message_id' => $message_id, 'text' => $lang['boshla']));
            //  sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $lang['reklama2'], 'reply_markup' => $keyboard2));
            exit();
        }
        if ($row['holat'] == 0) {
            $dataof = ['holat' => '1', 'id' => $row['id'],];
            $sql = "UPDATE userstg SET holat=:holat WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($dataof);
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'reply_to_message_id' => $message_id, 'text' => $lang['boshla']));
            // sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $lang['reklama2'], 'reply_markup' => $keyboard2));
            exit();
        } elseif ($row['holat'] == 1) {
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'reply_to_message_id' => $message_id, 'text' => $lang['boshla2']));
        }
    }
    // Прислали фото.
    if (!empty($data['message']['photo'])) {
        $photo = array_pop($data['message']['photo']);
        $res = sendTelegram('getFile', array('file_id' => $photo['file_id']));
        $res = json_decode($res, true);
        if ($res['ok']) {
            $src = 'https://api.telegram.org/file/bot' . TOKEN . '/' . $res['result']['file_path'];
            $sth = $pdo->prepare("SELECT * FROM `userstg` WHERE `tgid` = '" . $chat_id . "' AND `holat` = '1' LIMIT 1 ");
            $sth->execute();
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                // DB ulash
                $tgname = $first_name . " " . $last_name;
                $dbdata = ['time' => time(), 'tg_name' => $tgname, 'tgid' => $chat_id, 'file_link' => $src, 'username' => 'nousername', 'saqlangan' => '0'];
                $sql = "INSERT INTO jpgtopdf (time, tg_name, tgid, file_link, username, saqlangan) VALUES (:time, :tg_name, :tgid, :file_link, :username, :saqlangan)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($dbdata);
                sendTelegram('sendMessage', array('chat_id' => $chat_id, 'reply_to_message_id' => $message_id, 'text' => $lang['phototext']));
            } else {
                sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $lang['toxtaerror']));
            }
        }
        exit();
    }
    // Ответ на текстовые сообщения.
    if (!empty($user_text == "/toxta")) {
        $sth = $pdo->prepare("SELECT * FROM `userstg` WHERE `tgid` = '" . $chat_id . "' LIMIT 1 ");
        $sth->execute();
        $tekshirmaiz = $sth->fetch(PDO::FETCH_ASSOC);
        if ($tekshirmaiz['holat'] == '0') {
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $lang['toxtaerror']));
            exit();
        }
        $sth = $pdo->prepare("SELECT `saqlangan` FROM `jpgtopdf` WHERE `tgid` = '" . $chat_id . "' AND `saqlangan` = '0' LIMIT 1");
        $sth->execute();
        $bormi = $sth->fetch(PDO::FETCH_ASSOC);
        if ($bormi['saqlangan'] < '0') {
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $lang['toxtatashlanmagan']));
            exit();
        }
        $botpostid = sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $lang['toxta']));
        sendTelegram('sendChatAction', array('chat_id' => $chat_id, 'action' => 'upload_document'));
        $baza = $pdo->query("SELECT * FROM `jpgtopdf` WHERE `tgid` = $chat_id AND `saqlangan` = '0'")->fetchAll();
        if ($baza) {
            $filelink = array();
            foreach ($baza as $row1) {
                $filelink[] = $row1['file_link'];
            }
            $pdf = new Imagick($filelink);
            $pdf->setImageFormat('pdf');
            $pdf->writeImages($chat_id . '.pdf', true);
            $sth = $pdo->prepare("SELECT `check` FROM `userstg` WHERE `tgid` = '" . $chat_id . "' LIMIT 1");
            $sth->execute();
            $chegirma = $sth->fetch(PDO::FETCH_ASSOC);
            //if ($chegirma['check'] == 'pulli') {
            sendTelegram('sendDocument', array('chat_id' => $chat_id, 'reply_to_message_id' => botpostid($botpostid), 'document' => curl_file_create(__DIR__ . '/' . $chat_id . '.pdf')));
            $dataof = ['holat' => '0', 'tgid' => $chat_id];
            $sql = "UPDATE userstg SET holat=:holat WHERE tgid=:tgid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($dataof);
            $update = ['saqlangan' => '1', 'tgid' => $chat_id];
            $sql = "UPDATE `jpgtopdf` SET saqlangan=:saqlangan WHERE tgid=:tgid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($update);
            sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $lang['reklama'], 'reply_markup' => $keyboard));
            $botmessage_id = sendTelegram('sendMessage', array('chat_id' => $guruhim, 'text' => 'Rasmni PDFga o`tkazishdi. Bot hozirda pullik rejimda ishlamayotganligi sababli hammaga hujjatlarini PDF qilib bermoqda. Men bir nusxasini shu yerga tashlayman.
Familiya ismi: ' . $birgalikda . '
Usernamesi: @' . $username . '
Men faylni telegramga yuklashni boshladim
#jpgtopdf'));
            sendTelegram('sendChatAction', array('chat_id' => $guruhim, 'action' => 'upload_document'));
            sendTelegram('sendDocument', array('chat_id' => $guruhim, 'reply_to_message_id' => botpostid($botmessage_id), 'document' => curl_file_create(__DIR__ . '/' . $chat_id . '.pdf')));
            unlink($chat_id . '.pdf');
            exit();
        }
    } else {
        sendTelegram('sendMessage', array('chat_id' => $chat_id, 'text' => $lang['toxtaerror1']));
    }
}
