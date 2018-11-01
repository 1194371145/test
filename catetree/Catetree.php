<?php
namespace catetree;
class Catetree {
    
    //无限极分类
    public function catetree($cateRes){
        return $this->sort($cateRes);
    }

    public function sort($cateRes,$pid=0,$level=0){

        static $arr=array();
        foreach ($cateRes as $k => $v) {
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->sort($cateRes,$v['id'],$level+1);
            }
        }

        return $arr;
    }

    //获取子栏目id

   public function childrenids($cateid,$obj){
        $data=$obj->field('id,pid')->select();
        return $this->_childrenids($data,$cateid,TRUE);
   }

   private function _childrenids($data,$cateid,$clear=FALSE){
        static $arr=array();
        if($clear){
          $arr=array();
        }
        foreach ($data as $k => $v) {
            if($v['pid']==$cateid){
                $arr[]=$v['id'];
                $this->_childrenids($data,$v['id']);
            }
        }
        return $arr;
   }

   //处理栏目排序
   public function cateSort($data,$obj){
    foreach ($data as $k => $v) {
        $obj->update(['id'=>$k,'sort'=>$v]);
    }
   }

   //处理批量删除

   public function pdel($cateids){
            foreach ($cateids as $k => $v) {
                $childrenidsarr[]=$this->childrenids($v);
                $childrenidsarr[]=(int)$v;
            }  
            $_childrenidsarr=array();
            foreach ($childrenidsarr as $k => $v) {
                if(is_array($v)){
                    foreach ($v as $k1 => $v1) {
                       $_childrenidsarr[]=$v1;
                    }
                }else{
                    $_childrenidsarr[]=$v;
                }
            }
            $_childrenidsarr=array_unique($_childrenidsarr);
            $this::destroy($_childrenidsarr);
    
   }

    /*根据sort字段排序
    *$model为实例化的模型 eg：$model=db('conf');
    *演示在admin/ConfController/lst下
    */
   public function resort($model){
        $data=input('post.');
            foreach ($data['sort'] as $k => $v) {
                $model->where('id','=',$k)->update(['sort'=>$v]);
            }
   }
}