<script>
    $(function () {

        $('.js-domain-results-trigger').on('click', function () {
            $('.js-domain-search-block').toggleClass('domain-search-open');
            $('.js-domain-results-holder').slideToggle();
        });

        $('#domain-search-form').on('submit', function (e) {

            e.preventDefault();

            $('.domain-errors').html('').hide();

            let domainSld = $('#domain-search-name').val();

            if (domainSld === '') {
                $('.js-domain-search-block').removeClass('domain-search-open');
                $('.js-domain-results-holder').slideUp();
                $('#add_domains_button').slideUp();
                $('#webglobe-link').slideUp();

            } else {
                $('.js-domain-search-block').addClass('domain-search-open');
                $.blockUI({
                    message: $('#blockMessage'),
                    css: {
                        padding: '25px 15px',
                        border: 0
                    }
                });
                $.ajax({
                    url: '{{ route('list.domains') }}',
                    type: 'post',
                    data: {
                        _token: _token,
                        domainSld: domainSld
                    },
                    success: function (response) {
                        $('.js-domain-results-holder').find('#domains-list').html(response);
                        $('.js-domain-results-holder').slideDown();
                        $('#add_domains_button').slideDown();
                        $('#webglobe-link').slideDown();
                        $.unblockUI();
                    },
                    error: function (response) {
                        console.log(response);
                        $.unblockUI();
                    }
                });
            }
        });

        $(document).on('change', '.domains_selection_item', function () {
            let $thisCheck = $(this);

            let total = 0;
            $('.domains_selection_item').each(function () {
                if($(this).is(':checked')) {
                    total += $(this).data('domain-price');
                }
            });

            $('#domain_price_total > #price_amount').html(total);
        });

    });
</script>