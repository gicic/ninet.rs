/////////////////////////////////////////////////////////////
//FIXED HEADER
/////////////////////////////////////////////////////////////
function fixedHeader(){
// Fixed Header
    var topOffset = $(window).scrollTop();
    if(topOffset > 350){
        $('body').addClass('fixed-header');
    }
    $(window).on('scroll', function(){
        var fromTop = $(this).scrollTop();
        if(fromTop > 350){
            $('body').addClass('fixed-header');
        }
        else{
            $('body').removeClass('fixed-header');
        }

    });
}
fixedHeader();


/////////////////////////////////////////////////////////////
//CUSTOM DROPDOWN
/////////////////////////////////////////////////////////////
/*
 HTML STRUCTURE:
 <div class="c-drop-holder" data-drop="holder">
 <a class="c-drop-trigger" data-drop="trigger">Trigger text</a>
 <div class="c-drop-content" data-drop="content">    </div>
 </div>
 */

//custom dropdown
$('body').on('click', '*[data-drop="trigger"]', function (e) {
    e.preventDefault();

    var $dropHolder = $(this).closest('[data-drop="holder"]');

    if ($dropHolder.hasClass('drop-open')) {
        $dropHolder.removeClass('drop-open');
    } else {
        $('[data-drop="holder"]').removeClass('drop-open');
        $dropHolder.addClass('drop-open');
    }
});

//custom dropdown close on click outside
$(document).click(function (e) {
    if (!($(e.target).is('[data-drop="holder"], [data-drop="holder"] *'))) {
        $('[data-drop="holder"]').removeClass('drop-open');
    }
});

/////////////////////////////////////////////////////////////
//CUSTOM CHECKBOXES
/////////////////////////////////////////////////////////////
/*
 HTML STRUCTURE:
 <div class="checkbox" data-checkbox="block">
 <input type="checkbox" id="someID" name="someNAME" value="1" checked="checked">
 <label for="someID" class="active">Some label text</label>
 </div>
 */
$('*[data-checkbox="block"] input[type="checkbox"]').on('change', function () {
    if($(this).is(':checked')) {
        $(this).siblings('label').addClass('active');
    } else {
        $(this).siblings('label').removeClass('active');
    }
    // $(this).siblings("label").toggleClass("active");
});

/////////////////////////////////////////////////////////////
//CUSTOM RADIO BUTTONS
/////////////////////////////////////////////////////////////
/*
 HTML STRUCTURE:
 <div class="radio-box" data-radio="block">
 <div>
 <input type="radio" name="some_name" value="some_value_1" id="radio1" checked>
 <label class="active" for="radio1">Radio button name 1</label>
 </div>
 <div>
 <input type="radio" name="some_name" value="some_value_2" id="radio2">
 <label for="radio2">Radio button name 2</label>
 </div>
 </div>
 */
$('*[data-radio="block"] input[type="radio"]').on('change', function () {
    $(this).closest('[data-radio="block"]').find("label:not(.checkbox-label)").removeClass("active");
    $(this).siblings("label").addClass("active");
});


/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//IMAGE POSITIONING
/////////////////////////////////////////////////////////////
/*
 HTML STRUCTURE:
 <div class="ratiox-x" data-positioning="holder">
 <img data-positioning="img" src="<?php echo base_url('some-image...') ?>" alt=""/>
 </div>
 */

//image positioning
function imagePositioning() {
    $('*[data-positioning="img"]').delay(10).queue(function () {

        var image = $(this),
            imageHolder = $(this).closest('[data-positioning="holder"]');
        image.src = $(this).attr("src");
        var imageHeight = image.get(0).naturalHeight,
            imageWidth = image.get(0).naturalWidth,
            imageHolderHeight = imageHolder.height(),
            imageHolderWidth = imageHolder.width();

        var imgProp = imageHeight / imageWidth,
            imgHolderProp = imageHolderHeight / imageHolderWidth;

        image.addClass('cover-img');
        imageHolder.addClass('image-holder');

        if (imgProp > imgHolderProp) {
            $(this).addClass('align-width');
        } else {
            $(this).addClass('align-height');
        }
    });
};

/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//DOMAIN SEARCH BLOCK
/////////////////////////////////////////////////////////////
$('.js-domain-results-trigger').on('click', function(){
    $('.js-domain-search-block').toggleClass('domain-search-open');
    $('.js-domain-results-holder').slideToggle();
})

