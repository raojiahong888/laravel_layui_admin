<?php
function pp($data){
    echo "<pre>";
    die(var_dump($data));
}

/**
 * 监听sql执行
 */
function listenDbSql(){
    \Illuminate\Support\Facades\DB::listen(function($query) {
        $bindings = $query->bindings;
        $sql = $query->sql;
        foreach ($bindings as $replace){
            $value = is_numeric($replace) ? $replace : "'".$replace."'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        pp($sql);
    });
}

/**
 * 返回layui渲染的页面数据
 * @param int $totals
 * @param array $items
 * @return array
 */
function output_layui_data($items = [],$totals = 0,$code = 0,$msg = '正在请求中...'){
    $data = [
        'code' => $code,
        'msg'   => $msg,
        'count' => $totals,
        'data'  => $items
    ];
    return response()->json($data);
}

/**
 * 处理大于date()允许的最大时间(2038-01-01)
 * @param $time
 * @param string $format
 * @param $type 转换类型：1 时间戳转日期，此时$format传"Y-m-d H:i:s"格式, 2 日期转时间戳，此时$format传"U"
 * @return false|string
 */
function do_max_time($time,$format = "Y-m-d",$type=1){
    $time_str = "@".$time;
    if ($type != 1) $time_str = $time;
    $date = new \DateTime($time_str);
    $timezone = timezone_open('Asia/HONG_KONG'); // 设置时区
    $date->setTimezone($timezone);
    $time = $date->format($format);//格式化
    return $time;
}