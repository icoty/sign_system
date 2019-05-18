<?php

namespace app\login\controller;

use app\login\controller\ZhenziSmsClient;
use app\login\model\Sha;
use app\logmanage\model\Log as LogModel;
use app\adminquery\model\AdminModel;
use think\Controller;
use think\Request;

use think\Db;
use app\login\model\Mobile;

class Phonelogin extends Controller
{
    public function index()
    {
        return $this->fetch();

        //return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }

    public function getCode(){
        $telephone=Request::instance()->post('telephone');
        $signature=Request::instance()->post('signature');
        dump($telephone);
        if($signature=='pkusstelephone'){
            $mobile=new Mobile();
            $checkres=$mobile->hasMobile($telephone);
            if(!$checkres){
                // 手机号不存在
                $res['code']=3;
            }else {
                session_start();
                $_SESSION['telephone'] = $telephone;
                if (isset($_SESSION['time'])) {//如果此前已经申请过验证码
                    if ($_SESSION['time']+ 60 > time()) {//判断是否是在1分钟内申请的
                        $res['code']=4;
                        return json_encode($res);
                    } else {//如果是在1分钟之前申请的，则可以再次申请，并更新时间
                        $_SESSION['time'] = time();
                    }
                } else {
                    $_SESSION['time'] = time();
                }
                $seed = time();                   // 使用时间作为种子源
                srand($seed);                     // 播下随机数发生器种子
                $verifyCode = rand(100000, 999999);
                $_SESSION['verifycode']=$verifyCode;
                $client = new  ZhenziSmsClient("https://sms_developer.zhenzikj.com", "101241", "7c697169-8031-4c8d-8a5f-653c107e6711");
                //$info="您的验证码为" + $verifyCode + "，有效时间为5分钟";
                $result = $client->send($telephone, $verifyCode);
                //var_dump($result);
                $res['coderes']=$result;
                if($result['code']=='0'){
                    $res['code']=1;
                }
                else $res['code']=2;
            }
            return $res;
        }else{
            $res['code']=5;
            return $res;
        }
    }
    public function codeVerify(){
        $telephone = Request::instance()->post('telephone');
        $phonecode=Request::instance()->post('phonecode');
        $signature=Request::instance()->post('signature');
        $password=Request::instance()->post('password');
        if($signature=='pkussphonecode'){
            session_start();
            $res1['phonecode']=$phonecode;
            $res1['verifycode']=$_SESSION['verifycode'];
            $res1['time']=$_SESSION['time'];
            $res1['timenow']=time();
            if(!is_numeric($phonecode)){
                $res1['code']=2;
                return $res1;
            }else{
                if($phonecode==$_SESSION['verifycode']){
                    if($_SESSION['time']+ 300 < time()){//距离发出验证码已经超过5分钟
                        $res1['code']=4;
                    }else {
                        /*
                        $mobile=new Mobile();
                        $addphone=$mobile->addMobile($_SESSION['id'],$_SESSION['telephone']);//由于登录功能还未实现，因此无法获得管理员的id
                        if($addphone){//如果成功将手机号写入数据库
                            $res1['code']=1;//绑定完成
                        }
                        else{
                            $res1['code']=3;//如果未成功写入，则让用户稍后再试
                        }*/
                        $admin = new AdminModel();
                        $sha = new Sha();
                        $salt = $admin->getSaltByTel($telephone)['m_salt'];
                        $salt .= $sha->sha256($password);
                        $newPwd = $sha->sha256($salt);
                        $ret = $admin->resetPassword($newPwd);
                        if($ret){
                            $res1['code'] = 1;
                            // recordLogApi
                        }else{
                            $res1['code'] = 6;
                        }
                    }
                }else{
                    $res1['code']=2;
                }
            }
            return $res1;
        }else{
            $res1['code']=5;
            return $res1;
        }

    }
}