$('input.js-find-domain').on('keyup', function() {
    if($(this).val()=='') {
        $('.js-domain-search-block').removeClass('domain-search-open');
        $('.js-domain-results-holder').slideUp();
    } else {
        $('.js-domain-search-block').addClass('domain-search-open');
        $('.js-domain-results-holder').slideDown();
    }
});
/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//SHOW/HIDE CONTENT (SLIDE)
/////////////////////////////////////////////////////////////
/*
 HTML STRUCTURE:
 <a data-slide-trigger="someNAME"></a>
 <div data-slide-content="someNAME"></div>
 */

//hide all content first
if (($('[data-slide-content]')).length) {
    $('[data-slide-content]').hide();
}

//toggle slide
$('[data-slide-trigger]').on('click', function (e) {
    if ($(e.target).is('a')) {
        e.preventDefault();
    }
    var dataValue = ($(this).data('slide-trigger'));
    $('*[data-slide-content="' + dataValue + '"]').slideToggle();
});

/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//SHOW/HIDE CONTENT FOR USER TYPE ON REGISTRATION PAGE
/////////////////////////////////////////////////////////////
$('[name="user_type_register"]').click(function () {
    if ($(this).val() === 'individual_register') {
        $('#company-data-holder-register').slideUp();
    }
    else {
        $('#company-data-holder-register').slideDown();
    }
});
$('[name="user_type_guest"]').click(function () {
    if ($(this).val() === 'individual_guest') {
        $('#company-data-holder-guest').slideUp();
    }
    else {
        $('#company-data-holder-guest').slideDown();
    }
});
/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//SHOW/HIDE CONTENT FOR USER TYPE ON REGISTRATION PAGE
/////////////////////////////////////////////////////////////
$('#login-register-select').on('change', function(){
    console.log($(this));
    if($(this).val() == 'reg') {
        $('.bp-register-block').slideDown();
        $('.bp-login-block').slideUp();
        $('.bp-guest-block').slideUp();
    } else if($(this).val() == 'log') {
        $('.bp-register-block').slideUp();
        $('.bp-login-block').slideDown();
        $('.bp-guest-block').slideUp();
    } else {
        $('.bp-register-block').slideUp();
        $('.bp-login-block').slideUp();
        $('.bp-guest-block').slideDown();
    }
});
/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//
/////////////////////////////////////////////////////////////
$('*[data-radio="blockDomainType"] input[type="radio"]').on('click', function () {
    $(this).closest('[data-radio="blockDomainType"]').find("label.domain-label").removeClass("active");
    $(this).siblings("label.domain-label").addClass("active");
    if ($(this).val() === 'domain_type_1') {
        $('#domain-type-2').slideUp();
        $('#domain-type-1').slideDown();
    }
    else {
        $('#domain-type-1').slideUp();
        $('#domain-type-2').slideDown();
    }
});
/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
// SCROLLBAR
/////////////////////////////////////////////////////////////
$('.scroll-holder').scrollbar({
    ignoreMobile: true
});


function cartScrollbar(){
    $('.cart-items-scroller').scrollbar({
        ignoreMobile: true
    });
    if($('.cart-items-list').height() > $('.cart-items-scroller').height() ) {
        $('.cart-items-scroller').removeClass('no-scrollbar');
    } else {
        $('.cart-items-scroller').addClass('no-scrollbar');
    }
}
cartScrollbar();

$('body').on('click', '.cart-preview', function(){
    cartScrollbar();
});

/////////////////////////////////////////////////////////////

$('body').on('click', '.cart-preview', function(){
    $('.scroll-holder').scrollbar({
        ignoreMobile: true
    });
});

/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//COUNTERS
/////////////////////////////////////////////////////////////
// $("body").on('click', '.counter-trigger', function(e){
//     e.preventDefault();
//     var handler = $(this);
//     var counterStep = parseInt(handler.data("counter-step"), 10);
//     var counterType = handler.data("counter-type");
//     var counterField = handler.data("counter-field");
//     var counterAmount = parseInt($(counterField).val(), 10);
//     if(!isNaN(counterAmount)){
//         if(counterType == 'add'){
//             counterAmount = counterAmount + counterStep;
//         }
//         else if(counterType == 'minus'){
//             counterAmount = counterAmount - counterStep;
//         }
//         if(counterAmount < 1){
//             counterAmount = 1;
//         }
//         handler.parent().find(counterField).val(counterAmount);
//     }
// });

/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//SLIDERS
/////////////////////////////////////////////////////////////

//homepage slider
$('.homepage-slider').slick({
    dots: true,
    arrows: false
});

