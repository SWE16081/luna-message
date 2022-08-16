<?php


namespace Luna\Message\Platform;

use Luna\Message\MessageFactory;
use Luna\Message\MessagePlatform;
use Luna\Message\MessageStrategy;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Sms\V20210111\Models\SendSmsRequest;
use TencentCloud\Sms\V20210111\SmsClient;

class TencentSdkMessage implements MessageFactory,MessageStrategy
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
    private $client;
    private $credential;
    private $httpProfile;
    private $clientProfile;
    private $request;// 实例化一个请求对象,每个接口都会对应一个request对象

    public function __construct()
    {
        $this->initConfig();//初始化配置
    }

    public function getClientProfile(){
        $this->clientProfile = new ClientProfile();
        $this->clientProfile->setHttpProfile($this->httpProfile);
        return $this;
    }
    public function getHttpProfile(){
        $this->httpProfile=new HttpProfile();
        $this->httpProfile->setEndpoint("sms.tencentcloudapi.com");
        return $this;
    }
    public function getCredential(){
        $this->credential=new Credential($this->secreteId,$this->secretKey);
        return $this;
    }
    public function getClient(){
        $this->client = new SmsClient($this->credential, "ap-guangzhou", $this->clientProfile );
        return $this;
    }

    public function initConfig(){
        $this->getCredential()->getHttpProfile()->getClientProfile()->getClient();

    }
    public function getRequest($request){
        $this->request=new $request();
        return $this;
    }
    public function setConfigure()
    {
        // TODO: Implement setConfigure() method.
    }

    public function sendMessage($message, $phone)
    {
        try {

            // TODO: Implement sendMessage() method.
            $req=$this->getRequest(MessagePlatform::TENCENT_SEND_MESSAGE);
            $params=[
                "PhoneNumberSet" => [$phone],
                "SmsSdkAppId" =>config('message.type.tencent.SmsSdkAppId'),
                "TemplateId" =>config('message.type.tencent.TemplateId'),
                "SignName" => config('message.type.tencent.SignName'),
                'SessionContext'=>$message
            ];
            $req->fromJsonString(json_encode($params));
            // 返回的resp是一个SendStatusStatisticsResponse的实例，与请求对象对应
            $resp = $this->client->SendStatusStatistics($req);
            // 输出json格式的字符串回包
            return $resp->toJsonString();
        }catch (TencentCloudSDKException $e){
            return $e;
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
