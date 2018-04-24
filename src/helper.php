<?php
/**
 * Copyright 2018 cw1997. All Rights Reserved.
 * Project: think-auth
 * File: helper.php
 * Author: cw1997 [867597730@qq.com]
 * Website: changwei.me
 * Date: 2018/4/24
 * Time: 21:51
 */

use cw1997\auth\Auth;

function add_perm($strName, $strModule, $strController, $strAction, $strParameter, $strRemark) {
    return Auth::addPerm($strName, $strModule, $strController, $strAction, $strParameter, $strRemark);
}

function add_role($strName, $strRemark) {
    return Auth::addRole($strName, $strRemark);
}
