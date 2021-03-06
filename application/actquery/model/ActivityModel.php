<?php
namespace app\actquery\model;
use think\Model;
use think\Db;
use app\labelquery\model\LabelModel;

class ActivityModel extends Model
{

    /**
     * 杨宇
     * 功能：获取某班的所有活动
     * @param
     * @$cid：班级id 班级格式如：2018未名一苑
     * return list
     */
    public function getActByClassId($cid){
        $list = DB::table('activity_info')
            ->where('a_class_id', $cid)
            ->where('a_is_delete',0)
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：
     * @param
     * @$cid：班级id 班级格式如：2018未名一苑
     * return list
     */
    public function getActByActId($id){
        $list = DB::table('activity_info')
            ->where('a_id', $id)
            ->where('a_is_delete',0)
            ->find();
        return $list;
    }

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
     * 功能：添加活动,同时需要添加活动对应的标签
     * @$data post数据
     * return int
     */
    public function addAct($data){
        $id = Db::table('activity_info')
            ->insertGetId(['a_creator' => $data['a_creator'],
                'a_name' => $data['a_name'],
                'a_place' => $data['a_place'],
                'a_start_time' => $data['a_start_time'],
                'a_end_time' => $data['a_end_time'],
                'a_content' => $data['a_content'],
                'a_grade' => $data['a_grade'],
                'a_class_id' => $data['a_class_id'],
                'a_is_delete' => $data['a_is_delete']]);
        return $id;
    }

    /**
     * 杨宇
     * 功能：编辑活动,同时需要编辑活动对应的标签
     * @$data post数据
     * return int
     */
    public function editAct($data){
        // to do
        $ret = Db::table('activity_info')
            ->where('a_id', $data['a_id'])
            ->update(['a_creator' => $data['a_creator'],
                'a_name' => $data['a_name'],
                'a_place' => $data['a_place'],
                'a_start_time' => $data['a_start_time'],
                'a_end_time' => $data['a_end_time'],
                'a_content' => $data['a_content'],
                'a_grade' => $data['a_grade'],
                'a_class_id' => $data['a_class_id'],
                'a_is_delete' => $data['a_is_delete']]);
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
     * 功能：删除活动,,同时需要添加活动对应的标签
     * @$data post数据
     * return int
     */
    public function delAct($data){
        // 首先删除活动所有标签
        $label = new LabelModel();
        $ret = $label->delLabelByActId($data['a_id']);
        if(!$ret)
            return $ret;

        // 删除活动
        $ret = Db::table('activity_info')
            ->where('a_id',$data['a_id'])
            ->update(['a_is_delete' => 1]);
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

    /**
     * 杨宇
     * 功能：编辑活动,同时需要编辑活动对应的标签
     * $aid 活动id
     * $str 标签字符串
     * return int
     */
    public function editActLabelStr($aid,$str){
        $ret = Db::table('activity_info')
            ->where('a_id', $aid)
            ->where('a_label',$str)
            ->count();
        if($ret){ // 已经存在不做任何处理
            //echo "a_label not change";
            return 1;
        }else{
            $ret = Db::table('activity_info')
                ->where('a_id', $aid)
                ->update(['a_label'=>$str]);
        }
        return $ret;
    }

    /**
     * 杨宇
     * 功能：设置签到的时间段
     * @$data post数据
     * return int
     */
    public function editStartEndSignTime($data){
        //dump($data);
        // 判断设置的时间是否已经存在,$data需要转换，否则存在相同的记录也会返回false
        $ret = Db::table("activity_info")
            ->where('a_id',$data['a_id'])
            ->where('a_is_delete', 0)
            ->where('a_start_sign', $data['a_start_sign'])
            ->where('a_end_sign', $data['a_end_sign'])
            ->count();
        //dump($ret);
        if($ret){
            // 下发的请求未做任何修改，直接返回
            return 1;
        }else{
            //dump('2222');
            // 更新签到时间段
            $ret = Db::table("activity_info")
                ->where('a_id',$data['a_id'])
                ->where('a_is_delete', 0)
                ->update(['a_start_sign'=>$data['a_start_sign'],
                    'a_end_sign'=>$data['a_end_sign']]);
            //dump($ret);

        }
        return 1;
    }

    /**
     * 杨宇
     * 功能：获取开始签到和截止签到的时间
     * @$data post数据
     * return int
     */
    public function getStartAdnEndTime($data){
        // 判断设置的时间是否已经存在
        $ret = Db::table("activity_info")
            ->where('a_id',$data['a_id'])
            ->where('a_is_delete', 0)
            ->field('a_start_sign，a_end_sign')
            ->find();
        return $ret;
    }

    /**
     * 杨宇
     * 功能：添加活动标签,必须同时去修改活动标签字段
     * @$data post数据
     * $aid 活动id
     * return int
     */
    public function addActLabel($aid, $data){
        $keys = array_keys($data);
        for($i=0;$i<count($keys);$i++){
            if(is_numeric($keys[$i])){
                $ret = Db::table('act2label')->insert(['a2l_act_id'=>$aid,'a2l_label_id'=>$keys[$i],'a2l_is_delete'=>0]);
                if(!$ret)
                    return 0;
            }
        }

        // 获取活动的所有标签名称并拼接为字符串
        $label = new LabelModel();
        $info = $label->getActLabelName($aid);
        //dump($info);
        $str = '';
        foreach ($info as $key => $value) {
            $str = $str.' '.$info[$key]['l_name'];
        }

        //去除首尾空格后更新
        $ret = $this->editActLabelStr($aid,trim($str));
        return $ret;
    }

    public function updateAllActLabelStr(){
        $list = Db::table('activity_info')
            ->field('a_id')
            ->select();

        foreach ($list as $key1 => $value1) {
            // 获取活动的所有标签名称并拼接为字符串
            $label = new LabelModel();
            $aid = $list[$key1]['a_id'];
            $info = $label->getActLabelName($aid);
            //dump($info);
            $str = '';
            foreach ($info as $key => $value) {
                $str = $str.' '.$info[$key]['l_name'];
            }

            //去除首尾空格后更新
            $ret = $this->editActLabelStr($aid,trim($str));
            if(!$ret)
                return 0;
        }

        return 1;
    }

}