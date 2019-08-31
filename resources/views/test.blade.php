<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>开始使用layui</title>
    <link rel="stylesheet" href="/static/layui-v2.5.4/layui/css/layui.css">
</head>
<body>

<!-- 你的HTML代码 -->

<script src="/static/layui-v2.5.4/layui/layui.js"></script>
<script>
    //一般直接写在一个js文件中
    layui.use(['layer', 'form'], function(){
        var layer = layui.layer
            ,form = layui.form;

        layer.msg('Hello World');
    });
</script>
</body>
</html>