//brands slider
$('.brands-slider').slick({
    autoplay: true,
    autoplaySpeed: 3000,
    infinite: true,
    slidesToShow: 5,
    centerMode: true,
    variableWidth: true,
    arrows: false,
    pauseOnHover: false,
    pauseOnFocus: false
});

//testimonials slider
$('.testimonials-slider').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    swipeToSlide: true,
    prevArrow: '<span class="slick-arr slick-prev"><span class="fa fa-angle-left"></span></span>',
    nextArrow: '<span class="slick-arr slick-next"><span class="fa fa-angle-right"></span></span>',
    adaptiveHeight: true,
    responsive: [
        {
            breakpoint: 576,
            settings: {
                dots: true,
                arrows: false
            }
        }
    ]
});

//testimonials slider type 3
$('.testimonials-slider-t2').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    swipeToSlide: true,
    arrows: false,
    dots: true,
    adaptiveHeight: true,
    responsive: [
        {
            breakpoint: 576,
            settings: {
                dots: true,
                arrows: false
            }
        }
    ]
});

/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
// SIDR (MAIN MENU)
/////////////////////////////////////////////////////////////
$('.main-menu-trigger').on('click', function(e){
    e.preventDefault();
});
$('.main-menu-trigger').sidr({
    name: 'sidr-main',
    source: '#navigation',
    displace: false,
    renaming: false,
    side: 'right'
});



$(document).on("click", function () {
    $.sidr('close', 'sidr-main');
});



