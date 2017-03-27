<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>{$classDoc.name}-{$titleDoc}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="__STATIC__/hadmin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/animate.css" rel="stylesheet">
    <!--markdown-->
    <link rel="stylesheet" href="__STATIC__/hadmin/css/plugins/editormd/editormd.preview.css" />
    <!--markdown-->
    <style>
        .markdown p img {
            max-width: 100%;
        }
    </style>

    <link href="__STATIC__/hadmin/css/style.css?v=4.1.0" rel="stylesheet">


</head>

<body class="gray-bg">
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


<!-- 全局js -->
<script src="__STATIC__/hadmin/js/jquery.min.js?v=2.1.4"></script>
<script src="__STATIC__/hadmin/js/bootstrap.min.js?v=3.3.6"></script>

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

    $.get("__ROOT__{$classDoc.readme}", function(markdown) {
        editormd.markdownToHTML("markdown-class", {
            markdown        : markdown ,//+ "\r\n" + $("#append-test").text(),
            //htmlDecode      : true,       // 开启 HTML 标签解析，为了安全性，默认不开启
            htmlDecode      : "style,script,iframe",  // you can filter tags decode
            //toc             : false,
            tocm            : true,    // Using [TOCM]
            //tocContainer    : "#custom-toc-container", // 自定义 ToC 容器层
            //gfm             : false,
            //tocDropdown     : true,
            // markdownSourceCode : true, // 是否保留 Markdown 源码，即是否删除保存源码的 Textarea 标签
            emoji           : true,
            taskList        : true,
            tex             : true,  // 默认不解析
            flowChart       : true,  // 默认不解析
            sequenceDiagram : true,  // 默认不解析
        });
    });

</script>

</body>

</html>
