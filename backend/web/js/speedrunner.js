$(function() {
    
    let el, action, sendData;
    
    //      File input
    
    let fileName;
    
    $(document).on('change', '.custom-file-input', function() {
        fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });
    
    //      Nav full
    
    $(document).on('click', '.nav-full-toggle', function() {
        $('.nav-wrapper-full').toggleClass('opened');
        $('body').toggleClass('overflow-hidden');
    });
    
    if ($(window).outerWidth() <= 991) {
        $('.nav-wrapper-side').removeClass('opened');
    }
    
    $(document).on('click', '.nav-wrapper-side .nav-items .parent', function() {
        if (!$(this).closest('li').hasClass('active')) {
            $('.nav-wrapper-side .nav-items li').removeClass('active');
            $(this).closest('li').addClass('active');
        } else {
            $(this).closest('li').removeClass('active');
        }
    });
    
    //      Form autocomplete switching off
    
    $(document).on('focus', 'input, textarea, select', function() {
        $(this).attr('autocomplete', 'off');
    });
    
    //      Activating tab with error after form validation
    
    let tab;
    
    $(document).on('afterValidate', '#update-form', function(event, messages, errorAttributes) {
        if (errorAttributes.length > 0) {
            el = $('#' + errorAttributes[0].id);
            tab = el.closest('.tab-pane').attr('id');
            $(this).find('.nav-pills a[href="#' + tab + '"]').tab('show');
            
            return false;
        }
    });
    
    //      Toast
    
    let alertJson,
        alertLoaderColors = {
            success: '#80CFB1',
            warning: '#F5C480',
            danger: '#F5A480',
            info: '#80D1D5'
        };
    
    if ($('#main-alert').html().trim() !== '[]') {
        alertsJson = JSON.parse($('#main-alert').html());
        
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
    
    //      GridView common button
    
    let selection = $('.grid-view [name="selection[]"]');
    
    $(document).on('change', '.grid-view [name="selection[]"]', function() {
        $('.grid-view .common-buttons').addClass('d-none');
        
        selection.each(function() {
            if ($(this).prop('checked')) {
                $('.grid-view .common-buttons').removeClass('d-none');
            }
        });
    });
    
    //      Table relations
    
    let rand,
        relHtml, relHtmlTmp = [];
    
    $('.table-new-relation').each(function() {
        relHtmlTmp[$(this).data('table')] = $('<div/>').append($(this).clone().removeClass('table-new-relation')).html();
        $(this).remove();
    });
    
    $(document).on('click', '.table-relations .btn-add', function() {
        el = $(this);
        rand = Date.now();
        
        relHtml = relHtmlTmp[el.data('table')].replace(/\__key__/g, rand);
        el.closest('table').find('tbody').append(relHtml).find('[data-sr-trigger*="text_editor"]').click();
    });
    
    $(document).on('click', '.table-relations .btn-remove', function() {
        $(this).closest('tr').remove();
    });
});
