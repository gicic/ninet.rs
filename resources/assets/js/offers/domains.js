$(function () {

    $(document).on('change', 'input[name="domain_tlds[]"]', function (e) {

        var $thisCheckbox = $(this);
        var disabled = $thisCheckbox.is(':checked');
        $.ajax({
            url: _check_domain_compatibility,
            type: 'post',
            data: {
                _token: $('meta[name="xcsrf_token"]').prop('content'),
                productId: $thisCheckbox.val()
            },
            success: function (response) {
                response.disableDomains.forEach(function(index, value) {
                    var element = $('input[value="' + index + '"]');
                    element.prop('disabled', disabled);
                    if(disabled) {
                        element.parent().addClass('disabled');
                    } else {
                        element.parent().removeClass('disabled');
                    }
                });
            }
        });
    });

});