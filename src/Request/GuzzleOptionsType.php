<?php


use MyCLabs\Enum\Enum;

class GuzzleOptionsType extends Enum
{

    /**
     * 查询字符串参数
     */
    const GUZZLE_QUERY='query';

    /**
     * 上传数据
     * 你可以发送一个包含数据流的请求，将 body 请求参数设置成一个字符串、 fopen 返回的资源、或者一个 Psr\Http\Message\StreamInterface 的实例
     */
    const GUZZLE_BODY='body';
    /**
     * 上传数据
     * 上传json数据表单请求
     */
    const GUZZLE_JSON='json';

    /**
     * post表单请求
     * 发送表单字段
     */
    const GUZZLE_FORM_PARAMS='form_params';

    const GUZZLE_MULTIPART='multipart';

    const GUZZLE_COOKIE='cookie';
}
