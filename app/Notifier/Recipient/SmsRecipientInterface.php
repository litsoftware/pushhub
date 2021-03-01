<?php


namespace App\Notifier\Recipient;


interface SmsRecipientInterface
{
    public function getPhone(): string;
    public function getCountry(): string;
    public function getCountryCode(): string;
}
