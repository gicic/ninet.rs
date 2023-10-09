function preparePage() {
    $('#email2, #email3, #email4, #email5, #email6, #email7, #email8, #email9, #email10, #email11, #email12, #email13, #email14, #email15, #email16, #email17, #email18, #email19, #email20, #email21, #email22, #email23, #email24, #email25, #email26, #email27, #email28, #email29, #email30, #removeEmail').hide();
}

if (!$('[name="is_legal_entity"]').is(':checked')) {
    $('.legal-entity').hide();
}

$('[name="is_legal_entity"]').click(function() {
    $('.legal-entity').toggle(700);
});

window.onload = preparePage;


$('#addEmail').click(function () {
    let count = $('.email:visible').length;

    $('#email' + (count + 1)).slideDown(700);

    if(count > 0) {
        $('#removeEmail').show();
    }

    if(count === 29) {
        $('#addEmail').hide();
    }
});


$('#removeEmail').click(function () {
    let count = $('.email:visible').length;

    $('#email' + count).slideUp(700);
    $('.email'+ count).val('');

    if(count <= 30) {
        $('#addEmail').show();
    }

    if(count === 2) {
        $('#removeEmail').hide();
    }
});

$('.email').keyup(function () {
    let count = $('.email:visible').length;
    $('.email' + count).keyup(function () {
        if (this.value.endsWith('@medianis.net')) {
            $('.error' + count).html('Obrišite @medianis.net iz polja za unos email adrese!').show();
            $('#submit').prop('disabled', true);
        } else {
            $('.error' + count).hide();
            $('#submit').prop('disabled', false);
        }

        var values = [];
        for (i= 1; i<30; i++){
            if (i !== count){
                values.push($('.email' + i).val());
            }
        }
        if (values.includes(this.value) && this.value !== ''){
            $('.error' + count).html('Ne možete upisati istu e-mail adresu više puta!').show();
            $('#submit').prop('disabled', true);
        }
    });
});
