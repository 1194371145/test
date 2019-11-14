<?php
// +----------------------------------------------------------------------
// | 时间戳函数
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | email ( http://1194371145@qq.com)
// +----------------------------------------------------------------------
// | Author: crs
// +----------------------------------------------------------------------
namespace stortimelist;
class Times {



    //月初
    public function getMondayBegin()
    {
        return strtotime(date('Y-m'));
    }
    //月末
    public function getMondayEnd()
    {
        return strtotime(date('Y-m-t 23:59:59'));
    }
    //上个月初
    public function getLastMondayBegin()
    {
        return  strtotime(date('Y-m',strtotime("-1 month")));
    }
    //上个月末
    public function getLastMondayEnd()
    {
        return strtotime(date('Y-m-t 23:59:59',strtotime("-1 month")));
    }
    //下个月初
    public function getNextMondayBegin()
    {
        
        return  strtotime(date('Y-m',strtotime("+1 month")));
    }
    //下个月末
    public function getNextMondayEnd()
    {
        return strtotime(date('Y-m-t 23:59:59',strtotime("+1 month")));
    }
    //去年年初
    public function getYearBegin()
    {
        return strtotime(date('Y-01',strtotime("-1 year")));
    }
    //去年年末
    public function getYearEnd()
    {
        return strtotime(date('Y-12-t  23:59:59',strtotime("-1 year")));
    }


}
