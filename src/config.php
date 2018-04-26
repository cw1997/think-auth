<?php
/**
 * Copyright 2018 cw1997. All Rights Reserved.
 * Project: think-auth
 * File: config.php
 * Author: cw1997 [867597730@qq.com]
 * Website: changwei.me
 * Date: 2018/4/24
 * Time: 20:43
 */

return [

//    全局总开关（关闭后将停用认证功能）
    'enabled' => true,

//    严格模式
    'strict_mode' => [
//        严格模式开关（开启之后，所有未定义认证规则的操作将无法被访问）
        'enabled' => false,
//        白名单（开启严格模式时，数据库内无认证规则的情况下允许访问白名单内的操作
//               数据库内无有认证规则的情况下仍然按照认证规则进行判断
//               意味着白名单优先级低于数据库内的认证规则）
        'white_list' => [
//            规则为：模块名/控制器名/操作名，注意严格大小写区分
            'index/Index/index',
        ],
//        黑名单（关闭严格模式时，数据库内无认证规则的情况下拒绝访问黑名单内的操作）
        'black_list' => [
//            规则为：模块名/控制器名/操作名，注意严格大小写区分
            'index/Index/denied',
        ],
    ],

//    认证失败之后跳转路由
    'access_denied_action' => 'index/index/hello',

//    获取用户id的函数（该函数需要返回一个int类型，为用户id，该id需要和user_role表进行关联查询）
    'get_user_id_func' => function() {return 1;},

//    数据库配置（通常情况下无需修改，除非你对数据表名有特殊要求，数据库连接将使用项目database的连接）
    'database' => [
//        表名前缀
        'table_prefix' => 'think_auth_',
//        表名
        'table_name' => [
//            角色表
            'role' => 'role',
//            权限表
            'perm' => 'perm',
//            权限所属角色
            'role_perm' => 'role_perm',
//            角色所属用户
            'user_role' => 'user_role',
        ],
    ],

];
