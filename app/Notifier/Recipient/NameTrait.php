<?php


namespace App\Notifier\Recipient;


trait NameTrait
{
    private $name;

    public function getName(): string
    {
        return $this->name;
    }
}
