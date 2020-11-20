<?php

namespace App\Model;

use Symfony\Component\HttpClient\Exception\JsonException;
use Symfony\Component\HttpClient\HttpClient;

class QuoteManager
{
    public function randomQuote()
    {
        static $success = false;
        $response = [];
        $client = HttpClient::create();
        while ($success === false) {
            try {
                $apiResponse = $client->request(
                    'GET',
                    'http://api.forismatic.com/api/1.0/?method=getQuote&format=json&lang=en'
                );
                $response = $apiResponse->toArray();
                $success = true;
            } catch (JsonException $e) {
                $success = false;
            }
        }

        return $response;
    }
}
