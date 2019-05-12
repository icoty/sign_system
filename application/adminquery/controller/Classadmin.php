<?php

namespace app\adminquery\controller;

use app\attendquery\model\AttendModel;
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
        $class = new ClassModel();

        $info = $label->getClassAdmin(2018,1);
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
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }

    public function editAdmin(){
        $data = input('post.');
        dump($data);
        $label = new AdminModel();
        $ret = $label->editAdmin($data);
        if($ret){
            $this->success('编辑成功！');
        }else{
            $this->error('编辑失败！');
        }
    }
}