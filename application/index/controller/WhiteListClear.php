<?php
namespace app\index\controller;

use think\Controller;
use think\View;

class WhiteListClear extends Controller
{
    public function index(){
	$list = db("whiteList")->where("isdelete",0)->select();
	$res = 0;
	foreach($list as $data){
		$postdata = [
				"user" => "#".$data["user"],
				"isdelete" => 1,
	    		    ];
		$cul = db("whiteList")->where("id",$data["id"])->update($postdata);
		$res += $cul;
	}
	if($res != 0){
		$this->success('清空成功','index/index');
	}else{
		$this->error('清空失败');
	}
    }
}
