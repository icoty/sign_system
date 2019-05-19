<?php

namespace app\adminquery\controller;
use app\logmanage\model\Log as LogModel;
use think\Session;

use app\attendquery\model\AttendModel;
use app\common\controller\Common;
use app\adminquery\model\AdminModel;
use app\classquery\model\ClassModel;
use app\login\model\Sha;
use think\controller;
use think\Db;
use think\Request;

class Alladmin extends Common{
    public function index()
    {
        $admin = new AdminModel();
        $class = new ClassModel();

        $info = $admin->getAllAdmin();
        foreach ($info as $key => $value) {
            $info[$key]['m_class'] = '';
            $info[$key]['privilege'] = '';
            $ret = $class->getClassById($info[$key]['m_class_id']);
            if($ret){
                $info[$key]['m_class'] = $ret['c_name'];  # 创建者姓名
            }

            if($info[$key]['m_privilege'] == 1){
                $info[$key]['privilege'] = '超管';
            }else if($info[$key]['m_privilege'] == 2){
                $info[$key]['privilege'] = '教职工';
            }else if($info[$key]['m_privilege'] == 3){
                $info[$key]['privilege'] = '普通管理员';
            }
        }
        $this->assign('info',$info);
        $this->assign('admin_id',Session::get('admin_id'));

        $classinfo = $class->getAllClass();
        $gradeinfo = $class->getAllGrade();
        $this->assign('classinfo',$classinfo);
        $this->assign('gradeinfo',$gradeinfo);

        // 获取当前用户的姓名和和班级信息传给前端
        $userInfo = $admin->getInfoByNum(Session::get('admin_id'));
        if($userInfo){
            $this->assign('userInfo', $userInfo);
        }

        return $this->fetch();
    }

    public function addAdmin(){
        $data = input('post.');
        dump($data);

        if (empty($data['m_id'])||empty($data['m_name'])||empty($data['m_grade'])
            ||empty($data['m_class_id'])||empty($data['m_telephone']) ||empty($data['m_privilege'])
            ||empty($data['m_privilege'])||empty($data['m_password1'])||empty($data['m_password2'])){
            $this->error('输入不可为空');
        }

        if($data['m_password1'] != $data['m_password2']){
            $this->error('两次输入的密码不一致！');
        }

        $sha = new Sha();
        $salt = $sha->getRandomStr(256);
        $data['m_salt'] = $salt;
        $salt .= $data['m_password1'];
        $data['m_password'] = $sha->sha256($salt);
        $data['m_is_delete'] = 0;
        // 删除多余的数组元素
        unset($data['m_password1']);
        unset($data['m_password2']);

        // 管理员已经存在且未被软删除弹窗提示
        $admin = new AdminModel();
        $ret = $admin->isExistAndNotDel($data['m_id']);
        if ($ret){
            $this->error('学号已经存在');
            return;
        }

        $ret = $admin->hasTelephone($data['m_telephone']);
        if ($ret){
            $this->error('手机号已被注册');
            return;
        }

        // 标签已经存在且被软删除时恢复即可
        $ret = $admin->isExistAndDel($data['m_id']);
        if ($ret){
            $ret = $admin->recoverAdmin($data['m_id']);
            if ($ret){
                $model = new LogModel();
                $uid = Session::get('admin_id');; // 操作人主键id，非学号
                $type = 3;
                $table = 'manage_info';
                $field = [$data['m_id'] => ['m_is_delete' => [1, 0]]]; // 删除的主键列表, 不是学号
                $ret = $model->recordLogApi($uid, $type, $table, $field); //需要判断调用是否成功
                if (!$ret) {
                    $this->error('该标签被软删除,恢复成功,日志记录失败！');
                } else {
                    $this->success('该标签被软删除,恢复成功,日志记录成功！');
                }
            }else{
                $this->error('该学号被软删除, 恢复失败');
            }
            return;
        }

        // 不存在则添加
        $id = $admin->addAdmin($data);
        if ($id){
            $model = new LogModel();
            $uid = Session::get('admin_id'); // 操作人主键id，非学号
            $type = 2;
            $table = 'manage_info';
            $field = [$data['m_id']]; // 增加的主键列表，不是学号
            $ret = $model->recordLogApi ($uid, $type, $table, $field); //需要判断调用是否成功
            if($ret) {
                $this->success('添加成功, 日志记录成功');
            }else{
                $this->error('添加成功, 日志记录失败');
            }
        }else{
            $this->error('添加失败');
        }
    }

    public function delAdmin(){
        $data = input('post.');
        $label = new AdminModel();
        $ret = $label->delAdmin($data);
        if($ret){
            $model = new LogModel();
            $uid = Session::get('admin_id'); // 操作人主键id，非学号
            $type = 4;
            $table = 'manager_info';
            $field =[$data['m_id'] => ['m_is_delete' => [0,1]]]; // 删除的主键列表, 不是学号
            $ret = $model->recordLogApi ($uid, $type, $table, $field); //需要判断调用是否成功
            if($ret) {
                $this->success('删除成功, 日志记录成功');
            }else{
                $this->error('删除成功, 日志记录失败');
            }
        }else{
            $this->error('删除失败！');
        }
    }

