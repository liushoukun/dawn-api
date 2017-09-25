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
use think\Controller;
use think\exception\HttpResponseException;
use think\Request;
use think\Exception;
use DawnApi\contract\AuthContract;
use DawnApi\exception\UnauthorizedException;

abstract class ApiController extends Controller
{

    use Send;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->_init();
    }


    // 默认请求方式
    protected $restDefaultMethod = 'get';
    /**
     * 默认不验证
     * @var bool
     */
    public $apiAuth = false;

    public static $app;

    /**
     * 当前资源类型
     * @var string
     */
    private $type;
    /**
     * 运行方法
     * @var string
     */
    protected $restMethodList = 'index|create|save|read|edit|update|delete';
    protected $extraMethodList = '';

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


    private function _init()
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

        if (self::getConfig('api_debug')) {
            $auth = (self::getConfig('api_auth') && $this->apiAuth) ? self::auth() : true;
            if ($auth !== true) throw new UnauthorizedException();
            //执行操作
        } else {
            try {
                /**
                 * 配置开启并且控制器开启后执行验证程序
                 * 认证授权通过  return true,
                 * 不通过可返回 return false or throw new UnauthorizedException
                 */
                //认证
                $auth = (self::getConfig('api_auth') && $this->apiAuth) ? self::auth() : true;
                if ($auth !== true) throw new UnauthorizedException('Unauthorized');

            } catch (UnauthorizedException $e) {
                //授权认证失败
                throw  new HttpResponseException($this->sendError(401, $e->getMessage(), 401, [], $e->getHeaders()));
            } catch (Exception $e) {
                throw  new HttpResponseException($this->sendError(500, 'server error', 500));
            }
        }

    }


    /**
     * 注册必要的
     */
    private function register()
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


}