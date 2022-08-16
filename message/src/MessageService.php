<?php


namespace Luna\Message;




use App\tools\ApiMessage;
use Illuminate\Config\Repository;


class MessageService
{
    use ApiMessage;
    private $messageContext;
    public function __construct(Repository $config)
    {
        $this->messageContext=new MessageContext($config);

    }

    public function sendMessage($message,$phone){
       $res=$this->messageContext->sendMessage($message,$phone);
//       if(!$res){
//           return $this->error(ResponseCode::SERVICE_ERROR,'发送失败');
//       }
       return $this->success('发送成功', $res);
    }
}
