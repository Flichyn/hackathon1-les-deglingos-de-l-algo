<?php

namespace App\Model;

use Symfony\Component\HttpClient\HttpClient;

class QuoteManager
{
    public function randomQuote()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://api.forismatic.com/api/1.0/?method=getQuote&format=json&lang=en');
        return $response->toArray();
    }
}
