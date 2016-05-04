<?php 
    //上传product图片
    
        //TODO 上传图片的方法需要重新定义：如何上传组图？上传图片不成功的json返回？
    	/*function imgUpload(){
            //创建数据对象
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize    =     551200 ;// 设置附件上传大小500kb
            $upload->exts       =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath   =     './';
            $upload->savePath   =     './Public/Uploads/'; // 设置附件上传目录
            $upload->autoSub    =     false;
            $upload->saveName   =     time().'_'.mt_rand();
            // 上传文件
            $info   =   $upload->upload();
            $product_add =$info["photo"]["savename"];
            if(!$product_add)
              $product_add = '00000000.jpg';
            return $product_add;
        }
    
        //按文件名删除文件夹中的图片
        function imgDel($file_name){
        	$file="./Public/Uploads/".$file_name;//文件路径
        	unlink($file);//删除文件
        }*/


