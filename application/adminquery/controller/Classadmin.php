<?php

namespace app\adminquery\controller;

use app\attendquery\model\AttendModel;
use app\common\controller\Common;
use app\adminquery\model\AdminModel;
use app\classquery\model\ClassModel;

use app\logmanage\model\Log as LogModel;
use think\controller;
use think\Db;
use think\Request;
use think\Session;

class ClassAdmin extends Common{
    public function index()
    {
        $admin = new AdminModel();
        $class = new ClassModel();

        $cid = $admin->getClassId(Session::get('admin_id'));
        $info = $admin->getClassAdmin($cid['m_class_id']);
        foreach ($info as $key => $value) {
            $info[$key]['m_class'] = '';
            $info[$key]['privilege'] = '';
            $ret = $class->getClassById($info[$key]['m_class_id']);
            if($ret){
                $info[$key]['m_class'] = $ret['c_name'];  # 创建者姓名
            }

            if($info[$key]['m_privilege'] == 1){
                $info[$key]['privilege'] = '超管';
            }else if($info[$key]['m_privilege'] == 2){
                $info[$key]['privilege'] = '教职工';
            }else if($info[$key]['m_privilege'] == 3){
                $info[$key]['privilege'] = '普通管理员';
            }
        }
        $this->assign('info',$info);
        $this->assign('admin_id',Session::get('admin_id'));

        $classinfo = $class->getAllClass();
        $gradeinfo = $class->getAllGrade();
        $this->assign('classinfo',$classinfo);
        $this->assign('gradeinfo',$gradeinfo);
        return $this->fetch();
    }

    public function delAdmin(){
        $data = input('post.');
        $label = new AdminModel();
        $ret = $label->delAdmin($data);
        if($ret){
            $model = new LogModel();
            $uid = Session::get('admin_id'); // 操作人主键id，非学号
            $type = 4;
            $table = 'manager_info';
            $field =[$data['m_id'] => ['m_is_delete' => [0,1]]]; // 删除的主键列表, 不是学号
            $ret = $model->recordLogApi ($uid, $type, $table, $field); //需要判断调用是否成功
            if($ret) {
                $this->success('删除成功, 日志记录成功');
            }else{
                $this->error('删除成功, 日志记录失败');
            }
        }else{
            $this->error('删除失败！');
        }
    }

    public function editLogJson($old, $new){
        $log = array();

        if($new['m_name'] != $old['m_name']){
            $item = ['m_name' => [$old['m_name'], $new['m_name']]];
            $log[] = $item;
        }
        if($new['m_id'] != $old['m_id']){
            $item = ['m_id' => [$old['m_id'], $new['m_id']]];
            $log[] = $item;
        }
        if($new['m_class_id'] != $old['m_class_id']){
            $item = ['m_class_id' => [$old['m_class_id'], $new['m_class_id']]];
            $log[] = $item;
        }
        if($new['m_grade'] != $old['m_grade']){
            $item = ['m_grade' => [$old['m_grade'], $new['m_grade']]];
            $log[] = $item;
        }
        return $log;
    }


    public function editAdmin(){
        $data = input('post.');
        unset($data['m_num']);
        $data['m_name'] = trim($data['m_name']);
        dump($data);

        $label = new AdminModel();
        $old = $label->getAdminInfoByNum($data['m_id']);
        $logJson = $this->editLogJson($old, $data);

        if($logJson) {
            dump($logJson);
            $ret = $label->editAdmin($data);
            if ($ret) {
                $model = new LogModel();
                $uid = $uid = Session::get('admin_id'); // 操作人主键id，非学号
                $type = 3;
                $table = 'manager_info';
                $field = [
                    $data['m_id'] => $logJson
                ];
                $ret = $model->recordLogApi($uid, $type, $table, $field); //需要判断调用是否成功
                if($ret) {
                    $this->success('编辑成功, 日志记录成功');
                }else{
                    $this->error('编辑成功, 日志记录失败');
                }
            } else {
                $this->error('编辑失败！');
            }
            return;
        }else{
            $this->error('未做任何修改！');
        }
    }
}