<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$classDoc.title}-{$titleDoc}</title>
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="__STATIC__/hadmin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/animate.css" rel="stylesheet">
    <!--markdown-->
    <link rel="stylesheet" href="__STATIC__/hadmin/css/plugins/editormd/editormd.preview.css"/>
    <!--markdown-->
    <style>
        .markdown p img {
            max-width: 100%;
        }
    </style>

    <link href="__STATIC__/hadmin/css/style.css?v=4.1.0" rel="stylesheet">


</head>
{php}
    $label_class =array(
    'success ',
    'warning ',
    'info ',
    'danger ',
    'primary ',
    'inverse ',
    ' default ');
{/php}


<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs" style="font-size:20px;">
                                        <strong class="font-bold">{$titleDoc}</strong>
                                    </span>
                                </span>
                        </a>
                    </div>
                    <div class="logo-element">{$titleDoc}
                    </div>
                </li>


                <li>
                    <a  href="{:url('wiki/main')}">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">主页</span>
                    </a>
                </li>
                <li class="line dk"></li>
                {$menu}


            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row ">
            <div class="wrapper wrapper-content animated fadeInRight ">

                <div class="row">
                    <div class=" row ibox ">
                        <div class="ibox-content  ">
                            <div class="text-center ">
                                <h2 class="">{$classDoc.title}</h2>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="col-md-9">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">

                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <dl class="dl-horizontal">
                                                        <dt>请求地址：</dt>
                                                        <dd><a target="_blank"
                                                               href="__ROOT__{$classDoc.url}">__ROOT__{$classDoc.url}</a>
                                                        </dd>
                                                    </dl>
                                                </div>
                                                <div class="col-sm-6" id="cluster_info">
                                                    <dl class="dl-horizontal">
                                                        <dt>版本：</dt>
                                                        <dd>{$classDoc.version}</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <div class="well">
                                                {$classDoc.desc}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                                    <div class="file-manager">
                                        <h5>请求</h5>
                                        <div class="hr-line-dashed"></div>
                                        <!--请求列表-->
                                        <ul class="folder-list" style="padding: 0">
                                            {foreach name="methodDoc" item="vo" key="k" }
                                                {php} $label_class_one='';$label_class_one = array_rand($label_class,1){/php}
                                                <li><a href="#{$k}"><span
                                                                class="label label-{$label_class[$label_class_one]}">{$k}</span>
                                                        &nbsp; {$vo.title}</a></li>
                                            {/foreach}

                                        </ul>
                                        <!--请求列表-->
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {notempty  name="classDoc.readme"}
                                <div class="col-md-12">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title" data-target="#markdown-class">
                                            <h5>接口说明文档</h5>

                                        </div>
                                        <div class="ibox-content markdown " id="markdown-class">

                                        </div>
                                    </div>
                                </div>
                        {/notempty}
                    </div>


                    <!--methodDoc-->
                    {foreach name="methodDoc" item="vo" key="k" }
                        <div id="{$k}" class="row">
                            <div id="content-{$k}" class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-success">
                                    {php}
                                        if(isset($restToMethod[$k])){
                                        echo  $restToMethod[$k];
                                        }
                                    {/php}
                                        {$k}
                                    </span>
                                    <h5>  {$vo.title} </h5>

                                </div>
                                <!--title,desc-->
                                {notempty  name="vo.desc"}
                                    <div class="ibox-content">
                                        <div class="well">
                                            {$vo.desc}
                                        </div>
                                    </div>
                                {/notempty}
                                <!--title,desc-->
                                <!--readme-->
                                {notempty  name="vo.readme"}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox float-e-margins">
                                                <div class="ibox-title" >
                                                    <h5>
                                                        <small class="m-l-sm">* 详细文档</small>
                                                    </h5>
                                                </div>
                                                <div class="ibox-content markdown " id="markdown-{$k}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/notempty}


                                <!--readme-->

                                <!--request-->
                                {notempty  name="vo.rules"}
                                    <div class="ibox-title" data-toggle="collapse" data-target="#data-{$k}">
                                        <h5>
                                            <small class="m-l-sm">* 请求参数</small>
                                        </h5>
                                        <div class="ibox-tools">
                                            <a data-toggle="collapse" data-target="#sss" class="collapse-link">
                                                <i data-toggle="collapse" class="fa fa-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="data-{$k}" class="ibox-content collapse in">
                                        <div class="row row-lg">
                                            <div class="col-sm-12">
                                                <!-- Example Toolbar -->
                                                <div class="example-wrap">
                                                    <div class="example">

                                                        <table id="dataTable-{$k}" data-mobile-responsive="true">
                                                            <thead>
                                                            <tr>
                                                                {foreach name="fieldMaps.data" item="data" key="datak" }
                                                                    <th data-field="{$datak}">{$data}</th>
                                                                {/foreach}
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- End Example Toolbar -->
                                            </div>

                                        </div>
                                    </div>
                                {/notempty}
                                <!--request-->
                                <!--response-->
                                {notempty  name="vo.return"}
                                    <div class="ibox-title" data-toggle="collapse" data-target="#return-{$k}">
                                        <h5>
                                            <small class="m-l-sm">* 返回参数</small>
                                        </h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i data-toggle="collapse" class="fa fa-chevron-up success"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="return-{$k}" class="ibox-content">
                                        <div class="row row-lg">
                                            <div class="col-sm-12">
                                                <!-- Example Toolbar -->
                                                <div class="example-wrap">
                                                    <div class="example">

                                                        <table id="returnTable-{$k}" data-mobile-responsive="true">
                                                            <thead>
                                                            <tr>
                                                                {foreach name="fieldMaps.return" item="returnv" key="returnk" }
                                                                    <th data-field="{$returnk}">{$returnv}</th>
                                                                {/foreach}
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- End Example Toolbar -->
                                            </div>

                                        </div>
                                    </div>
                                {/notempty}
                                <!--response-->
                            </div>

                        </div>
                    {/foreach}
                    <!--methodDoc-->


                </div>


            </div>
        </div>
    </div>
    <!--右侧部分结束-->
