/*!
 * jquery.custom-animations.js 0.1
 * https://github.com/yckart/jquery-custom-animations
 *
 *
 * Copyright (c) 2012 Yannick Albert (http://yckart.com)
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
 * 2013/02/08
**/


/*!
 * @param {number} times - The number of fades
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.flash = function (times, duration, easing, complete) {
    times = (times || 2) * 2;
    while(times--){
        this.animate({
            opacity: !(times % 2)
        }, duration, easing, complete);
    }
    return this;
};



/*!
 * @param {number} times - The number of shakes
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.wiggle = function (times, duration, easing, complete) {
    var self = this;

    if (times > 0) {
        this.animate({
            marginLeft: times-- % 2 === 0 ? -15 : 15
        }, duration, easing, function () {
            self.wiggle(times, duration, easing, complete);
        });
    } else {
        this.animate({
            marginLeft: 0
        }, duration, easing, function () {
            if (jQuery.isFunction(complete)) {
                complete();
            }
        });
    }
    return this;
};



/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.zap = function (duration, easing, complete) {
    return this.css({
        overflow: 'hidden'
    }).animate({
        padding: 'toggle',
        width: 'toggle',
        height: 'toggle',
        margin: this.outerHeight() / 2 === parseFloat(this.css('marginTop')) || this.outerWidth() / 2 === parseFloat(this.css('marginLeft')) ? 0 : this.outerHeight() / 2 + ' ' + this.outerWidth() / 2
    }, jQuery.speed(duration, easing, complete));
};



/*!
 * @param {number} duration - The speed amount
 * @param {number} to - The opacity value to toggle
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.fadeToToggle = function (duration, to, easing, complete) {
    return this.animate({
        opacity: parseFloat(this.css('opacity')) < 1 ? 1 : to
    }, jQuery.speed(duration, easing, complete));
};



/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.slideFadeToggle = function (duration, easing, complete) {
    return this.animate({
        opacity: 'toggle',
        height: 'toggle'
    }, jQuery.speed(duration, easing, complete));
};


/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blowToggle = function (duration, easing, complete) {
    return this.animate({
        zoom: parseFloat(this.css('zoom')) < 4 ? 4 : 1,
        opacity: parseFloat(this.css('opacity')) < 1 ? 1 : 0
    }, jQuery.speed(duration, easing, complete));
};

/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blowOut = function (duration, easing, complete) {
    return this.animate({
        zoom: 8,
        opacity: 0
    }, jQuery.speed(duration, easing, complete));
};

/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blowIn = function (duration, easing, complete) {
    return this.animate({
        zoom: 1,
        opacity: 1
    }, jQuery.speed(duration, easing, complete));
};



/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindLeftToggle = function (duration, easing, complete) {
    return this.animate({
        marginLeft: parseFloat(this.css('marginLeft')) < 0 ? 0 : -this.outerWidth()
    }, jQuery.speed(duration, easing, complete));
};

/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindLeftOut = function (duration, easing, complete) {
    return this.animate({
        marginLeft: -this.outerWidth()
    }, jQuery.speed(duration, easing, complete));
};

/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindLeftIn = function (duration, easing, complete) {
    return this.animate({
        marginLeft: 0
    }, jQuery.speed(duration, easing, complete));
};



/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindRightToggle = function (duration, easing, complete) {
    return this.animate({
        marginLeft: -(parseFloat(this.css('marginLeft'))) < 0 ? 0 : this.outerWidth()
    }, jQuery.speed(duration, easing, complete));
};

/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindRightOut = function (duration, easing, complete) {
    return this.animate({
        marginLeft: this.outerWidth()
    }, jQuery.speed(duration, easing, complete));
};

/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindRightIn = function (duration, easing, complete) {
    return this.animate({
        marginLeft: 0
    }, jQuery.speed(duration, easing, complete));
};



/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindUpToggle = function (duration, easing, complete) {
    return this.animate({
        marginTop: parseFloat(this.css('marginTop')) < 0 ? 0 : -this.outerHeight()
    }, jQuery.speed(duration, easing, complete));
};

/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindUpOut = function (duration, easing, complete) {
    return this.animate({
        marginTop: -this.outerHeight()
    }, jQuery.speed(duration, easing, complete));
};

/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindUpIn = function (duration, easing, complete) {
    return this.animate({
        marginTop: 0
    }, jQuery.speed(duration, easing, complete));
};



/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindDownToggle = function (duration, easing, complete) {
    return this.animate({
        marginTop: -parseFloat(this.css('marginTop')) < 0 ? 0 : this.outerHeight()
    }, jQuery.speed(duration, easing, complete));
};

/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindDownOut = function (duration, easing, complete) {
    return this.animate({
        marginTop: this.outerHeight()
    }, jQuery.speed(duration, easing, complete));
};

/*!
 * @param {number} duration - The speed amount
 * @param {string} easing - The easing method
 * @param {function} complete - A callback function
**/
jQuery.fn.blindDownIn = function (duration, easing, complete) {
    return this.animate({
        marginTop: 0
    }, jQuery.speed(duration, easing, complete));
};

