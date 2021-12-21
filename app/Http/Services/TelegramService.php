<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class TelegramService {

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendMessage($message): \Psr\Http\Message\ResponseInterface {
        $client = new Client();
        return $client->get('https://api.telegram.org/bot' . env('TELEGRAM_TOKEN') .'/sendMessage?parse_mode=HTML&chat_id=' . env('CHAT_ID') . '&text=' . $message);
    }
}
