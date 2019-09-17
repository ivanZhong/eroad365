<?php
namespace app\index\controller;
use http\Url;
use  think\Controller;
use app\common\model\Teacher;
use think\Request;

class TeacherController extends Controller
{

    public function index(){
        try{
            //获取查询条件
            $sName = Request::instance()->get('name');
            //定义分页数据
            $pageSize = 2;
            //创建对象
            $teacher = new Teacher;
            //判断查询条件
            if(!empty($sName)){
                $teacher->where('name','like','%'.$sName.'%');
            }
            $teachers = $teacher->paginate($pageSize,false,['query'=>['name'=>$sName]]);
//            $teachers = $teacher->paginate($pageSize);
            //向V层传递数据
            $this->assign('dataList',$teachers);
            $this->assign('url',$this->imageUrl);
            //取回打包后的数据
            $data = $this->fetch();
            return $data;
        }catch (\think\Exception\HttpResponseException $e){
            throw  $e;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * 插入数据
     * @return html
     * @author ivan
     */
    public function insert(){
        $message = '';
        try{

            $data = Request::instance()->post();

            //引用teacher数据表对应的模型
            $Teacher = new Teacher();
            $Teacher->name =$data['name'];
            $Teacher->sex =$data['sex'];
            $Teacher->username =$data['username'];
            $Teacher->email =$data['email'];

            // 向teacher表中插入数据并判断是否插入成功
            $result = $Teacher->validate(true)->save($Teacher->getData());
            if($result === false){
                $message =  "新增失败:".$Teacher->getError();
            }else{
                return $this ->success('新增用户'.$Teacher->name.'成功!',url('/index/teacher'));
            }
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;
            // 获取到正常的异常时，输出异常
        }catch (\Exception $e){
             return $e->getMessage();
        }

        return $this->error($message);

    }

    /**
     *返回表单页面
     *
     */
    public function add(){
        try{
            $htmls = $this->fetch();
            return $htmls;
        }catch (\Exception $e){
             return '系统错误'.$e->getMessage();
        }

    }

    /**
     *
     * 数据删除
     */
    public function delete(){

        try{
            //获取get方法的数据
            $id = Request::instance()->param('id/d');
            if(is_null($id) || 0 === $id){
                return $this->error('未获取到ID信息');
            }

            //删除对象
            $Teacher = Teacher::get($id);
            if(is_null($Teacher)){
                return $this ->error('不存在ID为'.$id.'信息的用户');
            }
            if(!$Teacher->delete()){
                return $this ->error('删除失败:'.$Teacher->getError());
            }
            return $this->success('删除成功!',url('/index/teacher/'));

        }catch (\think\Exception\HttpResponseException $e){
            throw $e;
        }catch (\Exception $e){
            return $e->getMessage();
        }



    }

    /**
     * 编辑数据
     */

    public function edit()
    {
        try{
            $id = Request::instance()->param('id/d');
            if(is_null($id) || 0 === $id){
                return $this->error('未获取到ID信息');
            }
            //获取对象信息
            $Teacher = Teacher::get($id);
            if(is_null($Teacher)){
                return $this ->error('不存在ID为'.$id.'信息的用户');
            }

            $this->assign('info',$Teacher);
            $htmls = $this->fetch();
            return $htmls;
        }catch (\think\Exception\HttpResponseException $e){
               throw $e;
        }catch (\Exception $e){
            return $e->getMessage();
        }


    }

    /**
     * 更新数据
     */
    public function update(){
        try{
            $teacher = Request::instance()->post();
            if(is_null($teacher)){
                return $this->error('获取信息失败');
            }
            $Teacher = new Teacher();
            if($Teacher->validate(true)->isUpdate(true)->save($teacher)){
                return $this->success('更新用户'.$Teacher->name.'数据成功！',url('/index/teacher'));
            }else{
                return '更新失败:'.$Teacher->getError();
            }
        }catch (\think\Exception\HttpResponseException $e){
            throw $e;
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }

    /***
     * 图片上传
     */

    protected $imageUrl = '/upload';
    public function upload(){
        $data = $this->request->post();
        $file = $this->request->file('files');
        $info = $file->move(ROOT_PATH.'\public\static\images');
        $this ->imageUrl = $info->getSaveName();//上传保存路径
        if($info){
            $this->assign('url',$this->imageUrl);
            return $this->success('上传成功！',url('/index/teacher'));
        }else{
            return "上传失败";
        }
    }
}