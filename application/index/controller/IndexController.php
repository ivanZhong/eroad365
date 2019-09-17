<?php
namespace app\index\controller;
use think\Db;

class IndexController
{
    public function index()
    {
//        var_dump(Db::name('user')->find());
        return "<p>网站正在建设中...</p>";
//        return "hello";
    }

}
