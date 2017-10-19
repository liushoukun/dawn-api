Dawn-Api 
===============
[![Latest Stable Version](https://poser.pugx.org/liushoukun/dawn-api/v/stable)](https://packagist.org/packages/liushoukun/dawn-api)
[![Total Downloads](https://poser.pugx.org/liushoukun/dawn-api/downloads)](https://packagist.org/packages/liushoukun/dawn-api)
[![Latest Unstable Version](https://poser.pugx.org/liushoukun/dawn-api/v/unstable)](https://packagist.org/packages/liushoukun/dawn-api)
[![License](https://poser.pugx.org/liushoukun/dawn-api/license)](https://packagist.org/packages/liushoukun/dawn-api)
[![Monthly Downloads](https://poser.pugx.org/liushoukun/dawn-api/d/monthly)](https://packagist.org/packages/liushoukun/dawn-api)


## 说明
thinkphp5编写的restful风格的API，集API请求处理，权限认证，自动生成文档等功能；

 - restful风格处理请求
 > 每个接口对于一个控制器，method对应[method]方法响应

 - 权限认证
 > Basic,Oauth Client Credentials Grant
 
 - 文档生成
 > 简洁，优雅，不需要额外的文档工具;
 
 
## 安装
- 如果想在你的TP5项目中使用,那么可以直接使用
```
composer require liushoukun/dawn-api
```
- 如果是新项目先要创建tp5项目,然后再require

```
composer create-project topthink/think api  --prefer-dist
composer require liushoukun/dawn-api
```
- 如果要使用生成文档 需要在public/static/ 下 安装hadmin
```
cd /public/static/
git clone  https://github.com/liushoukun/hadmin.git
```


## dome & 文档
 [https://github.com/liushoukun/dawn-api-demo](https://github.com/liushoukun/dawn-api-demo)
