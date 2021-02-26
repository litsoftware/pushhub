<?php


namespace App\Notifier\Recipient;


interface EmailRecipientInterface
{
    public function getEmail(): string;
}
