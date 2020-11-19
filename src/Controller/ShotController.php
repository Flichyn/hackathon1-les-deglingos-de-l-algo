<?php

namespace App\Controller;

use App\Model\CocktailManager;
use App\Model\QuoteManager;

class ShotController extends AbstractController
{
    public function show()
    {
        $cocktailManager = new CocktailManager();
        $cocktails = $cocktailManager->getCocktailData();

        $quoteManager = new QuoteManager();
        $quote = $quoteManager->randomQuote();

        return $this->twig->render('ShotGenerator/generate.html.twig', [
            'cocktails' => $cocktails,
            'quote' => $quote,
            ]);
    }
}
