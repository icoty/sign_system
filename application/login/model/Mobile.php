<?php
namespace app\login\model;
use think\Model;
use think\Db;

class Mobile extends Model
{

    public function addMobile($id, $mobile)
    {
        $res = Db::name('manage_info')->where('id', $id)->update(['mobilephone' => $mobile]);
        return $res;
    }


    public function hasMobile($telephone)
    {
        $data = Db::name('manage_info')->where('telephone', $telephone)->select();//查询对应管理员的记录
        if (empty($data)) return false;
        else return true;
    }
}
