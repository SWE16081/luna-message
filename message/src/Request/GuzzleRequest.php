<?php


use GuzzleHttp\Client;

/**
 * Class GuzzleRequest
 * guzzle doc
 * https://guzzle-cn.readthedocs.io/zh_CN/latest/index.html
 */
class GuzzleRequest
{
    protected $client;

    protected $header;

    protected $method;

    protected $url;

    protected $options;

    protected $config;

    /**
     * @var 传参类型 query,body,json,form_params,multipart,cookie
     *  默认请求optionsType是query,post请求是json
     *
     */
    protected $optionsType;


    public function __construct()
    {
        $this->client=new Client();
    }

    /**
     * guzzlehttp 参数配置
     * @param array $config
     * @param string $method
     * @param $url
     * @param $options
     * @param array $header
     */
    public function setConfig($config=[],$method='get',$url,$options,$header=[]){
        $this->config=$config;
        $this->method=$method;
        $this->url=$url;
        $this->optionsType=$method=='get'? GuzzleOptionsType::GUZZLE_QUERY:GuzzleOptionsType::GUZZLE_JSON;
        $arr=[$this->optionsType=>$options];
        isset($header)?array_push($header):$arr;
        $this->options=$arr;
    }

    /**
     * 发送请求
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(){
        $res = $this->client->request($this->method, $this->url,$this->options);
        $result=json_decode($res->getBody(),true);
        return $result;
    }
}
