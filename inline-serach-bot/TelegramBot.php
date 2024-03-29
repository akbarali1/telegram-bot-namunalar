<?php

/**
 * Telegram Bot Class.
 *
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */

class TelegramBot
{
    /**
     * Constant for type Callback Query.
     */
    const CALLBACK_QUERY = 'callback_query';
    /**
     * Constant for type Edited Message.
     */
    const EDITED_MESSAGE = 'edited_message';
    /**
     * Constant for type Reply.
     */
    const REPLY = 'reply';
    /**
     * Constant for type Message.
     */
    const MESSAGE = 'message';
    /**
     * Constant for type Photo.
     */
    const PHOTO = 'photo';
    /**
     * Constant for type Video.
     */
    const VIDEO = 'video';
    /**
     * Constant for type Audio.
     */
    const AUDIO = 'audio';
    /**
     * Constant for type Voice.
     */
    const VOICE = 'voice';
    /**
     * Constant for type Document.
     */
    const DOCUMENT = 'document';
    /**
     * Constant for type Location.
     */
    const LOCATION = 'location';
    /**
     * Constant for type Contact.
     */
    const CONTACT = 'contact';

    private $bot_token = '';
    private $data = [];
    private $updates = [];

    /// Class constructor

    /**
     * Create a Telegram instance from the bot token
     * \param $bot_token the bot token
     * \return an instance of the class.
     */
    public function __construct($bot_token)
    {
        $this->bot_token = $bot_token;
        $this->data = $this->getData();
    }

    /// Do requests to Telegram Bot API

    /**
     * Contacts the various API's endpoints
     * \param $api the API endpoint
     * \param $content the request parameters as array
     * \param $post boolean tells if $content needs to be sends
     * \return the JSON Telegram's reply.
     */
    public function endpoint($api, array $content, $post = true)
    {
        $url = 'https://api.telegram.org/bot'.$this->bot_token.'/'.$api;
        if ($post) {
            $reply = $this->sendAPIRequest($url, $content);
        } else {
            $reply = $this->sendAPIRequest($url, [], false);
        }

        return json_decode($reply, true);
    }

    /// A method for testing your bot.

    /**
     * A simple method for testing your bot's auth token. Requires no parameters.
     * Returns basic information about the bot in form of a User object.
     * \return the JSON Telegram's reply.
     */
    public function getMe()
    {
        return $this->endpoint('getMe', [], false);
    }

    /// A method for responding http to Telegram.

    /**
     * \return the HTTP 200 to Telegram.
     */
    public function respondSuccess()
    {
        http_response_code(200);

        return json_encode(['status' => 'success']);
    }

    /// Send a message

