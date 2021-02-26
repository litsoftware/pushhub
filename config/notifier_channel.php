<?php

return [
    // type.driver.account
    'email' => [
        'aliyun' => [
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
            ]
        ],

        'netease' => [
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

                'sign' => ['创梦空间','支付猫','小猪软件','小猪京客'],
                'tmpl' => [
                    ['SMS_171853005', '审核失败提醒'],
                    ['SMS_171857990', '账户余额严重不足提醒'],
                    ['SMS_171857984', '余额不足提醒'],
                    ['SMS_171852993', '审核提交通知'],
                    ['SMS_170520417', '审核通过'],
                    ['SMS_170520407', '异常提醒'],
                    ['SMS_126355301', '通用验证码'],
                    ['SMS_126350339', '产品升级通知'],
                    ['SMS_126350333', '服务到期通知'],

                    ['SMS_14960303', '身份验证验证码'],
                    ['SMS_14960301', '登录确认验证码'],
                    ['SMS_14960300', '登录异常验证码'],
                    ['SMS_14960299', '用户注册验证码'],
                    ['SMS_14960298', '活动确认验证码'],
                    ['SMS_14960297', '修改密码验证码'],
                    ['SMS_14960296', '信息变更验证码'],
                ]
            ]
        ],
    ],

    'wecom' => [
        'cmzz_warning' => [
            'webhook' => '',
            'key' => '',
        ]
    ],

    'dingtalk' => [
        'default' => [
            'webhook' => '',
            'access_token' => '',
            'secret' => '',
            'sign' => false, // 是否签名
        ]
    ],
];
