<?php
/**
 * Copyright 2018 cw1997. All Rights Reserved.
 * Project: think-auth
 * File: Check.php
 * Author: cw1997 [867597730@qq.com]
 * Website: changwei.me
 * Repo: https://git.coding.net/cw1997/dingqing.git
 * Date: 2018/4/24
 * Time: 18:17
 */

namespace cw1997\auth;


class Check
{
    public function handle($request, \Closure $next, $name)
    {
        $strGetUidFuncName = config('auth.func.get_user_id');
        if (!Auth::auth($request, call_user_func($strGetUidFuncName))) {
            $strAccessDeniedFuncName = config('auth.func.access_denied');
            exit('access_denied');
//            return call_user_func($strAccessDeniedFuncName);
        }
        return $next($request);
    }
}