    /**
     * Contacts the various API's endpoints<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the message recipient вЂ” User or GroupChat id</td>
     * * </tr>
     * <tr>
     * <td>text</td>
     * <td>String</td>
     * <td>Yes</td>
     * <td>Text of the message to be sent</td>
     * </tr>
     * <tr>
     * <td>parse_mode</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Send <em>Markdown</em>, if you want Telegram apps to show bold, italic and inline URLs in your bot's message. For the moment, only Telegram for Android supports this.</td>
     * </tr>
     * <tr>
     * <td>disable_web_page_preview</td>
     * <td>Boolean</td>
     * <td>Optional</td>
     * <td>Disables link previews for links in this message</td>
     * </tr>
     * <tr>
     * <td>reply_to_message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>If the message is a reply, ID of the original message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td>ReplyKeyboardMarkup or ReplyKeyboardHide or ForceReply</td>
     * <td>Optional</td>
     * <td>Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function sendMessage(array $content)
    {
        return $this->endpoint('sendMessage', $content);
    }

    /// Forward a message

    /**
     * Use this method to forward messages of any kind. On success, the sent Message is returned<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the message recipient вЂ” User or GroupChat id</td>
     * </tr>
     * <tr>
     * <td>from_chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the chat where the original message was sent вЂ” User or GroupChat id</td>
     * </tr>
     * <tr>
     * <td>message_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique message identifier</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function forwardMessage(array $content)
    {
        return $this->endpoint('forwardMessage', $content);
    }

    /// Send a photo

    /**
     * Use this method to send photos. On success, the sent Message is returned.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the message recipient вЂ” User or GroupChat id</td>
     * </tr>
     * <tr>
     * <td>photo</td>
     * <td><a href="https://core.telegram.org/bots/api#inputfile">InputFile</a> or String</td>
     * <td>Yes</td>
     * <td>Photo to send. You can either pass a <em>file_id</em> as String to resend a photo that is already on the Telegram servers, or upload a new photo using multipart/form-data.</td>
     * </tr>
     * <tr>
     * <td>caption</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Photo caption (may also be used when resending photos by <em>file_id</em>).</td>
     * </tr>
     * <tr>
     * <td>reply_to_message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>If the message is a reply, ID of the original message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td>ReplyKeyboardMarkup or >ReplyKeyboardHide or ForceReply</td>
     * <td>Optional</td>
     * <td>Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function sendPhoto(array $content)
    {
        return $this->endpoint('sendPhoto', $content);
    }

    /// Send an audio

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player. Your audio must be in the .mp3 format. On success, the sent Message is returned. Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future.

     * For backward compatibility, when the fields title and performer are both empty and the mime-type of the file to be sent is not audio/mpeg, the file will be sent as a playable voice message. For this to work, the audio must be in an .ogg file encoded with OPUS. This behavior will be phased out in the future. For sending voice messages, use the sendVoice method instead.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the message recipient вЂ” User or GroupChat id</td>
     * </tr>
     * <tr>
     * <td>audio</td>
     * <td><a href="https://core.telegram.org/bots/api#inputfile">InputFile</a> or String</td>
     * <td>Yes</td>
     * <td>Audio file to send. You can either pass a <em>file_id</em> as String to resend an audio that is already on the Telegram servers, or upload a new audio file using <strong>multipart/form-data</strong>.</td>
     * </tr>
     * <tr>
     * <td>duration</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>Duration of the audio in seconds</td>
     * </tr>
     * <tr>
     * <td>performer</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Performer</td>
     * </tr>
     * <tr>
     * <td>title</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Track name</td>
     * </tr>
     * <tr>
     * <td>reply_to_message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>If the message is a reply, ID of the original message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td>ReplyKeyboardMarkup or ReplyKeyboardHide or ForceReply</td>
     * <td>Optional</td>
     * <td>Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function sendAudio(array $content)
    {
        return $this->endpoint('sendAudio', $content);
    }

    /// Send a document

    /**
     * Use this method to send general files. On success, the sent Message is returned. Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the message recipient вЂ” User or GroupChat id</td>
     * </tr>
     * <tr>
     * <td>document</td>
     * <td>InputFile or String</td>
     * <td>Yes</td>
     * <td>File to send. You can either pass a <em>file_id</em> as String to resend a file that is already on the Telegram servers, or upload a new file using <strong>multipart/form-data</strong>.</td>
     * </tr>
     * <tr>
     * <td>reply_to_message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>If the message is a reply, ID of the original message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td>ReplyKeyboardMarkup or ReplyKeyboardHide or ForceReply</td>
     * <td>Optional</td>
     * <td>Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function sendDocument(array $content)
    {
        return $this->endpoint('sendDocument', $content);
    }

    /// Send a sticker

    /**
     * Use this method to send .webp stickers. On success, the sent Message is returned.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the message recipient вЂ” User or GroupChat id</td>
     * </tr>
     * <tr>
     * <td>sticker</td>
     * <td><a href="https://core.telegram.org/bots/api#inputfile">InputFile</a> or String</td>
     * <td>Yes</td>
     * <td>Sticker to send. You can either pass a <em>file_id</em> as String to resend a sticker that is already on the Telegram servers, or upload a new sticker using <strong>multipart/form-data</strong>.</td>
     * </tr>
     * <tr>
     * <td>reply_to_message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>If the message is a reply, ID of the original message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td>ReplyKeyboardMarkup or ReplyKeyboardHide or ForceReply</td>
     * <td>Optional</td>
     * <td>Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function sendSticker(array $content)
    {
        return $this->endpoint('sendSticker', $content);
    }

    /// Send a video

    /**
     * Use this method to send video files, Telegram clients support mp4 videos (other formats may be sent as Document). On success, the sent Message is returned. Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the message recipient вЂ” User or GroupChat id</td>
     * </tr>
     * <tr>
     * <td>video</td>
     * <td><a href="https://core.telegram.org/bots/api#inputfile">InputFile</a> or String</td>
     * <td>Yes</td>
     * <td>Video to send. You can either pass a <em>file_id</em> as String to resend a video that is already on the Telegram servers, or upload a new video file using <strong>multipart/form-data</strong>.</td>
     * </tr>
     * <tr>
     * <td>duration</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>Duration of sent video in seconds</td>
     * </tr>
     * <tr>
     * <td>caption</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Video caption (may also be used when resending videos by <em>file_id</em>).</td>
     * </tr>
     * <tr>
     * <td>reply_to_message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>If the message is a reply, ID of the original message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td>ReplyKeyboardMarkup or ReplyKeyboardHide or ForceReply</td>
     * <td>Optional</td>
     * <td>Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function sendVideo(array $content)
    {
        return $this->endpoint('sendVideo', $content);
    }

    /// Send a voice message

    /**
     *  Use this method to send audio files, if you want Telegram clients to display the file as a playable voice message. For this to work, your audio must be in an .ogg file encoded with OPUS (other formats may be sent as Audio or Document). On success, the sent Message is returned. Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the message recipient вЂ” User or GroupChat id</td>
     * </tr>
     * <tr>
     * <td>voice</td>
     * <td><a href="https://core.telegram.org/bots/api#inputfile">InputFile</a> or String</td>
     * <td>Yes</td>
     * <td>Audio file to send. You can either pass a <em>file_id</em> as String to resend an audio that is already on the Telegram servers, or upload a new audio file using <strong>multipart/form-data</strong>.</td>
     * </tr>
     * <tr>
     * <td>duration</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>Duration of sent audio in seconds</td>
     * </tr>
     * <tr>
     * <td>reply_to_message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>If the message is a reply, ID of the original message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td>ReplyKeyboardMarkup</a> or ReplyKeyboardHide or ForceReply</td>
     * <td>Optional</td>
     * <td>Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function sendVoice(array $content)
    {
        return $this->endpoint('sendVoice', $content);
    }

    /// Send a location

    /**
     *  Use this method to send point on the map. On success, the sent Message is returned.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the message recipient вЂ” User or GroupChat id</td>
     * </tr>
     * <tr>
     * <td>latitude</td>
     * <td>Float number</td>
     * <td>Yes</td>
     * <td>Latitude of location</td>
     * </tr>
     * <tr>
     * <td>longitude</td>
     * <td>Float number</td>
     * <td>Yes</td>
     * <td>Longitude of location</td>
     * </tr>
     * <tr>
     * <td>reply_to_message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>If the message is a reply, ID of the original message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td>ReplyKeyboardMarkup or ReplyKeyboardHide or ForceReply</td>
     * <td>Optional</td>
     * <td>Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function sendLocation(array $content)
    {
        return $this->endpoint('sendLocation', $content);
    }

    /// Send Venue

    /**
     * Use this method to send information about a venue. On success, the sent <a href="https://core.telegram.org/bots/api#message">Message</a> is returned.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the target chat or username of the target channel (in the format <code>@channelusername</code>)</td>
     * </tr>
     * <tr>
     * <td>latitude</td>
     * <td>Float number</td>
     * <td>Yes</td>
     * <td>Latitude of the venue</td>
     * </tr>
     * <tr>
     * <td>longitude</td>
     * <td>Float number</td>
     * <td>Yes</td>
     * <td>Longitude of the venue</td>
     * </tr>
     * <tr>
     * <td>title</td>
     * <td>String</td>
     * <td>Yes</td>
     * <td>Name of the venue</td>
     * </tr>
     * <tr>
     * <td>address</td>
     * <td>String</td>
     * <td>Yes</td>
     * <td>Address of the venue</td>
     * </tr>
     * <tr>
     * <td>foursquare_id</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Foursquare identifier of the venue</td>
     * </tr>
     * <tr>
     * <td>disable_notification</td>
     * <td>Boolean</td>
     * <td>Optional</td>
     * <td>Sends the message <a href="https://telegram.org/blog/channels-2-0#silent-messages">silently</a>. iOS users will not receive a notification, Android users will receive a notification with no sound.</td>
     * </tr>
     * <tr>
     * <td>reply_to_message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>If the message is a reply, ID of the original message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td><a href="https://core.telegram.org/bots/api#inlinekeyboardmarkup">InlineKeyboardMarkup</a> or <a href="https://core.telegram.org/bots/api#replykeyboardmarkup">ReplyKeyboardMarkup</a> or <a href="https://core.telegram.org/bots/api#replykeyboardhide">ReplyKeyboardHide</a> or <a href="https://core.telegram.org/bots/api#forcereply">ForceReply</a></td>
     * <td>Optional</td>
     * <td>Additional interface options. A JSON-serialized object for an <a href="https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating">inline keyboard</a>, <a href="https://core.telegram.org/bots#keyboards">custom reply keyboard</a>, instructions to hide reply keyboard or to force a reply from the user.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function sendVenue(array $content)
    {
        return $this->endpoint('sendVenue', $content);
    }

    //Send contact
    /**Use this method to send phone contacts. On success, the sent <a href="https://core.telegram.org/bots/api#message">Message</a> is returned.</p> <br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the target chat or username of the target channel (in the format <code>@channelusername</code>)</td>
     * </tr>
     * <tr>
     * <td>phone_number</td>
     * <td>String</td>
     * <td>Yes</td>
     * <td>Contact&#39;s phone number</td>
     * </tr>
     * <tr>
     * <td>first_name</td>
     * <td>String</td>
     * <td>Yes</td>
     * <td>Contact&#39;s first name</td>
     * </tr>
     * <tr>
     * <td>last_name</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Contact&#39;s last name</td>
     * </tr>
     * <tr>
     * <td>disable_notification</td>
     * <td>Boolean</td>
     * <td>Optional</td>
     * <td>Sends the message <a href="https://telegram.org/blog/channels-2-0#silent-messages">silently</a>. iOS users will not receive a notification, Android users will receive a notification with no sound.</td>
     * </tr>
     * <tr>
     * <td>reply_to_message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>If the message is a reply, ID of the original message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td><a href="https://core.telegram.org/bots/api#inlinekeyboardmarkup">InlineKeyboardMarkup</a> or <a href="https://core.telegram.org/bots/api#replykeyboardmarkup">ReplyKeyboardMarkup</a> or <a href="https://core.telegram.org/bots/api#replykeyboardhide">ReplyKeyboardHide</a> or <a href="https://core.telegram.org/bots/api#forcereply">ForceReply</a></td>
     * <td>Optional</td>
     * <td>Additional interface options. A JSON-serialized object for an <a href="https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating">inline keyboard</a>, <a href="https://core.telegram.org/bots#keyboards">custom reply keyboard</a>, instructions to hide keyboard or to force a reply from the user.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply
     */
    public function sendContact(array $content)
    {
        return $this->endpoint('sendContact', $content);
    }

