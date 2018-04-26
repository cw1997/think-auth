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

use think\Db;
use think\Request;

class Auth
{

    public static function addPerm($strName, $strModule='index', $strController='index', $strAction='index', $strParameter='', $strRuleFunction='', $strRemark='')
    {
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

    public static function DelPerm($intPermId)
    {
        $bolRet = false;
        $strTablePrefix = config('auth.database.table_prefix');
        // 启动事务
        Db::startTrans();
        try {
            $strTableName = $strTablePrefix.config('auth.database.table_name.role_perm');
            Db::table($strTableName)->where('perm_id', '=', $intPermId)->delete();
            $strTableName = $strTablePrefix.config('auth.database.table_name.perm');
            Db::table($strTableName)->where('id', '=', $intPermId)->delete();
            // 提交事务
            Db::commit();
            $bolRet = true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $bolRet = false;
        }
        return $bolRet;
    }

    public static function addRole($strName, $strRemark='')
    {
        $strTablePrefix = config('auth.database.table_prefix');
        $strTableName = $strTablePrefix.config('auth.database.table_name.role');
        $arrData = [
            'role_name' => $strName,
            'remark' => $strRemark,
        ];
        return Db::table($strTableName)->insertGetId($arrData, true);
    }

    public static function DelRole($intRoleId)
    {
        $bolRet = false;
        $strTablePrefix = config('auth.database.table_prefix');
        // 启动事务
        Db::startTrans();
        try {
            $strTableName = $strTablePrefix.config('auth.database.table_name.role_perm');
            Db::table($strTableName)->where('role_id', '=', $intRoleId)->delete();
            $strTableName = $strTablePrefix.config('auth.database.table_name.role');
            Db::table($strTableName)->where('id', '=', $intRoleId)->delete();
            // 提交事务
            Db::commit();
            $bolRet = true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $bolRet = false;
        }
        return $bolRet;
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

    public static function DelPermFromRole($intRole, $mixPerms)
    {
        $strTablePrefix = config('auth.database.table_prefix');
        $strTableName = $strTablePrefix.config('auth.database.table_name.role_perm');
        if (is_array($mixPerms)) {
            $arrData = [];
            foreach ($mixPerms as $intIndex => $intValue) {
                $arrData['role_id'] = $intRole;
                $arrData['perm_id'] = $intValue;
            }
            return Db::table($strTableName)->delete($arrData);
        } else {
            $arrData = ['role_id' => $intRole, 'perm_id' => $mixPerms];
            return Db::table($strTableName)->delete($arrData);
        }
    }

    public static function addRoleToUser($intUserId, $mixRoles)
    {
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

    public static function DelRoleFromUser($intUserId, $mixRoles)
    {
        $strTablePrefix = config('auth.database.table_prefix');
        $strTableName = $strTablePrefix.config('auth.database.table_name.user_role');
        if (is_array($mixRoles)) {
            $arrData = [];
            foreach ($mixRoles as $intIndex => $intValue) {
                $arrData['user_id'] = $intUserId;
                $arrData['role_id'] = $intValue;
            }
            return Db::table($strTableName)->delete($arrData);
        } else {
            $arrData = ['user_id' => $intUserId, 'role_id' => $mixRoles];
            return Db::table($strTableName)->delete($arrData);
        }
    }

    public static function auth(Request $objRequest, $intUserId)
    {
        $strModule = $objRequest->module();
        $strController = $objRequest->controller();
        $strAction = $objRequest->action();
//        var_dump($objRequest);
//        TODO:暂未做参数认证规则
//        $strParameter = $objRequest->param();

        $strTablePrefix = config('auth.database.table_prefix');
        $strUserRoleTableName = $strTablePrefix.config('auth.database.table_name.user_role');
        $strRoleTableName = $strTablePrefix.config('auth.database.table_name.role');
        $strRolePermTableName = $strTablePrefix.config('auth.database.table_name.role_perm');
        $strPermTableName = $strTablePrefix.config('auth.database.table_name.perm');

        $intRet = Db::table($strPermTableName)
            ->where('module', '=',$strModule)
            ->where('controller', '=',$strController)
            ->where('action', '=',$strAction)
            ->count();
//        如果有记录则需要进行rule规则判断，否则判断是否为严格模式
        if ($intRet === 0) {
            $strUri = "$strModule/$strController/$strAction";
            $bolStrictMode = config('auth.strict_mode.enabled');
            $arrWhiteList = config('auth.strict_mode.white_list');
            $arrBlackList = config('auth.strict_mode.black_list');
//            如果是严格模式，则放行条件为：在白名单 并且 不在数据库认证规则记录中
            if ($bolStrictMode) {
                return in_array($strUri, $arrWhiteList);
//            如果不是严格模式，则放行条件为：不在黑名单 并且 不在数据库认证规则记录中
            } else {
                return !in_array($strUri, $arrBlackList);
            }
        }

        $arrRet = Db::table($strUserRoleTableName)->alias('ur')
            ->join("$strRoleTableName r", 'ur.role_id = r.id')
            ->join("$strRolePermTableName rp", 'ur.role_id = rp.role_id')
            ->join("$strPermTableName p", 'rp.perm_id')
            ->where('ur.user_id', '=', $intUserId)
            ->where('p.module', '=',$strModule)
            ->where('p.controller', '=',$strController)
            ->where('p.action', '=',$strAction)
//        TODO:暂未做参数认证规则
//            ->where('p.parameter', '=', $strParameter)
            ->find();
//        如果没有记录，表示该用户所属的角色组在该操作方法下没有权限
        if (count($arrRet) === 0) {
            return true;
        } else {
//            有记录，则判断是否存在rule规则验证函数，存在则使用执行该函数的返回值作为验证结果
            $strFuncName = $arrRet['rule_function'];
            if (empty($strFuncName)) {
                return true;
            } else {
//                $strFuncName函数必须返回一个bool类型的值
                return call_user_func(unserialize($strFuncName));
            }
        }
    }

}