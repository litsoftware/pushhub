<?php


namespace App\Notifier\Channel\WeCom\Messages;


use Illuminate\Contracts\Support\Arrayable;

interface MessageInterface extends Arrayable
{
    public function toJson(): string;
}