    /// Send a chat action

    /**
     *  Use this method when you need to tell the user that something is happening on the bot's side. The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing status).

     * Example: The ImageBot needs some time to process a request and upload the image. Instead of sending a text message along the lines of вЂњRetrieving image, please waitвЂ¦вЂќ, the bot may use sendChatAction with action = upload_photo. The user will see a вЂњsending photoвЂќ status for the bot.

     * We only recommend using this method when a response from the bot will take a noticeable amount of time to arrive.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier for the message recipient вЂ” User or GroupChat id</td>
     * </tr>
     * <tr>
     * <td>action</td>
     * <td>String</td>
     * <td>Yes</td>
     * <td>Type of action to broadcast. Choose one, depending on what the user is about to receive: <em>typing</em> for text messages, <em>upload_photo</em> for photos, <em>record_video</em> or <em>upload_video</em> for videos, <em>record_audio</em> or <em>upload_audio</em> for audio files, <em>upload_document</em> for general files, <em>find_location</em> for location data.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function sendChatAction(array $content)
    {
        return $this->endpoint('sendChatAction', $content);
    }

    /// Get a list of profile pictures for a user

    /**
     *  Use this method to get a list of profile pictures for a user. Returns a UserProfilePhotos object.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>user_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier of the target user</td>
     * </tr>
     * <tr>
     * <td>offset</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>Sequential number of the first photo to be returned. By default, all photos are returned.</td>
     * </tr>
     * <tr>
     * <td>limit</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>Limits the number of photos to be retrieved. Values between 1вЂ”100 are accepted. Defaults to 100.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function getUserProfilePhotos(array $content)
    {
        return $this->endpoint('getUserProfilePhotos', $content);
    }

    /// Use this method to get basic info about a file and prepare it for downloading

    /**
     *  Use this method to get basic info about a file and prepare it for downloading. For the moment, bots can download files of up to 20MB in size. On success, a File object is returned. The file can then be downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>, where <file_path> is taken from the response. It is guaranteed that the link will be valid for at least 1 hour. When the link expires, a new one can be requested by calling getFile again.
     * \param $file_id String File identifier to get info about
     * \return the JSON Telegram's reply.
     */
    public function getFile($file_id)
    {
        $content = ['file_id' => $file_id];

        return $this->endpoint('getFile', $content);
    }

