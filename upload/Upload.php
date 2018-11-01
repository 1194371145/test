<?php
namespace upload;//extend下文件夹叫啥，该叫啥
/*
*文件上传类
*/
class Upload{
    /*图片上传
    *@param  $folder 文件夹
    *@param  $file 文件夹名
    *演示在admin/controller/brand
    */
    public function upload($file){
                $folder=request()->controller();//文件夹
                $info = $file->move(ROOT_PATH . 'public'. DS . 'static' . DS . 'uploads'. DS . $folder);
                    if($info){//上传成功
                         $image=$info->getSaveName();
                         $images=str_replace("\\", "/", $image);
                         $img_path=$folder.'/'.$images;
                         return $img_path;
                    }else{//上传失败获取错误信息
                        echo $file->getError();
                    }
}
}
