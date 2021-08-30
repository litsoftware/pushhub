<?php

namespace App\Notifier\Channel;

class ChannelTypes
{
    const TypeChat = "chat";
    const TypeEmail = "email";
    const TypeSms = "sms";

    public static function allTypes(): array {
        return [
            static::TypeChat,
            static::TypeEmail,
            static::TypeSms,
        ];
    }
}
