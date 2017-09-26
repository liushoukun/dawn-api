<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2017/3/22 20:44
// +----------------------------------------------------------------------
// | TITLE: 文档
// +----------------------------------------------------------------------


namespace DawnApi\facade;

use DawnApi\helper\Tree;
use think\Config;
use think\Request;
use think\Response;
use think\Url;

abstract class Doc
{
    public function __construct()
    {
        Config::set('app_trace',false);
    }


    public $titleDoc = 'API文档';
    /**
     * 字段类型
     * @var array
     */
    public static $typeMaps = [
        'string' => '字符串',
        'int' => '整型',
        'float' => '浮点型',
        'boolean' => '布尔型',
        'date' => '日期',
        'array' => '数组',
        'fixed' => '固定值',
        'enum' => '枚举类型',
        'object' => '对象',
    ];
    /**
     * 返回字段
     * @var array
     */
    public static $returnFieldMaps = [
        'name' => '参数名',
        'type' => '类型',
        'desc' => '说明',
    ];
    /**
     * 请求字段
     * @var array
     */
    public static $dataFieldMaps = [
        'name' => '参数名',
        'desc' => '说明',
        'require' => '必须',
        'type' => '类型',
        'default' => '默认值',
        'range' => '范围',

    ];

    public static $restToMethod = [
        'index' => 'GET',
        'create' => 'GET',
        'save' => 'POST',
        'read' => 'GET',
        'edit' => 'GET',
        'update' => 'PUT',
        'delete' => 'DELETE',
    ];



    /**
     * 接口列表
     * @return \think\response\View
     */
    public function index()
    {
        $mainHtmlPath = dirname(__FILE__) . DS . '..' . DS . 'tpl' . DS . 'main.tpl';
        $mainHtmlPath = (Config::get('mainHtmlPath')) ? Config::get('mainHtmlPath') : $mainHtmlPath;
        $apiList = self::getApiDocList();
        $menu = (empty($apiList)) ? '' : self::buildMenuHtml(Tree::makeTree($apiList));
        return view($mainHtmlPath, ['menu' => $menu, 'titleDoc' => $this->titleDoc]);
    }

    /**
     * 接口详细文档
     * @param Request $request
     * @return \think\response\View
     */
    public function apiInfo(Request $request)
    {
        $id = $request->param('id');
        $apiOne = self::getApiDocOne($id);

        $apiList = self::getApiDocList();
        $menu = (empty($apiList)) ? '' : self::buildMenuHtml(Tree::makeTree($apiList));

        $className = $apiOne['class'];
        //获取接口类注释
        $classDoc = self::getClassDoc($className);

        //没有接口类  判断是否有 Markdown文档
        if ($classDoc == false) {
            //输出 Markdown文档
            if (!isset($apiOne['readme']) || empty($apiOne['readme'])) return false;
            $apiMarkdownHtmlPath = dirname(__FILE__) . DS . '..' . DS . 'tpl' . DS . 'apiMarkdown.tpl';
            $apiMarkdownHtmlPath = (Config::get('apiMarkdownHtmlPath')) ? Config::get('apiMarkdownHtmlPath') : $apiMarkdownHtmlPath;
            return view($apiMarkdownHtmlPath, ['menu' => $menu,'classDoc' => $apiOne, 'titleDoc' => $this->titleDoc]);
        }
        //获取请求列表文档
        $methodDoc = self::getMethodListDoc($className);
        //模板位置
        $apiInfoHtmlPath = dirname(__FILE__) . DS . '..' . DS . 'tpl' . DS . 'apiInfo.tpl';
        $apiInfoHtmlPath = (Config::get('apiInfoHtmlPath')) ? Config::get('apiInfoHtmlPath') : $apiInfoHtmlPath;
        //字段
        $fieldMaps['return'] = self::$returnFieldMaps;
        $fieldMaps['data'] = self::$dataFieldMaps;
        $fieldMaps['type'] = self::$typeMaps;

        $data = ['menu' => $menu, 'restToMethod' => self::$restToMethod, 'classDoc' => $classDoc, 'methodDoc' => $methodDoc, 'fieldMaps' => $fieldMaps, 'titleDoc' => $this->titleDoc];
        return view($apiInfoHtmlPath,$data);
    }

    /**
     * 获取文档
     * @return mixed
     */
    public static function getApiDocList()
    {
        //todo 可以写配置文件或数据
        $apiList = Config::get('api_doc');
        return $apiList;
    }

    public static function getApiDocOne($id)
    {
        $apiList = Config::get('api_doc');
        return $apiList[$id];
    }

    /**
     * 获取接口类文档
     * @param $className
     * @return array
     */
    private static function getClassDoc($className)
    {
        try {
            $reflection = new \ReflectionClass($className);
        } catch (\ReflectionException  $e) {
            return false;
        }
        $docComment = $reflection->getDocComment();
        return self::getDoc($docComment);
    }

