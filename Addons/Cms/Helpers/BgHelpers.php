<?php

namespace Addons\Cms\Helpers;

class BgHelpers
{

    /**
     * 背景颜色
     *
     * @param string $color
     * @return string
     */ 
    public static function color($color = '#FFFFFF')
    {
        return 'background-color:' . $color . ";";
    }

    /**
     * 背景图片
     *
     * @param string $url
     * @param string $size
     * @return string
     */
    public static function url($url, $size = '')
    {
        return 'background: url(' . $url . ') ' . $size . ';';
    }

    /**
     * 水平渐变
     */
    public static function gradient_horizontal($start_color = '#00b3ee', $end_color = '#7a43b6', $start_percent = '0%', $end_percent = '100%')
    {
        $start_color = trim($start_color, '#');
        $end_color = trim($end_color, '#');
        return <<<GRADIENT
background-image: -webmmadmin-linear-gradient(left, #{$start_color} $start_percent, #{$end_color} $end_percent); 
background-image: -o-linear-gradient(left, #{$start_color} $start_percent, #{$end_color} $end_percent); 
background-image: linear-gradient(to right, #{$start_color} $start_percent, #{$end_color} $end_percent); 
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff{$start_color}', endColorstr='#ff{$end_color}', GradientType=1);
filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
background-repeat: repeat-x;
GRADIENT;
    }

    /**
     * 垂直渐变 
     */
    public static function gradient_vertical($start_color = '#00b3ee', $end_color = '#7a43b6', $start_percent = '0%', $end_percent = '100%')
    {
        $start_color = trim($start_color, '#');
        $end_color = trim($end_color, '#');
        return <<<GRADIENT
background-image: -webmmadmin-linear-gradient(top, #{$start_color} $start_percent, #{$end_color} $end_percent); 
background-image: -o-linear-gradient(top, #{$start_color} $start_percent, #{$end_color} $end_percent); 
background-image: linear-gradient(to bottom, #{$start_color} $start_percent, #{$end_color} $end_percent); 
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff{$start_color}', endColorstr='#ff{$end_color}', GradientType=0);
filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
background-repeat: repeat-x;
GRADIENT;
    }

    /**
     * 对角渐变 
     */
    public static function gradient_directional($start_color = '#00b3ee', $end_color = '#7a43b6', $deg = '45deg')
    {
        $start_color = trim($start_color, '#');
        $end_color = trim($end_color, '#');
        return <<<GRADIENT
background-image: -webmmadmin-linear-gradient($deg, #{$start_color} , #{$end_color}); 
background-image: -o-linear-gradient($deg, #{$start_color} , #{$end_color}); 
background-image: linear-gradient($deg, #{$start_color} , #{$end_color}); 
background-repeat: repeat-x;
GRADIENT;
    }

    /**
     * 水平渐变
     */
    public static function gradient_3horizontal($start_color = '#00b3ee', $mid_color = '#7a43b6', $color_stop = '50%', $end_color = '#c3325f')
    {
        $start_color = trim($start_color, '#');
        $mid_color = trim($mid_color, '#');
        $end_color = trim($end_color, '#');
        return <<<GRADIENT
background-image: -webmmadmin-linear-gradient(left, #{$start_color} #{$mid_color} $color_stop, #{$end_color} ); 
background-image: -o-linear-gradient(left, #{$start_color} #{$mid_color} $color_stop, #{$end_color}); 
background-image: linear-gradient(to right, #{$start_color} #{$mid_color} $color_stop, #{$end_color}); 
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff{$start_color}', endColorstr='#ff{$end_color}', GradientType=1);
filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
background-repeat: repeat-x;
GRADIENT;
    }

    /**
     * 垂直渐变 
     */
    public static function gradient_3vertical($start_color = '#00b3ee', $mid_color = '#7a43b6', $color_stop = '50%', $end_color = '#c3325f')
    {
        $start_color = trim($start_color, '#');
        $mid_color = trim($mid_color, '#');
        $end_color = trim($end_color, '#');
        return <<<GRADIENT
background-image: -webmmadmin-linear-gradient(top, #{$start_color} #{$mid_color} $color_stop, #{$end_color}); 
background-image: -o-linear-gradient(top, #{$start_color} #{$mid_color} $color_stop, #{$end_color}); 
background-image: linear-gradient(to bottom, #{$start_color} #{$mid_color} $color_stop, #{$end_color}); 
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff{$start_color}', endColorstr='#ff{$end_color}', GradientType=0);
filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
background-repeat: repeat-x;
GRADIENT;
    }

    /**
     * 径向渐变
     */
    public static function gradient_radial($inner_color = '#00b3ee', $outer_color = '#7a43b6')
    {
        return <<<GRADIENT
        background-image: -webmmadmin-radial-gradient(circle, $inner_color, $outer_color);
        background-image: radial-gradient(circle, $inner_color, $outer_color);
        background-repeat: no-repeat;
    GRADIENT;
    }

    /**
     * 透明渐变
     */
    public static function gradient_striped($color = 'rgba(255, 255, 255, .15)', $angle = '45deg')
    {
        return <<<GRADIENT
        background-image: -webmmadmin-linear-gradient($angle, $color 25%, transparent 25%, transparent 50%, $color 50%, $color 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient($angle, $color 25%, transparent 25%, transparent 50%, $color 50%, $color 75%, transparent 75%, transparent);
        background-image: linear-gradient($angle, $color 25%, transparent 25%, transparent 50%, $color 50%, $color 75%, transparent 75%, transparent);
GRADIENT;
    }
}
