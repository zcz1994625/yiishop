<?php

namespace backend\controllers;


use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\web\Controller;

class RbacController extends Controller
{
    /**
     * 权限列表
     */
    public function actionPermissionIndex(){
        //获取所有权限
        $authManager = \yii::$app->authManager;
        $permissions = $authManager->getPermissions();
        return $this->render('permissionIndex',['permissions'=>$permissions]);
    }
    /**
     *权限的添加
     *
     */
    public function actionAddPermission(){
        //实例化表单模型
        $model = new PermissionForm();

        if($model->load(\yii::$app->request->post()) && $model->validate()){
            //实例化rbac
            $authManager = \yii::$app->authManager;
            //创建权限
            $permission = $authManager->createPermission($model->name);
            $permission->description = $model->description;
            //添加到数据库
            if($authManager->add($permission)){
                //权限添加成功
                \yii::$app->session->setFlash('success',$permission->description.'权限添加成功');
                return $this->redirect(['rbac/permission-index']);
            }
        }
        return $this->render('addPermission',['model'=>$model]);
    }
    /**
     * 权限的删除
     */
    public function actionPermissionDel($name){
        //获取权限
        $authManager = \yii::$app->authManager;
        $permission = $authManager->getPermission($name);
        //删除
        $authManager->remove($permission);
        \yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['rbac/permission-index']);
    }
    /**
     * 角色列表
     */
    public function actionRoleIndex(){
        //获取所有角色
        $authManager = \yii::$app->authManager;
        $roles = $authManager->getRoles();
        return $this->render('roleIndex',['roles'=>$roles]);
    }
    /**
     * 角色添加
     */
    public function actionAddRole(){
        //实例化表单模型
        $model = new RoleForm();
        //指定场景
        $model->scenario = RoleForm::SCENARIO_ADD;
        if($model->load(\yii::$app->request->post()) && $model->validate()){
            //实例化rbac
            $authManager = \yii::$app->authManager;
            //创建角色
            $role = $authManager->createRole($model->name);
            $role->description = $model->description;
            //添加到数据表
            $authManager->add($role);
            //给角色关联权限
            //var_dump($model->permissions);exit;
            foreach($model->permissions as $permission){
                //addchild ---- 给角色赋予权限
                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            \yii::$app->session->setFlash('success','角色添加成功');
            return $this->redirect(['rbac/role-index']);

        }
        return $this->render('addRole',['model'=>$model]);
    }
    /**
     * 角色删除
     */
    public function actionRoleDel($name){
        $authManager = \yii::$app->authManager;
        $role = $authManager->getRole($name);
        //删除
        $authManager->remove($role);
        \yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['rbac/role-index']);
    }
    /**
     * 角色修改
     */
    public function actionRoleEdit($name){
        $model = new RoleForm();
        $authManager = \yii::$app->authManager;
        //获取要修改的角色
        $role = $authManager->getRole($name);
        //赋值
        $model->name = $role->name;
        $model->description = $role->description;
        //根据角色名字获取对应的权限
        $permissions = $authManager->getPermissionsByRole($role->name);
        //将获取到的权限改为键=>值得格式
        $model->permissions = array_keys($permissions);
        if($model->load(\yii::$app->request->post()) && $model->validate()){
            //名字不可以修改
            $role->description = $model->description;
            //更新到数据表
            $authManager->update($role->name,$role);
            //清楚之前关联的权限
            $authManager->removeChildren($role);
            //再循环赋值
            foreach($model->permissions as $permission){
                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            \yii::$app->session->setFlash('success','更新成功');
            return $this->redirect(['rbac/role-index']);
        }
        return $this->render('addRole',['model'=>$model]);
    }
}