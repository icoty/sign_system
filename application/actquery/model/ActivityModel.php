<?php
namespace app\actquery\model;
use think\Model;
use think\Db;


class ActivityModel extends Model
{
    /**
     * 杨宇
     * 功能：获取某管理员创建的所有活动
     * @param
     * @num：管理员主键ID，也是学号
     * return list
     */
    public function getActByNumber($num){
        $list = DB::table('activity_info')
            ->where('a_creator', $num)
            ->where('a_is_delete',0)
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：获取某个班级创建的活动
     * @param
     * @classid：班级id
     * $year 年级
     * return list
     */
    public function getActByClassId($year, $classid){
        $list = DB::table('activity_info')
            ->where('a_class_id', $classid)
            ->where('a_grade', $year)
            ->where('a_is_delete',0)
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：获取某个年级开展的所有活动
     * @param
     * @$year：年级
     * return list
     */
    public function getActByYear($year){
        $list = DB::table('activity_info')
            ->where('a_grade', $year)
            ->where('a_is_delete',0)
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：获取历史以来的所有活动
     * @param
     * return list
     */
    public function getAllAct(){
        $list = DB::table('activity_info')
            ->where('a_is_delete',0)
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：添加活动
     * @$data post数据
     * return int
     */
    public function addAct($data){
        $ret = Db::table('activity_info')
            ->insert($data);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：编辑活动
     * @$data post数据
     * return int
     */
    public function editAct($data){
        // to do
        $ret = Db::table('activity_info')
            ->where('a_id', $data['a_id'])
            ->update($data);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：删除活动所有标签 act2label表
     * @$actid 活动id
     * return int
     */
    public function delActLabel($actid){
        $ret = Db::table('act2label')
            ->where('a2l_act_id',$actid)
            ->update(['a2l_is_delete' => 1]);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：删除活动,同时需要删除活动的标签act2label表
     * @$data post数据
     * return int
     */
    public function delAct($data){
        //ret = $this->delActLabel($data['a_id']);
        //if($ret){
            $ret = Db::table('activity_info')
                ->where('a_id',$data['a_id'])
                ->update(['a_is_delete' => 1]);
        //}
        return $ret;
    }

    /**
     * 杨宇
     * 功能：编辑活动标签
     * @$actid 活动id
     * return int
     */
    public function editActLabel($data){
        // todo
        $ret = Db::table('act2label')
            ->where('a2l_act_id',$actid)
            ->update(['a2l_is_delete' => 1]);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：获取活动的所有标签信息
     * @$data post数据
     * return int
     */
    public function getActLabel($id){
        $ret = Db::table('act2label')
            ->where('a2l_act_id',$id)
            ->where('a2l_is_delete', 0)
            ->field('a2l_act_id,a2l_label_id')
            ->select();
        return $ret;
    }
}