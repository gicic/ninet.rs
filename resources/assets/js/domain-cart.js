$(function () {

    $('input[name=hosting_lines]').change(function () {
        var $thisVal = $(this).val();

        $('[id^="line_wrapper_"]').hide(0, function () {
            $('#line_wrapper_' + $thisVal).show(0);
        });

    });

    $('input[name^="whois_"]').change(function () {
        var $thisCheckbox = $(this);
        if ($thisCheckbox.is(':checked')) {
            addAdditionalToCartDomain($thisCheckbox.data('cart-additional-id'), $thisCheckbox.data('cart-item-id'), 1, function (response) {
                reloadDomainCarts();
                $thisCheckbox.attr('data-cart-row-id', response.rowId);
            });
        } else {
            removeWhois($thisCheckbox.data('cart-row-id'), function () {
                reloadDomainCarts();
                $thisCheckbox.attr('data-cart-row-id', '');
                $thisCheckbox.attr('checked', false).next('label').removeClass('active');
            });
        }
    });

    $('a.add-hosting-to-cart').click(function (e) {
        e.preventDefault();
        uiBlocker();

        let productID = $(this).data('cart-id');
        let hostname = $('#main_domain').val();
        let period = $('.hosting_order_period').val();

        let options = new Object({
            domain: hostname
        });

        addHostingToCart(productID, period, options, function () {
            reloadDomainCarts();
        });

    });

    $('.domain_order_period').change(function (e) {
        e.preventDefault();

        let period = $(this).val();
        let cartItemRowId = $(this).data('cart-item-row-id');

        let data = new Object({
            period: period
        });

        updateCartItemDomain(cartItemRowId, data, function () {
            reloadDomainCarts();
        });

    });

});

function uiBlocker() {
    $.blockUI({
        message: $('#blockMessage'),
        css: {
            padding: '25px 15px',
            border: 0
        }
    });
}
function removeWhois(cartItemRemoveID, callback) {

    $.ajax({
        url: _whois_remove_url,
        type: 'post',
        data: {
            _token: _token,
            rowId: cartItemRemoveID
        },
        success: function (response) {
            callback(response);
        },
        error: function (msg) {
            console.log(msg);
        }
    });
}
function reloadDomainCarts() {
    cartDomainReload();
    cartDomainSideReload();
    $.unblockUI();
}

function addHostingToCart(productID, period, options, callback) {
    $.ajax({
        url: _add_to_cart_url,
        type: 'post',
        data: {
            _token: _token,
            productId: productID,
            options: options,
            period: period
        },
        success: function (response) {
            console.log(response);
            callback(response);
        },
        error: function (msg) {
            console.log(msg);
        }
    });
}

function updateCartItemDomain(cartItemID, data, callback) {

    $.ajax({
        url: _shopcart_update_url,
        type: 'post',
        data: {
            _token: _token,
            rowId: cartItemID,
            updateData: data
        },
        success: function (response) {
            console.log(response);
            callback(response);
        },
        error: function (msg) {
            console.log(msg);
        }
    });

}

function removeItemFromCartDomain(cartItemRemoveID, callback) {

    $.ajax({
        url: _shopcart_remove_url,
        type: 'post',
        data: {
            _token: _token,
            rowId: cartItemRemoveID
        },
        success: function (response) {
            callback(response);
        },
        error: function (msg) {
            console.log(msg);
        }
    });
}

function addAdditionalToCartDomain(additionalID, parentID, quantity, callback) {
    $.ajax({
        url: _additional_add_url,
        type: 'post',
        data: {
            _token: _token,
            additionalID: additionalID,
            parentID: parentID,
            quantity: quantity
        },
        success: function (response) {
            callback(response);
        },
        error: function (msg) {
            console.log(msg);
        }
    });
}

function cartDomainReload() {
    $.ajax({
        url: _get_cart_view_url,
        type: 'get',
        success: function (response) {
            $('.cart-holder').html(response);
        }
    });
}

function cartDomainSideReload() {
    $.ajax({
        url: _get_side_cart_view_url,
        type: 'get',
        success: function (response) {
            $('.sidebar-cart').html(response);
        }
    });
}