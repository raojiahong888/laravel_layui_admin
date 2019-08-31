@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <h2>修改密码</h2>
    </div>
    <div class="layui-card-body">
        <form class="layui-form" action="{{route('admin.updatePwd')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="layui-form-item">
                <label class="layui-form-label">请输入旧密码</label>
                <div class="layui-input-block">
                    <input type="text" name="oldPwd" lay-verify="required" autocomplete="off" placeholder="请输入旧密码" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">请输入新密码</label>
                <div class="layui-input-block">
                    <input type="password" name="newPwd" lay-verify="required" autocomplete="off" placeholder="请输入新密码" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">确认新密码</label>
                <div class="layui-input-block">
                    <input type="password" name="confirmNewPwd" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="demo1" onclick="return checkData()">确认提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script>
        //旧密码输入完成之后，开始验证
        $('input[name=oldPwd]').blur(function () {
            //验证旧密码的正确性
            validateOldPwd();
        });

        //验证 旧密码的正确性
        function validateOldPwd() {
            var oldPwd = $("input[name=oldPwd]").val();

            $.post(
                "{{route('admin.validateOldPwd')}}",
                {'oldPwd':oldPwd},
                function (res) {
                    if(res.code != 200){
                        $('.layui-btn').attr('disabled',true);
                        layer.msg(res.msg);
                        return false;
                    }else{
                        $('.layui-btn').removeAttr('disabled',true);
                    }
                }
            );
        }
        //验证新密码的 二次验证
        function validatePwdEqual() {
            var onePwd = $('input[name=newPwd]').val();         //新密码
            var twoPwd = $('input[name=confirmNewPwd]').val(); //第二次输入的密码
            if(onePwd != twoPwd){
                layer.msg('两次输入密码不一致');
                return false;
            }
        }
        function checkData() {
            //验证两次输入的 密码
            return validatePwdEqual();
        }
    </script>
@endsection