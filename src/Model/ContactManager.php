<?php

namespace App\Model;

class ContactManager extends AbstractManager
{
    public const TABLE = "contact";

    public function __construct()
    {
        parent::__construct(self:: TABLE);
    }
}