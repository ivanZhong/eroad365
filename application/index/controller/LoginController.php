<?php
namespace app\index\controller;


use think\Controller;

class LoginController extends Controller
{
    //登录页面
    public function index(){
        //显示登录页面
         return $this->fetch();
    }

    //登录提交处理
    public function login(){

    }
}