<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// |  User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2017/3/9 15:10
// +----------------------------------------------------------------------
// | TITLE: basic
// +----------------------------------------------------------------------


namespace DawnApi\auth;


use DawnApi\contract\AuthContract;
use DawnApi\exception\UnauthorizedException;
use think\Exception;
use think\Request;

abstract class Basic implements AuthContract
{

    protected $username;
    protected $password;

    /**
     * 认证授权 通过用户信息和路由
     * @param Request $request
     * @return bool
     * @throws UnauthorizedException
     */
    public function authenticate(Request $request)
    {
        try {
            //获取用户信息
            return $this->getClient($request)->certification($request);
        } catch (UnauthorizedException $e) {
            return $e;
        } catch (Exception $e) {
            throw new  UnauthorizedException('Basic', 'Invalid authentication credentials.');
        }

    }

    /**
     * 获取客户端信息
     * @param Request $request
     * @return object userInfo
     */
    public function getClient(Request $request)
    {
        $authorization = $request->header('authorization');
        $authorization = str_replace("Basic ", "", $authorization);
        $authorization = explode(':', base64_decode($authorization));
        $username = $authorization[0];//$_SERVER['PHP_AUTH_USER']
        $password = $authorization[1];//$_SERVER['PHP_AUTH_PW']
        $this->username = $username;
        $this->password = $password;
        return $this;

    }

    /**
     * 获取用户信息后 验证权限,
     * @param Request $request
     */
    abstract public function certification(Request $request);

    /**
     * 获取用户信息
     * @return mixed
     */
    abstract public function getUser();

}