<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// |  User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2017/3/9 11:28
// +----------------------------------------------------------------------
// | TITLE: 授权接口
// +----------------------------------------------------------------------
namespace DawnApi\contract;

use think\Request;

interface AuthContract
{


    /**
     * 认证授权通过客户端信息和路由等
     * @param Request $request
     */
    public function authenticate(Request $request);

    /**
     * 获取客户端信息
     * @param Request $request
     * @return mixed
     */
     function getClient(Request $request);

    /**
     * 获取用户信息
     * @return mixed
     */
     public function getUser();

}