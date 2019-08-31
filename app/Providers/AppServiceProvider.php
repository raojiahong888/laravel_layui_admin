<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_DEBUG')){
            DB::listen(function ($query) {
                $sql = $query->sql;
                $bindings = $query->bindings;
                $sql_log = storage_path('logs/sql_log/' . date("Y-m-d"));
                if (!is_dir($sql_log)){
                    mkdir($sql_log);
                    chmod($sql_log,0777);
                }
                if (!file_exists($sql_log.'/sql.log')){
                    $handle = fopen($sql_log.'/sql.log','w');
                    chmod($sql_log.'/sql.log',0777);
                    fclose($handle);
                }
                //写入sql
                if ($bindings) {
                    file_put_contents($sql_log.'/sql.log', "[" . date("Y-m-d H:i:s") . "]" . $sql . "\r\nparmars:" . json_encode($bindings, 320) . "\r\n\r\n", FILE_APPEND);
                } else {
                    file_put_contents($sql_log.'/sql.log', "[" . date("Y-m-d H:i:s") . "]" . $sql . "\r\n\r\n", FILE_APPEND);
                }
            });
        }
        Schema::defaultStringLength(191);
        //左侧菜单
        view()->composer('admin.layout',function($view){
            $menus = \App\Models\Permission::with([
                'childs'])->where('parent_id',0)->orderBy('sort','desc')->get();
            $view->with('menus',$menus);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
