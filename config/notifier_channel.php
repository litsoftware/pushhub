<?php

return [
    // type.driver.account
    'email' => [
        'smtp' => [
            'paycats' => [
                'transport' => 'smtp',
                'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
                'port' => env('MAIL_PORT', 587),
                'encryption' => env('MAIL_ENCRYPTION', 'tls'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
                'timeout' => null,
                'auth_mode' => null,
                'from' => [
                    'name' => env('MAIL_FROM_NAME'),
                    'address' => env('MAIL_FROM_ADDRESS'),
                ]
            ],

            'ssl100' => [
                'transport' => env('MAIL_SSL100_DRIVER', 'smtp'),
                'host' => env('MAIL_SSL100_HOST', 'smtp.mailgun.org'),
                'port' => env('MAIL_SSL100_PORT', 587),
                'encryption' => env('MAIL_SSL100_ENCRYPTION', 'tls'),
                'username' => env('MAIL_SSL100_USERNAME'),
                'password' => env('MAIL_SSL100_PASSWORD'),
                'timeout' => null,
                'auth_mode' => null,
                'from' => [
                    'name' => env('MAIL_SSL100_FROM_NAME'),
                    'address' => env('MAIL_SSL100_FROM_ADDRESS'),
                ]
            ]
        ],
    ],

    'sms' => [
        'aliyun' => [
            'default' => [
                'ak' => env('ALIYUN_SMS_ACCESS_KEY_ID'),
                'sk' => env('ALIYUN_SMS_ACCESS_KEY_SECRET'),
                'region' => env('ALIYUN_SMS_REGION', 'cn-hangzhou'),

                'sign' => explode(',', env('ALIYUN_SMS_SINGS', '')),
                'tmpl' => [
                    ['id' => 'SMS_171853005', 'title' => '审核失败提醒'],
                    ['id' => 'SMS_171857990', 'title' => '账户余额严重不足提醒'],
                    ['id' => 'SMS_171857984', 'title' => '余额不足提醒'],
                    ['id' => 'SMS_171852993', 'title' => '审核提交通知'],
                    ['id' => 'SMS_170520417', 'title' => '审核通过'],
                    ['id' => 'SMS_170520407', 'title' => '异常提醒'],
                    ['id' => 'SMS_126355301', 'title' => '通用验证码'],
                    ['id' => 'SMS_126350339', 'title' => '产品升级通知'],
                    ['id' => 'SMS_126350333', 'title' => '服务到期通知'],
                    ['id' => 'SMS_14960303', 'title' => '身份验证验证码'],
                    ['id' => 'SMS_14960301', 'title' => '登录确认验证码'],
                    ['id' => 'SMS_14960300', 'title' => '登录异常验证码'],
                    ['id' => 'SMS_14960299', 'title' => '用户注册验证码'],
                    ['id' => 'SMS_14960298', 'title' => '活动确认验证码'],
                    ['id' => 'SMS_14960297', 'title' => '修改密码验证码'],
                    ['id' => 'SMS_14960296', 'title' => '信息变更验证码'],
                ]
            ]
        ],

        'qcloud' => [
            'default' => [
                'app_id' => env('QCLOUD_SMS_APP_ID'),
                'app_key' => env('QCLOUD_SMS_APP_KEY'),
            ]
        ]
    ],

    'chat' => [
        'wecom' => [
            'cmzz_test' => [
                'key' => env('WECOM_WEB_HOOK_KEY_1'),
            ]
        ],

        'dingtalk' => [
            'default' => [
                'token' => env('DINGTALK_WEB_HOOK_TOKEN_1'),
                'secret' => env('DINGTALK_WEB_HOOK_SECRET_1'),
                'sign' => env('DINGTALK_WEB_SIGN_ENABLE_1'), // 是否签名
            ]
        ],
    ]
];
