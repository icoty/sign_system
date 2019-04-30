<?php

namespace app\classquery\controller;

use app\common\controller\Common;
use app\classquery\model\ClassModel;

use think\controller;
use think\Db;
use think\Request;

class Classinfo extends Common{
    public function index()
    {
        $label = new ClassModel();
        $info = $label->getAllClass();
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function addClass(){
        $data = input('post.');
        if (empty($data['c_name'])){
            $this->error('输入不可为空');
        }

        // 标签已经存在且未被软删除弹窗提示
        $label = new ClassModel();
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
        $ret = $label->addClass($data['c_name']);
        if ($ret){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }

    public function delClass(){
        $data = input('post.');
        $label = new ClassModel();
        $ret = $label->delClass($data);
        if($ret){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }

    public function editClass(){
        $data = input('post.');
        $label = new ClassModel();
        $ret = $label->editClass($data);
        if($ret){
            $this->success('编辑成功！');
        }else{
            $this->error('编辑失败！');
        }
    }
}