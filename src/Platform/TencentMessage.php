<?php


namespace Luna\Message\platform;


use Luna\Message\MessageFactory;
use Luna\Message\MessageStrategy;

class TencentMessage implements  MessageFactory,MessageStrategy
{
    /*******腾讯接口公共参数**********/
   private $action;

   private $region;

   private $timestamp;

   private $version;

   private $authorization;

   private $secreteId;

   private $secretKey;

   /*******其他参数***********/
   private $phone;
   private $message;
   private $smsSdkAppId;
   private $templateId;


    public function setConfigure()
    {
        // TODO: Implement setConfigure() method.
    }

    public function sendMessage($message, $phone)
    {
        // TODO: Implement sendMessage() method.
    }

    public function conutMessage()
    {
        // TODO: Implement conutMessage() method.
    }

    public function statusMessage()
    {
        // TODO: Implement statusMessage() method.
    }

    public function rebackMessage()
    {
        // TODO: Implement rebackMessage() method.
    }
}
