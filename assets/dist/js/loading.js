(function ($) {
    $.each(['load', 'hide', 'fadeOut', 'fadeIn'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
            var result = el.apply(this, arguments);
            result.promise().done(function () {
                this.triggerHandler(ev, [result]);
            })
            return result;
        };
    });
})(jQuery);
/*$(window).on('shown.bs.modal', function() { 
    alert('shown');
});*/
$('div').on('load', function() { 
    $(this).html('<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>');
});
