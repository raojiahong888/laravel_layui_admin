<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->increments('id')->comment('权限表ID');
            $table->string('name')->default('')->comment('权限名称');
            $table->string('guard_name')->default('')->comment('看守器名称');
            $table->string('display_name')->default('')->comment('显示名称');
            $table->string('route')->nullable()->comment('路由名称');
            $table->integer('icon_id')->nullable()->comment('图标ID');
            $table->integer('parent_id')->default(0)->comment('父ID');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE {$tableNames['permissions']} comment '权限表'");

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->increments('id')->comment('角色表ID');
            $table->string('name')->default('')->comment('角色名称');
            $table->string('guard_name')->default('')->comment('看守器名称');
            $table->string('display_name')->default('')->comment('显示名称');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE {$tableNames['roles']} comment '角色表'");

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('permission_id');
            $table->morphs('model');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'model_id', 'model_type'], 'model_has_permissions_permission_model_type_primary');
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE {$tableNames['model_has_permissions']} comment '模型拥有的权限表'");

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('role_id');
            $table->morphs('model');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', 'model_id', 'model_type']);
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE {$tableNames['model_has_roles']} comment '模型拥有的角色表'");

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);

            app('cache')->forget('spatie.permission.cache');
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE {$tableNames['role_has_permissions']} comment '角色权限关联表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
