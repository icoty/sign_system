<?php
namespace app\adminquery\model;
use think\Model;
use think\Db;

class AdminModel extends Model
{
    /**
     * 杨宇
     * 功能：通过管理员ID获取个人详细信息
     * @param
     * @$num：管理员学号
     * return list
     */
    public function getInfoByNum($num){
        $list = DB::table('manage_info')
            ->alias('m')
            ->join('class_info c', 'm.m_class_id = c.c_id')
            ->where('c.c_is_delete',0)
            ->where('m.m_is_delete',0)
            ->where('m.m_id',$num)
            ->find();
        return $list;
    }

    /**
     * 杨宇
     * 功能：通过学号获取姓名
     * @param
     * @$num：管理员学号
     * return list
     */
    public function getNameByNum($num){
        $list = DB::table('manage_info')
            ->where('m_id', $num)
            ->where('m_is_delete',0)
            ->field('m_id,m_name')
            ->find();
        return $list;
    }

    /**
     * 杨宇
     * 功能：通过某个班级和年级获取班上所有管理员
     * @param
     * @$year：年级
     * @$cid: 班级id
     * return list
     */
    public function getClassAdmin($year, $cid){
        $list = Db::table('manage_info')
            ->where('m_grade', $year)
            ->where('m_class_id', $cid)
            ->where('m_is_delete',0)
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：获取所有管理员信息
     * @param
     * return list
     */
    public function getAllAdmin(){
        $ret = Db::table('manage_info')
            ->where('m_is_delete',0)
            ->order("m.m_grade desc")
            ->select();
        return $ret;
    }

    /**
     * 杨宇
     * 功能：判断 $num是否存在且被删除
     * @$num 学号
     * return int
     */
    public function isExistAndDel($num){
        $ret = Db::table('manage_info')
            ->where('m_id',$num)
            ->where('m_is_delete',1)
            ->find();
        return $ret;
    }

    /**
     * 杨宇
     * 功能：判断 $num是否存在且未被删除
     * @$num 学号
     * return int
     */
    public function isExistAndNotDel($num){
        $ret = Db::table('manage_info')
            ->where('m_id',$num)
            ->where('m_is_delete',0)
            ->find();
        return $ret;
    }

    /**
     * 杨宇
     * 功能：添加管理员
     * @$name 班级名称
     * return int
     */
    public function addAdmin($data){
        $ret = Db::table('manage_info')
            ->insert($data);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：恢复被删除的管理员
     * @$num 管理员学号
     * return int
     */
    public function recoverAdmin($num){
        $data = ['m_is_delete' => 0];
        $ret = Db::name('manage_info')
            ->where('m_id',$num)
            ->update($data);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：编辑管理员信息
     * @$data post数据
     * return int
     */
    public function editAdmin($data){
        $ret = Db::table('manage_info')
            ->where('m_id', $data['m_id'])
            ->update(['m_name' => $data['m_name']]);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：删除管理员
     * @$data post数据
     * return int
     */
    public function delAdmin($data){
        $ret = Db::table('manege_info')
            ->where('m_id',$data['m_id'])
            ->update(['m_is_delete' => 1]);
        return $ret;
    }
}