<?php

/*
|--------------------------------------------------------------------------
| Web Routes 控制台首页
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 后台用户登录，注销路由
Auth::routes();

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 后台需要授权的路由 admins
|
*/
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'auth'],function (){
    //后台头，左侧菜单布局
    Route::get('/','IndexController@layout')->name('admin.layout');
    //后台首页
    Route::get('/index','IndexController@index')->name('admin.index');
    //图标
    Route::get('icons','IndexController@icons')->name('admin.icons');
    //后台 修改密码
    Route::get('/modifyPwd','IndexController@modifyPwd')->name('admin.modPwd');
    Route::post('/updatePwd','IndexController@updatePwd')->name('admin.updatePwd');
    Route::post('/validateOldPwd','IndexController@validateOldPwd')->name('admin.validateOldPwd');
    // 修改基础资料
    Route::get('index/userInfo','IndexController@userInfo')->name('admin.index.userInfo');
    Route::put('index/updateInfo','IndexController@updateInfo')->name('admin.index.updateInfo');
});


Route::get('/home', 'HomeController@index')->name('home');

//系统管理
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['auth','permission:system.manage']],function (){
    //数据表格接口
    Route::get('data','IndexController@data')->name('admin.data')->middleware('permission:system.role|system.user|system.permission');
    //用户管理
    Route::group(['middleware'=>['permission:system.user']],function (){
        Route::get('user','UserController@index')->name('admin.user');
        //添加
        Route::get('user/create','UserController@create')->name('admin.user.create')->middleware('permission:system.user.create');
        Route::post('user/store','UserController@store')->name('admin.user.store')->middleware('permission:system.user.create');
        //编辑
        Route::get('user/{id}/edit','UserController@edit')->name('admin.user.edit')->middleware('permission:system.user.edit');
        Route::put('user/{id}/update','UserController@update')->name('admin.user.update')->middleware('permission:system.user.edit');
        //删除
        Route::delete('user/destroy','UserController@destroy')->name('admin.user.destroy')->middleware('permission:system.user.destroy');
        //分配角色
        Route::get('user/{id}/role','UserController@role')->name('admin.user.role')->middleware('permission:system.user.role');
        Route::put('user/{id}/assignRole','UserController@assignRole')->name('admin.user.assignRole')->middleware('permission:system.user.role');
        //分配权限
        Route::get('user/{id}/permission','UserController@permission')->name('admin.user.permission')->middleware('permission:system.user.permission');
        Route::put('user/{id}/assignPermission','UserController@assignPermission')->name('admin.user.assignPermission')->middleware('permission:system.user.permission');
    });
    //角色管理
    Route::group(['middleware'=>'permission:system.role'],function (){
        Route::get('role','RoleController@index')->name('admin.role');
        //添加
        Route::get('role/create','RoleController@create')->name('admin.role.create')->middleware('permission:system.role.create');
        Route::post('role/store','RoleController@store')->name('admin.role.store')->middleware('permission:system.role.create');
        //编辑
        Route::get('role/{id}/edit','RoleController@edit')->name('admin.role.edit')->middleware('permission:system.role.edit');
        Route::put('role/{id}/update','RoleController@update')->name('admin.role.update')->middleware('permission:system.role.edit');
        //删除
        Route::delete('role/destroy','RoleController@destroy')->name('admin.role.destroy')->middleware('permission:system.role.destroy');
        //分配权限
        Route::get('role/{id}/permission','RoleController@permission')->name('admin.role.permission')->middleware('permission:system.role.permission');
        Route::put('role/{id}/assignPermission','RoleController@assignPermission')->name('admin.role.assignPermission')->middleware('permission:system.role.permission');
    });
    //权限管理
    Route::group(['middleware'=>'permission:system.permission'],function (){
        Route::get('permission','PermissionController@index')->name('admin.permission');
        //添加
        Route::get('permission/create','PermissionController@create')->name('admin.permission.create')->middleware('permission:system.permission.create');
        Route::post('permission/store','PermissionController@store')->name('admin.permission.store')->middleware('permission:system.permission.create');
        //编辑
        Route::get('permission/{id}/edit','PermissionController@edit')->name('admin.permission.edit')->middleware('permission:system.permission.edit');
        Route::put('permission/{id}/update','PermissionController@update')->name('admin.permission.update')->middleware('permission:system.permission.edit');
        //删除
        Route::delete('permission/destroy','PermissionController@destroy')->name('admin.permission.destroy')->middleware('permission:system.permission.destroy');
    });

    //区县管理
    Route::group(['middleware'=>['permission:system.area']],function (){
        Route::get('area','AreaController@area')->name('admin.area');
        Route::get('area/data','AreaController@data')->name('admin.area.data');
        //添加
        Route::get('area/create','AreaController@create')->name('admin.area.create')->middleware('permission:system.area.create');
        Route::post('area/store','AreaController@store')->name('admin.area.store')->middleware('permission:system.area.create');
        //编辑
        Route::get('area/{id}/edit','AreaController@edit')->name('admin.area.edit')->middleware('permission:system.area.edit');
        Route::put('area/{id}/update','AreaController@update')->name('admin.area.update')->middleware('permission:system.area.edit');
        //删除
        Route::delete('area/destroy','AreaController@destroy')->name('admin.area.destroy')->middleware('permission:system.area.destroy');
    });
});