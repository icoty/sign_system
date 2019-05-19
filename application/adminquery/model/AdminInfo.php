<?php
namespace app\adminquery\model;
use app\logmanage\model\Log as LogModel;
use think\Cookie;
use think\Model;
use think\Session;
use think\Db;
use app\login\model\Sha;

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

        $sha = new Sha();
        $adminModel = new AdminModel();
        $salt = $adminModel->getSaltByNum($username)['m_salt'];
        $salt .= $password;

        $pwd = $sha->sha256($salt);
        if ($admin['m_password'] == $pwd) {
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