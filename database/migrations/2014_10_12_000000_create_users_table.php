<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('用户ID');
            $table->string('username')->unique()->comment('登录名'); // 登录名
            $table->string('phone')->unique()->comment('电话'); // 电话
            $table->string('name')->comment('姓名'); // 姓名
            $table->string('email')->unique();
            $table->string('password')->comment('密码'); // 密码
            $table->rememberToken()->default('')->comment('登录token值');
            $table->unsignedInteger('area_id')->default(0)->comment('所属区ID'); // 所属区ID
            $table->unsignedInteger('role_id')->default(0)->comment('所属角色ID');
            $table->unsignedInteger('banzu_id')->default(0)->comment('所属班组ID');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `users` comment '用户表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
