<?php

namespace app\labelquery\controller;
use app\actquery\model\ActivityModel;
use app\adminquery\model\AdminModel;
use app\logmanage\model\Log as LogModel;
use think\Session;

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

        $admin = new AdminModel();
        // 获取当前用户的姓名和和班级信息传给前端
        $userInfo = $admin->getInfoByNum(Session::get('admin_id'));
        if($userInfo){
            $this->assign('userInfo', $userInfo);
        }
        return $this->fetch();
    }

    public function addLabel()
    {
        $data = input('post.');
        if (empty($data['l_name'])) {
            $this->error('输入不可为空');
        }

        $name = trim($data['l_name']);
        // 标签已经存在且未被软删除弹窗提示
        $label = new LabelModel();
        $ret = $label->isExistAndNotDel($name);
        if ($ret) {
            $this->error('该标签已存在');
            return;
        }

        // 标签已经存在且被软删除时恢复即可
        $id = $label->isExistAndDel($name);
        if ($id) {
            $ret = $label->recoverLabel($name);
            if ($ret) {
                $model = new LogModel();
                $uid = Session::get('admin_id');; // 操作人主键id，非学号
                $type = 3;
                $table = 'label_info';
                $field = [$id['l_id'] => ['l_is_delete' => [1, 0]]]; // 删除的主键列表, 不是学号
                $ret = $model->recordLogApi($uid, $type, $table, $field); //需要判断调用是否成功
                if (!$ret) {
                    $this->error('该标签被软删除,恢复成功,日志记录失败！');
                } else {
                    $this->success('该标签被软删除,恢复成功,日志记录成功！');
                }
            }else{
                $this->error('该标签被软删除,恢复失败！');
            }
            return;
        }
        // 不存在则添加
        $lid = $label->addLabel($name);
        if ($lid) {
            $model = new LogModel();
            $uid = Session::get('admin_id'); // 操作人主键id，非学号
            $type = 2;
            $table = 'label_info';
            $field = [$lid]; // 增加的主键列表，不是学号
            $ret = $model->recordLogApi($uid, $type, $table, $field); //需要判断调用是否成功
            if (!$ret) {
                $this->error('添加成功，日志记录失败！');
            } else {
                $this->success('添加成功，日志记录成功！');
            }
        } else {
            $this->error('添加失败！');
        }
    }

    public function delLabel(){
        $data = input('post.');
        $label = new LabelModel();
        $ret = $label->delLabel($data);
        if($ret){
            $model = new LogModel();
            $uid = Session::get('admin_id');; // 操作人主键id，非学号
            $type = 4;
            $table = 'label_info';
            $field =[$data['l_id'] => ['l_is_delete' => [0, 1]]]; // 删除的主键列表, 不是学号
            $ret = $model->recordLogApi ($uid, $type, $table, $field); //需要判断调用是否成功
            if(!$ret) {
                $this->error('删除成功，日志记录失败！');
            }else{
                $this->success('删除成功，日志记录成功！');
            }
        }else{
            $this->error('删除失败！');
        }
    }

    public function editLabel()
    {
        $data = input('post.');
        $label = new LabelModel();
        $ret = $label->getLabelById($data['l_id']);
        if(!$ret){
            $this->error('编辑失败,请重试！');
        }

        $old = $ret[0]['l_name'];
        $new = trim($data['l_name']);

        if ($old != $new) {
            $ret = $label->editLabel($data);
            if ($ret) {
                // 更新所有活动的标签字段
                $act = new ActivityModel();
                $ret = $act->updateAllActLabelStr();
                if(!$ret){
                    echo "更新所有活动标签字段失败！";
                }

                $model = new LogModel();
                $uid = Session::get('admin_id'); // 操作人主键id，非学号
                $type = 3;
                $table = 'label_info';
                $field = [
                    $data['l_id'] => ['l_name' => [$old, $new]]
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