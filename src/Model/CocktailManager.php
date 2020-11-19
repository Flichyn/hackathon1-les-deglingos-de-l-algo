<?php

namespace App\Model;

use Symfony\Component\HttpClient\HttpClient;

class CocktailManager
{
    public const ALCOHOL_LIST = ['Vodka', 'Gin', 'Scotch', 'Tequila', 'Rum'];

    public function getCocktails(): array
    {
        $client = HttpClient::create();
        $randomizer = array_rand(self::ALCOHOL_LIST, 1);
        $randomAlcohol = self::ALCOHOL_LIST[$randomizer];
        $response = $client->request(
            'GET',
            'https://www.thecocktaildb.com/api/json/v1/1/filter.php?i=' . $randomAlcohol
        );

        return $response->toArray();
    }

    public function getRandomCocktailById(): array
    {
        $client = HttpClient::create();
        $cocktails = $this->getCocktails();
        $cocktailIds = [];

        foreach ($cocktails as $cocktail) {
            foreach ($cocktail as $cocktailData) {
                $cocktailIds[] = $cocktailData['idDrink'];
            }
        }

        $randomizer = array_rand($cocktailIds, 1);
        $randomCocktailId = $cocktailIds[$randomizer];

        $response = $client->request(
            'GET',
            'https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=' . $randomCocktailId
        );

        return $response->toArray();
    }
}
