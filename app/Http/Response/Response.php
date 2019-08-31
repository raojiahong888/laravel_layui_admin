<?php

namespace App\Http\Response;

/**
 * Class BusinessException
 * 业务异常
 * @package Medlinker\Http
 */
class BusinessException extends \Exception
{

}

class Response
{
    const SUCCESS           = 200;
    const PARAM_ERROR       = 1;
    const FAILED            = 405;
    const UNAUTHORIZED      = 3;
    const FORBIDDEN         = 5;
    const ACCOUNT_DISABLED  = 6;
    const SIGN_INVALID      = 7;
    const SIGN_TIME_INVALID = 8;
    const MINI_PARAM_ERROR  = 9;
    const WEB_PARAM_ERROR   = 10;
    const PHONE_FORMAT_ERROR=16;
    const NUMBER_CON_ERROR  =17;
    const HAS_MOBILE_PHONE  =18;

    const CLIENT_TYPE_ERR   = 11;
    const CLIENT_TYPE_DATA_ERR  = 12;
    const MINI_TOKEN_ERR    = 13;
    const DATA_INSERT_FAILED=14;
    const LOGIN_ERR         =15;
    const TYPE_OR_NUMBER_ERR = 19;
    const CITY_ERR          =  21;
    const CITY_OPEN_ERR     =  22;
    const CONTACT_NUMBER_ERROR = 23;

    private static $errorMsgs = [
        self::SUCCESS           => 'success',
        self::PARAM_ERROR       => '参数错误',
        self::FAILED            => '操作失败，请稍后再试',
        self::FORBIDDEN         => '权限不足',
        self::UNAUTHORIZED      => '请先登录',
        self::ACCOUNT_DISABLED  => '当前账号被禁用',
        self::SIGN_INVALID      => '签名非法',
        self::SIGN_TIME_INVALID => '签名时间非法',
        self::MINI_PARAM_ERROR  => '小程序API,参数错误',
        self::WEB_PARAM_ERROR   => 'WEBApi,参数错误',
        self::NUMBER_CON_ERROR  => '传入参数与对应数据不相符合',
        self::HAS_MOBILE_PHONE  => '手机号已存在！',

        self::CLIENT_TYPE_ERR   => '客户端请求type类型参数错误',
        self::CLIENT_TYPE_DATA_ERR   => '客户端请求type类型错误',
        self::MINI_TOKEN_ERR    => 'token验证失败',
        self::DATA_INSERT_FAILED    => '数据存储,操作失败！',
        self::TYPE_OR_NUMBER_ERR    =>  '账号和角色不匹配',

        self::CITY_ERR          =>  '请正确选择城市',
        self::CITY_OPEN_ERR     =>  '该城市暂未开放',
        self::LOGIN_ERR         =>  '登录失败,账号不存在！',
        self::PHONE_FORMAT_ERROR=>  '电话号码格式错误！',
        self::CONTACT_NUMBER_ERROR => '联系方式格式不正确！',
    ];

    public static function getMsg($code)
    {
        return isset(static::$errorMsgs[$code]) ? static::$errorMsgs[$code] : '';
    }

    public static function generate($errCode, $data = '', $errMsg = '')
    {
        $rs['code'] = $errCode;
        $rs['msg'] = $errMsg;
        $rs['msg'] OR $rs['msg'] = static::getMsg($errCode) ?: static::$errorMsgs[static::FAILED];
        $rs['data'] = $data;
        return response()->json($rs, 200, ['Content-Type' => 'application/json; charset=UTF-8'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit();
    }

    public static function success($data = [])
    {
        return static::generate(Response::SUCCESS, $data);
        exit();
    }

    public static function throwError($errCode, $errMsg = '',$exception = false)
    {
        $errMsg OR $errMsg = static::getMsg($errCode);
        if ($exception) throw new BusinessException($errMsg, $errCode);
        return static::generate($errCode, '',$errMsg);
    }

}