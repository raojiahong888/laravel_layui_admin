<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>HuanHouse-Keeper-Platform</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layui-v2.5.4/layui/css/layui.css" media="all">
</head>
<body>

<div class="layui-fluid">
    @yield('content')
</div>

<script src="/js/jquery.min.js"></script>
<script src="/static/layui-v2.5.4/layui/layui.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    layui.use(['form', 'layedit', 'laydate'], function(){
        var $ = layui.$;
        var form = layui.form;

        //错误提示
        @if(count($errors)>0)
            @foreach($errors->all() as $error)
                layer.msg("{{$error}}",{icon:5});
                @break
            @endforeach
        @endif

        //信息提示
        @if(session('status'))
            layer.msg("{{session('status')}}",{icon:6});
        @endif
    });
</script>
@yield('script')
</body>
</html>



