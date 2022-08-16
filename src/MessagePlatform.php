<?php


namespace Luna\Message;


use MyCLabs\Enum\Enum;

class MessagePlatform extends Enum
{
    const ALI_MESSAGE='ali';
    const TENCENT_MESSAGE='tencent';
    /*******阿里接口名称*********/
    const ALI_SEN_MESSAGE='SendSms';

    /*******腾讯接口名称请求名称*****************/
    const TENCENT_SEND_MESSAGE='SendSmsRequest';//发送短信
    const TENCENT_MESSAGE_COUNT='SendStatusStatisticsRequest';//发送短信数据统计

    const HTTP_POST='POST';
}
