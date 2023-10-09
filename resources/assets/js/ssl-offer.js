$(function () {

    $('.advice-holder').find('a[data-next="trigger"]').click(function(e) {
        e.preventDefault();

        let nextStep = $(this).data('next-step');

        $(this).closest('div[class^="advice-step"]').fadeOut(function () {
            if(nextStep === 'finish') {

                let domainTypeAnswer = $('input[name="domain_type_question"]:checked').val();
                let domainsNumberAnswer = $('input[name="domains_number_question"]:checked').val();
                let wildcardAnswer = $('input[name="wildcard_question"]:checked').val();

                let answer1 = $('input[name="domain_type_question"]:checked').next('label').html();
                let answer2 = $('input[name="domains_number_question"]:checked').next('label').html();
                let answer3 = $('input[name="wildcard_question"]:checked').next('label').html();

                $('#ssl_condition_1').html(answer1);
                $('#ssl_condition_2').html(answer2);
                $('#ssl_condition_3').html(answer3);

                $.ajax({
                    url: _ssl_products_url,
                    type: 'post',
                    data: {
                        _token: _token,
                        domainTypeAnswer: domainTypeAnswer,
                        domainsNumberAnswer: domainsNumberAnswer,
                        wildcardAnswer: wildcardAnswer
                    },
                    success: function (response) {
                        $('#advice-products-holder').html(response.view);
                        $('#advice_result').fadeIn();
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });

            } else {
                $('.advice-step' + nextStep).fadeIn();
            }
        });
    });

    $('.advice-holder').find('a[data-previous="trigger"]').click(function(e) {
       e.preventDefault();

       let previousStep = $(this).data('previous-step');

       $(this).closest('div[class^="advice-step"]').fadeOut(function() {

           $('.advice-step' + previousStep).fadeIn();

       });

    });

});