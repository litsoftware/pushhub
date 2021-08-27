<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $table = 'channels';

    const ID = 'id';
    const USER_ID = 'user_id';
    const TYPE = 'type';
    const TITLE = 'title';
    const NAME = 'name';
    const CONF = 'conf';
    const VERSION = 'version';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::ID,
        self::USER_ID,
        self::TYPE,
        self::TITLE,
        self::NAME,
        self::CONF,
        self::VERSION,
        self::STATUS,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
}
