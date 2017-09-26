<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>{$titleDoc}</title>

    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->

    <link rel="shortcut icon" href="/favicon.ico">
    <link href="__STATIC__/hadmin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/animate.css" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/style.css?v=4.1.0" rel="stylesheet">
</head>

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
                    <a class="J_menuItem" href="{:url('main')}">
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
        <div class="row " >
            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="row">

                    <div class="ibox-content  ">
                        <div class="text-center ">
                            <h2 class="">{$classDoc.name}</h2>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title" data-toggle="collapse" data-target="#markdown-class">
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content markdown " id="markdown-class">

                                </div>
                            </div>
                        </div>
                    </div>

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
<!-- 自定义js -->
<script src="__STATIC__/hadmin/js/hAdmin.js?v=4.1.0"></script>
<script type="text/javascript" src="__STATIC__/hadmin/js/index.js"></script>

<!-- 第三方插件 -->
<script src="__STATIC__/hadmin/js/plugins/pace/pace.min.js"></script>

</body>

</html>

