<?php


namespace app\common\validate;
use think\Validate;

class Teacher extends Validate
{
    protected $rule =['email' => 'email','name' => 'require|max:4','username' => 'require|max:12'];

}