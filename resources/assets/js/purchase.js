$(function () {

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $('input.has-errors:first').focus();

    $('#login-register-select').change(function () {
        let $thisVal = $(this).val();

        if($thisVal === 'guest') {
            $('.auth-user-data-block').slideUp();
            $('#user_id').val('');
        }

    });

    $('#user_login_submit').click(function (e) {
        e.preventDefault();

        let $thisButton = $(this);
        $thisButton.prop('disabled', true);

        let email_field = $('#user_login_email');
        let password_field = $('#user_login_password');

        // clear errors
        $('.password-error-block, .email-error-block').html('');
        email_field.removeClass('has-errors');
        password_field.removeClass('has-errors');

        $.ajax({
            url: _purchase_login_url,
            type: 'post',
            data: {
                _token: _token,
                email: email_field.val(),
                password: password_field.val()
            },
            success: function (response) {

                let user_data = response.data;

                $('#first_name_info').html(user_data.first_name);
                $('#last_name_info').html(user_data.last_name);
                $('#email_info').html(user_data.email);
                $('#phone_info').html(user_data.phone);
                $('#country_info').html(user_data.country);
                $('#city_info').html(user_data.city);
                $('#address_info').html(user_data.address);
                $('#postal_code_info').html(user_data.postal_code);
                $('#company_name_info').html(user_data.company_name);
                $('#company_registration_number_info').html(user_data.company_registration_number);
                $('#company_tax_number_info').html(user_data.company_tax_number);

                $('.bp-login-block').slideUp();
                $('.auth-user-data-block').slideDown();

                $thisButton.prop('disabled', false);

            },
            error: function (response) {
                let responseJSON = response.responseJSON;

                if(responseJSON.success === false) {
                    if(typeof responseJSON.errors.email !== 'undefined') {
                        email_field.addClass('has-errors');
                        $.each(responseJSON.errors.email, function (key, value) {
                            $('.email-error-block').append('<p>' + value + '</p>');
                        });
                    }
                    if(typeof responseJSON.errors.password !== 'undefined') {
                        password_field.addClass('has-errors');
                        $.each(responseJSON.errors.password, function (key, value) {
                            $('.password-error-block').append('<p>' + value + '</p>');
                        });
                    }
                }
                $thisButton.prop('disabled', false);
            }
        });

    });

    $('#country').change(function () {
        var $thisCountry = $(this);

        $.ajax({
            url: _get_dial_code_url,
            type: 'post',
            data: {
                _token: _token,
                countryId: $thisCountry.val()
            },
            success: function (response) {
                $('#dial_code').val(response.dial_code);
            },
            error: function (msg) {
                console.log(msg);
            }
        });
    });

});