<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';

    const ID = 'id';
    const USER_ID = 'user_id';
    const PATH = 'path';
    const APP_ID = 'app_id';
    const NAME = 'name';
    const MEDIA_HASH = 'media_hash';
    const FS_DRIVER = 'fs_driver';
    const MEDIA_ID = 'media_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::ID,
        self::USER_ID,
        self::PATH,
        self::APP_ID,
        self::NAME,
        self::FS_DRIVER,
        self::MEDIA_HASH,
        self::MEDIA_ID,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
}
