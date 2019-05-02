<?php
namespace app\classquery\model;
use think\Model;
use think\Db;


class ClassModel extends Model
{
    /**
     * 杨宇
     * 功能：通过班级ID获取班级名称
     * @param
     * @labelid：班级ID
     * return list
     */
    public function getClassById($classid = ''){
        $list = DB::table('class_info')
            ->where('c_id', $classid)
            ->where('c_is_delete',0)
            ->field('c_id, c_name')
            ->find();
        return $list;
    }

    /**
     * 杨宇
     * 功能：获取所有班级信息
     * @param
     * return list
     */
    public function getAllClass(){
        $class = Db::table('class_info')
            ->where('c_is_delete',0)
            ->field('c_id, c_name')
            ->select();
        return $class;
    }

    /**
     * 杨宇
     * 功能：获取所有可选年级
     * @param
     * return list
     */
    public function getAllGrade(){
        $grade = [
            2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009,
            2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019,
            2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029,
            2030, 2031, 2032, 2033, 2034, 2035, 2036, 2037, 2038, 2039,
            2040, 2041, 2042, 2043, 2044, 2045, 2046, 2047, 2048, 2049,
            2050, 2051, 2052, 2053, 2054, 2055, 2056, 2057, 2058, 2059,
        ];
        return $grade;
    }

    /**
     * 杨宇
     * 功能：判断班级名称 $name是否存在且已经被删除
     * @$name 标签名
     * return int
     */
    public function isExistAndDel($name = ''){
        $ret = Db::table('class_info')
            ->where('c_name',$name)
            ->where('c_is_delete',1)
            ->find();
        return $ret;
    }

    /**
     * 杨宇
     * 功能：判断 $name是否存在且未被删除
     * @$name 标签名
     * return int
     */
    public function isExistAndNotDel($name = ''){
        $ret = Db::table('class_info')
            ->where('c_name',$name)
            ->where('c_is_delete',0)
            ->find();
        return $ret;
    }

    /**
     * 杨宇
     * 功能：添加班级
     * @$name 班级名称
     * return int
     */
    public function addClass($name = ''){
        $data = ['c_name' => $name, 'c_is_delete'=> 0];
        $ret = Db::table('class_info')
            ->insert($data);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：恢复被删除的班级
     * @$name 班级名
     * return int
     */
    public function recoverClass($name = ''){
        $data = ['c_is_delete' => 0];
        $ret = Db::name('class_info')
            ->where('c_name',$name)
            ->update($data);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：编辑班级信息
     * @$data post数据
     * return int
     */
    public function editClass($data){
        $ret = Db::table('class_info')
            ->where('c_id', $data['c_id'])
            ->update(['c_name' => $data['c_name']]);
        return $ret;
    }

    /**
     * 杨宇
     * 功能：删除班级
     * @$data post数据
     * return int
     */
    public function delClass($data){
        $ret = Db::table('class_info')
            ->where('c_id',$data['c_id'])
            ->update(['c_is_delete' => 1]);
        return $ret;
    }
}