</div>

<!-- 全局js -->
<script src="__STATIC__/hadmin/js/jquery.min.js?v=2.1.4"></script>
<script src="__STATIC__/hadmin/js/bootstrap.min.js?v=3.3.6"></script>
<script src="__STATIC__/hadmin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="__STATIC__/hadmin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="__STATIC__/hadmin/js/plugins/layer/layer.min.js"></script>


<!-- Bootstrap table -->
<script src="__STATIC__/hadmin/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="__STATIC__/hadmin/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
<script src="__STATIC__/hadmin/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>


<!-- editormd -->
<script src="__STATIC__/hadmin/js/plugins/editormd/lib/marked.min.js"></script>
<script src="__STATIC__/hadmin/js/plugins/editormd/lib/prettify.min.js"></script>
<script src="__STATIC__/hadmin/js/plugins/editormd/lib/raphael.min.js"></script>
<script src="__STATIC__/hadmin/js/plugins/editormd/lib/underscore.min.js"></script>
<script src="__STATIC__/hadmin/js/plugins/editormd/lib/sequence-diagram.min.js"></script>
<script src="__STATIC__/hadmin/js/plugins/editormd/lib/flowchart.min.js"></script>
<script src="__STATIC__/hadmin/js/plugins/editormd/lib/jquery.flowchart.min.js"></script>
<script src="__STATIC__/hadmin/js/plugins/editormd/editormd.js"></script>

<script>
    //获取class md

    $.get("__ROOT__{$classDoc.readme}", function (markdown) {
        editormd.markdownToHTML("markdown-class", {
            markdown: markdown,//+ "\r\n" + $("#append-test").text(),
            //htmlDecode      : true,       // 开启 HTML 标签解析，为了安全性，默认不开启
            htmlDecode: "style,script,iframe",  // you can filter tags decode
            //toc             : false,
            tocm: true,    // Using [TOCM]
            //tocContainer    : "#custom-toc-container", // 自定义 ToC 容器层
            //gfm             : false,
            //tocDropdown     : true,
            // markdownSourceCode : true, // 是否保留 Markdown 源码，即是否删除保存源码的 Textarea 标签
            emoji: true,
            taskList: true,
            tex: true,  // 默认不解析
            flowChart: true,  // 默认不解析
            sequenceDiagram: true,  // 默认不解析
        });
    });

</script>
{foreach name="methodDoc" item="vo" key="k" }
    <script>
        (function (document, window, $) {
            'use strict';


            (function () {
                $('#dataTable-{$k}').bootstrapTable({
//                    url:dataTableUrl,
                    data:{:json_encode(array_values($vo['rules']))},
                    search: true,
                    showRefresh: false,
                    showToggle: true,
                    showColumns: true,
                    iconSize: 'outline',
                    icons: {
                        refresh: 'glyphicon-repeat',
                        toggle: 'glyphicon-list-alt',
                        columns: 'glyphicon-list'
                    }
                });

                $('#returnTable-{$k}').bootstrapTable({
//                    url:returnTableUrl,
                    data:{:json_encode($vo['return'])},
                    search: true,
                    showRefresh: false,
                    showToggle: true,
                    showColumns: true,
                    iconSize: 'outline',
                    icons: {
                        refresh: 'glyphicon-repeat',
                        toggle: 'glyphicon-list-alt',
                        columns: 'glyphicon-list'
                    }
                });
            })();


        })(document, window, jQuery);
    </script>
    <script>
        //获取method md


        $.get("__ROOT__{$vo.readme}", function (markdown) {
            editormd.markdownToHTML("markdown-{$k}", {
                markdown: markdown,//+ "\r\n" + $("#append-test").text(),
                //htmlDecode      : true,       // 开启 HTML 标签解析，为了安全性，默认不开启
                htmlDecode: "style,script,iframe",  // you can filter tags decode
                //toc             : false,
                tocm: true,    // Using [TOCM]
                //tocContainer    : "#custom-toc-container", // 自定义 ToC 容器层
                //gfm             : false,
                //tocDropdown     : true,
                // markdownSourceCode : true, // 是否保留 Markdown 源码，即是否删除保存源码的 Textarea 标签
                emoji: true,
                taskList: true,
                tex: true,  // 默认不解析
                flowChart: true,  // 默认不解析
                sequenceDiagram: true,  // 默认不解析
            });
        });

    </script>
{/foreach}


<!-- 自定义js -->
<script src="__STATIC__/hadmin/js/hAdmin.js?v=4.1.0"></script>
<script type="text/javascript" src="__STATIC__/hadmin/js/index.js"></script>

<!-- 第三方插件 -->
<script src="__STATIC__/hadmin/js/plugins/pace/pace.min.js"></script>


</body>

</html>
