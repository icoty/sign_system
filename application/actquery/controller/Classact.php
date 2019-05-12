<?php

namespace app\actquery\controller;
use app\logmanage\model\Log as LogModel;
use think\controller;
use think\Db;
use app\classquery\model\ClassModel;
use app\common\controller\Common;
use app\actquery\model\ActivityModel;
use app\adminquery\model\AdminModel;
use app\labelquery\model\LabelModel;
use app\actquery\controller\Startsign;

use think\Session;


class Classact extends Common{
    public function index()
    {
        $act = new ActivityModel();
        $admin = new AdminModel();
        $class = new ClassModel();
        $label = new LabelModel();

        // 获取某个班创建的活动
        $year = 2018;
        $cid = 1;
        $info = $act->getActByClassId($year,$cid);

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

        // 获取当前用户的姓名和和班级信息传给前端
        $userInfo = $admin->getInfoByNum(1801220025);
        if($userInfo){
            $this->assign('userInfo', $userInfo);
        }

        return $this->fetch();
    }

    public function addAct(){
        $data = input('post.');
        dump($data);
        if (empty($data['a_name'])||empty($data['a_content'])||empty($data['a_start_time'])
            ||empty($data['a_end_time'])){
            $this->error('输入不可为空');
        }

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
        // 添加活动并返回主键
        $aid = $act->addAct($data);
        
        $act = new ActivityModel();
        // 添加活动并返回主键
        $aid = $act->addAct($data);
        // 记录日志
        if($aid){
            $model = new LogModel();
            $uid = Session::get('admin_id'); // 操作人主键id，非学号
            $type = 2;
            $table = 'user_info';
            $field = [$aid]; // 增加的主键列表，不是学号
            $model->recordLogApi ($uid, $type, $table, $field); //需要判断调用是否成功

        }else{
            $this->error('添加失败');
        }

        $label = new LabelModel();
        if ($aid){
            $ret = $label->editLabelByActId($aid,$data['add_label_id_list']);
            if($ret){
                $this->success('添加成功');
                return;
            }
        }

        $this->error('添加失败');
    }

    public function startSign(){
        $data = input('post.');
        dump($data);
        //$this->qrcode("http://localhost:81/public/index.php/actquery/classact/addSign",4);

        Vendor('phpqrcode.phpqrcode');
        \QRcode::png("http://localhost:81/public/index.php/actquery/classact/addSign",false,2,4,2);
        die;
        return;
    }

    public function addSign(){
        $data = input('post.');
        dump($data);
        return;
        $act = new ActivityModel();
        $ret = $act->delAct($data);
        if($ret){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }

    public function delAct(){
        $data = input('post.');
        $act = new ActivityModel();
        $ret = $act->delAct($data);
        if($ret){
            
            $model = new LogModel();
            $uid = Session::get('admin_id');; // 操作人主键id，非学号
            $type = 4;
            $table = 'user_info';
            $field = [$uid]; // 删除的主键列表, 不是学号
            $model->recordLogApi ($uid, $type, $table, $field); //需要判断调用是否成功

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
            
            $model = new LogModel();
            $uid = $uid = Session::get('admin_id'); // 操作人主键id，非学号
            $type = 3;
            $table = 'user_info';
            $field = [
            '22'=>[
            'field1'=> ['before value', 'after value'], 
            'field2'=> ['before value', 'after value']
            ],
            '23'=>[
            'field1'=> ['before value', 'after value'], 
            'field2'=> ['before value', 'after value']
            ]
            ];
            $model->recordLogApi ($uid, $type, $table, $field); //需要判断调用是否成功

            $this->success('编辑成功！');
        }else{
            $this->error('编辑失败！');
        }
    }

    public function export(){
        //1.从数据库中取出数据
        echo "ddd";
        $act = new ActivityModel();
        $list = $act->getActByClassId(2018, 1);
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