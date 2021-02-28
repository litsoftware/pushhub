# litnotifier

litNotifier 是一个支持国内多种不同渠道消息的通知服务，如：企业微信通知、钉钉群机器人、SMS短信、EMAIL等。

litNotifier 构建于 Laravel Notification / Job / Queue 之上，提供了一种动态的、方便扩展的方式来管理消息的发送。


## Usage


## Document

### 通知渠道：SMS、EMAIL、CHAT、WechatMp

litNotifier 可以非常方便的发送消息到不同的渠道，且支持多账号配置。

- EMAIL 通过邮件发送消息
- CHAT 把消息推送到国内主流的社交软件。如 企业微信、钉钉
- SMS 通过短信方式发送消息
- WechatMp 通过公众号推送消息（同样支持小程序）


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

## TODO

- [ ] 微信公众号/小程序 模板消息推送支持
- [ ] 接口文档
- [ ] 管理控制台
- [ ] 日志
