$(function () {

    $('#ssl_domain').keyup(function () {
        var domain = $(this).val();

        if(this.value.indexOf('*.') === 0) {
            domain = domain.substring(2);
        }

        console.log(domain);

        $.ajax({
            url: _ssl_confirmation_emails_url,
            type: 'post',
            data: {
                _token: _token,
                domain: domain
            },
            success: function (response) {
                console.log(response);
                if(response.success === true) {
                    $('#ssl_confirmation_email').html(response.view);
                }
            }
        });

        // $('#admin_email').val('admin@' + domain).html('admin@' + domain);
        // $('#administrator_email').val('administrator@' + domain).html('administrator@' + domain);
        // $('#hostmaster_email').val('hostmaster@' + domain).html('hostmaster@' + domain);
        // $('#webmaster_email').val('webmaster@' + domain).html('webmaster@' + domain);
        // $('#postmaster_email').val('postmaster@' + domain).html('postmaster@' + domain);

    });

    var isWildcard = $('#ssl_domain').data('is-wildcard');

    if(isWildcard) {
        $('#ssl_domain').keydown(function () {
            var domain = $(this).val();
            var field = this;
            setTimeout(function () {
                if (field.value.indexOf('*.') !== 0) {
                    $(field).val(domain);
                }
            }, 1);
        });
    }
    /*
    |-------------------------------------------------------------------------
    | SSL CSR Choice
    |-------------------------------------------------------------------------
    */
    $('input[name="radio-csr-choice"]').change(function () {

        if($(this).val() === 'auto') {
            $('#csr_code_form_holder').slideUp(function () {
                $('#csr_auto_form_holder').slideDown();
            });
        } else {
            $('#csr_auto_form_holder').slideUp(function () {
                $('#csr_code_form_holder').slideDown();
                $('#csr_private_key_holder').hide();
            });
        }
    });

    $('#csr_generate_button').click(function () {
        $.blockUI({
            message: $('#blockMessage'),
            css: {
                padding: '25px 15px',
                border: 0
            }
        });

        $('input[id^=ssl_]').removeClass('has-errors');
        $('div[id$=_error_block]').html('');

        $.ajax({
            url: _csr_generate_url,
            type: 'post',
            data: {
                _token: _token,
                country: $('#ssl_country').val(),
                region: $('#ssl_region').val(),
                city: $('#ssl_city').val(),
                company: $('#ssl_company').val(),
                department: $('#ssl_department').val(),
                domain: $('#ssl_domain').val(),
                email: $('#ssl_email').val(),
            },
            success: function (response) {
                $.unblockUI();
                console.log(response);

                if(typeof response.errors !== 'undefined') {
                    $.each(response.errors, function (field, messages) {
                        $.each(messages, function (index, message) {
                            $('#' + field + '_error_block').append('<p>' + message + '</p>');
                            $('#ssl_' + field).addClass('has-errors').focus();
                        });
                    });
                } else {
                    $('#csr_auto_form_holder').slideUp(function () {
                        $('#csr_code_form_holder').slideDown().find('#csr_code').html(response.csr).prop('readonly', true);
                        $('#csr_private_key_holder').slideDown().find('#csr_private_key').html(response.private_key).prop('readonly', true);
                        $('#ssl_agreed_holder').slideDown();
                    });
                }
            },
            error: function (response) {
                $.unblockUI();
                alert('Error generating CSR');
            }
        });

    });

    $('#copy_csr_code').click(function(){
        $('#csr_code').select();
        document.execCommand('copy');
    });

    $('#copy_csr_private_key').click(function(){
        $('#csr_private_key').select();
        document.execCommand('copy');
    });

});