    /**
     * 获取各种方式响应文档
     * @param $className
     * @return mixed
     */
    private static function getMethodListDoc($className)
    {
        //获取参数规则
        $rules = $className::getRules();
        $restMethodList = self::getRestMethodList($className);
        foreach ($restMethodList as $method) {
            $rc = new \ReflectionClass($className);
            if (false == $rc->hasMethod($method)) continue;
            $reflection = new \ReflectionMethod($className, $method);
            $docComment = $reflection->getDocComment();
            //获取title,desc,readme,return等说明
            $methodDoc[$method] = self::getDoc($docComment);
            if (isset($rules[$method])) {
                $rules['all'] = (isset($rules['all'])) ? $rules['all'] : [];
                $methodDoc[$method]['rules'] = array_merge($rules['all'], $rules[$method]);
            } else {
                $rules['all'] = (isset($rules['all'])) ? $rules['all'] : [];
                $methodDoc[$method]['rules'] = $rules['all'];
            }

        }
        return $methodDoc;
    }

    /**
     * 获取接口所有请求方式
     * @param $className
     * @return array
     */
    private static function getRestMethodList($className)
    {
        $reflection = new \ReflectionClass($className);
        $Properties = $reflection->getDefaultProperties();
        $restMethodList = $Properties['restActionList'];
        //是否添加有附加方法
        if (isset($Properties['extraActionList'])) {
            $extraMethodList = $Properties['extraActionList'];
            $restMethodList = array_merge($restMethodList, $extraMethodList);
        }
        return $restMethodList;
    }


    /**
     * 获取注释转换成数组
     * @param $docComment
     * @return mixed
     */
    private static function getDoc($docComment)
    {
        $docCommentArr = explode("\n", $docComment);
        foreach ($docCommentArr as $comment) {
            $comment = trim($comment);
            //接口名称
            $pos = stripos($comment, '@title');
            if ($pos !== false) {
                $data['title'] = trim(substr($comment, $pos + 6));
                continue;
            }
            //接口描述
            $pos = stripos($comment, '@desc');
            if ($pos !== false) {
                $data['desc'] = trim(substr($comment, $pos + 5));
                continue;
            }
            //接口说明文档
            $pos = stripos($comment, '@readme');
            if ($pos !== false) {
                $data['readme'] = trim(substr($comment, $pos + 7));
                continue;
            }
            //接口url
            $pos = stripos($comment, '@url');
            if ($pos !== false) {
                $data['url'] = trim(substr($comment, $pos + 4));
                continue;
            }
            //接口url versions
            $pos = stripos($comment, '@version');
            if ($pos !== false) {
                $data['version'] = trim(substr($comment, $pos + 8));
                continue;
            }

            //返回字段说明
            //@return注释
            $pos = stripos($comment, '@return');
            //以上都没有匹配到直接下一行
            if ($pos === false) {
                continue;
            }
            $returnCommentArr = explode(' ', substr($comment, $pos + 8));
            //将数组中的空值过滤掉，同时将需要展示的值返回
            $returnCommentArr = array_values(array_filter($returnCommentArr));
            //如果小于3个也过滤
            if (count($returnCommentArr) < 2) {
                continue;
            }
            if (!isset($returnCommentArr[2])) {
                $returnCommentArr[2] = '';    //可选的字段说明
            } else {
                //兼容处理有空格的注释
                $returnCommentArr[2] = implode(' ', array_slice($returnCommentArr, 2));
            }
            $returnCommentArr[0] = (in_array(strtolower($returnCommentArr[0]), array_keys(self::$typeMaps))) ? self::$typeMaps[strtolower($returnCommentArr[0])] : $returnCommentArr[0];
            $data['return'][] = [
                'name' => $returnCommentArr[1],
                'type' => $returnCommentArr[0],
                'desc' => $returnCommentArr[2],
            ];

        }
        $data['title'] = (isset($data['title'])) ? $data['title'] : '';
        $data['desc'] = (isset($data['desc'])) ? $data['desc'] : '';
        $data['readme'] = (isset($data['readme'])) ? $data['readme'] : '';
        $data['return'] = (isset($data['return'])) ? $data['return'] : [];
        $data['url'] = (isset($data['url'])) ? $data['url'] : '';
        $data['version'] = (isset($data['version'])) ? $data['version'] : '';
        return $data;
    }

    /**
     * 生成 接口菜单
     * @param $data
     * @param string $html
     * @return string
     */
    private static function buildMenuHtml($data, $html = '')
    {
        foreach ($data as $k => $v) {
            $html .= '<li >';
            if (isset($v['children']) && is_array($v['children'])) {
                $html .= '<a href="javascript:;"><i class="fa fa-folder"></i> <span class="nav-label">' . $v['name'] . '</span><span class="fa arrow"></span></a>';//name
            } else {
                $html .= '<a href="' . Url::build('wiki/apiInfo', ['id' => $v['id']]) . '" ><i class="fa fa-file"></i> <span class="nav-label">' . $v['name'] . '</span></a>';//
            }
            //需要验证是否有子菜单
            if (isset($v['children']) && is_array($v['children'])) {

                $html .= '<ul class="nav nav-second-level">';
                $html .= self::buildMenuHtml($v['children']);
                //验证是否有子订单
                $html .= '</ul>';

            }
            $html .= '</li>';

        }
        return $html;

    }

}