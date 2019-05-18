<?php
namespace app\login\controller;
use app\common\controller\Common;
use app\login\controller\ZhenziSmsClient;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\adminquery\model\AdminModel;

class Smsbinding extends Common
{
    public function index()
    {
        return $this->fetch();
    }

    /*
    *杨宇
    *生成验证码并发送给管理员
    */
    public function getCode(){
        $telephone=Request::instance()->post('telephone');
        $signature=Request::instance()->post('signature');
        $admin_id=Session::get('admin_id');

        if($signature=='pkusstelephone'){
            $mobile=new Mobile();
            $checkres=$mobile->hasMobile($telephone);//判断手机号是否已经存在于数据库中
            if($checkres){//手机号已绑定
                $res=3;
            }
            else {
                if (!session_id()) session_start();
                $_SESSION['admin_id']=$admin_id;
                $_SESSION['telephone'] = $telephone;
                if (isset($_SESSION['time'])) {//如果此前已经申请过验证码
                    if ($_SESSION['time']+ 60 > time()) {//判断是否是在1分钟内申请的
                        $res=4;
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
                $client = new  ZhenziSmsClient("https://sms_developer.zhenzikj.com", "101241", "7c697169-8031-4c8d-8a5f-653c107e6711");//使用榛子云API发送短信
                //$info="您的验证码为" + $verifyCode + "，有效时间为5分钟";
                $client->send($telephone, $verifyCode);
                //var_dump($result);
                //    $res['coderes']=$result;
                //  if($result['code']=='0'){
                //       $res['code']=1;
                //  }
                //   else $res['code']=2;
                $res=1;//发送成功
            }
            return $res;
        }
        else{
            $res=5;
            return $res;
        }
    }

    public function codeVerify(){
        $phonecode=Request::instance()->post('phonecode');
        $signature=Request::instance()->post('signature');
        if($signature=='pkussphonecode'){
            if (!session_id()) session_start();
            $res1['phonecode']=$phonecode;
            $res1['verifycode']=$_SESSION['verifycode'];
            $res1['time']=$_SESSION['time'];
            $res1['timenow']=time();
            if(!is_numeric($phonecode)){
                $res1['code']=2;
                return $res1;
            }
            else{
                if($phonecode==$_SESSION['verifycode']){
                    if($_SESSION['time']+ 300 < time()){//距离发出验证码已经超过5分钟
                        $res1['code']=4;
                    }
                    else {

                        $admin = new AdminModel();
                        $ret = $admin->bindTelephone($_SESSION['admin_id'],$_SESSION['telephone']);
                        if($ret){//如果成功将手机号写入数据库
                            $res1['code']=1;//绑定完成
                        }
                        else{
                            $res1['code']=3;//如果未成功写入，则让用户稍后再试
                        }
                        $res1['code'] = 1;
                    }
                }
                else{
                    $res1['code']=2;
                }

            }
            return $res1;
        }
        else{
            $res1['code']=5;
            return $res1;
        }
    }
}