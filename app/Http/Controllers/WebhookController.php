<?php

namespace App\Http\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\Exception\InvalidEventRequestException;

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

        try {
            $events = $this->bot->parseEventRequest($body, $this->signature);
        } catch (InvalidSignatureException $e) {
            return response()->json('Invalid Signature', 400);
        } catch (InvalidEventRequestException $e) {
            return response()->json('Invalid event request', 400);
        }

        $this->events = json_decode($body, true);

        if ($event['type'] == 'message') {
            // your playground
        } else {
            // add bot
        }
    }
}
