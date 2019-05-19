<?php

namespace app\classquery\controller;
use app\actquery\model\ActivityModel;
use app\adminquery\model\AdminModel;
use app\logmanage\model\Log as LogModel;
use app\common\controller\Common;
use app\classquery\model\ClassModel;

use think\controller;
use think\Db;
use think\Request;
use think\Session;

class Classinfo extends Common{
    public function index()
    {
        $label = new ClassModel();
        $info = $label->getAllClass();
        $this->assign('info',$info);

        $admin = new AdminModel();
        // 获取当前用户的姓名和和班级信息传给前端
        $userInfo = $admin->getInfoByNum(Session::get('admin_id'));
        if($userInfo){
            $this->assign('userInfo', $userInfo);
        }
        return $this->fetch();
    }

    public function addClass(){
        $data = input('post.');
        if (empty(trim($data['c_name']))){
            $this->error('输入不可为空');
        }

        // 标签已经存在且未被软删除弹窗提示
        $label = new ClassModel();
        $ret = $label->isExistAndNotDel(trim($data['c_name']));
        if ($ret){
            $this->error('该标签已存在');
            return;
        }

        // 标签已经存在且被软删除时恢复即可
        $id = $label->isExistAndDel(trim($data['c_name']));
        if ($id){
            $ret = $label->recoverClass(trim($data['c_name']));
            if($ret){
                $model = new LogModel();
                $uid = Session::get('admin_id');; // 操作人主键id，非学号
                $type = 3;
                $table = 'class_info';
                $field = [$id['c_id'] => ['c_is_delete' => [1, 0]]]; // 删除的主键列表, 不是学号
                $ret = $model->recordLogApi($uid, $type, $table, $field); //需要判断调用是否成功
                if (!$ret) {
                    $this->error('该标签被软删除,恢复成功,日志记录失败！');
                } else {
                    $this->success('该标签被软删除,恢复成功,日志记录成功！');
                }
            }else{
                $this->error('该标签被软删除, 恢复失败');
            }
            return;
        }

        // 不存在则添加
        $id = $label->addClass(trim($data['c_name']));
        if ($id){
            $model = new LogModel();
            $uid = Session::get('admin_id'); // 操作人主键id，非学号
            $type = 2;
            $table = 'class_info';
            $field = [$id]; // 增加的主键列表，不是学号
            $ret = $model->recordLogApi ($uid, $type, $table, $field); //需要判断调用是否成功
            if($ret){
                $this->success('添加成功,记录日志成功!');
            }else{
                $this->error('添加成功,记录日志失败!');
            }
            return;
        }else{
            $this->error('添加失败');
        }
    }

    public function delClass(){
        $data = input('post.');
        $label = new ClassModel();
        $ret = $label->delClass($data);
        if($ret){
            $model = new LogModel();
            $uid = Session::get('admin_id');; // 操作人主键id，非学号
            $type = 4;
            $table = 'class_info';
            $field = [$data['c_id'] => ['c_is_delete' => [0, 1]]]; // 删除的主键列表, 不是学号
            $ret = $model->recordLogApi($uid, $type, $table, $field); //需要判断调用是否成功
            if (!$ret) {
                $this->error('删除成功,日志记录失败！');
            } else {
                $this->success('删除成功,日志记录成功！');
            }
        }else{
            $this->error('删除失败！');
        }
    }

    public function editClass(){
        $data = input('post.');
        $label = new ClassModel();
        $ret = $label->getClassById($data['c_id']);
        if(!$ret){
            $this->error('编辑失败,请重试！');
        }

        $old = $ret['c_name'];
        $new = trim($data['c_name']);
        if ($old != $new) {
            $data['c_name'] = $new; // trim处理
            $ret = $label->editClass($data);
            if ($ret) {
                $model = new LogModel();
                $uid = Session::get('admin_id'); // 操作人主键id，非学号
                $type = 3;
                $table = 'class_info';
                $field = [
                    $data['c_id'] => ['c_name' => [$old, $new]]
                ];

                $ret = $model->recordLogApi($uid, $type, $table, $field); //需要判断调用是否成功
                if(!$ret) {
                    $this->error('编辑成功，日志记录失败！');
                }else{
                    $this->success('编辑成功，日志记录成功！');
                }
            } else {
                $this->error('编辑失败！');
            }
        }else{
            $this->error('未做任何修改！');
        }
    }
}