    /// Kick Chat Member

    /**
     * Use this method to kick a user from a group or a supergroup. In the case of supergroups, the user will not be able to return to the group on their own using invite links, etc., unless <a href="https://core.telegram.org/bots/api#unbanchatmember">unbanned</a> first. The bot must be an administrator in the group for this to work. Returns <em>True</em> on success.<br>
     * Note: This will method only work if the Гўв‚¬ЛњAll Members Are AdminsГўв‚¬в„ў setting is off in the target group. Otherwise members may only be removed by the group&#39;s creator or by the member that added them.<br/>Values inside $content:<br/>
     * <table>
     * <tbody>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the target group or username of the target supergroup (in the format <code>@supergroupusername</code>)</td>
     * </tr>
     * <tr>
     * <td>user_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier of the target user</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function kickChatMember(array $content)
    {
        return $this->endpoint('kickChatMember', $content);
    }

    /// Leave Chat

    /**
     * Use this method for your bot to leave a group, supergroup or channel. Returns <em>True</em> on success.</p> <br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the target chat or username of the target supergroup or channel (in the format <code>@channelusername</code>)</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function leaveChat(array $content)
    {
        return $this->endpoint('leaveChat', $content);
    }

    /// Unban Chat Member

    /**
     * Use this method to unban a previously kicked user in a supergroup. The user will <strong>not</strong> return to the group automatically, but will be able to join via link, etc. The bot must be an administrator in the group for this to work. Returns <em>True</em> on success.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the target group or username of the target supergroup (in the format <code>@supergroupusername</code>)</td>
     * </tr>
     * <tr>
     * <td>user_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier of the target user</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function unbanChatMember(array $content)
    {
        return $this->endpoint('unbanChatMember', $content);
    }

    /// Get Chat Information

    /**
     * Use this method to get up to date information about the chat (current name of the user for one-on-one conversations, current username of a user, group or channel, etc.). Returns a <a href="https://core.telegram.org/bots/api#chat">Chat</a> object on success.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the target chat or username of the target supergroup or channel (in the format <code>@channelusername</code>)</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function getChat(array $content)
    {
        return $this->endpoint('getChat', $content);
    }

    /**
     * Use this method to get a list of administrators in a chat. On success, returns an Array of <a href="https://core.telegram.org/bots/api#chatmember">ChatMember</a> objects that contains information about all chat administrators except other bots. If the chat is a group or a supergroup and no administrators were appointed, only the creator will be returned.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the target chat or username of the target supergroup or channel (in the format <code>@channelusername</code>)</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function getChatAdministrators(array $content)
    {
        return $this->endpoint('getChatAdministrators', $content);
    }

    /**
     * Use this method to get the number of members in a chat. Returns <em>Int</em> on success.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the target chat or username of the target supergroup or channel (in the format <code>@channelusername</code>)</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function getChatMembersCount(array $content)
    {
        return $this->endpoint('getChatMembersCount', $content);
    }

    /**
     * Use this method to get information about a member of a chat. Returns a <a href="https://core.telegram.org/bots/api#chatmember">ChatMember</a> object on success.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the target chat or username of the target supergroup or channel (in the format <code>@channelusername</code>)</td>
     * </tr>
     * <tr>
     * <td>user_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>Unique identifier of the target user</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function getChatMember(array $content)
    {
        return $this->endpoint('getChatMember', $content);
    }

    /**
     * Use this method to send answers to an inline query. On success, <em>True</em> is returned.<br>No more than <strong>50</strong> results per query are allowed.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>inline_query_id</td>
     * <td>String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the answered query</td>
     * </tr>
     * <tr>
     * <td>results</td>
     * <td>Array of <a href="https://core.telegram.org/bots/api#inlinequeryresult">InlineQueryResult</a></td>
     * <td>Yes</td>
     * <td>A JSON-serialized array of results for the inline query</td>
     * </tr>
     * <tr>
     * <td>cache_time</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>The maximum amount of time in seconds that the result of the inline query may be cached on the server. Defaults to 300.</td>
     * </tr>
     * <tr>
     * <td>is_personal</td>
     * <td>Boolean</td>
     * <td>Optional</td>
     * <td>Pass <em>True</em>, if results may be cached on the server side only for the user that sent the query. By default, results may be returned to any user who sends the same query</td>
     * </tr>
     * <tr>
     * <td>next_offset</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Pass the offset that a client should send in the next query with the same text to receive more results. Pass an empty string if there are no more results or if you donГўв‚¬Лњt support pagination. Offset length canГўв‚¬в„ўt exceed 64 bytes.</td>
     * </tr>
     * <tr>
     * <td>switch_pm_text</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>If passed, clients will display a button with specified text that switches the user to a private chat with the bot and sends the bot a start message with the parameter <em>switch_pm_parameter</em></td>
     * </tr>
     * <tr>
     * <td>switch_pm_parameter</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Parameter for the start message sent to the bot when user presses the switch button<br><br><em>Example:</em> An inline bot that sends YouTube videos can ask the user to connect the bot to their YouTube account to adapt search results accordingly. To do this, it displays a Гўв‚¬ЛњConnect your YouTube accountГўв‚¬в„ў button above the results, or even before showing any. The user presses the button, switches to a private chat with the bot and, in doing so, passes a start parameter that instructs the bot to return an oauth link. Once done, the bot can offer a <a href="https://core.telegram.org/bots/api#inlinekeyboardmarkup"><em>switch_inline</em></a> button so that the user can easily return to the chat where they wanted to use the bot&#39;s inline capabilities.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function answerInlineQuery(array $content)
    {
        return $this->endpoint('answerInlineQuery', $content);
    }

    /// Set Game Score

    /**
     * Use this method to set the score of the specified user in a game. On success, if the message was sent by the bot, returns the edited Message, otherwise returns <em>True</em>. Returns an error, if the new score is not greater than the user&#39;s current score in the chat and <em>force</em> is <em>False</em>.<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>user_id</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>User identifier</td>
     * </tr>
     * <tr>
     * <td>score</td>
     * <td>Integer</td>
     * <td>Yes</td>
     * <td>New score, must be non-negative</td>
     * </tr>
     * <tr>
     * <td>force</td>
     * <td>Boolean</td>
     * <td>Optional</td>
     * <td>Pass True, if the high score is allowed to decrease. This can be useful when fixing mistakes or banning cheaters</td>
     * </tr>
     * <tr>
     * <td>disable_edit_message</td>
     * <td>Boolean</td>
     * <td>Optional</td>
     * <td>Pass True, if the game message should not be automatically edited to include the current scoreboard</td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>Required if <em>inline_message_id</em> is not specified. Unique identifier for the target chat</td>
     * </tr>
     * <tr>
     * <td>message_id</td>
     * <td>Integer</td>
     * <td>Optional</td>
     * <td>Required if <em>inline_message_id</em> is not specified. Identifier of the sent message</td>
     * </tr>
     * <tr>
     * <td>inline_message_id</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Required if <em>chat_id</em> and <em>message_id</em> are not specified. Identifier of the inline message</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function setGameScore(array $content)
    {
        return $this->endpoint('setGameScore', $content);
    }

    /// Answer a callback Query

    /**
     * Use this method to send answers to callback queries sent from inline keyboards. The answer will be displayed to the user as a notification at the top of the chat screen or as an alert. On success, <em>True</em> is returned.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>callback_query_id</td>
     * <td>String</td>
     * <td>Yes</td>
     * <td>Unique identifier for the query to be answered</td>
     * </tr>
     * <tr>
     * <td>text</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Text of the notification. If not specified, nothing will be shown to the user</td>
     * </tr>
     * <tr>
     * <td>show_alert</td>
     * <td>Boolean</td>
     * <td>Optional</td>
     * <td>If <em>true</em>, an alert will be shown by the client instead of a notification at the top of the chat screen. Defaults to <em>false</em>.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function answerCallbackQuery(array $content)
    {
        return $this->endpoint('answerCallbackQuery', $content);
    }

    /**
     * Use this method to edit text messages sent by the bot or via the bot (for <a href="https://core.telegram.org/bots/api#inline-mode">inline bots</a>). On success, if edited message is sent by the bot, the edited <a href="https://core.telegram.org/bots/api#message">Message</a> is returned, otherwise <em>True</em> is returned.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>No</td>
     * <td>Required if <em>inline_message_id</em> is not specified. Unique identifier for the target chat or username of the target channel (in the format <code>@channelusername</code>)</td>
     * </tr>
     * <tr>
     * <td>message_id</td>
     * <td>Integer</td>
     * <td>No</td>
     * <td>Required if <em>inline_message_id</em> is not specified. Unique identifier of the sent message</td>
     * </tr>
     * <tr>
     * <td>inline_message_id</td>
     * <td>String</td>
     * <td>No</td>
     * <td>Required if <em>chat_id</em> and <em>message_id</em> are not specified. Identifier of the inline message</td>
     * </tr>
     * <tr>
     * <td>text</td>
     * <td>String</td>
     * <td>Yes</td>
     * <td>New text of the message</td>
     * </tr>
     * <tr>
     * <td>parse_mode</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>Send <a href="https://core.telegram.org/bots/api#markdown-style"><em>Markdown</em></a> or <a href="https://core.telegram.org/bots/api#html-style"><em>HTML</em></a>, if you want Telegram apps to show <a href="https://core.telegram.org/bots/api#formatting-options">bold, italic, fixed-width text or inline URLs</a> in your bot&#39;s message.</td>
     * </tr>
     * <tr>
     * <td>disable_web_page_preview</td>
     * <td>Boolean</td>
     * <td>Optional</td>
     * <td>Disables link previews for links in this message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td><a href="https://core.telegram.org/bots/api#inlinekeyboardmarkup">InlineKeyboardMarkup</a></td>
     * <td>Optional</td>
     * <td>A JSON-serialized object for an <a href="https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating">inline keyboard</a>.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function editMessageText(array $content)
    {
        return $this->endpoint('editMessageText', $content);
    }

    /**
     * Use this method to edit captions of messages sent by the bot or via the bot (for <a href="https://core.telegram.org/bots/api#inline-mode">inline bots</a>). On success, if edited message is sent by the bot, the edited <a href="https://core.telegram.org/bots/api#message">Message</a> is returned, otherwise <em>True</em> is returned.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>No</td>
     * <td>Required if <em>inline_message_id</em> is not specified. Unique identifier for the target chat or username of the target channel (in the format <code>@channelusername</code>)</td>
     * </tr>
     * <tr>
     * <td>message_id</td>
     * <td>Integer</td>
     * <td>No</td>
     * <td>Required if <em>inline_message_id</em> is not specified. Unique identifier of the sent message</td>
     * </tr>
     * <tr>
     * <td>inline_message_id</td>
     * <td>String</td>
     * <td>No</td>
     * <td>Required if <em>chat_id</em> and <em>message_id</em> are not specified. Identifier of the inline message</td>
     * </tr>
     * <tr>
     * <td>caption</td>
     * <td>String</td>
     * <td>Optional</td>
     * <td>New caption of the message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td><a href="https://core.telegram.org/bots/api#inlinekeyboardmarkup">InlineKeyboardMarkup</a></td>
     * <td>Optional</td>
     * <td>A JSON-serialized object for an <a href="https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating">inline keyboard</a>.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function editMessageCaption(array $content)
    {
        return $this->endpoint('editMessageCaption', $content);
    }

    /**
     * Use this method to edit only the reply markup of messages sent by the bot or via the bot (for <a href="https://core.telegram.org/bots/api#inline-mode">inline bots</a>).  On success, if edited message is sent by the bot, the edited <a href="https://core.telegram.org/bots/api#message">Message</a> is returned, otherwise <em>True</em> is returned.<br/>Values inside $content:<br/>
     * <table>
     * <tr>
     * <td><strong>Parameters</strong></td>
     * <td><strong>Type</strong></td>
     * <td><strong>Required</strong></td>
     * <td><strong>Description</strong></td>
     * </tr>
     * <tr>
     * <td>chat_id</td>
     * <td>Integer or String</td>
     * <td>No</td>
     * <td>Required if <em>inline_message_id</em> is not specified. Unique identifier for the target chat or username of the target channel (in the format <code>@channelusername</code>)</td>
     * </tr>
     * <tr>
     * <td>message_id</td>
     * <td>Integer</td>
     * <td>No</td>
     * <td>Required if <em>inline_message_id</em> is not specified. Unique identifier of the sent message</td>
     * </tr>
     * <tr>
     * <td>inline_message_id</td>
     * <td>String</td>
     * <td>No</td>
     * <td>Required if <em>chat_id</em> and <em>message_id</em> are not specified. Identifier of the inline message</td>
     * </tr>
     * <tr>
     * <td>reply_markup</td>
     * <td><a href="https://core.telegram.org/bots/api#inlinekeyboardmarkup">InlineKeyboardMarkup</a></td>
     * <td>Optional</td>
     * <td>A JSON-serialized object for an <a href="https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating">inline keyboard</a>.</td>
     * </tr>
     * </table>
     * \param $content the request parameters as array
     * \return the JSON Telegram's reply.
     */
    public function editMessageReplyMarkup(array $content)
    {
        return $this->endpoint('editMessageReplyMarkup', $content);
    }

