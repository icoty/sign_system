<?php
namespace app\labelquery\model;
use think\Model;
use think\Db;
use app\actquery\model\ActivityModel;

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
     * 功能：获取活动所有标签名称
     * @param
     * return list
     * $aid 活动id
     */
    public function getActLabelName($aid){
        $list = DB::table('label_info')
            ->alias('l')
            ->join('act2label a2l', 'a2l.a2l_label_id = l.l_id')
            ->where('a2l.a2l_is_delete',0)
            ->where('l.l_is_delete',0)
            ->where('a2l.a2l_act_id',$aid)
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

    /**
     * 杨宇
     * 功能：删除活动的所有标签信息
     * @$data post数据
     * return int
     */
    public function delLabelByActId($aid){
        $ret = Db::table('act2label')
            ->where('a2l_act_id',$aid)
            ->update(['a2l_is_delete' => 1]);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：传入活动id去更新活动表的标签字符串字段
     * @param
     * return list
     * $aid 活动id
     */
    public function updateActLabelStr($aid){
        // 获取活动的所有标签名称并拼接为字符串
        $info = $this->getActLabelName($aid);
        dump($info);
        $str = '';
        foreach ($info as $key => $value) {
            $str = $str.' '.$info[$key]['l_name'];
        }

        //去除首尾空格后更新
        $act = new ActivityModel();
        $ret = $act->editActLabelStr($aid,trim($str));
        return $ret;
    }

    /**
     * 杨宇
     * 功能：获取活动id的所有标签id
     * @param
     * $aid 活动id
     * return list
     * $aid 活动id
     */
    public function getAllLabelIdByActId($aid){
        $list = DB::table('act2label')
            ->where('a2l_act_id',$aid)
            ->where('a2l_is_delete',0)
            ->field('a2l_label_id')
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：根据活动id编辑标签信息,同时需要去修改活动表的标签字符串
     * @$data post数据
     * $aid 活动id
     * $idlist 标签id之间用空格隔开
     * return int
     */
    public function editLabelByActId($aid,$idlist){
        $list = explode(" ", $idlist);  // 新传入的标签用于更新
        $info = $this->getAllLabelIdByActId($aid);  // 活动已有标签
        dump($list);
        dump($info);

        for($i=0;$i<count($list);++$i) {
            $ret = Db::table("act2label")
                ->where('a2l_act_id', $aid)
                ->where('a2l_label_id', (int)$list[$i])
                ->where('a2l_is_delete', 1)
                ->count();
            if ($ret) { // 已经存在且被软删除则恢复
                dump("恢复中");
                $ret = Db::table("act2label")
                    ->where('a2l_act_id', $aid)
                    ->where('a2l_label_id', (int)$list[$i])
                    ->update(['a2l_is_delete' => 0]);
                if (!$ret) {
                    return 0;
                }
                continue;
            }

            $ret1 = Db::table("act2label")
                ->where('a2l_act_id', $aid)
                ->where('a2l_label_id', (int)$list[$i])
                ->where('a2l_is_delete', 0)
                ->count();
            if ($ret1){ // 已经存在且未被软删除，则不用做任何处理
                dump("已经存在");
                continue;
            }

            // 记录不存在则添加
            dump("添加");
            $ret = Db::table("act2label")
                    ->insert(['a2l_act_id' => $aid,
                    'a2l_label_id' => (int)$list[$i],
                    'a2l_is_delete' => 0]);
            if (!$ret) {
                return 0;
            }
        }

        foreach ($info as $key => $value) {
            $flg = false;
            for($i=0; $i<count($list);++$i){
                if($info[$key]['a2l_label_id'] == (int)$list[$i]){
                    $flg = true;
                    break;
                }
            }

            // 以前存在的标签$info[$key]['a2l_label_id']现在被删除
            if(!$flg){
                dump("删除中");
                $ret = Db::table("act2label")
                    ->where('a2l_act_id',$aid)
                    ->where('a2l_label_id',$info[$key]['a2l_label_id'])
                    ->update(['a2l_is_delete'=>1]);
                if(!$ret){
                    return 0;
                }
            }
        }

        $ret = $this->updateActLabelStr($aid);
        return $ret;
    }
}