<?php
namespace app\login\controller;
use think\Config;
use \think\Request;
use think\Controller;


class Login extends Controller
{
    public function loginout(){
        session(null);
        cookie('PHPSESSID', null);
        //session('loggedIn', false);
        //跳轉回登入頁面
        $this -> success('登出成功', 'login/namelogin/index', null, 1);
    }
}