<?php

namespace app\msgmanage\controller;

use app\common\controller\Common;

class Msgmodel extends Common
{

    //添加模板
    public function  addTemplate()
    {
        $tit = $_POST['tit'];
        $con = $_POST['con'];
        /* var_dump($des);
        var_dump($con); */
        $model = model('Template');
        $isHasSame = $model->getItemByTitle($tit);
        if ($isHasSame == null) {
            $res = $model->insertTemplate($tit, $con);
            if($res ==1){
                $this->success("新增成功");
            }
            else{
                $this->error("添加失败，请重新尝试");
            }
        }
        else{
            $this->error("名称重复");
        }
    }

    //查询模板
    public function index(){
        $model = model('Template');
        $templateItems = $model->getAllTemplates();
        $this->assign('templateItems',$templateItems);
        return $this->fetch();
    }

    public function loadTemplate()
    {
        $template = model('Template');
        $templates = $template->getAllTemplates();
        return $templates;
    }

    //删除模板
    public function deleteTemplates(){
        $id = $_POST['id'];
        $model = model('ScheduleItem');
        $res = $model->deleteTemplates($id);
        if($res == 1){
            $this->success("删除成功");
        }
        else{
            $this->error(  "删除失败，请重新操作!");
        }
    }

    //编辑模板
    public function editTemplates(){
        $id = $_POST['id'];
        $des = $_POST['des'];
        $model = model('ScheduleItem');
        $isSame = $model->getItemByName($des);
        if($isSame ==null){
            $res = $model->updateTemplates($id,$des);
            if($res ==1){
                $this->success("编辑成功");
            }
            else{
                $this->error(  "编辑失败，请重新操作!");
            }
        }
        else{
            $this->error(  "修改事项名称与已有重复，请重新修改!");
        }
    }
}