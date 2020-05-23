<?php

namespace AdminBase\Common;

use Encore\Admin\Facades\Admin;

class Format
{
    /**
     * 格式化请求参数（针对搜索时间格式类型不同）
     * @param array $params
     * @return array
     */
    public static function formatRequest(array $params)
    {
        if ($params) {
            foreach ($params as &$val) {
                if ($val) {
                    $val = self::formatInt($val);
                }
            }
        }
        return $params;
    }

    /**
     * 格式化成INT
     * @param $value
     * @return array|int
     */
    public static function formatInt($value)
    {
        if (is_numeric($value) && strpos($value, ".") === false) {
            return intval($value);
        } elseif (is_array($value)) {
            foreach ($value as $k => $v) {
                if (is_numeric($v) && strpos($v, ".") === false) {
                    $value[$k] = intval($v);
                }
            }
            return $value;
        }
        return $value;
    }

    /**
     * 手机号格式化
     * @param $mobile
     * @return mixed|string
     */
    public static function formatMobile($mobile)
    {
        if (Admin::user()->can('user_mobile')) {
            return $mobile;
        } else {
            return $mobile ? substr_replace($mobile, '******', 3, 6) : '';
        }
    }

    /**
     * 格式化数值，保留两位小数
     * @param $value
     * @return float
     */
    public static function formatNumber($value)
    {
        if ($value == 0) return 0;
        return number_format(round($value, 2));
    }

    /**
     * 格式化成分
     * @param $value
     * @return int
     */
    public static function formatAmountToPenny($value)
    {
        return intval($value * 100);
    }

    /**
     * 格式化为元
     * @param $value
     * @return float|int
     */
    public static function formatAmountToYuan($value)
    {
        if ($value == 0) return 0;
        return number_format(round($value / 100, 2));
    }

    /**
     * 格式化数组
     * @param $list
     * @param $key
     * @param $value
     * @return array|false
     */
    public static function formatColumn($list, $key, $value)
    {
        return array_combine(array_column($list, $key), array_column($list, $value));
    }

    /**
     * 处理小数百分比格式
     * @param $decimal
     * @return string
     */
    public static function formatDecimal($decimal)
    {
        if ($decimal == 0) {
            return '0.00%';
        }
        return sprintf("%.2f", $decimal).'%';
    }

    /**
     * 多维数组排序
     * @param $arr
     * @param $key
     * @param $order
     * @return mixed
     */
    public static function arraySort($arr, $key, $order)
    {
        $date = array_column($arr, $key);
        $orderBy = '';
        if ($order == 'DESC') {
            $orderBy = 3;//SORT_DESC
        } elseif ($order == 'ASC') {
            $orderBy = 4;//SORT_ASC
        }
        array_multisort($date, $orderBy, $arr);
        return $arr;
    }

    /**
     * 处理数据统计里边的百分比显示
     * @param int $value 处理的数值(百分比)
     * @return string
     */
    public static function formatStatPp($value)
    {
        //先缩小100倍
        $roundData = round($value / 100, 2);
        //再格式化千分位+%
        return sprintf("%.2f", $roundData) . '%';
    }
}