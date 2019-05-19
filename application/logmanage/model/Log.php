<?php
namespace app\logmanage\model;

use think\Model;
use think\Db;

use think\Request;

class ClientInfo extends Model{
    public function GetLang() {
        $Lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        //使用substr()截取字符串，从 0 位开始，截取4个字符
        if (preg_match('/zh-c/i',$Lang)) {
            //preg_match()正则表达式匹配函数
            $Lang = '简体中文';
        }
        elseif (preg_match('/zh/i',$Lang)) {
            $Lang = '繁體中文';
        }
        else {
            $Lang = 'English';
        }
        return $Lang;
    }

    public function getBrowser() {
        $user_OSagent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_OSagent, "Maxthon") && strpos($user_OSagent, "MSIE")) {
            $visitor_browser = "Maxthon(Microsoft IE)";
        } elseif (strpos($user_OSagent, "Maxthon 2.0")) {
            $visitor_browser = "Maxthon 2.0";
        } elseif (strpos($user_OSagent, "Maxthon")) {
            $visitor_browser = "Maxthon";
        } elseif (strpos($user_OSagent, "Edge")) {
            $visitor_browser = "Edge";
        } elseif (strpos($user_OSagent, "Trident")) {
            $visitor_browser = "IE";
        } elseif (strpos($user_OSagent, "MSIE")) {
            $visitor_browser = "IE";
        } elseif (strpos($user_OSagent, "MSIE")) {
            $visitor_browser = "MSIE";
        } elseif (strpos($user_OSagent, "NetCaptor")) {
            $visitor_browser = "NetCaptor";
        } elseif (strpos($user_OSagent, "Netscape")) {
            $visitor_browser = "Netscape";
        } elseif (strpos($user_OSagent, "Chrome")) {
            $visitor_browser = "Chrome";
        } elseif (strpos($user_OSagent, "Lynx")) {
            $visitor_browser = "Lynx";
        } elseif (strpos($user_OSagent, "Opera")) {
            $visitor_browser = "Opera";
        } elseif (strpos($user_OSagent, "MicroMessenger")) {
            $visitor_browser = "WeiXinBrowser";
        } elseif (strpos($user_OSagent, "Konqueror")) {
            $visitor_browser = "Konqueror";
        } elseif (strpos($user_OSagent, "Mozilla/5.0")) {
            $visitor_browser = "Mozilla";
        } elseif (strpos($user_OSagent, "Firefox")) {
            $visitor_browser = "Firefox";
        } elseif (strpos($user_OSagent, "U")) {
            $visitor_browser = "Firefox";
        } elseif (strpos($user_OSagent, "Safari/")) {
            $visitor_browser = "Safari";
        } else {
            $visitor_browser = "Other Browser";
        }
        return $visitor_browser;
    }

    public function GetOS() {
        $OS = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/win/i',$OS)) {
            $OS = 'Windows';
        }
        elseif (preg_match('/mac/i',$OS)) {
            $OS = 'MAC';
        }
        elseif (preg_match('/linux/i',$OS)) {
            $OS = 'Linux';
        }
        elseif (preg_match('/unix/i',$OS)) {
            $OS = 'Unix';
        }
        elseif (preg_match('/bsd/i',$OS)) {
            $OS = 'BSD';
        }
        else {
            $OS = 'Other';
        }
        return $OS;
    }
    public function GetIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //如果变量是非空或非零的值，则 empty()返回 FALSE。
            $IP = explode(',',$_SERVER['HTTP_CLIENT_IP']);
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $IP = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
        }
        elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $IP = explode(',',$_SERVER['REMOTE_ADDR']);
        }
        else {
            $IP[0] = 'None';
        }
        return $IP[0];
    }

    private function GetAddIsp() {
        $IP = $this->GetIP();
        $AddIsp = mb_convert_encoding(file_get_contents('http://open.baidu.com/ipsearch/s?tn=ipjson&wd='.$IP),'UTF-8','GBK');
        //mb_convert_encoding() 转换字符编码。
        if (preg_match('/noresult/i',$AddIsp)) {
            $AddIsp = 'None';
        }
        else {
            $Sta = stripos($AddIsp,$IP) + strlen($IP) + strlen('来自');
            $Len = stripos($AddIsp,'"}')-$Sta;
            $AddIsp = substr($AddIsp,$Sta,$Len);
        }
        $AddIsp = explode(' ',$AddIsp);
        return $AddIsp;
    }

    public function findCityByIp($ip){
        $data = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
        return json_decode($data,$assoc=true);
    }

    public function GetAdd() {
        $Add = $this->GetAddIsp();
        return $Add[0];
    }

    public function GetIsp() {
        $Isp = $this->GetAddIsp();
        if ($Isp[0] != 'None' && isset($Isp[1])) {
            $Isp = $Isp[1];
        }
        else {
            $Isp = 'None';
        }
        return $Isp;
    }
}

