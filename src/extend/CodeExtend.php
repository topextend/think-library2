<?php
// -----------------------------------------------------------------------
// |Author       : Jarmin <edshop@qq.com>
// |----------------------------------------------------------------------
// |Date         : 2020-07-08 16:36:17
// |----------------------------------------------------------------------
// |LastEditTime : 2020-07-08 17:20:18
// |----------------------------------------------------------------------
// |LastEditors  : Jarmin <edshop@qq.com>
// |----------------------------------------------------------------------
// |Description  : Class CodeExtend
// |----------------------------------------------------------------------
// |FilePath     : \think-library\src\extend\CodeExtend.php
// |----------------------------------------------------------------------
// |Copyright (c) 2020 http://www.ladmin.cn   All rights reserved. 
// -----------------------------------------------------------------------
namespace think\admin\extend;

/**
 * 随机数码管理扩展
 * Class CodeExtend
 * @package think\admin\extend
 */
class CodeExtend
{
    /**
     * 获取随机字符串编码
     * @param integer $size 字符串长度
     * @param integer $type 字符串类型(1纯数字,2纯字母,3数字字母)
     * @param string $prefix 编码前缀
     * @return string
     */
    public static function random($size = 10, $type = 1, $prefix = '')
    {
        $numbs = '0123456789';
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        if (intval($type) === 1) $chars = $numbs;
        if (intval($type) === 3) $chars = "{$numbs}{$chars}";
        $string = $prefix . $chars[rand(1, strlen($chars) - 1)];
        if (isset($chars)) while (strlen($string) < $size) {
            $string .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $string;
    }

    /**
     * 唯一日期编码
     * @param integer $size
     * @param string $prefix
     * @return string
     */
    public static function uniqidDate($size = 16, $prefix = '')
    {
        if ($size < 14) $size = 14;
        $string = $prefix . date('Ymd') . (date('H') + date('i')) . date('s');
        while (strlen($string) < $size) $string .= rand(0, 9);
        return $string;
    }

    /**
     * 唯一数字编码
     * @param integer $size
     * @param string $prefix
     * @return string
     */
    public static function uniqidNumber($size = 12, $prefix = '')
    {
        $time = time() . '';
        if ($size < 10) $size = 10;
        $string = $prefix . (intval($time[0]) + intval($time[1])) . substr($time, 2) . rand(0, 9);
        while (strlen($string) < $size) $string .= rand(0, 9);
        return $string;
    }
}