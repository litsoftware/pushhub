<?php


namespace App\Notifier\Recipient;


trait SmsRecipientTrait
{
    private string $phone;
    private string $country;
    private string $countryCode;

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