/////////////////////////////////////////////////////////////
//TABS
/////////////////////////////////////////////////////////////
$(".c-tab").each(function(){
    $(this).find('li').first().addClass('active');
    $(this).closest('.container').find('.tab-content').find('.tab-pane').first().addClass('active');
    $(this).on('click', 'a', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//STICKY SIDEBAR
/////////////////////////////////////////////////////////////
var elements = $('.sticky');
Stickyfill.add(elements);
/////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////
//DEO ZA DODAVANJE U KORPU I IZBACIVANJE IZ KORPE NA FRONTU
/////////////////////////////////////////////////////////////
// $('a[data-cart="trigger"]').on('click', function(e){
//
//     e.preventDefault();
//
//     var cartItemID = '';
//     var cartItemData1 = '';
//     var cartItemData1Code = '';
//     var cartItemData2 = '';
//     var cartItemData2Code = '';
//     var cartItemPrice = '';
//     var cartItemPriceCode = '';
//     var cartItemQty = '';
//     var cartItemDuration = '';
//     var cartItemDurationCode = '';
//
//     var cartItem = $(this).closest('[data-cart="item"]');
//
//     if(cartItem.attr('data-cart-id')!='') {
//         cartItemID = cartItem.data('cartId');
//     }
//
//     if(cartItem.find('.counter').length) {
//         cartItemQty = cartItem.find('.counter').find('input').val();
//     }
//
//     if(cartItem.attr('[data-cart-data1]')!='') {
//         cartItemData1 = cartItem.data('cartData1');
//         if(cartItemData1 != '') {
//
//             if(cartItemQty != '' && cartItemQty != '1') {
//                 cartItemData1Code = '<span>' + cartItemQty + ' X ' + cartItemData1 + '</span>';
//             } else {
//                 cartItemData1Code = '<span>' + cartItemData1 + '</span>';
//             }
//
//         }
//     }
//
//     if(cartItem.attr('[data-cart-data2]')!='') {
//         cartItemData2 = cartItem.data('cartData2');
//         if(cartItemData2 != '') {
//             cartItemData2Code = '<span>' + cartItemData2 + '</span>';
//         }
//     }
//
//     if(cartItem.find('[data-cart-price]')!='') {
//         cartItemPrice = cartItem.data('cartPrice');
//         if(cartItemPrice != '') {
//             if(cartItemQty != '' && cartItemQty != '1') {
//                 cartItemPriceCode = '<div class="item-price">' + cartItemQty * cartItemPrice + '&euro;</div>';
//             } else {
//                 cartItemPriceCode = '<div class="item-price">' + cartItemPrice + '&euro;</div>'
//             }
//         }
//     }
//
//     if(cartItem.attr('[data-cart-duration]')!='') {
//         cartItemDuration = cartItem.data('cartDuration');
//         if(cartItemDuration != '') {
//             cartItemDurationCode = '<div class="item-duration">Vreme: <span>' + cartItemDuration + '</span></div>'
//         }
//     }
//
//     $('[data-cart="list"]').append('' +
//     '<li data-cart="item" data-cart-id="' + cartItemID + '">' +
//     '<h3 class="item-name">' +
//     cartItemData1Code+
//     cartItemData2Code+
//     '</h3>' +
//     cartItemDurationCode+
//     cartItemPriceCode+
//     '<a href="#" class="remove-item" data-cart="remove"><span class="fa fa-close"></span></a>' +
//     '</li>');
//
//     $('[ data-cart="empty"]').hide();
//
//     cartScrollbar();
// })
//
// $('a[data-cart-additional="trigger"]').on('click', function(e){
//
//     e.preventDefault();
//
//     var cartItemID = '';
//     var cartItemData1 = '';
//     var cartItemData1Code = '';
//     var cartItemData2 = '';
//     var cartItemData2Code = '';
//     var cartItemPrice = '';
//     var cartItemPriceCode = '';
//     var cartItemQty = '';
//     var cartItemDuration = '';
//     var cartItemDurationCode = '';
//     var additionalFor = '';
//
//     var cartItem = $(this).closest('[data-cart="item"]');
//
//
//     if(cartItem.attr('data-cart-id')!='') {
//         cartItemID = cartItem.data('cartId');
//     }
//
//     if(cartItem.find('.counter').length) {
//         cartItemQty = cartItem.find('.counter').find('input').val();
//     }
//
//     if(cartItem.attr('[data-cart-data1]')!='') {
//         cartItemData1 = cartItem.data('cartData1');
//         if(cartItemData1 != '') {
//             cartItemData1Code = '<span>'+ cartItemData1 + '</span>';
//
//         }
//     }
//
//     if(cartItem.attr('[data-cart-data2]')!='') {
//         cartItemData2 = cartItem.data('cartData2');
//         if(cartItemData2 != '') {
//             cartItemData2Code = '<span>' + cartItemData2 + '</span>';
//         }
//     }
//
//     if(cartItem.find('[data-cart-price]')!='') {
//         cartItemPrice = cartItem.data('cartPrice');
//         if(cartItemPrice != '') {
//             cartItemPriceCode = '<span class="additional-item-price">' + cartItemPrice + '&euro;</span>'
//         }
//     }
//
//     if(cartItem.attr('[data-cart-duration]')!='') {
//         cartItemDuration = cartItem.data('cartDuration');
//         if(cartItemDuration != '') {
//             cartItemDurationCode = '<div class="item-duration">Vreme: <span>' + cartItemDuration + '</span></div>'
//         }
//     }
//
//     if(cartItem.attr('[data-cart-additional-for]')!='') {
//         additionalFor = cartItem.data('cartAdditionalFor');
//     }
//
//     console.log('[data-cart-additional="'+ additionalFor +'"]');
//
//     $('*[data-cart-additional="'+ additionalFor +'"]').append('' +
//     '<div class="additional-item" data-cart-additional-id="' + cartItemID + '">' +
//     '<a href="" class="remove-additional-item" data-cart-additional="remove"><span class="fa fa-close"></span></a>' +
//     cartItemData1Code + ' ' + cartItemData2Code + ' ' + '<span>(x' + cartItemQty + ')</span>' + cartItemPriceCode +
//     '<span class="additional-item-price">' + cartItemPriceCode + '</span>' +
//     '</div>');
//
//     $('[ data-cart="empty"]').hide();
//
//     cartScrollbar();
// })
//
// $('[data-cart="list"]').on('click', 'a[data-cart="remove"]', function(e){
//
//     e.preventDefault();
//
//     var cartItemRemoveID = '';
//
//     cartItemRemoveID = $(this).closest('[data-cart="item"]').data('cartId');
//
//     if($(this).closest('[data-cart="list"]').find('li').length == 1) {
//         $('*[data-cart="empty"]').show();
//     }
//
//     $('[data-cart="list"]').find('*[data-cart-id="' + cartItemRemoveID + '"]').remove();
// })
//
// $('[data-cart="list"]').on('click', 'a[data-cart-additional="remove"]', function(e){
//
//     e.preventDefault();
//
//     var cartItemRemoveID = '';
//
//     cartItemRemoveID = $(this).closest('.additional-item').data('cartAdditionalId');
//
//     if($(this).closest('[data-cart="list"]').find('li').length == 1) {
//         $('*[data-cart="empty"]').show();
//     }
//
//     $('[data-cart="list"]').find('*[data-cart-additional-id="' + cartItemRemoveID + '"]').remove();
// })

//<div data-cart="item" data-cart-id="x">
//<span data-cart="data1">Data 1</span>
//<span data-cart="data2">Data 2</span>
//<span data-cart-price="x">x</span>
//<a href="" data-cart="trigger"></a>
//</div>

/////////////////////////////////////////////////////////////