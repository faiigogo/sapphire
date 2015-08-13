/*!
 * Check ID Card Thai
 * Version: 2.0
 */

(function($) {
    $.fn.CheckIdCardThai = function(options) {
        var setOpt = $.extend({
            process: "check"
        }, options);

        var CheckIdCardIsNumeric = function(input) {
//            var RE = /^-?(9|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
            var RE = /^[0-9]+$/;
            return (RE.test(input));
        };

        var check = function(id) {
            id = id.toString();
            id = id.replace('-', '');
            // for support jquery masked input
            id = id.replace('-', '');
            id = id.replace('-', '');
            id = id.replace('-', '');

            if (!CheckIdCardIsNumeric(id))
                return false;
//            if (id.substring(0, 1) == 1)
//			    return false;
            if (id.length != 13)
                return false;
            for (i = 0, sum = 0; i < 12; i++)
                sum += parseFloat(id.charAt(i)) * (13 - i);
            if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
                return false;
            return true;
        };

        if (setOpt.process == "check") {
            return check(this.val());
        } else {
            return false;
        }
    };

    $.fn.RandomIdCardThai = function() {

        id = "0";

        for (i = 0; i < 11; i++) {
            id += parseInt(Math.random() * 10);

        }
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(id.charAt(i)) * (13 - i);
        modsum = 11 - (sum % 11);

        if (modsum > 9) {
            modsum = modsum.toString();
            modsum = modsum.substr(1, 1)
        }

        fullid = id + modsum;
        jQuery(this).val(fullid);

    };
})(jQuery);
