<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2017/3/13 12:00
// +----------------------------------------------------------------------
// | TITLE: 授权失败
// +----------------------------------------------------------------------
namespace DawnApi\exception;


use think\Exception;

class UnauthorizedException extends Exception
{

    public $authenticate;


    public function __construct($challenge = 'Basic', $message = 'authentication Failed')
    {
        $this->authenticate = $challenge;
        $this->message = $message;
    }

    /**
     * 获取验证错误信息
     * @access public
     * @return array|string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * WWW-Authenticate challenge string
     * @return array
     */
    public function getHeaders()
    {
        return array('WWW-Authenticate' => $this->authenticate);
    }

}