<?php

namespace App\Http\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class WebhookController extends Controller
{
    private $bot;

    private $events;

    private $signature;

    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // create bot object
        $httpClient = new CurlHTTPClient(env('CHANNEL_ACCESS_TOKEN'));
        $this->bot = new LINEBot($httpClient, ['channelSecret' => env('CHANNEL_SECRET')]);
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo 'みなさん、こんにちは';
            header('HTTP/1.1 400 Only POST method allowed');
            exit;
        }

        // get request
        $body = file_get_contents('php://input');
        $this->signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : '-';

        $channelSecret = env('CHANNEL_SECRET');

        $hash = hash_hmac('sha256', $body, $channelSecret, true);
        $signature = base64_encode($hash);

        if ($this->signature != $signature) {
            return response()->json('Invalid Signature', 400);
        } else {
            $this->events = json_decode($body, true);
            if (is_array($this->events['events'])) {
                foreach ($this->events['events'] as $event) {
                    if ($event['type'] == 'message') {
                        // your playground
                    } else {
                        // add bot
                    }
                }
            }
        }
    }
}
