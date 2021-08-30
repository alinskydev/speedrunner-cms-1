$(function() {
    
    let el, action, sendData;
    
    //      Checking alerts wrapper
    
    let alertJson,
        alertLoaderColors = {
            success: '#80CFB1',
            warning: '#F5C480',
            danger: '#F5A480',
            info: '#80D1D5'
        };
    
    if ($('#alerts-wrapper').html().trim() !== '[]') {
        alertsJson = JSON.parse($('#alerts-wrapper').html());
        console.log(alertsJson);
        
        for (key in alertsJson) {
            for (alert_key in alertsJson[key]) {
                $.toast({
                    heading: alertsJson[key][alert_key],
                    position: 'bottom-right',
                    loaderBg: alertLoaderColors[key],
                    icon: key,
                    hideAfter: 4000,
                    stack: 10
                });
            }
        }
    }
    
    //      Lazy load button
    
    let offset, offsetMax;
    
    $(document).on('click', '[data-toggle="lazy-load-button"]', function(e) {
        e.preventDefault();
        
        el = $(this);
        action = el.data('action');
        sendData = {offset: el.data('offset')};
        offsetMax = parseInt(el.data('offset_max'));
        
        $.get(action, sendData, function(data) {
            $(el.data('result')).append(data);
            
            offset = parseInt(el.data('offset'));
            offset < offsetMax ? el.data('offset', offset + 1) : el.remove();
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
