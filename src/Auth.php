<?php
/**
 * Copyright 2018 cw1997. All Rights Reserved.
 * Project: think-auth
 * File: Auth.php
 * Author: cw1997 [867597730@qq.com]
 * Website: changwei.me
 * Date: 2018/4/24
 * Time: 15:53
 */

namespace cw1997\auth;

/*use cw1997\auth\model\Perm;
use cw1997\auth\model\Role;
use cw1997\auth\model\UserRole;
use cw1997\auth\model\RolePerm;*/

use think\Db;
use think\Request;

class Auth
{

    function __construct()
    {
    }

    public static function setup()
    {
//        TODO:改用Phinx\Migration迁移工具进行数据库初始化
//        $strSqlFile = dirname(dirname(__FILE__)).'think_auth.sql';
//        $strDDL = file_get_contents($strSqlFile);
//        Db::execute($strDDL);
    }

    public static function addPerm($strName,
                                   $strModule='index', $strController='index', $strAction='index', $strParameter='',
                                   $strRuleFunction='', $strRemark='')
    {
        /*$objRole = new Perm;
        $objRole->perm_name = $strName;
        $objRole->module = $strModule;
        $objRole->controller = $strController;
        $objRole->action = $strAction;
        $objRole->parameter = $strParameter;
        $objRole->remark = $strRemark;
        return $objRole->save();*/
        $strTablePrefix = config('auth.database.table_prefix');
        $strTableName = $strTablePrefix.config('auth.database.table_name.perm');
        $arrData = [
            'perm_name' => $strName,
            'module' => $strModule,
            'controller' => $strController,
            'action' => $strAction,
            'parameter' => $strParameter,
            'rule_function' => serialize($strRuleFunction),
            'remark' => $strRemark,
        ];
        return Db::table($strTableName)->insertGetId($arrData);
    }

    public static function addRole($strName, $strRemark='')
    {
        /*$objRole = new Role;
        $objRole->role_name = $strName;
        $objRole->remark = $strRemark;
        return $objRole->save();*/
        $strTablePrefix = config('auth.database.table_prefix');
        $strTableName = $strTablePrefix.config('auth.database.table_name.role');
        $arrData = [
            'role_name' => $strName,
            'remark' => $strRemark,
        ];
        return Db::table($strTableName)->insertGetId($arrData, true);
    }

    public static function addPermToRole($intRole, $mixPerms)
    {
        $strTablePrefix = config('auth.database.table_prefix');
        $strTableName = $strTablePrefix.config('auth.database.table_name.role_perm');
        if (is_array($mixPerms)) {
            $arrData = [];
            foreach ($mixPerms as $intIndex => $intValue) {
                $arrData['role_id'] = $intRole;
                $arrData['perm_id'] = $intValue;
            }
            return Db::table($strTableName)->insertAll($arrData, true);
        } else {
            $arrData = ['role_id' => $intRole, 'perm_id' => $mixPerms];
            return Db::table($strTableName)->insertGetId($arrData, true);
        }
    }

    public static function addRoleToUser($intUserId, $mixRoles)
    {
        /*$objUserRole = new UserRole;
        $objUserRole->user_id = $intUserId;
        $objUserRole->role_id = $intRoleId;
        $objUserRole->remark = $strRemark;
        $mixRet = $objUserRole->save();
        return $mixRet;*/
        $strTablePrefix = config('auth.database.table_prefix');
        $strTableName = $strTablePrefix.config('auth.database.table_name.user_role');
        if (is_array($mixRoles)) {
            $arrData = [];
            foreach ($mixRoles as $intIndex => $intValue) {
                $arrData['user_id'] = $intUserId;
                $arrData['role_id'] = $intValue;
            }
            return Db::table($strTableName)->insertAll($arrData, true);
        } else {
            $arrData = ['user_id' => $intUserId, 'role_id' => $mixRoles];
            return Db::table($strTableName)->insertGetId($arrData, true);
        }
    }

    public static function auth(Request $objRequest, $intUserId)
    {
        return false;
    }

}