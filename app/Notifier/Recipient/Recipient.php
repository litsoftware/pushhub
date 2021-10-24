<?php


namespace App\Notifier\Recipient;


use App\Exceptions\InvalidArgumentException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Recipient implements NameInterface, EmailRecipientInterface, SmsRecipientInterface
{
    use EmailRecipientTrait;
    use SmsRecipientTrait;
    use NameTrait;

    public function __construct(array|null $to)
    {
        if ($to) {
            try {
                $email = Validator::make($to, [
                    'name' => 'string',
                    'to' => 'email'
                ])->validate();

                $this->email(data_get($email, 'to'));
                $this->name($to['name']);
            } catch (ValidationException $e) {
                Log::error("验证失败1");
            }

            try {
                $phone = Validator::make($to, [
                    'to' => 'phone:'.implode(',', ['CN','HK','TW','MO','US','mobile', data_get($to, 'country')])
                ])->validate();

                $this->phone(data_get($phone, 'to'));
                $this->country($to['country']);
                $this->countryCode($to['country_code']);
            } catch (ValidationException $e) {
                Log::error("验证失败2");
            }

            if (!isset($email) && !isset($phone)) {
                throw new InvalidArgumentException(sprintf('"%s" needs an email or a phone but both cannot be empty.', static::class));
            }

            if (isset($email) && '' === data_get($email, 'to') || isset($phone) && '' === data_get($phone, 'to')) {
                throw new InvalidArgumentException(sprintf('"%s" needs an email or a phone but both cannot be empty.', static::class));
            }
        }
    }

    /**
     * @param string $email
     * @return $this
     */
    public function email(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     *
     * @param string $phone
     * @return $this
     */
    public function phone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     *
     * @param string $name
     * @return $this
     */
    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function country(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function countryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }
}