    /// Use this method to download a file

    /**
     *  Use this method to to download a file from the Telegram servers.
     * \param $telegram_file_path String File path on Telegram servers
     * \param $local_file_path String File path where save the file.
     */
    public function downloadFile($telegram_file_path, $local_file_path)
    {
        $file_url = 'https://api.telegram.org/file/bot'.$this->bot_token.'/'.$telegram_file_path;
        $in = fopen($file_url, 'rb');
        $out = fopen($local_file_path, 'wb');

        while ($chunk = fread($in, 8192)) {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }

    /// Set a WebHook for the bot

    /**
     *  Use this method to specify a url and receive incoming updates via an outgoing webhook. Whenever there is an update for the bot, we will send an HTTPS POST request to the specified url, containing a JSON-serialized Update. In case of an unsuccessful request, we will give up after a reasonable amount of attempts.

     * If you'd like to make sure that the Webhook request comes from Telegram, we recommend using a secret path in the URL, e.g. https://www.example.com/<token>. Since nobody else knows your botГўв‚¬Лњs token, you can be pretty sure itГўв‚¬в„ўs us.
     * \param $url String HTTPS url to send updates to. Use an empty string to remove webhook integration
     * \param $certificate InputFile Upload your public key certificate so that the root certificate in use can be checked
     * \return the JSON Telegram's reply.
     */
    public function setWebhook($url, $certificate = '')
    {
        if ($certificate == '') {
            $requestBody = ['url' => $url];
        } else {
            $requestBody = ['url' => $url, 'certificate' => "@$certificate"];
        }

        return $this->endpoint('setWebhook', $requestBody, true);
    }

    /// Delete the WebHook for the bot

    /**
     *  Use this method to remove webhook integration if you decide to switch back to <a href="https://core.telegram.org/bots/api#getupdates">getUpdates</a>. Returns True on success. Requires no parameters.
     * \return the JSON Telegram's reply.
     */
    public function deleteWebhook()
    {
        return $this->endpoint('deleteWebhook', [], false);
    }

    /// Get the data of the current message

    /** Get the POST request of a user in a Webhook or the message actually processed in a getUpdates() enviroment.
     * \return the JSON users's message.
     */
    public function getData()
    {
        if (empty($this->data)) {
            $rawData = file_get_contents('php://input');

            return json_decode($rawData, true);
        } else {
            return $this->data;
        }
    }

    /// Set the data currently used
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /// Get the text of the current message

    /**
     * \return the String users's text.
     */
    public function Text()
    {
        if ($this->getUpdateType() == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['data'];
        }

        return @$this->data['message']['text'];
    }

    public function Caption()
    {
        return @$this->data['message']['caption'];
    }

    /// Get the chat_id of the current message

    /**
     * \return the String users's chat_id.
     */
    public function ChatID()
    {
        if ($this->getUpdateType() == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['message']['chat']['id'];
        }

        return $this->data['message']['chat']['id'];
    }

    /// Get the message_id of the current message

    /**
     * \return the String message_id.
     */
    public function MessageID()
    {
        if ($this->getUpdateType() == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['message']['message_id'];
        }

        return $this->data['message']['message_id'];
    }

    /// Get the reply_to_message message_id of the current message

    /**
     * \return the String reply_to_message message_id.
     */
    public function ReplyToMessageID()
    {
        return $this->data['message']['reply_to_message']['message_id'];
    }

    /// Get the reply_to_message forward_from user_id of the current message

    /**
     * \return the String reply_to_message forward_from user_id.
     */
    public function ReplyToMessageFromUserID()
    {
        return $this->data['message']['reply_to_message']['forward_from']['id'];
    }

    /// Get the inline_query of the current update

    /**
     * \return the Array inline_query.
     */
    public function Inline_Query()
    {
        return $this->data['inline_query'];
    }

    /// Get the callback_query of the current update

    /**
     * \return the String callback_query.
     */
    public function Callback_Query()
    {
        return $this->data['callback_query'];
    }

    /// Get the callback_query id of the current update

    /**
     * \return the String callback_query id.
     */
    public function Callback_ID()
    {
        return $this->data['callback_query']['id'];
    }

    /// Get the Get the data of the current callback

    /**
     * \return the String callback_data.
     */
    public function Callback_Data()
    {
        return $this->data['callback_query']['data'];
    }

    /// Get the Get the message of the current callback

    /**
     * \return the Message.
     */
    public function Callback_Message()
    {
        return $this->data['callback_query']['message'];
    }

    /// Get the Get the chati_id of the current callback

    /**
     * \return the String callback_query.
     */
    public function Callback_ChatID()
    {
        return $this->data['callback_query']['message']['chat']['id'];
    }

    /// Get the date of the current message

    /**
     * \return the String message's date.
     */
    public function Date()
    {
        return $this->data['message']['date'];
    }

    /// Get the first name of the user
    public function FirstName()
    {
        if ($this->getUpdateType() == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['from']['first_name'];
        }

        return @$this->data['message']['from']['first_name'];
    }

    /// Get the last name of the user
    public function LastName()
    {
        if ($this->getUpdateType() == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['from']['last_name'];
        }

        return @$this->data['message']['from']['last_name'];
    }

/// Get the username of the user
    public function Username()
    {
        if ($this->getUpdateType() == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['from']['username'];
        }

        return @$this->data['message']['from']['username'];
    }

/// Get the location in the message
    public function Location()
    {
        return $this->data['message']['location'];
    }

/// Get the update_id of the message
    public function UpdateID()
    {
        return $this->data['update_id'];
    }

/// Get the number of updates
    public function UpdateCount()
    {
        return count($this->updates['result']);
    }

    /// Get user's id of current message
    public function UserID()
    {
        if ($this->getUpdateType() == self::CALLBACK_QUERY) {
            return $this->data['callback_query']['from']['id'];
        }

        return $this->data['message']['from']['id'];
    }

    /// Get user's id of current forwarded message
    public function FromID()
    {
        return $this->data['message']['forward_from']['id'];
    }

    /// Get chat's id where current message forwarded from
    public function FromChatID()
    {
        return $this->data['message']['forward_from_chat']['id'];
    }

    /// Tell if a message is from a group or user chat

    /**
     *  \return BOOLEAN true if the message is from a Group chat, false otherwise.
     */
    public function messageFromGroup()
    {
        if ($this->data['message']['chat']['type'] == 'private') {
            return false;
        }

        return true;
    }

    /// Get the title of the group chat

    /**
     *  \return a String of the title chat.
     */
    public function messageFromGroupTitle()
    {
        if ($this->data['message']['chat']['type'] != 'private') {
            return $this->data['message']['chat']['title'];
        }
    }

    public function buildKeyBoard(array $options, $onetime = false, $resize = true, $selective = true)
    {
        $replyMarkup = [
            'keyboard'          => $options,
            'one_time_keyboard' => $onetime,
            'resize_keyboard'   => $resize,
            'selective'         => $selective,
        ];
        $encodedMarkup = json_encode($replyMarkup, true);

        return $encodedMarkup;
    }

    public function buildInlineKeyBoard(array $options)
    {
        $replyMarkup = [
            'inline_keyboard' => $options,
        ];
        $encodedMarkup = json_encode($replyMarkup, true);

        return $encodedMarkup;
    }


    public function buildInlineKeyboardButton($text, $url = '', $callback_data = '', $switch_inline_query = null, $switch_inline_query_current_chat = null, $callback_game = '', $pay = '')
    {
        $replyMarkup = [
            'text' => $text,
        ];
        if ($url != '') {
            $replyMarkup['url'] = $url;
        } elseif ($callback_data != '') {
            $replyMarkup['callback_data'] = $callback_data;
        } elseif (!is_null($switch_inline_query)) {
            $replyMarkup['switch_inline_query'] = $switch_inline_query;
        } elseif (!is_null($switch_inline_query_current_chat)) {
            $replyMarkup['switch_inline_query_current_chat'] = $switch_inline_query_current_chat;
        } elseif ($callback_game != '') {
            $replyMarkup['callback_game'] = $callback_game;
        } elseif ($pay != '') {
            $replyMarkup['pay'] = $pay;
        }

        return $replyMarkup;
    }

    public function buildKeyboardButton($text, $request_contact = false, $request_location = false)
    {
        $replyMarkup = [
            'text'             => $text,
            'request_contact'  => $request_contact,
            'request_location' => $request_location,
        ];

        return $replyMarkup;
    }

    public function buildKeyBoardHide($selective = true)
    {
        $replyMarkup = [
            'remove_keyboard' => true,
            'selective'       => $selective,
        ];
        $encodedMarkup = json_encode($replyMarkup, true);

        return $encodedMarkup;
    }

    public function buildForceReply($selective = true)
    {
        $replyMarkup = [
            'force_reply' => true,
            'selective'   => $selective,
        ];
        $encodedMarkup = json_encode($replyMarkup, true);

        return $encodedMarkup;
    }
    public function sendInvoice(array $content)
    {
        return $this->endpoint('sendInvoice', $content);
    }

    public function answerShippingQuery(array $content)
    {
        return $this->endpoint('answerShippingQuery', $content);
    }

    public function answerPreCheckoutQuery(array $content)
    {
        return $this->endpoint('answerPreCheckoutQuery', $content);
    }
    public function sendVideoNote(array $content)
    {
        return $this->endpoint('sendVideoNote', $content);
    }
    public function restrictChatMember(array $content)
    {
        return $this->endpoint('restrictChatMember', $content);
    }
    public function promoteChatMember(array $content)
    {
        return $this->endpoint('promoteChatMember', $content);
    }

    public function exportChatInviteLink(array $content)
    {
        return $this->endpoint('exportChatInviteLink', $content);
    }

    public function setChatPhoto(array $content)
    {
        return $this->endpoint('setChatPhoto', $content);
    }

    public function deleteChatPhoto(array $content)
    {
        return $this->endpoint('deleteChatPhoto', $content);
    }

    public function setChatTitle(array $content)
    {
        return $this->endpoint('setChatTitle', $content);
    }

    public function setChatDescription(array $content)
    {
        return $this->endpoint('setChatDescription', $content);
    }

    public function pinChatMessage(array $content)
    {
        return $this->endpoint('pinChatMessage', $content);
    }

    public function unpinChatMessage(array $content)
    {
        return $this->endpoint('unpinChatMessage', $content);
    }

    public function getStickerSet(array $content)
    {
        return $this->endpoint('getStickerSet', $content);
    }

    public function uploadStickerFile(array $content)
    {
        return $this->endpoint('uploadStickerFile', $content);
    }

    public function createNewStickerSet(array $content)
    {
        return $this->endpoint('createNewStickerSet', $content);
    }


    public function addStickerToSet(array $content)
    {
        return $this->endpoint('addStickerToSet', $content);
    }

    public function setStickerPositionInSet(array $content)
    {
        return $this->endpoint('setStickerPositionInSet', $content);
    }

    public function deleteStickerFromSet(array $content)
    {
        return $this->endpoint('deleteStickerFromSet', $content);
    }

    public function deleteMessage(array $content)
    {
        return $this->endpoint('deleteMessage', $content);
    }

    public function getUpdates($offset = 0, $limit = 100, $timeout = 0, $update = true)
    {
        $content = ['offset' => $offset, 'limit' => $limit, 'timeout' => $timeout];
        $this->updates = $this->endpoint('getUpdates', $content);
        if ($update) {
            if (count($this->updates['result']) >= 1) { //for CLI working.
                $last_element_id = $this->updates['result'][count($this->updates['result']) - 1]['update_id'] + 1;
                $content = ['offset' => $last_element_id, 'limit' => '1', 'timeout' => $timeout];
                $this->endpoint('getUpdates', $content);
            }
        }

        return $this->updates;
    }

    public function serveUpdate($update)
    {
        $this->data = $this->updates['result'][$update];
    }

    public function getUpdateType()
    {
        $update = $this->data;
        if (isset($update['callback_query'])) {
            return self::CALLBACK_QUERY;
        }
        if (isset($update['edited_message'])) {
            return self::EDITED_MESSAGE;
        }
        if (isset($update['message']['reply_to_message'])) {
            return self::REPLY;
        }
        if (isset($update['message']['text'])) {
            return self::MESSAGE;
        }
        if (isset($update['message']['photo'])) {
            return self::PHOTO;
        }
        if (isset($update['message']['video'])) {
            return self::VIDEO;
        }
        if (isset($update['message']['audio'])) {
            return self::AUDIO;
        }
        if (isset($update['message']['voice'])) {
            return self::VOICE;
        }
        if (isset($update['message']['contact'])) {
            return self::CONTACT;
        }
        if (isset($update['message']['document'])) {
            return self::DOCUMENT;
        }
        if (isset($update['message']['location'])) {
            return self::LOCATION;
        }

        return false;
    }

    private function sendAPIRequest($url, array $content, $post = true)
    {
        if (isset($content['chat_id'])) {
            $url = $url.'?chat_id='.$content['chat_id'];
            unset($content['chat_id']);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        if ($result === false) {
            $result = json_encode(['ok'=>false, 'curl_error_code' => curl_errno($ch), 'curl_error' => curl_error($ch)]);
        }
        curl_close($ch);
        if (class_exists('TelegramErrorLogger')) {
            TelegramErrorLogger::log(json_decode($result, true), [$this->getData(), $content]);
        }

        return $result;
    }
}

