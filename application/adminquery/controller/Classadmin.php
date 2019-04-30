<?php

namespace app\adminquery\controller;

use app\common\controller\Common;
use app\adminquery\model\AdminModel;
use app\classquery\model\ClassModel;

use think\controller;
use think\Db;
use think\Request;

class ClassAdmin extends Common{
    public function index()
    {
        $label = new AdminModel();
        $info = $label->getClassAdmin(2018, '未名一苑');
        $this->assign('info',$info);

        $class = new ClassModel();
        $classinfo = $class->getAllClass();
        $gradeinfo = $class->getAllGrade();
        $this->assign('classinfo',$classinfo);
        $this->assign('gradeinfo',$gradeinfo);
        return $this->fetch();
    }

    public function addAdmin(){
        $data = input('post.');
        if (empty($data['c_name'])){
            $this->error('输入不可为空');
        }

        // 标签已经存在且未被软删除弹窗提示
        $label = new AdminModel();
        $ret = $label->isExistAndNotDel($data['c_name']);
        if ($ret){
            $this->error('该标签已存在');
            return;
        }

        // 标签已经存在且被软删除时恢复即可
        $ret = $label->isExistAndDel($data['c_name']);
        if ($ret){
            $ret = $label->recoverClass($data['c_name']);
            if ($ret){
                $this->success('该标签被软删除, 恢复成功');
            }else{
                $this->error('该标签被软删除, 恢复失败');
            }
            return;
        }

        // 不存在则添加
        $ret = $label->addAdmin($data['c_name']);
        if ($ret){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }

    public function delAdmin(){
        $data = input('post.');
        $label = new AdminModel();
        $ret = $label->delAdmin($data);
        if($ret){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }

    public function editAdmin(){
        $data = input('post.');
        $label = new AdminModel();
        $ret = $label->editAdmin($data);
        if($ret){
            $this->success('编辑成功！');
        }else{
            $this->error('编辑失败！');
        }
    }
}