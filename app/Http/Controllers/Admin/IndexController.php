<?php

namespace App\Http\Controllers\Admin;

use App\Http\Response\Response;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * 后台布局
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function layout()
    {
        return view('admin.layout');
    }

    /**
     * 后台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 数据表格接口
     */
    public function data(Request $request)
    {
        $model = $request->get('model');
        switch (strtolower($model)) {
            case 'user':
                $query = new User();
                break;
            case 'role':
                $query = new Role();
                break;
            case 'permission':
                $query = new Permission();
                $query = $query->where('parent_id', $request->get('parent_id', 0));
                break;
            default:
                $query = new User();
                break;
        }
        $res = $query->paginate($request->get('limit', 30))->toArray();
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * 后台修改密码，页面展示
     * @param Request $request
     */
    public function modifyPwd(Request $request)
    {
        return view('admin.index.modPwd');
    }

    /**
     * 验证旧密码的正确性
     */
    public function validateOldPwd(Request $request)
    {
        $oldPwd     = $request->get('oldPwd');
        if(empty($oldPwd))  return Response::throwError(Response::PARAM_ERROR);

        $validateRes= Auth::attempt(['username'=>Auth::user()->username,'password'=>$oldPwd]);
        if(!$validateRes)   return Response::generate(101,[],'旧密码验证失败!');

        return Response::success();
    }

    /**
     * 修改账户密码
     */
    public function updatePwd(Request $request)
    {
        $this->validate($request,[
            'oldPwd'  => 'required|string',
            'newPwd'  => 'required|string'
        ]);
        //1、验证，用户与提交的 oldPwd，是否匹配
        $oldPwd = $request->get('oldPwd');
        $validateRes= Auth::attempt(['username'=>Auth::user()->username,'password'=>$oldPwd]);
        if(!$validateRes)   return redirect(route('admin.modPwd'))->withErrors(['status'=>'用户与密码不匹配！']);
        //2、执行更新用户密码操作
        $user = User::findOrFail(Auth::user()->id);

        if ($request->get('newPwd'))    $data['password'] = bcrypt($request->get('newPwd'));
        if ($user->update($data)){
            return redirect()->to(route('admin.modPwd'))->with(['status'=>'密码更新成功']);
        }
        return redirect(route('admin.modPwd'))->withErrors(['status'=>'密码更新失败']);
    }

    /** 回显当前管理员信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userInfo(){
        $user = Auth::user();
        return view('admin.index.userInfo',compact('user'));
    }

    /** 修改当前管理员信息
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateInfo(Request $request){
        $user = User::findOrFail(Auth::id());
        $data = $request->except(['password','username']);//过滤 密码和用户名
        if ($user->update($data)){
            return redirect()->to(route('admin.index.userInfo'))->with(['status'=>'修改资料成功']);
        }
        return redirect()->to(route('admin.index.userInfo'))->withErrors('系统错误');
    }

}
