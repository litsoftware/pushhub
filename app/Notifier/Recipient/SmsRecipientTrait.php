<?php


namespace App\Notifier\Recipient;


trait SmsRecipientTrait
{
    private $phone;

    public function getPhone(): string
    {
        return $this->phone;
    }
}
