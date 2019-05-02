<?php

namespace app\classquery\controller;

use app\common\controller\Common;

use think\controller;
use think\Db;
use think\Request;

class Importexport extends Common{

	public function index()
	{
		return $this->fetch();
	}
}
