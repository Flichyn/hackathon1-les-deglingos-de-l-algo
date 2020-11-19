<?php

namespace App\Controller;

use App\Model\CocktailManager;

class ShotController extends AbstractController
{
    public function show()
    {
        $cocktailManager = new CocktailManager();

        $cocktails = $cocktailManager->getRandomCocktailById();

        return $this->twig->render('ShotGenerator/generate.html.twig', [
            'cocktails' => $cocktails,
            ]);
    }
}
