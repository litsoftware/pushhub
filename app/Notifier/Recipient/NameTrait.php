<?php


namespace App\Notifier\Recipient;


trait NameTrait
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }
}
