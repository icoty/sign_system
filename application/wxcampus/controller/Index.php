<?php

namespace app\wxcampus\controller;

use app\classquery\model\ClassModel;
use app\common\controller\Common;
use app\actquery\model\ActivityModel;
use app\adminquery\model\AdminModel;
use app\actquery\controller\Startsign;

use app\labelquery\model\LabelModel;
use think\Db;
use think\Controller;
use think\Request;

class Index extends Controller{
    public function index()
    {/*
        $act = new ActivityModel();
        $admin = new AdminModel();
        $class = new ClassModel();
        $label = new LabelModel();

        $info = $act->getAllAct();
        $this->assign('info',$info);

        foreach ($info as $key => $value) {
            $info[$key]['creator'] = '';
            $ret = $admin->getNameByNum($info[$key]['a_creator']);
            if($ret){
                $info[$key]['creator'] = $ret['m_name'];  # 创建者姓名
            }

            $info[$key]['class'] = '';
            $ret = $class->getClassById($info[$key]['a_class_id']);
            if($ret){
                $info[$key]['class'] = $ret['c_name'];  # 祖组织单位名称
            }
        }

        $this->assign('info',$info);

        $labelinfo = $label->getAllLabel();
        if($labelinfo){
            $this->assign('labelinfo', $labelinfo);
        }

        $classinfo = $class->getAllClass();
        if($classinfo){
            $this->assign('classinfo', $classinfo);
        }

        // 获取当前用户的姓名和和班级信息传给前端
        $userInfo = $admin->getInfoByNum(1801220025);
        if($userInfo){
            $this->assign('userInfo', $userInfo);
        }
*/
        #return $this->redirect('Index/wx_policy',['wxcode'=>$code]);
        return $this->fetch();
    }

    public function addAct(){
        $data = input('post.');
        if (empty($data['a_name'])||empty($data['a_content'])||empty($data['a_start_time'])
            ||empty($data['a_end_time'])||empty($data['a_label'])){
            $this->error('输入不可为空');
        }
        $data['a_is_delete'] = 0;

        $act = new ActivityModel();
        $ret = $act->addAct($data);
        if ($ret){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }

    public function delAct(){
        $data = input('post.');
        $act = new ActivityModel();
        $ret = $act->delAct($data);
        if($ret){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }

    public function editAct(){
        $data = input('post.');
        $label = new LabelModel();

        // 未传入标签列表，则删除所有标签
        if(!isset($data['edit_label_id_list'])){
            $ret = $label->delLabelByActId($data['a_id']);
            if(!$ret)
                $this->error('删除标签失败！');
        }

        $ret = $label->editLabelByActId($data['a_id'],trim($data['edit_label_id_list']));
        if(!$ret){
            $this->error('编辑标签失败！');
        }

        // 获取创建人详细信息插入到数据库
        $admin = new AdminModel();
        $ret = $admin->getInfoByNum(1801220025);
        if(!$ret){
            $this->error('添加失败');
        }
        $data['a_creator'] = $ret['m_id'];
        $data['a_class_id'] = $ret['m_class_id'];
        $data['a_grade'] = $ret['m_grade'];
        $data['a_is_delete'] = 0;

        $act = new ActivityModel();
        $ret = $act->editAct($data);
        if($ret){
            $this->success('编辑成功！');
        }else{
            $this->error('编辑失败！');
        }
    }

    public function export(){
        //1.从数据库中取出数据
        echo "ddd";
        $list = Db::name('activity_info')->select();
        echo "aaa";
        //2.加载PHPExcle类库
        vendor('PHPExcel.PHPExcel');
        //3.实例化PHPExcel类
        $objPHPExcel = new \PHPExcel();
        //4.激活当前的sheet表
        $objPHPExcel->setActiveSheetIndex(0);
        //5.设置表格头（即excel表格的第一行）
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '序号')
            ->setCellValue('B1', '活动ID')
            ->setCellValue('C1', '活动名称')
            ->setCellValue('D1', '创建人')
            ->setCellValue('E1', '创建人学号')
            ->setCellValue('F1', '活动地点')
            ->setCellValue('G1', '活动内容')
            ->setCellValue('H1', '举办年级')
            ->setCellValue('I1', '组织单位')
            ->setCellValue('J1', '活动标签')
            ->setCellValue('K1', '开始时间')
            ->setCellValue('L1', '结束时间')
            ->setCellValue('M1', '创建时间')
            ->setCellValue('N1', '开始签到')
            ->setCellValue('O1', '结束签到');
        //设置F列水平居中
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //设置单元格宽度
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(30);
        //6.循环刚取出来的数组，将数据逐一添加到excel表格。
        echo "aaa";
        $class = new ClassModel();
        $admin = new AdminModel();
        for($i=0;$i<count($list);$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2),$i+1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2),$list[$i]['a_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2),$list[$i]['a_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2),$admin->getNameByNum($list[$i]['a_creator'])['m_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2),$list[$i]['a_creator']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2),$list[$i]['a_place']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($i+2),$list[$i]['a_content']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($i+2),$list[$i]['a_grade']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($i+2),$class->getClassById($list[$i]['a_class_id'])['c_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($i+2),$list[$i]['a_label']);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($i+2),$list[$i]['a_start_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($i+2),$list[$i]['a_end_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.($i+2),$list[$i]['a_create_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.($i+2),$list[$i]['a_start_sign']);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.($i+2),$list[$i]['a_end_sign']);
        }
        //7.设置保存的Excel表格名称
        $filename = '活动表'.date('ymd',time()).'.xls';
        //8.设置当前激活的sheet表格名称；
        $objPHPExcel->getActiveSheet()->setTitle('活动表');
        //9.设置浏览器窗口下载表格
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$filename.'"');
        ob_end_clean();
        ob_start();
        //生成excel文件
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //下载文件在浏览器窗口
        $objWriter->save('php://output');
        exit;
    }
}