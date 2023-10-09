/////////////////////////////////////////////////////////////
//DEO ZA DODAVANJE U KORPU I IZBACIVANJE IZ KORPE NA FRONTU
/////////////////////////////////////////////////////////////
$(function () {

    /*
    |--------------------------------------------------------------------------
    | Initializing of data cart
    |--------------------------------------------------------------------------
    */
    init();


    /*
    |--------------------------------------------------------------------------
    | Removing cart item
    |--------------------------------------------------------------------------
    */
    $(document).on('click', 'a[data-cart="remove"]', function (e) {

        e.preventDefault();

        let cartItemRemoveID = $(this).closest('[data-cart="item"]').data('cartId');

        removeItemFromCart(cartItemRemoveID, function (response) {
            if (response && typeof response === 'object') {
                if (typeof _current_cart_item_id !== 'undefined' && cartItemRemoveID === _current_cart_item_id) {
                    document.location.href = "/";
                } else {
                    reloadCarts();
                }
            }
            $('li[data-domain-row-id="' + cartItemRemoveID + '"]').slideUp(function () {
                $(this).remove();
            });
        });

    });

    /*
    |--------------------------------------------------------------------------
    | Adding cart additional item
    |--------------------------------------------------------------------------
    */
    $('a[data-cart-additional="trigger"]').on('click', function (e) {

        e.preventDefault();

        let cartItemID = $(this).data('additional-id');
        let quantity = $('input[data-cart-additional-id="'+ cartItemID +'"]').val();

        addAdditionalToCart(cartItemID, _current_cart_item_id, quantity, function (response) {
            reloadCarts();
        });

    });

    /*
    |--------------------------------------------------------------------------
    | Removing cart additional item
    |--------------------------------------------------------------------------
    */
    $(document).on('click', 'a[data-cart-additional="remove"]', function (e) {

        e.preventDefault();

        let cartItemRemoveID = $(this).closest('.additional-item').data('cartAdditionalItemId');

        removeItemFromCart(cartItemRemoveID, function (response) {
            if (response && typeof response === 'object') {
                $('[data-cart-additional-item-id="'+ cartItemRemoveID +'"]').remove();
                console.log(cartItemRemoveID);
                $('input[data-cart-row-id="'+ cartItemRemoveID +'"]')
                    .attr('checked', false)
                    .attr('data-cart-row-id', '')
                    .next('label').removeClass('active');
                reloadCarts();
            }
        });

    });

    /*
    |--------------------------------------------------------------------------
    | Deleting cart item from purchase cart table
    |--------------------------------------------------------------------------
    */
    $('[data-purchase="delete"]').on('click', 'a', function (e) {
        e.preventDefault();
        let $thisItemRow = $(this).closest('[data-purchase="delete"]').closest('tr');
        let cartItemRemoveID = $(this).closest('[data-purchase="delete"]').data('cartId');

        removeItemFromCart(cartItemRemoveID, function (response) {
            if (response && typeof response === 'object') {
                $($thisItemRow).remove();
                $('td.total-price>span.total-price-price').html(response.total);
                reloadCarts();
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Updating terms and conditions
    |--------------------------------------------------------------------------
    */
    $('input[name="terms_and_conditions[]"]').change(function () {
        let terms = false;
        let checkedLength = $('input[name="terms_and_conditions[]"]:checked').length;
        let totalLength = $('input[name="terms_and_conditions[]"]').length;
        if(checkedLength === totalLength) {
            terms = true;
        }

        let data = new Object({
            terms: terms
        });

        updateCartItem(_current_cart_item_id, data, function () {
            reloadCarts();
        });

    });

    /*
    |--------------------------------------------------------------------------
    | Changing order period
    |--------------------------------------------------------------------------
    */
    $('#order_period').change(function (e) {
        e.preventDefault();

        let period = $(this).val();

        let data = new Object({
            period: period
        });

        updateCartItem(_current_cart_item_id, data, function () {
            reloadCarts();
        });

    });

    /*
    |-------------------------------------------------------------------------
    | Adding hostname to server cart item
    |-------------------------------------------------------------------------
    */
    $('#add-hostname').click(function (e) {
        e.preventDefault();

        let hostname = $('#server_hostname').val();

        let data = new Object({
            options: {
                hostname: hostname
            }
        });

        updateCartItem(_current_cart_item_id, data, function () {
            reloadCarts();
        });

    });

    /*
    |-------------------------------------------------------------------------
    | Adding OS to server cart item
    |-------------------------------------------------------------------------
    */
    $('#operating_system').change(function (e) {
        e.preventDefault();

        let template = $(this).val();

        let data = new Object({
            options: {
                template: template
            }
        });

        updateCartItem(_current_cart_item_id, data, function () {
            reloadCarts();
        });

    });

    /*
    |-------------------------------------------------------------------------
    | Adding OS to server cart item
    |-------------------------------------------------------------------------
    */
    $('#server_operating_system').change(function (e) {
        e.preventDefault();

        let operatingSystemId = $(this).val();
        let operatingSystemName = $(this).find('option:selected').html();

        let data = new Object({
            options: {
                operating_system_id: operatingSystemId,
                operating_system_name: operatingSystemName
            }
        });

        updateCartItem(_current_cart_item_id, data, function () {
            reloadCarts();
        });

    });

    /*
    |-------------------------------------------------------------------------
    | Adding Domain to Hosting cart item
    |-------------------------------------------------------------------------
    */
    $('#domain').click(function (e) {
        e.preventDefault();
        uiBlockerCart();

        let domainName = $('#domain_sld').val();
        let domainTldId = $('#domain_tld').val();
        let existingDomain = $('input[name="radio-domain-availability"]:checked').val();

        if(existingDomain === 'newDomain') {
            domainIsAvailable(domainName, domainTldId, function (responseCheck) {
                if(responseCheck.value === true) {
                    addDomainToCart(domainName, domainTldId, function (response) {
                        setHostingDomain(response.domainItem.name);
                        existingHostingDomain(false);
                        $('#domain-message-holder').removeClass('text-danger').addClass('text-success').html(response.message).show();
                    });
                } else {
                    $('#domain-message-holder').removeClass('text-success').addClass('text-danger').html(responseCheck.message).show();
                }
                $.unblockUI();
            });
        } else {
            setHostingDomain(domainName);
            existingHostingDomain(true);
            $.unblockUI();
        }

    });

    /*
    |-------------------------------------------------------------------------
    | Existing or new domain
    |-------------------------------------------------------------------------
    */
    $('input[name="radio-domain-availability"]').change(function () {
        let existingDomain = $(this).val();
        if(existingDomain === 'existingDomain') {
            $('#domain_tld_holder').fadeOut();
        } else {
            $('#domain_tld_holder').fadeIn();
        }
        existingHostingDomain(existingDomain === 'existingDomain');
    });

});

function domainIsAvailable(domainName, domainTldId, callback) {
    $.ajax({
        url: _domain_availability_check_url,
        type: 'post',
        data: {
            _token: _token,
            domainName: domainName,
            domainTldId: domainTldId
        },
        success: function (response) {
            if(typeof callback === 'function') {
                callback(response);
            }
        },
        error: function (response) {
            console.log(response);
            $.unblockUI();
        }
    });
}

function addDomainToCart(domainName, domainTldId, callback) {
    $.ajax({
        url: _add_domains_to_cart_url,
        type: 'post',
        data: {
            _token: _token,
            domainName: domainName,
            domainTldId: domainTldId
        },
        success: function (response) {
            console.log(response);
            callback(response);
        },
        error: function (msg) {
            console.log(msg);
            $.unblockUI();
        }
    });
}

/*
 * Initial printing of carts on page load
 */
function init() {
    reloadCarts();
}

function setHostingDomain(domainName) {
    let data = new Object({
        options: {
            domain: domainName
        }
    });

    updateCartItem(_current_cart_item_id, data, function () {
        reloadCarts();
    });
}

function existingHostingDomain(existing) {
    console.log(existing);
    let data = new Object({
        options: {
            existingDomain: existing
        }
    });

    updateCartItem(_current_cart_item_id, data, function () {
        reloadCarts();
    });
}

/*
 * Cart item terms acceptance
 */
function updateCartItem(cartItemID, data, callback) {

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

/*
 * Cart data reload after ajax call
 */
function reloadCarts() {
    cartReload();
    cartSideReload();
}

function removeItemFromCart(cartItemRemoveID, callback) {

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

function addAdditionalToCart(additionalID, parentID, quantity, callback) {
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

function cartReload() {
    $.ajax({
        url: _get_cart_view_url,
        type: 'get',
        success: function (response) {
            $('.cart-holder').html(response);
        }
    });
}

function cartSideReload() {
    $.ajax({
        url: _get_side_cart_view_url,
        type: 'get',
        success: function (response) {
            $('.sidebar-cart').html(response);
        }
    });
}

function uiBlockerCart() {
    $.blockUI({
        message: $('#blockMessage'),
        css: {
            padding: '25px 15px',
            border: 0
        }
    });
}