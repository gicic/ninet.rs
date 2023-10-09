$(function () {
    /////////////////////////////////////////////////////////////
    //COUNTERS
    ////////let/////////////////////////////////////////////////////
    $("body").on('click', '.counter-trigger', function(e){
        e.preventDefault();
        let handler = $(this);
        let counterStep = parseInt(handler.data("counter-step"), 10);
        let counterMin = parseInt(handler.data("counter-min"));
        let counterMax = parseInt(handler.data("counter-max"));
        let counterType = handler.data("counter-type");
        let counterField = handler.data("counter-field");
        let counterAmount = parseInt($(counterField).val(), 10);
        let priceField = $(handler.data('price-field'));
        let basePrice = parseFloat(handler.data('base-price'));

        if(!isNaN(counterAmount)){
            if(counterType === 'add'){
                if(counterAmount < counterMax) {
                    counterAmount = counterAmount + counterStep;
                }
            }
            else if(counterType === 'minus') {
                if(counterAmount > counterMin) {
                    counterAmount = counterAmount - counterStep;
                }
            }
            if(counterAmount < 1){
                counterAmount = 1;
            }
            handler.parent().find(counterField).val(counterAmount);
            priceField.html(counterAmount * basePrice);
        }
    });
    /////////////////////////////////////////////////////////////
});