<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>业绩管理系统</title>
    <link rel="stylesheet" href="/static/layui-v2.5.4/layui/css/layui.css">
    <style>
        a{
            cursor: pointer;
        }
    </style>
</head>
<body class="layui-layout-body">

<!-- 你的HTML代码 -->

<script src="/static/layui-v2.5.4/layui/layui.js"></script>


<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">业绩管理系统</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        {{--<ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">商品管理</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>--}}
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    {{ Auth::user()->name }}
                </a>
                <dl class="layui-nav-child">
                    <dd><a lay-href="{{route('admin.index.userInfo')}}">基本资料</a></dd>
                    <dd><a lay-href="{{route('admin.modPwd')}}">修改密码</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    退出
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">主页</a>
                    <dl class="layui-nav-child">
                        <dd><a lay-href="{{ route('welcome') }}">控制台</a></dd>
                    </dl>
                </li>
                {{--<li class="layui-nav-item">
                    <a href="javascript:;">解决方案</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;">列表一</a></dd>
                        <dd><a href="javascript:;">列表二</a></dd>
                        <dd><a href="">超链接</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="">云市场</a></li>
                <li class="layui-nav-item"><a href="">发布商品</a></li>--}}

                @foreach($menus as $menu)
                    @can($menu->name)
                        <li data-name="{{$menu->name}}" class="layui-nav-item">
                            <a href="javascript:;">{{$menu->display_name}}</a>
                            @if($menu->childs->isNotEmpty())
                                <dl class="layui-nav-child">
                                    @foreach($menu->childs as $subMenu)
                                        @can($subMenu->name)
                                            <dd data-name="{{$subMenu->name}}" >
                                                <a lay-href="{{ route($subMenu->route) }}">{{$subMenu->display_name}}</a>
                                            </dd>
                                        @endcan
                                    @endforeach
                                </dl>
                            @endif
                        </li>
                    @endcan
                @endforeach

            </ul>
        </div>
    </div>

    <div class="layui-body layui-tab-content site-demo site-demo-body">
        <!-- 内容主体区域 -->
        <div class="layui-tab-item layui-show"><iframe src="{{route('welcome')}}" frameborder="0" id="demoAdmin"  style="width: 100%;"></iframe></div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
</div>
<script>

    layui.use(['layer','element'], function(){
        var element = layui.element;
        // 设定iframe 的高度
        var $ = layui.$
            ,setIframe = function(){
            var height = $(window).height()-130;
            $('#demoAdmin').height(height);
        };
        setIframe();
        $(window).on('resize', setIframe);
        // 动态加载iframe内容
        $('.layui-nav-child a').click(function () {
            var href = $(this).attr('lay-href');
            $('#demoAdmin').attr('src',href);
        });
    });

</script>
</body>
</html>