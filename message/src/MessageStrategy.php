<?php


namespace Luna\Message;


interface MessageStrategy
{
    //发送短信
    public function sendMessage($message,$phone);
    //短信统计
    public function conutMessage();
    //短信回复状态
    public function statusMessage();
    //短信回调
    public function rebackMessage();
    //。。。。。
}
