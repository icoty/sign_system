<?php

namespace app\common\model;

use think\Db;
use think\Model;

class Common extends Model
{

    public function get_menu_id($module,$controller,$action){
        $menu_id = Db::table('menu')->where('mu_module',$module)
            ->where('mu_controller',$controller)
            ->where('mu_action',$action)
            ->field('mu_id')
            ->find();
        return $menu_id['mu_id'];
    }
    public function get_menu_info(){
        $menu_info = Db::table('menu')->where('mu_is_delete',0)
            ->order('mu_number')
            ->select();
        return $menu_info;
    }
}