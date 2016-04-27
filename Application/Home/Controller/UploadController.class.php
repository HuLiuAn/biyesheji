<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {

    public function picture(){

         if(empty($_FILES)){
           return;
         }
        $upload = new \Think\Upload();// 实例化上传类
           $upload->maxSize   =     3145728 ;// 设置附件上传大小
           $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
           $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
           $upload->savePath  =     ''; // 设置附件上传（子）目录

           $upload->saveName= time().'_'.mt_rand();
           // 上传文件
           $info   =   $upload->upload();
         if (!$info) {
             //捕获上传异常
           //  $this->error($upload->getErrorMsg());
               $this->ajaxReturn (json_encode($upload->getError()),'JSON');
         } else {
             //取得成功上传文件信息
            $this->ajaxReturn ($info);
         }

    }


    
}