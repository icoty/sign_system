<?php

namespace app\actquery\controller;

use app\attendquery\model\AttendModel;
use think\controller;
use think\Db;
use app\classquery\model\ClassModel;
use app\common\controller\Common;
use app\actquery\model\ActivityModel;
use app\adminquery\model\AdminModel;
use app\labelquery\model\LabelModel;

class Startsign extends Common{
    public function index()
    {
        // 下发签到时间段写到数据库
        $data = input('get.');
        //dump($data);
        if($data['a_start_sign'] >= $data['a_end_sign']){
            $this->error('开始签到时间点必须小于截止签到的时间点！');
        }

        $act = new ActivityModel();
        $ret = $act->editStartEndSignTime($data);
        if(!$ret){
            $this->error('设置签到时间段失败！');
        }

        // 活动ID:a_id需要关联到url
        Vendor('phpqrcode.phpqrcode');
        \QRcode::png('http://localhost:81/public/index.php/actquery/classact/signIn?a_id='.$data['a_id'],false,2,10,2);
        die;
    }

    public function signIn(){
        // 扫码签到
        $data = input('post.');
        dump($data);

        $data = date('Y-m-d H:i:s', time());
        $act = new ActivityModel();
        $act->getStartAdnEndTime($data);
        if($data < $data['a_start_sign']){
            $this->error('签到还未开始！');
        }else if($data > $data['a_end_sign']){
            $this->error('签到已关闭！');
        }

        return;

        $att = new AttendModel();
        $ret = $att->signIn($data);
        if($ret){
            $this->success('签到成功！');
        }else{
            $this->error('签到失败！');
        }
    }
}