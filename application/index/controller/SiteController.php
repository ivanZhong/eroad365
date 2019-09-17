<?php
namespace app\index\controller;
use app\common\model\Site;
use think\Controller;
use think\Request;

class SiteController extends Controller
{

    protected $imagesUrl ='';
    public function index(){
        try{

//            $pageSize = 6;
//            $Site = new Site();
//            $siteData = $Site->paginate($pageSize);

//            $this->assign('dataInfo',$siteData);
            $this->assign('url',$this->imagesUrl);
            return $this->fetch();
        }catch (\think\Exception\HttpResponseException $e){
            throw $e;
        }catch (\Exception $e){
             return $e->getMessage();
        }
    }

    /**
     *
     * @return
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
     * 添加油站信息
     */
    public function insert()
    {

    }

    /**
     * 上传油站图片
     */
    public function upload(){

        try{
            $data = $this->request->post();
            $file = $this->request->file('files');
            var_dump($file);
            $info = $file->move(ROOT_PATH.'\public\static\upload\images');
            $uploadUrl= $info->getSaveName();//上传保存路径

            if($info){
                $site = new Site();
            }else{

            }
        }catch(\think\Exception\HttpResponseException $e){
            throw $e;
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }
}