@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>修改资料</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.index.updateInfo',['user'=>$user])}}" method="post">
                <input type="hidden" name="id" value="{{$user->id}}">
                {{method_field('put')}}
                @include('admin.index.user_form')
            </form>
        </div>
    </div>
@endsection


