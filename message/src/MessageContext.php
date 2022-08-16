<?php


namespace Luna\Message;

use Illuminate\Config\Repository;
use Luna\Message\platform\AliSdkMessage;
use Luna\Message\Platform\TencentSdkMessage;

class MessageContext implements MessageStrategy
{
    protected $messageFactory,$config;
    public function __construct(Repository $config){
        $this->config = $config;
        //读取默认配置，实例化工厂
        $this->setConfig();
    }
    public function setConfig(){
        $default=$this->config->get('message.default');
        if($default==MessagePlatform::TENCENT_MESSAGE){
            $this->messageFactory=new TencentSdkMessage();
        }else if($default==MessagePlatform::ALI_MESSAGE){
            $this->messageFactory=new AliSdkMessage();
        }
    }
    public function sendMessage($message, $phone)
    {
        // TODO: Implement sendMessage() method.
        if (!isset($this->messageFactory)){
            return false;
        }
        return $this->messageFactory->sendMessage($message,$phone);
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
