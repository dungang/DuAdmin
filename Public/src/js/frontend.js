import { WOW } from "wowjs";
import "./affix-navbar";
import "./fix-col-height";
import "./video-background";
import "./load-more";

$(function() {
    // css3
    var isIE = function(ver) {
        ver = ver || '';
        var b = document.createElement('b');
        b.innerHTML = '<!--[if IE ' + ver + ']>1<![endif]-->';
        return b.innerHTML === '1'
    };
    if (isIE(8) || isIE(7)) {

    } else {
        //        动画
        var wow = new WOW({
            animateClass: 'animated'
        });
        wow.init();
    }
})