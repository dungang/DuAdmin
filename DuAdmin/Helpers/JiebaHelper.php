<?php

namespace DuAdmin\Helpers;

use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\JiebaAnalyse;

class JiebaHelper
{

    private static function init()
    {
        ini_set('memory_limit', '600M');
        Jieba::init( ['dict' => 'small'] );
        Finalseg::init();
    }

    public static function cut( $text )
    {
        static::init();
        return Jieba::cut( $text );
    }

    public static function extraKeywords( $context, $top = 15 )
    {
        static::init();
        JiebaAnalyse::init();
        JiebaAnalyse::setStopWords(__DIR__ . '/jieba_stop_words.txt');
        $tops = JiebaAnalyse::extractTags( $context, $top );
        if ( $tops ) {
            return implode( ",", array_keys( $tops ) );
        }
        return "";
    }
}