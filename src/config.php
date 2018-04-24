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
    'database' => [
//        'user_table' => [
//            'table_name' => 'user',
//            'primary_key' => 'id',
//        ],
        'table_prefix' => 'think_auth_',
        'table_name' => [
            'role' => 'role',
            'perm' => 'perm',
            'role_perm' => 'role_perm',
            'user_role' => 'user_role',
        ],
    ],
    'func' => [
        'get_user_id' => 'getUserId',
        'access_denied' => 'accessDenied',
    ],
];
