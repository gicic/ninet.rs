function generateHTML (html, callback) {
    $('#nestpay_form_holder').html(html);

    if(typeof callback === 'function') {
        callback();
    }
}

function printErrors(errors) {
    var html;
    if(typeof errors['g-recaptcha-response'] !== 'undefined') {
        html = '<ul>';
        for(let i = 0; i < errors['g-recaptcha-response'].length; i++ ){
             html += '<li>' + errors['g-recaptcha-response'][i] + '</li>';
        }
        html += '</ul>';
        $('.recaptcha_error').html(html);
    }

    if(typeof errors['terms_and_conditions'] !== 'undefined') {
        html = '<ul>';
        for(let i = 0; i < errors['terms_and_conditions'].length; i++ ){
            html += '<li>' + errors['terms_and_conditions'][i] + '</li>';
        }
        html += '</ul>';
        $('.terms_and_conditions_error').html(html);
    }
}

function validate (callback) {

    var termsAndConditions = null;

    if($('#terms-and-conditions').is(':checked')) {
        termsAndConditions = 'on';
    }

    $.ajax({
        url: _payment_validation_url,
        type: 'post',
        data: {
            _token: _token,
            'g-recaptcha-response': $('[name="g-recaptcha-response"]').val(),
            'terms_and_conditions': termsAndConditions,
            'payment': $('[name="payment"]').val()
        },
        success: function (data) {
            console.log(data);
            if(data.success != true) {
                $.unblockUI();
                printErrors(data.errors);
            } else if(typeof callback === 'function') {
                callback();
            }
        },
        error: function (data) {
            $.unblockUI();
            console.log(data);
        }
    });
}

function clearErrors() {
    $('.errors-container').html('');
}

$(function () {

    $('#payment_redirect_form').submit(function (e) {

        e.preventDefault();
        var paymentType = $(this).find('input[name=payment]:checked').val();

        if(paymentType === 'card_payment') {
            clearErrors();
            $.blockUI({
                message: $('#blockMessage'),
                css: {
                    padding: '25px 15px',
                    border: 0
                }
            });
            validate(function() {
                $.ajax({
                    url: _nestpay_form_url,
                    type: 'post',
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        generateHTML(data.form, function () {
                            $('#nestpay_payment_form').submit();
                        });
                    },
                    error: function (msg) {
                        $.unblockUI();
                        console.log(msg);
                    }
                });
            });
        } else {
            $(this).unbind().submit();
        }
    });

    $('#apply_promo_code').click(function () {
        var promoCode = $('#promo_code_field').val();

        $.ajax({
            url: _apply_promo_code_url,
            type: 'post',
            data: {
                _token: _token,
                promoCode: promoCode
            },
            success: function (response) {
                if(response.success == false) {
                    $('#promo_code_message_holder').html(response.message);
                    $('#promo_code_success_holder').html('');
                } else {
                    $('#promo_code_message_holder').html('');
                    $('#promo_code_success_holder').html(response.message);
                }
                reloadCarts();
            },
            error: function (msg) {
                reloadCarts();
            }
        });
    });

});



/*
 * Cart data reload after ajax call
 */
function reloadCarts() {
    cartReload();
    cartPaymentsReload();
}

function cartReload() {
    $.ajax({
        url: _get_cart_view_url,
        type: 'get',
        success: function (response) {
            $('.cart-holder').html(response);
        }
    });
}

function cartPaymentsReload() {
    $.ajax({
        url: _get_payments_cart_view_url,
        type: 'get',
        success: function (response) {
            console.log(response);
            $('#cart_table_div').html(response);
        }
    });
}