class Log extends Model
{
    /**
     * 杨宇
     * 功能：记录web端和企业微信端的登录/增加/修改/删除日志
     * @param
     * @uid：操作人的主键id，非学号
     * @type: 1登陆 2增加 3修改 4删除
     * @table ：操作的数据表名，如操作的数据表为'user_info'，则 $table = 'user_info'
     * @field ：操作的数据表的内容数组
     * @return int
     * 1登陆: 只需要传入$uid, $type
     * 2增加：需要传入$uid, $type, $table, $field(该字段传入你增加的所有数据的主键，如 $field = ['11'，'12'])
     * 3修改：假如同时操作了数据表中主键为22和23的两条数据的field1和field2字段, 则 $field = ['22'=>['field1'=> ['before value', 'after value'], 'field2'=> ['before value', 'after value']],'23'=>['field1'=> ['before value', 'after value'], 'field2'=> ['before value', 'after value']]]
     * 4删除：需要传入$uid, $type, $table, $field(该字段传入你删除的所有数据的主键，如 $field = ['11'，'12'])
     */
    public function recordLogApi($uid, $type, $table = '', $action = ''){
        if($type != 1 && $type != 2 && $type != 3 && $type != 4 && $type != 5)
            return 0;

        $client = new ClientInfo();
        $ip = $client->getIp();
        $os = $client->GetOS();
        $brower = $client->getBrowser();

        if($type == 1) {
            $data = ['lg_num' => $uid, 'lg_table' => $table, 'lg_type' => $type, 'lg_time' => date('Y-m-d H:i:s', time()), 'lg_os' => $os, 'lg_brower' => $brower, 'lg_ip' => $ip];
        }else{
            $data = ['lg_num' => $uid, 'lg_table' => $table, 'lg_type' => $type, 'lg_time' => date('Y-m-d H:i:s', time()), 'lg_os' => $os, 'lg_brower' => $brower, 'lg_ip' => $ip, 'lg_action' => json_encode($action)];
        }
        $res = Db::name('log_info')->insert($data);
        return $res;
    }

    /**
     * 杨宇
     * 功能：根据本人的学号插叙日志
     * @param $num
     * @return list
     */
    public function getLogByNum($num){
        $list = Db::name('log_info')
            ->where('lg_num',$num)
            ->order("log_info.lg_time desc")
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：查询所有日志
     * @return array
     */
    public function getAllLog(){
        $list = Db::table('log_info')
            ->order("lg_time desc")
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：查询所有非管理员日志
     * @return array
     */
    public function getAllUserLog(){
        $list = Db::table('log_info')
            ->alias('l')
            ->join('manage_info m', 'l.lg_num != m.m_id')
            ->where("m.m_is_delete=0")
            ->order("l.lg_time desc")
            ->select();
        return $list;
    }

    /**
     * 杨宇
     * 功能：查询所有管理员日志
     * @return array
     */
    public function getAllManagerLog(){
        $list = Db::table('log_info')
            ->alias('l')
            ->join('manage_info m', 'l.lg_num = m.m_id')
            ->where("m.m_is_delete=0")
            ->order("l.lg_time desc")
            ->select();
        return $list;
    }
}
