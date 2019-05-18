<?php
namespace app\login\model;
use think\Model;
use think\Db;

class Mobile extends Model
{
    public function addMobile($id, $mobile)
    {
        $res = Db::name('manage_info')->where('m_id', $id)->update(['m_telephone' => $mobile]);
        return $res;
    }

    public function hasMobile($telephone)
    {
        $ret = Db::name('manage_info')->where('m_telephone', $telephone)->select();
        return $ret;
    }
}
