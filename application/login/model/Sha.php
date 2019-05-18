<?php
namespace app\login\model;
use think\Model;
use think\Db;

class Sha extends Model
{
    /*
     * 以下代码实现PHP sha256() sha256_file() sha512() sha512_file() PHP 5.1.2+完美兼容
     * @param string $data 要计算散列值的字符串
     * @param boolean $rawOutput 为true时返回原始二进制数据，否则返回字符串
     * @param string file 要计算散列值的文件名，可以是单独的文件名，也可以包含路径，绝对路径相对路径都可以
     * @return boolean | string 参数无效或者文件不存在或者文件不可读时返回false，计算成功则返回对应的散列值
     * @notes 使用示例 sha256('mrdede.com') sha512('mrdede.com') sha256_file('index.php') sha512_file('index.php')
    */
    /* PHP sha256() */
    public function sha256($data, $rawOutput = false)
    {
        if (!is_scalar($data)) {
            return false;
        }
        $data = (string)$data;
        $rawOutput = !!$rawOutput;
        return hash('sha256', $data, $rawOutput);
    }

    /* PHP sha256_file() */
    public function sha256_file($file, $rawOutput = false)
    {
        if (!is_scalar($file)) {
            return false;
        }
        $file = (string)$file;
        if (!is_file($file) || !is_readable($file)) {
            return false;
        }
        $rawOutput = !!$rawOutput;
        return hash_file('sha256', $file, $rawOutput);
    }

    /* PHP sha512() */
    public function sha512($data, $rawOutput = false)
    {
        if (!is_scalar($data)) {
            return false;
        }
        $data = (string)$data;
        $rawOutput = !!$rawOutput;
        return hash('sha512', $data, $rawOutput);
    }

    /* PHP sha512_file()*/
    public function sha512_file($file, $rawOutput = false)
    {
        if (!is_scalar($file)) {
            return false;
        }
        $file = (string)$file;
        if (!is_file($file) || !is_readable($file)) {
            return false;
        }
        $rawOutput = !!$rawOutput;
        return hash_file('sha512', $file, $rawOutput);
    }


    /**
     * 获得随机字符串
     * @param $len          需要的长度
     * @param $special      是否需要特殊符号
     * @return string       返回随机字符串
     */
    public function getRandomStr($len, $special=true){
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );

        if($special){
            $chars = array_merge($chars, array(
                "!", "@", "#", "$", "?", "|", "{", "/", ":", ";",
                "%", "^", "&", "*", "(", ")", "-", "_", "[", "]",
                "}", "<", ">", "~", "+", "=", ",", "."
            ));
        }

        $charsLen = count($chars) - 1;
        shuffle($chars);                            //打乱数组顺序
        $str = '';
        for($i=0; $i<$len; $i++){
            $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
        }
        return $str;
    }
}