<?php
/**
 * Created by PhpStorm.
 * User: 84333
 * Date: 2019/4/14
 * Time: 0:55
 */

namespace app\login\controller;
use app\adminmanage\model\ManageInfo;
use think\Controller;
use think\Request;

class Namelogin extends Controller
{
    public function index(){
        if(request() -> isPost()){
            $admin = new ManageInfo();

            // 登入驗證代號
            // 1: 帳號錯誤| 2: 密碼錯誤| 3: 登入成功| 4: 帳戶狀態失效| 5: 其他錯誤
            if(input('?post.username') && input('?post.password')){
                $username = Request::instance()->param('username');
                $password = Request::instance()->param('password');
            }else{
                $this -> error('请输入完整登入信息');
            }
            $num = $admin -> checkLogin($username, $password);
            switch ($num){
                case 3:
                    $this -> success('登入成功', 'index/index/index', null, 1);
                    break;
                case 4:
                    $this -> error('您的帐户状态已失效，请联系相关管理员', null, null, 3);
                    break;
                case 5:
                    $this -> error('OOPS！发生错误，请稍候重试', null, null, 3);
                    break;
                default:
                $this -> error('用户名或密码错误', null, null, 3);
            }
            return;
        }

        return $this->fetch();
    }

}
