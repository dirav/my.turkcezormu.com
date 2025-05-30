"use strict";

(function ($) {
    $(document).ready(function () {
        $('#license').on('input', function () {
            $('.activation-form button').toggleClass('disabled', $(this).val().length === 0);
        });

        $('.activation-form button').on('click', function (e) {
            e.preventDefault();
            let license = $('#license').val();

            if (license.length > 0) {
                $.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    dataType: 'json',
                    context: this,
                    data: {
                        action: 'appsumo_activate_license',
                        license: license
                    },
                    beforeSend: function () {
                        $('.activation-content .error').hide();
                        $('.activation-form button').addClass('disabled').text('Activating...');
                    },
                    success: function (response) {
                        if (response?.success) {
                            if (typeof response.redirect_to !== 'undefined') {
                                window.location.replace(response.redirect_to);
                            }
                        } else {
                            let error = typeof response.message !== 'undefined' ? response.message : 'Something went wrong.';
                            $('.activation-content .error').show().text(error);
                        }
                    },
                    complete: function () {
                        $('.activation-form button').removeClass('disabled').text('Activate');
                    },
                });
            }
        });
    });
})(jQuery);