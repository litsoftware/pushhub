<?php


namespace App\Notifier\Recipient;


trait EmailRecipientTrait
{
    private $email;

    public function getEmail(): string
    {
        return $this->email;
    }
}
