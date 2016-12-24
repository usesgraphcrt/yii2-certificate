if (typeof usesgraphcrt == "undefined" || !usesgraphcrt) {
    var usesgraphcrt = {};
}

usesgraphcrt.certificate = {
    init: function() {
        $(document).on('click', '.certificate-enter-btn', this.enter);
        $(document).on('change', '.certificate-enter input', this.enter);
        $(document).on('click', '.certificate-clear-btn', this.clear);

        return true;
    },
    clear: function() {
        var form = $(this).parents('form');
        var data = $(form).serialize();
        data = data+'&clear=1';

        jQuery.post($(form).attr('action'), data,
            function(json) {
                if(json.result == 'success') {
                    $(form).find('input[type=text]').css({'border': '1px solid #ccc'}).val('');
                    $(form).find('.certificate-discount').show('slow').html(json.message);

                    setTimeout(function() { $('.certificate-discount').hide('slow'); }, 2300);

                    if(json.informer) {
                        $('.pistol88-cart-informer').replaceWith(json.informer);
                    }
                }
                else {
                    $(form).find('input[type=text]').css({'border': '1px solid red'});
                    console.log(json.errors);
                }

                return true;

            }, "json");

        return false;
    },
    enter: function() {
        var form = $(this).parents('form');
        var data = $(form).serialize();

        jQuery.post($(form).attr('action'), data,
            function(json) {
                if(json.result == 'success') {
                    $(form).find('input[type=text]').css({'border': '1px solid green'});

                    if(json.informer) {
                        $('.pistol88-cart-informer').replaceWith(json.informer);
                    }
                }
                else {
                    $(form).find('input[type=text]').css({'border': '1px solid red'});
                    console.log(json.errors);
                }

                $(document).trigger("certificateEnter", json.code);

                $(form).find('.certificate-discount').show().html(json.message);

                return true;

            }, "json");

        return false;
    }
};

usesgraphcrt.certificate.init();