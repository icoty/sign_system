<?php
/**
 * Created by PhpStorm.
 * User: 84333
 * Date: 2019/4/17
 * Time: 14:31
 */

namespace app\msgmanage\controller;


use app\common\controller\Common;

function utf8_fopen_read($fileName)
{
    $fc = iconv('windows-1250', 'utf-8', file_get_contents($fileName));
    $handle=fopen("php://memory", "rw");
    fwrite($handle, $fc);
    fseek($handle, 0);
    return $handle;
}

class Policy extends Common
{
    public function index()
    {
        $provisionFile = fopen("provisions.txt", "r") or die("Unable to open file!");
        $last = fread($provisionFile, filesize("provisions.txt"));
        fclose($provisionFile);
        $this->assign('last', $last);
        return $this->fetch();
    }

    public function postProvisionDetail()
    {
        $data = input('textarea-input');
        $provisionFile = fopen("provisions.txt", "w") or die("Unable to open file!");
        $tag = fwrite($provisionFile, $data);
        fclose($provisionFile);
        if ($tag) {
            return json(['msg' => '成功！', 'code' => 1]);
        } else {
            return json(['msg' => '失败！', 'code' => 0]);
        }
    }
}