<?php



namespace Luna\Message\platform;




use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\AlibabaCloudException;
use Cls\Log;
use Luna\Message\MessageFactory;
use Luna\Message\MessagePlatform;
use Luna\Message\MessageStrategy;

/**
 * 阿里消息平台,依赖于阿里sdk
 * Class AliSdkMessage
 * @package App\Services\Message\Platform
 */
class AliSdkMessage implements MessageFactory,MessageStrategy
{

    private $accessKeyId;

    private $accessKeySecret;

    private $type;

    private $templateCode;

    private $code;

    private $message;

    private $signName;

    private $alibabaCloud;

    private $regionId;

    private $phone;

    private $version;

    private $action;

    private $method;

    private $host;

    private $options;

    private $product;

    private $sendMessageFun=['product','version','action','method','host','options'];

    public function __construct()
    {
        //初始化配置
        $this->setConfigure();
    }

    public function __call($name, $arguments)
    {
        $this->$name=$arguments[0];
        return $this;
    }

    public function code($code){
        $this->code=json_encode(['code' => $code]);
        return $this;
    }

    public function region(){
        $this->regionId=config('message.type.ali.region_id');
    }

    public function vesrion()
    {
        $this->version = config('message.type.ali.vesrion');
        return $this;
    }

    public function host()
    {
        $this->host = config('message.type.ali.url');
        return $this;
    }

    public function product(){
        $this->product=config('message.type.ali.product');
        return $this;
    }

    public function setConfigure()
    {
        // TODO: Implement setConfigure() method.
        //可以优化 入如果没有配置会报错  需要处理
        $this->accessKeyId = config('message.type.ali.access_key_id');
        $this->accessKeySecret = config('message.type.ali.access_key_secret');
        $this->type=config('message.type.ali.template_type');

        $this->signName = config("message.type.ali.{$this->type}.sign_name");
        $this->templateCode = config("message.type.ali.{$this->type}.register_template");
        $this->region();
        $this->getKeyClient();
    }
    public function getKeyClient(){
        $this->alibabaCloud= AlibabaCloud::accessKeyClient($this->accessKeyId, $this->accessKeySecret)
            ->regionId($this->regionId)
            ->asDefaultClient();
    }
    /**
     * 初始化发送短信配置
     * @param $message
     * @param $action
     * @param $method
     * @return $this
     */
    public function sendMessageInit($message,$phone,$action,$method){
            $this->product()
                ->vesrion()
                ->action($action)
                ->code($message)
                ->method($method)
                ->host()
                ->phone($phone)
                ->options([
                    'query' => [
                        'RegionId' => $this->regionId,
                        'PhoneNumbers' => $this->phone,
                        'SignName' => $this->signName,
                        'TemplateCode' => $this->templateCode,
                        'TemplateParam' => $this->code,
                    ]
                ]);
            return $this;
    }

    public function getRpc(){
        return  AlibabaCloud::rpc();
    }
    public function sendMessage($message,$phone)
    {
        try{
            $this->sendMessageInit($message,$phone,MessagePlatform::ALI_SEN_MESSAGE,MessagePlatform::HTTP_POST);
            $rpc=$this->getRpc();
            foreach($this->sendMessageFun as $fun){
                $rpc->$fun($this->$fun);
            }
            $result=$rpc->request()->toArray();
            if ($result['Message'] != "OK" || $result['Code'] != "OK") {
                \Illuminate\Support\Facades\Log::error($result);
                return $result;
            }
            return true;
        }catch (AlibabaCloudException $e){
            \Illuminate\Support\Facades\Log::info($e);
            return $e->getMessage();
        }

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
