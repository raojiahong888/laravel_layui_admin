@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header">
            <h2>更新权限</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form layui-form-pane1" action="{{route('admin.permission.update',['permission'=>$permission])}}" method="post">
                {{method_field('put')}}
                <input type="hidden" name="id" value="{{ $permission->id }}">
                @include('admin.permission._from')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.permission._js')
@endsection