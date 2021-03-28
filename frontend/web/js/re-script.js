$(function() {
    
    //      Ajax button
    
    let el, action, sendData;
    
    $(document).on('click', '[data-toggle="ajax-button"]', function(e) {
        e.preventDefault();
        
        el = $(this);
        action = el.data('action');
        sendData = {};
        
        $.get(action, sendData, function(data) {
            switch (el.data('type')) {
                case 'el':
                    $(el.data('el')).html(data);
                    break;
                case 'modal':
                    $('#main-modal').html(data).modal();
                    break;
            }
        });
    });
    
    //      Ajax form
    
    $(document).on('submit', '[data-toggle="ajax-form"]', function(e) {
        e.preventDefault();
        
        el = $(this);
        action = el.attr('action');
        sendData = new FormData(el[0]);
        
        $.ajax({
            type: "POST",
            url: action,
            data: sendData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data === '1') {
                    $(el.data('el')).modal('hide');
                } else {
                    $(el.data('el')).html(data);
                }
            }
        });
    });
    
    //      Cart changing quantity
    
    let quantity;
    
    $(document).on('click', '[data-toggle="cart-quantity-change"]', function(e) {
        e.preventDefault();
        
        el = $(this).closest('.cart-quantity-wrapper').find('input[name="quantity"]');
        quantity = parseInt(el.val());
        quantity = isNaN(quantity) ? 0 : quantity;
        quantity += $(this).data('type') === 'plus' ? 1 : -1;
        quantity = quantity >= 0 ? quantity : 0;
        
        el.val(quantity).trigger('change');
    });
    
    //      Cart changing form
    
    $(document).on('submit', '[data-toggle="cart-change-form"]', function(e) {
        e.preventDefault();
        
        el = $(this);
        action = el.attr('action');
        sendData = el.serialize();
        
        $.post(action, sendData, function(data) {
            $('#cart-quantity').html(data.quantity);
            $('#cart-preview').html(data.preview);
            $('#cart-page').html(data.page);
        });
    });
});
