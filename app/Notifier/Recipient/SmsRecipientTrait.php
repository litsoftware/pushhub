<?php


namespace App\Notifier\Recipient;


trait SmsRecipientTrait
{
    private $phone;
    private $country;
    private $countryCode;

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
}
