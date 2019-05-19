<?php
namespace app\attendquery\model;
use think\Model;
use think\Db;

class AttendModel extends Model
{
    /**
     * 杨宇
     * 功能：获取某个学生参加的所有活动
     * @param
     * @num：学号
     * return list
     */
    public function getActByNumber($num){
        $list = DB::table('act2stu')
            ->alias('s')
            ->join('activity_info a', 's.a2s_act_id = a.a_id')
            ->where('s.a2s_is_delete',0)
            ->where('a.a_is_delete',0)
            ->where('a.a2s_stu_num',$num)
            ->order("s.a2s_create_time desc")
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：获取某个班开展的活动的出席情况
     * @param
     * @$cid：班级id
     * $year 年级
     * return list
     */
    public function getClassActAttend($cid){
        $list = DB::table('act2stu')
            ->alias('s')
            ->join('activity_info a', 's.a2s_act_id = a.a_id')
            ->where('s.a2s_is_delete',0)
            ->where('a.a_is_delete',0)
            ->where('a.a_class_id',$cid)
            ->order("s.a2s_create_time desc")
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
    public function getActAttendByYear($year){
        $list = DB::table('act2stu')
            ->alias('s')
            ->join('activity_info a', 's.a2s_act_id = a.a_id')
            ->where('s.a2s_is_delete',0)
            ->where('a.a_is_delete',0)
            ->where('a.a_grade',$year)
            ->order("s.a2s_create_time desc")
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：获取所有活动的的出席情况
     * @param
     * return list
     */
    public function getAllActAttend(){
        $list = DB::table('act2stu')
            ->alias('s')
            ->join('activity_info a', 's.a2s_act_id = a.a_id')
            ->where('s.a2s_is_delete',0)
            ->where('a.a_is_delete',0)
            ->order("s.a2s_create_time desc")
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：签入
     * @$data post数据
     * return int
     */
    public function signIn($data){
        // 更新签到时间段
        $ret = Db::table("act2stu")
            ->insert(['a2s_act_id'=>$data['a_id'],
                'a2s_stu_num'=>$data['a2s_stu_num'],
                'a2s_stu_name'=>$data['a2s_stu_name'],
                'a2s_sign_time'=>date('Y-m-d H:i:s', time()),
                'a2s_is_delete'=>$data['a2s_is_delete']]);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：扫码签到
     * @$data post数据
     * return int
     */
    public function addAttend($data){
        // 需要判断是否已经存在
        $ret = Db::table("act2label")
            ->where('a2l_act_id', $aid)
            ->where('a2l_label_id', (int)$list[$i])
            ->where('a2l_is_delete', 1)
            ->count();
        $ret = Db::table('act2stu')
            ->insert($data);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：修改信息
     * @$data post数据
     * return int
     */
    public function editAttend($data){
        $ret = Db::table('act2stu')
            ->where('a2s_id', $data['a2s_id'])
            ->update($data);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：删除某个活动的所有出席情况
     * @$actid 活动id
     * return int
     */
    public function delAttenByActId($actid){
        $ret = Db::table('act2stu')
            ->where('a2s_act_id',$actid)
            ->update(['a2s_id_delete' => 1]);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：删除一条数据
     * @$a2sid 活动id
     * $num 参加者学号
     * return int
     */
    public function delOneAttend($a2sid){
        $ret = Db::table('act2stu')
            ->where('a2s_act_id',$a2sid)
            ->update(['a2s_is_delete' => 1]);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：判断某个学生是否已经签到了某个活动
     * @$aid 活动id
     * $stunum 学号
     * $num 参加者学号
     * return int
     */
    public function signIsExist($aid,$stunum){
        $ret = Db::table('act2stu')
            ->where('a2s_act_id',$aid)
            ->where('a2s_stu_num',$stunum)
            ->where('a2s_is_delete',0)
            ->count();
        //dump($ret);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：导入签到记录
     * $data
     * return int
     */
    public function importAttend($data){
        //dump($data);

        $ret = Db::table('act2stu')
            ->insertAll($data);
        return $ret;
    }
}