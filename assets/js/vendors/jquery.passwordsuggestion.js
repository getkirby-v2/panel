(function ($) {

    $.fn.suggestPassword = function () {
        var len = 16,
            set = ['abcdefghjkmnpqrstuvwxyz', 'ABCDEFGHJKMNPQRSTUVWXYZ', '23456789', '!@#$%&*?'],
            a = '',
            pw = '';

        $.each(set, function (i, v) {
            var l = set[i].split("");
            pw += l[Math.floor(l.length * Math.random())];
            a += set[i];
        });

        a = a.split("");

        for (i = 0; i < (len - set.length); i++) {
            pw += a[Math.floor(a.length * Math.random())];
        }

        pw = str_shuffle(pw);

        var d_len = Math.floor(Math.sqrt(len)),
            d_str = "";

        while (pw.length > d_len) {
            d_str += pw.substr(0, d_len) + '-';
            pw = pw.substr(d_len);
        }

        return d_str;
    };

    $.fn.fillPassword = function () {
      this.val($('.pw-suggestion').text());
    };

})(jQuery);


function str_shuffle(s) {
    //  credit: http://phpjs.org/functions/str_shuffle/
    if (s === null) {
        return '';
    }

    s += '';
    var nStr = '',
        r,
        i = s.length;

    while (i) {
        r = Math.floor(Math.random() * i);
        nStr += s.charAt(r);
        s = s.substring(0, r) + s.substr(r + 1);
        i--;
    }

    return nStr;
}
