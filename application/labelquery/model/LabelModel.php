<?php
namespace app\labelquery\model;
use think\Model;
use think\Db;


class LabelModel extends Model
{
    /**
     * 杨宇
     * 功能：通过标签ID获取标签名称
     * @param
     * @labelid：活动标签id编号
     * return list
     */
    public function getLabelById($labelid = ''){
        $list = DB::table('label_info')
            ->where('l_id', $labelid)
            ->where('l_is_delete',0)
            ->field('l_id, l_name')
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：获取活动所有标签信息
     * @param
     * return list
     */
    public function getAllLabel(){
        $depart = Db::table('label_info')
            ->where('l_is_delete',0)
            ->field('l_id, l_name')
            ->select();
        return $depart;
    }

    /**
     * 杨宇
     * 功能：判断 $name是否存在且已经被删除
     * @$name 标签名
     * return int
     */
    public function isExistAndDel($name = ''){
        // 存在且被删除
        $ret = Db::table('label_info')
            ->where('l_name',$name)
            ->where('l_is_delete',1)
            ->find();
        return $ret;
    }

    /**
     * 杨宇
     * 功能：判断 $name是否存在且未被删除
     * @$name 标签名
     * return int
     */
    public function isExistAndNotDel($name = ''){
        // 存在且未被删除
        $ret = Db::table('label_info')
            ->where('l_name',$name)
            ->where('l_is_delete',0)
            ->find();
        return $ret;
    }

    /**
     * 杨宇
     * 功能：添加一个标签
     * @$name 标签名
     * return int
     */
    public function addLabel($name = ''){
        $data = ['l_name' => $name, 'l_is_delete'=> 0];
        $ret = Db::table('label_info')
            ->insert($data);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：恢复被删除的标签
     * @$name 标签名
     * return int
     */
    public function recoverLabel($name = ''){
        $data = ['l_is_delete' => 0];
        $ret = Db::name('label_info')
            ->where('l_name',$name)
            ->update($data);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：编辑标签信息
     * @$data post数据
     * return int
     */
    public function editLabel($data){
        $ret = Db::table('label_info')
            ->where('l_id', $data['l_id'])
            ->update(['l_name' => $data['l_name']]);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：删除标签信息
     * @$data post数据
     * return int
     */
    public function delLabel($data){
        $ret = Db::table('label_info')
            ->where('l_id',$data['l_id'])
            ->update(['l_is_delete' => 1]);
        return $ret;
    }
}