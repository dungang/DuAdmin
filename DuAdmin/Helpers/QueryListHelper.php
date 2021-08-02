<?php


namespace DuAdmin\Helpers;


use QL\QueryList;
use yii\helpers\StringHelper;

class QueryListHelper
{

    public static function extraDescription( $content )
    {
        $ql = QueryList::html( $content );
        $pList = $ql->find( 'p' );
        $txt = '';
        if ( $pList->length() > 0 ) {
            $txt = $pList->eq( 0 )->text();
        } else {
            $txt = $ql->text();
        }
        return static::substrUtf8( $txt, 150, '' );

    }

    public static function substrUtf8( $str, $length = 120, $sign = '...', $start = 0 )
    {
        if ( strlen( $str ) < $length ) {
            return $str;
        }

        $chars = $str;
        $i = 0;
        $m = 0;
        $n = 0;
        do {
            if ( preg_match( "/[0-9a-zA-Z]/", @$chars[ $i ] ) ) {//纯英文
                $m++;
            } else { //非英文字节
                $n++;
            }
            $k = $n / 3 + $m / 2;
            $l = $n / 3 + $m;//最终截取长度；$l = $n/3+$m*2？
            $i++;
        } while ( $k < $length );

        $str1 = mb_substr( $str, $start, $l, 'utf-8' );//保证不会出现乱码
        return $str1 . $sign;
    }
}