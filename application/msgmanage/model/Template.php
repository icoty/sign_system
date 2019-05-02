<?php

namespace app\msgmanage\model;
use think\Model;
use think\Db;

class Template extends Model
{
    //绑定表名
    /* protected $table = 'message_template';
    protected $pk = 'id'; */

    //根据模板名称获取模板
    public function getItemByTitle($tit){
        $titleTemp = Db::name('message_template')
            ->where('title',$tit)
            ->where('is_delete',0)
            ->find();
        return $titleTemp;
    }

    //获取所有模板
    public function getAllTemplates(){
        $allItems = Db::name('message_template')
            ->where('is_delete',0)
            ->select();
        return $allItems;
    }

    //插入模板
    public function insertTemplate($tit, $cont){
        $data = ['title' => $tit, 'content'=> $cont, 'is_delete' => 0,'update_time'=> date('Y-m-d H:i:s',time())];
        $res = Db::name('message_template')->insert($data);
        return $res;
    }

    //删除模板
    public function deleteTemplates($id){
        $data = ['is_delete' => 1,'update_time'=> date('Y-m-d H:i:s',time()),'delete_time'=> date('Y-m-d H:i:s',time())];
         $res = Db::name('message_template')
            ->where('id',$id)
            ->update($data);
        return $res;
    }
    //更新模板
    public function updateTemplates($id,$des){
        $data = ['name' => $des,'update_time'=> date('Y-m-d H:i:s',time())];
        $res = Db::name('schedule_item')
            ->where('id',$id)
            ->update($data);
           return $res;
       }
}