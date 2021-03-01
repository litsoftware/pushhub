# litnotifier

litNotifier 是一个支持国内多种不同渠道消息的通知服务，如：企业微信通知、钉钉群机器人、SMS短信、EMAIL等。

litNotifier 构建于 Laravel Notification / Job / Queue 之上，提供了一种动态的、方便扩展的方式来管理消息的发送。


## Usage

1. pull code
2. 修改 `config/notifier_channel.php`，填写消息渠道参数配置
3. `php artisan serv` 启动服务


## Document

### 通知渠道：SMS、EMAIL、CHAT、WechatMp

litNotifier 可以非常方便的发送消息到不同的渠道，且支持多账号配置。

- EMAIL 通过邮件发送消息
- CHAT 把消息推送到国内主流的社交软件。如 企业微信、钉钉
- SMS 通过短信方式发送消息
- WechatMp 通过公众号推送消息


### SMS Channel

SMS 消息支持模板消息和纯文本消息。


|服务提供商| DSN |
|:---|:---|
|阿里云SMS|sms://<配置名称>@aliyun|
|腾讯云SMS|sms://<配置名称>@qcloud|


### EMAIL Channel

邮件支持发送纯文本、本地邮件模板、附件。


|服务提供商| DSN |
|:---|:---|
|SMTP 邮件服务|email://<配置名称>@smtp|


### Chat Channel

向各社交软件发送消息。支持模板消息、文本消息、markdown、发送文件等。
具体请见各软件支持情况。


|服务提供商| DSN | 文档 |
|:---|:---|:---|
|企业微信消息|chat://<配置名称>@wecom|[官方文档](https://work.weixin.qq.com/api/doc/90000/90136/91770)|
|钉钉消息|chat://<配置名称>@dingtalk|[官方文档](https://developers.dingtalk.com/document/app/custom-robot-access)|


### WechatMp Channel

待实现

## APIs

- 发送消息 POST `/api/v1/webhook`

    具体消息格式见下方

        
        curl '/api/v1/webhook' \
        -H 'Content-Type: application/json' \
        -d '
        {
          "dsn": "text",
          "data": {
            "content": '消息内容' 
          }
        }'


- 文件上传 POST `/api/v1/upload`
  
  文件上传参考 : https://docs.guzzlephp.org/en/stable/request-options.html#multipart


```
    POST https://qyapi.weixin.qq.com/cgi-bin/webhook/upload_media?key=693a91f6-7xxx-4bc4-97a0-0ec2sifa5aaa&type=file HTTP/1.1
    Content-Type: multipart/form-data; boundary=-------------------------acebdf13572468
    Content-Length: 220
    ---------------------------acebdf13572468
    Content-Disposition: form-data; name="media";filename="wework.txt"; filelength=6
    Content-Type: application/octet-stream
    mytext
    ---------------------------acebdf13572468--
```



## 接口参数与格式

### EMAIL

    {
        "dsn": "email://default@aliyun",
        "from": {
            "name": "test",
            "address": "test@qq.com"
        },
        "to": {
            "name": "haha",
            "to": "haha@qq.com"
        },
        "data": {
            "content": "测试消息",
            "view": "email.haha",
            "params": [],
            "attachment": [],
        },
    }

### SMS
    
    {
        "dsn": "sms://default@aliyun",
        "to": {
            "country": "CN",
            "country_code": "+86",
            "to": "13800138000"
        },
        "data": {
            "content": "",
            "tmpl_id": "",
            "params": [],
            "sign": "",
        },
    }

### WeCom

content 结构同官方，参考： https://work.weixin.qq.com/api/doc/90000/90136/91770

    {
        "dsn": "chat://default@wecom",
        "data": {
            "content": []
        },
    }


### DingTalk

content 结构同官方，参考： https://developers.dingtalk.com/document/app/custom-robot-access/title-72m-8ag-pqw

    {
        "dsn": "chat://default@dingtalk",
        "data": {
            "content": []
        },
    }


## TODO

- [ ] 微信公众号/小程序 模板消息推送支持
- [ ] 接口文档
- [ ] 管理控制台
- [ ] 日志
