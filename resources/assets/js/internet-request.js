$(function () {

    $('#have_equipment').change(function () {
        var checked = $(this).is(':checked');

        if(checked) {
            $('#additional_holder').slideDown();
        } else {
            $('#additional_holder').slideUp();
        }
    });

});