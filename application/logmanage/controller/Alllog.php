<?php
/**
 * Created by PhpStorm.
 * User: 84333
 * Date: 2019/4/14
 * Time: 0:47
 */

namespace app\logmanage\controller;

use app\common\controller\Common;
use app\logmanage\model\Log as LogModel;

class AllLog extends Common
{
    public function index(){
        $model = new LogModel();
        $info = $model->getAllLog();

        foreach($info as $key=>$value){
            if ($info[$key]['lg_type'] == 1){
                $info[$key]['type'] = '登录';
            }elseif ($info[$key]['lg_type'] == 2){
                $info[$key]['type'] = '添加';
            }elseif ($info[$key]['lg_type'] == 3){
                $info[$key]['type'] = '修改';
            }elseif ($info[$key]['lg_type'] == 4){
                $info[$key]['type'] = '删除';
            }elseif ($info[$key]['lg_type'] == 5){
                $info[$key]['type'] = '导出';
            }
        }

        $this->assign('info',$info);
        return $this->fetch();
    }
}