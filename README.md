laravel_layui_admin
laravel5.5结合layui2.0写的iframe结构的后台用户管理权限系统

安装步骤：
1、git clone
2、composer install
3、创建好数据库并配置好后，进行数据表迁移：php artisan migrate
    填充数据：composer dump-autoload
              php artisan db:seed
4、nginx配置文件，增加如下配置代码：
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
5、管理后台默认账号：root，密码：secret