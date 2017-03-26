<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// |  User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2017/3/9 11:39
// +----------------------------------------------------------------------
// | TITLE: API基础
// +----------------------------------------------------------------------
namespace DawnApi\facade;

use think\Config;
use think\Request;
use think\Exception;
use DawnApi\contract\AuthContract;
use DawnApi\exception\UnauthorizedException;

abstract class Api
{

    use Send;
    /**
     * 对应操作
     * @var array
     */
    public $methodToAction = [
        'get' => 'get',
        'post' => 'post',
        'put' => 'put',
        'delete' => 'delete',
        'patch' => 'patch',
        'head' => 'head',
        'options' => 'options',
    ];

    /**
     * 允许访问的请求类型
     * @var string
     */
    public $restMethodList = 'get|post|put|delete|patch|head|options';
    // 默认请求方式
    protected $restDefaultMethod = 'get';
    /**
     * 默认不验证
     * @var bool
     */
    public $apiAuth = false;

    public static $app;
    /**
     * 当前请求类型
     * @var string
     */
    protected $method;
    /**
     * 当前资源类型
     * @var string
     */
    protected $type;
    /**
     * 返回的资源类的
     * @var string
     */
    protected $restTypeList = 'xml|json|jsonp';
    /**
     * REST允许输出的资源类型列表
     * @var array
     */
    protected $restOutputType = [ //
        'xml' => 'application/xml',
        'json' => 'application/json',
        'jsonp' => 'application/jsonp',
    ];


    public function init()
    {
        // 资源类型检测
        $request = Request::instance();
        $ext = $request->ext();
        if ('' == $ext) {
            // 自动检测资源类型
            $this->type = $request->type();
        } elseif (!preg_match('/\(' . $this->restTypeList . '\)$/i', $ext)) {
            // 资源类型非法 则用默认资源类型访问
            $this->type = $this->restDefaultType;
        } else {
            $this->type = $ext;
        }

        //必要性的注册
        $this->register();
        //设置响应类型
        $this->setType();

        // 请求方式检测
        $method = strtolower($request->method());
        $this->method = $method;
        if (false === stripos($this->restMethodList, $method)) {
            return false;
        }

        return true;

    }

    /**
     * 执行代码
     * @param Request $request
     * @return \think\Response|\think\response\Json|\think\response\Jsonp|\think\response\Xml
     * @throws UnauthorizedException
     */
    public function restful(Request $request)
    {

        //检查方法是否允许等初始操作
        $init = $this->init();
        if ($init !== true) return $this->sendError(405, 'Method Not Allowed', 405, [], ["Access-Control-Allow-Origin" => $this->restMethodList]);;
        if (self::getConfig('api_debug')) {
            $auth = (self::getConfig('api_auth') && $this->apiAuth) ? self::auth() : true;
            if ($auth !== true) throw new UnauthorizedException();
            //执行操作
            $response = $this->run($request);
        } else {
            try {
                /**
                 * 配置开启并且控制器开启后执行验证程序
                 * 认证授权通过  return true,
                 * 不通过可返回 return false or throw new AuthException
                 */
                //认证
                $auth = (self::getConfig('api_auth') && $this->apiAuth) ? self::auth() : true;
                if ($auth !== true) throw new UnauthorizedException();
                //执行操作
                $response = $this->run($request);

            } catch (UnauthorizedException $e) {
                //授权认证失败
                $response = $this->sendError(401, $e->getMessage(), 401, [], $e->getHeaders());
            } catch (Exception $e) {
                //其他错误 返回500
                $response = $this->sendError(500, 'server error', 500);
            }
            //清空之前输出 保证输出格式
            ob_end_clean();
        }
        return $response;
    }

    /**
     * 执行具体方法
     * @param $request
     * @return \think\Response|\think\response\Json|\think\response\Jsonp|\think\response\Xml
     */
    private function run($request)
    {
        $action = $this->methodToAction[$this->method];
        if (method_exists($this, $action)) {
            $response = $this->$action($request);
        } else {
            //执行空操作
            $response = $this->_empty($action);
        }
        return $response;
    }

    /**
     * 注册必要的
     */
    public function register()
    {
        //初始化配置
        self::getConfig();
        //授权器
        if (self::getConfig('api_auth') && $this->apiAuth) self::getAuth();
    }

    /**
     * 获取授权
     * @return mixed
     */
    private static function getAuth()
    {
        if (!isset(self::$app['auth']) || !self::$app['auth']) {
            $auth = self::getConfig('auth_class');
            //支持数组配置
            //判断是否实现验证接口
            if (((new \ReflectionClass($auth))->implementsInterface(AuthContract::class)))
                self::$app['auth'] = Factory::getInstance($auth);
        }
        return self::$app['auth'];
    }

    /**
     * 授权验证
     * @throws AuthException
     */
    private static function auth()
    {
        $baseAuth = Factory::getInstance(\DawnApi\auth\BaseAuth::class);
        try {
            $baseAuth->auth(self::$app['auth']);
        } catch (UnauthorizedException $e) {
            throw  new  UnauthorizedException($e->authenticate, $e->getMessage());
        } catch (Exception $e) {
            throw  new  Exception('server error', 500);
        }
        return true;
    }

    /**
     * 获取配置信息
     * @param null $keys
     * @return mixed
     */
    final static function getConfig($keys = null)
    {
        if (!self::$app['config']) self::registerConfig();
        return ($keys == null) ? self::$app['config'] : self::$app['config'][$keys];
    }

    /**
     * 注册配置信息
     */
    private static function registerConfig()
    {
        $path = realpath(__DIR__ . '/../../config/api.php');
        $api = is_array(Config::get('api')) ? Config::get('api') : [];
        self::$app['config'] = array_merge(require $path, $api);
    }


    /**
     * 空操作
     * @return \think\Response|\think\response\Json|\think\response\Jsonp|\think\response\Xml
     */
    public function _empty()
    {
        return $this->sendSuccess([], 'empty method!', 200);
    }

}