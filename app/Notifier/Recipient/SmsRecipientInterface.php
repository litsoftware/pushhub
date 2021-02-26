<?php


namespace App\Notifier\Recipient;


interface SmsRecipientInterface
{
    public function getPhone(): string;
}
