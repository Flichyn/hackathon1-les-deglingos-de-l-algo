<?php

namespace App\Model;

use Symfony\Component\HttpClient\HttpClient;

class CocktailManager
{
    public const ALCOHOL_LIST = ['Vodka', 'Gin', 'Scotch', 'Tequila', 'Rum'];

    private function getCocktails(): array
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

    private function getRandomCocktailById(): array
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

    public function getCocktailData(): array
    {
        $cocktails = $this->getRandomCocktailById();
        $cocktailsInfos = [];

        foreach ($cocktails as $cocktail) {
            foreach ($cocktail as $cocktailData) {
                $cocktailsInfos['name'] = ucwords($cocktailData['strDrink']);
                $cocktailsInfos['image'] = ucwords($cocktailData['strDrinkThumb']);
                $cocktailsInfos['ingredient1'] = ucwords($cocktailData['strIngredient1']);
                $cocktailsInfos['ingredient2'] = ucwords($cocktailData['strIngredient2']);
                $cocktailsInfos['ingredient3'] = ucwords($cocktailData['strIngredient3']);
                $cocktailsInfos['ingredient4'] = ucwords($cocktailData['strIngredient4']);
                $cocktailsInfos['ingredient5'] = ucwords($cocktailData['strIngredient5']);
            }
        }
        return $cocktailsInfos;
    }

    private function getCocktailsByType(string $alcoholType): array
    {
        $client = HttpClient::create();

        $response = $client->request(
            'GET',
            'https://www.thecocktaildb.com/api/json/v1/1/filter.php?i=' . $alcoholType
        );
        return $response->toArray();
    }

    private function getRandomCocktailByType(string $alcoholType): array
    {
        $client = HttpClient::create();
        $cocktails = $this->getCocktailsByType($alcoholType);
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

    public function getCocktailDataByType(string $alcoholType): array
    {
        $cocktails = $this->getRandomCocktailByType($alcoholType);
        $cocktailsInfos = [];

        foreach ($cocktails as $cocktail) {
            foreach ($cocktail as $cocktailData) {
                $cocktailsInfos['name'] = ucwords($cocktailData['strDrink']);
                $cocktailsInfos['image'] = ucwords($cocktailData['strDrinkThumb']);
                $cocktailsInfos['ingredient1'] = ucwords($cocktailData['strIngredient1']);
                $cocktailsInfos['ingredient2'] = ucwords($cocktailData['strIngredient2']);
                $cocktailsInfos['ingredient3'] = ucwords($cocktailData['strIngredient3']);
                $cocktailsInfos['ingredient4'] = ucwords($cocktailData['strIngredient4']);
                $cocktailsInfos['ingredient5'] = ucwords($cocktailData['strIngredient5']);
            }
        }
        return $cocktailsInfos;
    }

    public function isAlcoholic($data)
    {
        $client = HttpClient::create();
        $data = strtolower($data);
        $data = str_replace(' ', '+', $data);
        $response = $client->request(
            'GET',
            'https://www.thecocktaildb.com/api/json/v1/1/search.php?i=' . $data
        );

        return $response->toArray();
    }
}
