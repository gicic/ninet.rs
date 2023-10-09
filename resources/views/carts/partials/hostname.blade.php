<div class="block-t1">
    <div class="block-title">
        Unesite hostname
    </div>
    <div class="block-content">
        <div class="vps-add-hostname">
            <input type="text" placeholder="Vaš hostname" id="server_hostname" value="{{ !empty($cartItem->options['hostname']) ? $cartItem->options['hostname'] : '' }}">
            <button type="button" class="cursor-pointer add-hostname" id="add-hostname">{{ __('main.add_hostname') }}</button>
        </div>
    </div>
    <span class='error-message' id='host-name'></span>
</div>