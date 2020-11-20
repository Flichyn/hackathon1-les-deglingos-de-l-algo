<?php

namespace App\Controller;

class NotSnapshotController extends AbstractController
{
    public function hattersGonnaHat()
    {
        return $this->twig->render('Hatter/hatter.html.twig');
    }
}
