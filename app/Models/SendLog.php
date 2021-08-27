<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendLog extends Model
{
    use HasFactory;

    protected $table = 'send_logs';
    public string $header = 'Send Log';

    const ID = 'id';
    const USER_ID = 'user_id';
    const FROM = 'from';
    const TO = 'to';
    const CONTENT = 'content';
    const EXTRA = 'extra';
    const STATUS = 'status';
    const SUCCESS_AT = 'success_at';
    const FAIL_AT = 'fail_at';
    const FAIL_REASON = 'fail_reason';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::ID,
        self::USER_ID,
        self::FROM,
        self::TO,
        self::CONTENT,
        self::EXTRA,
        self::STATUS,
        self::SUCCESS_AT,
        self::FAIL_AT,
        self::FAIL_REASON,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
}
