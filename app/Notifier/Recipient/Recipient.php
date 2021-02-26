<?php


namespace App\Notifier\Recipient;


use App\Exceptions\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Recipient implements NameInterface, EmailRecipientInterface, SmsRecipientInterface
{
    use EmailRecipientTrait;
    use SmsRecipientTrait;
    use NameTrait;

    public function __construct(array $to)
    {
        $email = $phone = [];

        try {
            $email = Validator::make($to, [
                'name'=>'string',
                'to'=>'email'
            ])->validate();
            $this->email(data_get($email, 'to'));
        } catch (ValidationException $e) {
        }

        try {
            $phone = Validator::make($to, [
                'name'=>'string',
                'to'=>'phone:CN,HK,TW,MO,US,mobile'
            ])->validate();
            $this->phone(data_get($phone, 'to'));
        } catch (ValidationException $e) {
        }

        if ('' === data_get($email, 'to') && '' === data_get($phone, 'to')) {
            throw new InvalidArgumentException(sprintf('"%s" needs an email or a phone but both cannot be empty.', static::class));
        }

        $this->name($to['name']);
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
}
