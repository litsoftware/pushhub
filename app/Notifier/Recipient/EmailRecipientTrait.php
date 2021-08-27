<?php


namespace App\Notifier\Recipient;


trait EmailRecipientTrait
{
    private string $email;

    public function getEmail(): string
    {
        return $this->email;
    }
}