    public function editLogJson($old, $new){
        $log = array();

        if($new['m_name'] != $old['m_name']){
            $item = ['m_name' => [$old['m_name'], $new['m_name']]];
            $log[] = $item;
        }
        if($new['m_id'] != $old['m_id']){
            $item = ['m_id' => [$old['m_id'], $new['m_id']]];
            $log[] = $item;
        }
        if($new['m_class_id'] != $old['m_class_id']){
            $item = ['m_class_id' => [$old['m_class_id'], $new['m_class_id']]];
            $log[] = $item;
        }
        if($new['m_grade'] != $old['m_grade']){
            $item = ['m_grade' => [$old['m_grade'], $new['m_grade']]];
            $log[] = $item;
        }
        if($new['m_privilege'] != $old['m_privilege']){
            $item = ['m_privilege' => [$old['m_privilege'], $new['m_privilege']]];
            $log[] = $item;
        }
        return $log;
    }


    public function editAdmin(){
        $data = input('post.');
        unset($data['m_num']);
        $data['m_name'] = trim($data['m_name']);
        //dump($data);

        $label = new AdminModel();
        $old = $label->getAdminInfoByNum($data['m_id']);
        $logJson = $this->editLogJson($old, $data);

        if($logJson) {
            //dump($logJson);
            $ret = $label->editAdmin($data);
            if ($ret) {
                $model = new LogModel();
                $uid = $uid = Session::get('admin_id'); // 操作人主键id，非学号
                $type = 3;
                $table = 'manager_info';
                $field = [
                    $data['m_id'] => $logJson
                ];
                $ret = $model->recordLogApi($uid, $type, $table, $field); //需要判断调用是否成功
                if($ret) {
                    $this->success('编辑成功, 日志记录成功');
                }else{
                    $this->error('编辑成功, 日志记录失败');
                }
            } else {
                $this->error('编辑失败！');
            }
            return;
        }else{
            $this->error('未做任何修改！');
        }
    }

    public function importByExcel()
    {
        //dump($_FILES);
        if(empty($_FILES['file']['name'])) {
            $this->error('输入不可为空');
        }

        $format = explode(".", $_FILES['file']['name']);  // 新传入的标签用于更新
        if($format[count($format) - 1] == 'xlsx'){
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }else if($format[count($format) - 1] == 'xls'){
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }else{
            $this->error('文件格式错误,必须为Excel,文件后缀为.xls或.xlsx');
        }

        try {
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            die($e->getMessage());
        }

        $sheet = $spreadsheet->getActiveSheet();

        $sqlData = array();

        $att = new AttendModel();
        foreach ($sheet->getRowIterator(2) as $row) {
            $tmp = array();
            foreach ($row->getCellIterator() as $cell) {
                $tmp[] = $cell->getFormattedValue();
            }
            $ret = $att->signIsExist((int)$tmp[0],(int)$tmp[2]);
            if($ret){
                $this->error('导入失败! 活动ID:'.$tmp[0].',学号:'.$tmp[2].' 已经存在！');
            }
            $tmp = ['a2s_act_id' => (int)$tmp[0],
                'a2s_stu_name' => $tmp[1],
                'a2s_stu_num' => (int)$tmp[2],
                'a2s_sign_time' => $tmp[3],
                'a2s_is_delete' => 0];
            //dump($tmp);
            $sqlData[$row->getRowIndex() - 2] = $tmp;
        }

        $ret = $att->importAttend($sqlData);
        if ($ret) {
            $this->success('导入成功');
        } else {
            $this->error('导入失败');
        }
    }

    public function export(){
        //1.从数据库中取出数据
        echo "ddd";
        $attend = new AdminModel();
        // to do
        $list = $attend->getAllAdmin();
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
            ->setCellValue('B1', '学号')
            ->setCellValue('C1', '姓名')
            ->setCellValue('D1', '班级')
            ->setCellValue('E1', '年级')
            ->setCellValue('F1', '手机号')
            ->setCellValue('G1', '权限(1超管 2教职工 3普通管理员)');

        //设置F列水平居中
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //设置单元格宽度
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(30);
        //6.循环刚取出来的数组，将数据逐一添加到excel表格。
        echo "aaa";
        $class = new ClassModel();
        $admin = new AdminModel();
        $log = array();
        for($i=0;$i<count($list);$i++){
            $item = $list[$i]['m_id'];
            $log[] = $item;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2),$i+1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2),$list[$i]['m_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2),$list[$i]['m_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2),$class->getClassById($list[$i]['m_class_id'])['c_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2),$list[$i]['m_grade']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2),$list[$i]['m_telephone']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($i+2),$list[$i]['m_privilege']);

        }
        //7.设置保存的Excel表格名称
        $filename = '活动出席表'.date('ymd',time()).'.xls';
        //8.设置当前激活的sheet表格名称；
        $objPHPExcel->getActiveSheet()->setTitle('活动出席表');
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

        $model = new LogModel();
        $uid = Session::get('admin_id'); // 操作人主键id，非学号
        $type = 5;
        $table = 'manage_info';
        $field = $log;
        $ret = $model->recordLogApi($uid, $type, $table, $field); //需要判断调用是否成功
        if($ret) {
            echo "导出成功, 日志记录成功！";
            //$this->success('导出成功, 日志记录成功！');
        }else{
            echo "导出成功, 日志记录失败！";
            //$this->error('导出成功, 日志记录失败！');
        }
        exit;
    }
}