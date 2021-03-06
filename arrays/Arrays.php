<?php
// +----------------------------------------------------------------------
// | 数组函数
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | email ( http://1194371145@qq.com)
// +----------------------------------------------------------------------
// | Author: crs
// +----------------------------------------------------------------------
namespace arrays;
class Arrays {

    /**
     * 对象转数组
     * @param $object
     * @return array
     */
    public static function object2Array($object)
    {
        $result = array();
        if (!$object) {return $result;}
        $object = is_object($object) ? get_object_vars($object) : $object;
        foreach ($object as $key => $val) {
            $val = (is_object($val) || is_array($val)) ? self::object2Array($val) : $val;
            $result[$key] = $val;
        }
        return $result;
    }
    /*********************************二维数组排序****************************************************/

    /**
     * 二维数组按某一字段排序
     * @param $arr  二维数组
     * @param $keys 根据指定key排序
     * @param string $type  顺序排列还是倒序排列
     * @return array
     */
    public static  function arr_multisort($arr,$keys,$type='asc'){
        if($type=='asc'){
            $arg=SORT_ASC;
        }else{
            $arg=SORT_DESC;
        }
        $last_names = array_column($arr,$keys);
        array_multisort($last_names,$arg,$arr);
        return $arr;
    }
    /**
     * @comment 二维数组根据多个字段排序，类似mysql中的多个 order by
     * 用法： sortArrByManyField($arr, 'age', SORT_DESC, 'id', SORT_ASC, 'id', SORT_DESC)
     * @return mixed|null
     */
    function sortArrByManyField()
    {
        $args = func_get_args();//函数返回的是包含当前函数所有参数的一个数组
        if (empty($args)) {
            return null;
        }
        $arr = array_shift($args);
        if (!is_array($arr)) {
            throw new Exception("第一个参数不为数组");
        }
        foreach ($args as $key => $field) {
            if (is_string($field)) {
                $temp = [];
                foreach ($arr as $index => $val) {
                    $temp[$index] = $val[$field];
                }
                $args[$key] = $temp;
            }
        }
        $args[] = &$arr; // 引用值
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }
    /*********************************二维数组去重****************************************************/
    
    /**数组去重
     * @param array $arr
     * @return array
     * 用法:$arr=[['id'=>3,'node_id'=>4],['id'=>2,'node_id'=>5],['id'=>2,'node_id'=>5]];去重后返回俩条数据
     */
    public static function moreArrayUnique($arr = array())
    {
        foreach ($arr[0] as $k => $v) {
            $arr_inner_key[] = $k;
        }
        foreach ($arr as $k => $v) {
            $v = join(",", $v);
            $temp[$k] = $v;
        }
        $temp = array_unique($temp);
        foreach ($temp as $k => $v) {
            $a = explode(",", $v);
            $arr_after[$k] = array_combine($arr_inner_key, $a);
        }
        $arr_after = array_values($arr_after);
        return $arr_after;
    }
    /**
     * @comment 二维数组/对象按一个/多个字段去重
     * @param array|object $arr
     * @param string|array $filed
     * @return array
     */
    function getUniqueArr($arr, $filed)
    {
        $result = [];
        if (is_string($filed)) {
            $filed = [$filed];
        }
        foreach ($arr as $item) {
            if (is_array($item)) {
                $rKey = '';
                foreach ($filed as $key) {
                    $rKey .= md5($item[$key]);
                }
            } else { // 对象
                $rKey = '';
                foreach ($filed as $key) {
                    $rKey .= md5($item->$key);
                }
            }
            $result[$rKey] = $item;
        }
        return array_values($result);
    }

}