var win = $(window),
    $box = $('.box'),
    item = $('.area'),
    current = $('.inView'),
    scroller = $('.outer');

$(function () {

    $('input').click(function(){
        var self = $(this);
        // $(this).parent().find('code').html($.fn[this.id].toString());
        // scroller.css({top: self.parent('.area').offset().top+10});
    });

    $('#wiggle').click(function () {
        $box.wiggle(4);
    });

    $('#zap').click(function () {
        $box.zap('slow');
    });

    $('#flash').click(function () {
        $box.flash();
    });



    $('#blowOut').click(function () {
        $box.blowOut('slow');
    });
    $('#blowIn').click(function () {
        $box.blowIn('slow');
    });
    $('#blowToggle').click(function () {
        $box.blowToggle('slow');
    });



    $('#blindLeftToggle').click(function () {
        $box.blindLeftToggle('slow');
    });
    $('#blindLeftIn').click(function () {
        $box.blindLeftIn('slow');
    });
    $('#blindLeftOut').click(function () {
        $box.blindLeftOut('slow');
    });


    $('#blindRightToggle').click(function () {
        $box.blindRightToggle('slow');
    });
    $('#blindRightIn').click(function () {
        $box.blindRightIn('slow');
    });
    $('#blindRightOut').click(function () {
        $box.blindRightOut('slow');
    });


    $('#fadeToToggle').click(function () {
        $box.fadeToToggle('slow', '0.5');
    });


    $('#slideFadeToggle').click(function () {
        $box.slideFadeToggle('slow');
    });

    $('#slideFadeIn').click(function () {
        $box.slideFadeIn('slow');
    });
    $('#slideFadeOut').click(function () {
        $box.slideFadeOut('slow');
    });



    $('#blindUpToggle').click(function () {
        $box.blindUpToggle('slow');
    });

    $('#blindUpIn').click(function () {
        $box.blindUpIn('slow');
    });
    $('#blindUpOut').click(function () {
        $box.blindUpOut('slow');
    });

    $('#blindDownToggle').click(function () {
        $box.blindDownToggle('slow');
    });
    $('#blindDownIn').click(function () {
        $box.blindDownIn('slow');
    });
    $('#blindDownOut').click(function () {
        $box.blindDownOut('slow');
    });
});


win.scroll(function () {
    var cutoff = win.scrollTop() + (win.height() / item.length);
    item.each(function () {
        var self = $(this),
            offset = self.offset().top;

        if (offset + self.height() > cutoff + 100){
            item.removeClass('inView');
            current = self.addClass('inView');

            scroller.stop().css({
                top: offset + 10
            }).find('a.animate').text(current.text());

            $('a.reset').toggle(current.find('.box').is(':hidden'));

            return false; // stops the iteration after the first one on screen
        }
    });
}).scroll();