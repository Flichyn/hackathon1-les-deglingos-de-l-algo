<?php

namespace App\Controller;

use App\Model\CocktailManager;
use App\Model\QuoteManager;

class ShotController extends AbstractController
{
    public const ABSURD_INGREDIENTS = [
        'Wax',
        'Soy Sauce',
        'Tabasco',
        'Pumpkin Soup',
        'Gaspacho',
        'Compost',
        'Liquid Soap',
        'Vinegar',
        'Sock Juice',
        'Hair Spray',
        'Pink Paint',
        'Sausage Syrup',
        'BZH Caramel',
        'Motor Oil',
        'Brake Fluid',
        'Windshield Washer',
        'Perfume',
    ];

    public function show()
    {
        $cocktailManager = new CocktailManager();
        $randomizer = array_rand(self::ABSURD_INGREDIENTS, 1);
        $randomIngredient = self::ABSURD_INGREDIENTS[$randomizer];

        $cocktails = $cocktailManager->getCocktailData();
        $cocktailsAliases = [
            'Vodka' => 'Potato Alcohol',
            'Gin' => 'Bathtub Gin',
            'Rum' => 'Beet Alcohol',
            'Tequila' => 'Fermented Salsa Sauce',
            'Scotch' => 'Gasoline'
        ];

        if (array_key_exists($cocktails['ingredient1'], $cocktailsAliases)) {
            $name = $cocktails['ingredient1'];
            $cocktails['ingredient1'] = $cocktailsAliases[$name];
        }
        if (array_key_exists($cocktails['ingredient2'], $cocktailsAliases)) {
            $name = $cocktails['ingredient2'];
            $cocktails['ingredient2'] = $cocktailsAliases[$name];
        }
        if (array_key_exists($cocktails['ingredient3'], $cocktailsAliases)) {
            $name = $cocktails['ingredient3'];
            $cocktails['ingredient3'] = $cocktailsAliases[$name];
        }
        if (array_key_exists($cocktails['ingredient4'], $cocktailsAliases)) {
            $name = $cocktails['ingredient4'];
            $cocktails['ingredient4'] = $cocktailsAliases[$name];
        }
        if (array_key_exists($cocktails['ingredient5'], $cocktailsAliases)) {
            $name = $cocktails['ingredient5'];
            $cocktails['ingredient5'] = $cocktailsAliases[$name];
        }

        $quoteManager = new QuoteManager();
        $quote = $quoteManager->randomQuote();

        return $this->twig->render('ShotGenerator/generate.html.twig', [
            'cocktails' => $cocktails,
            'quote' => $quote,
            'cocktailsAliases' => $cocktailsAliases,
            'randomIngredient' => $randomIngredient,
            ]);
    }

    public function chooseYourAlcohol()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $alcohol = $_POST['alcohol'];
            $cocktailManager = new CocktailManager();
            $randomizer = array_rand(self::ABSURD_INGREDIENTS, 1);
            $randomIngredient = self::ABSURD_INGREDIENTS[$randomizer];

            $cocktails = $cocktailManager->getCocktailDataByType($alcohol);
            $cocktailsAliases = [
                'Vodka' => 'Potato Alcohol',
                'Gin' => 'Bathtub Gin',
                'Rum' => 'Beet Alcohol',
                'Tequila' => 'Fermented Salsa Sauce',
                'Scotch' => 'Gasoline'
            ];

            if (array_key_exists($cocktails['ingredient1'], $cocktailsAliases)) {
                $name = $cocktails['ingredient1'];
                $cocktails['ingredient1'] = $cocktailsAliases[$name];
            }
            if (array_key_exists($cocktails['ingredient2'], $cocktailsAliases)) {
                $name = $cocktails['ingredient2'];
                $cocktails['ingredient2'] = $cocktailsAliases[$name];
            }
            if (array_key_exists($cocktails['ingredient3'], $cocktailsAliases)) {
                $name = $cocktails['ingredient3'];
                $cocktails['ingredient3'] = $cocktailsAliases[$name];
            }
            if (array_key_exists($cocktails['ingredient4'], $cocktailsAliases)) {
                $name = $cocktails['ingredient4'];
                $cocktails['ingredient4'] = $cocktailsAliases[$name];
            }
            if (array_key_exists($cocktails['ingredient5'], $cocktailsAliases)) {
                $name = $cocktails['ingredient5'];
                $cocktails['ingredient5'] = $cocktailsAliases[$name];
            }

            $quoteManager = new QuoteManager();
            $quote = $quoteManager->randomQuote();

            return $this->twig->render('ShotGenerator/generate.html.twig', [
                'cocktails' => $cocktails,
                'quote' => $quote,
                'cocktailsAliases' => $cocktailsAliases,
                'randomIngredient' => $randomIngredient,
            ]);
        }
    }
}
