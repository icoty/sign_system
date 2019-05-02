<?php

namespace app\labelquery\controller;

use app\common\controller\Common;
use app\labelquery\model\LabelModel;

use think\controller;
use think\Db;
use think\Request;

class Labelinfo extends Common{
    public function index()
    {
        $label = new LabelModel();
        $info = $label->getAllLabel();
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function addLabel(){
        $data = input('post.');
        if (empty($data['l_name'])){
            $this->error('输入不可为空');
        }

        // 标签已经存在且未被软删除弹窗提示
        $label = new LabelModel();
        $ret = $label->isExistAndNotDel($data['l_name']);
        if ($ret){
            $this->error('该标签已存在');
            return;
        }

        // 标签已经存在且被软删除时恢复即可
        $ret = $label->isExistAndDel($data['l_name']);
        if ($ret){
            $ret = $label->recoverLabel($data['l_name']);
            if ($ret){
                $this->success('该标签被软删除, 恢复成功');
            }else{
                $this->error('该标签被软删除, 恢复失败');
            }
            return;
        }

        // 不存在则添加
        $ret = $label->addLabel($data['l_name']);
        if ($ret){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }

    public function delLabel(){
        $data = input('post.');
        $label = new LabelModel();
        $ret = $label->delLabel($data);
        if($ret){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }

    public function editLabel(){
        $data = input('post.');
        $label = new LabelModel();
        $ret = $label->editLabel($data);
        if($ret){
            $this->success('编辑成功！');
        }else{
            $this->error('编辑失败！');
        }
    }
}