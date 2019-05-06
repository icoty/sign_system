<?php
namespace app\adminquery\model;
use app\logmanage\model\Log as LogModel;
use think\Cookie;
use think\Model;
use think\Session;
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
            ->order("manage_info.m_grade desc")
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


class AdminInfo extends Model
{
    //protected $autoWriteTimestamp = true;
    protected $autoWriteTimestamp = 'datetime';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    protected function get_client_ip($type = 0)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL) return $ip[$type];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) unset($arr[$pos]);
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = ip2long($ip);
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    /**
     * @param String username
     * @param String password
     * @return Number 1:帳號錯誤| 2: 密碼錯誤| 3: 登入成功| 4: 帳戶狀態失效| 5: 其他錯誤
     * @version 1.0
     * @author 程詠
     * 功能：管理員登入驗證
     */
    public function checkLogin($username, $password)
    {
        Session::set(null);
        cookie('PHPSESSID', null);
        $admin = Db::table('manage_info')->where('m_id', $username)->find();
        if (!$admin) {
            return 1; // 帳號錯誤
        }
        if ($admin['m_is_delete'] == 1) {
            return 4; // 帳戶狀態失效
        }
        if ($admin['m_password'] == md5($password)) {
            // 紀錄 session 和 cookie
            Session::set('admin_id', $admin['m_id']);
            Session::set('admin_name', $admin['m_name']);
            Cookie::set('PHPSESSID', Session_id(), 3600);
            // 寫入日誌
            $model = new LogModel();
            $type = 1;
            if (Session::get('admin_id')) {
                $res = $model->recordLogApi(Session::get('admin_id'), $type);
                if ($res) {
                    return 3; //登入成功
                }
            }
        } else {
            return 2; //密碼錯誤
        }
        return 5; //其他錯誤
    }
}