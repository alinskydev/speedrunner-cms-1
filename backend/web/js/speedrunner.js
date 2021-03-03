$(function() {
    let el, action, sendData,
        csrf = $('meta[name="csrf-token"]').attr('content');
    
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
    
    //      Nav side
    
    $(document).on('click', '.nav-side-toggle', function() {
        el = $(this);
        action = el.data('action');
        sendData = {
            "_csrf-backend": csrf,
            name: 'nav',
            value: $('.nav-wrapper-side').hasClass('opened') ? 0 : 1
        };
        
        $.post(action, sendData);
        $('.nav-wrapper-side').toggleClass('opened');
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
    
    //      Datepickers
    
    $(document).on('mousedown', '[data-toggle="datepicker"], input[name*="Search[created_at]"], input[name*="Search[updated_at]"]', function() {
        if (!$(this).hasClass("hasDatepicker")) {
            $(this).datepicker({
                format: 'dd.mm.yyyy',
                weekStart: 1,
                todayBtn: 'linked',
                todayHighlight: true,
                autoclose: true,
                fontAwesome: true
            }).datepicker('show');
        }
    });
    
    $(document).on('mousedown', '[data-toggle="datetimepicker"]', function() {
        if (!$(this).hasClass("hasDatepicker")) {
            $(this).datetimepicker({
                format: 'dd.mm.yyyy hh:ii',
                weekStart: 1,
                todayBtn: 'linked',
                todayHighlight: true,
                autoclose: true,
                fontAwesome: true
            }).datetimepicker('show');
        }
    });
    
    $(document).on('mousedown', '[data-toggle="timepicker"]', function() {
        if (!$(this).hasClass("hasDatepicker")) {
            $(this).datetimepicker({
                format: 'hh:ii',
                startView: 1,
                maxView: 1,
                formatViewType: 'time',
                todayBtn: 'linked',
                autoclose: true,
                fontAwesome: true
            }).datetimepicker('show');
        }
    });
    
    //      Select2
    
    $(document).on('mousedown', '[data-toggle="select2"]', function() {
        if (!$(this).hasClass('select2-hidden-accessible')) {
            $(this).select2({
                allowClear: true,
                placeholder: ''
            }).select2('open');
        }
    });
    
    $(document).on('mousedown', '[data-toggle="select2-ajax"]', function() {
        action = $(this).data('action');
        
        if (!$(this).hasClass('select2-hidden-accessible')) {
            $(this).select2({
                allowClear: true,
                placeholder: ' ',
                ajax: {
                    url: action,
                    dataType: 'json',
                    delay: 300,
                    data: function (params) { return {q: params.term}; }
                }
            }).select2('open');
        }
    });
    
    //      ElFinder
    
    let elfinderId, elfinderParams,
        elfinderUrl = $('meta[name="elfinder-connection-url"]').attr('content');
    
    $(document).on('click', '[data-toggle="elfinder"] .yii2-elfinder-select-button', function() {
        if ($(this).hasClass('elfinder-initialized')) {
            return false;
        }
        
        elfinderId = $(this).closest('.elfinder-container').find('.yii2-elfinder-input').attr('id');
        elfinderParams = 'menubar=no,toolbar=no,location=no,directories=no,status=no,fullscreen=no,width=900,height=600';
        
        alexantr.elFinder.registerSelectButton($(this).attr('id'), elfinderUrl + '?id=' + elfinderId);
        window.open(elfinderUrl + '?id=' + elfinderId, 'elfinder-select-file', elfinderParams).focus();
    });
    
    $(document).on('click', '.btn-elfinder-remove', function() {
        $(this).closest('.elfinder-container').find('img, audio, video').remove();
        $(this).closest('.elfinder-container').find('input').removeAttr('value');
    });
    
    //      Imperavi
    
    let ImperaviImagesGetUrl = $('meta[name="imperavi-images-get-connection-url"]').attr('content'),
        ImperaviImageUploadUrl = $('meta[name="imperavi-image-upload-connection-url"]').attr('content'),
        ImperaviImageDeleteUrl = $('meta[name="imperavi-image-delete-connection-url"]').attr('content');
    
    $(document).on('click', '[data-toggle="imperavi"]', function() {
        if ($(this).closest('.redactor-box').length === 0) {
            $(this).redactor({
                imageManagerJson: ImperaviImagesGetUrl,
                imageUpload: ImperaviImageUploadUrl,
                imageDelete: ImperaviImageDeleteUrl,
                plugins: [
                    'fontcolor', 'fontsize', 'table', 'clips', 'fullscreen', 'imagemanager'
                ],
                lang: $('html').attr('lang'),
                uploadImageFields: {
                    "_csrf-backend": csrf
                },
                imageUploadErrorCallback: function (response) {
                    alert('An error occurred during the upload process!');
                }
            });
        }
    });
    
    //      Sortable
    
    $(document).on('mouseenter', '[data-toggle="sortable"]', function() {
        if (!$(this).hasClass('ui-sortable')) {
            $(this).sortable({
                handle: '.table-sorter',
                placeholder: 'sortable-placeholder'
            });
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
    
    //      Popover & tooltip
    
    $('[data-toggle="popover"]').popover({placement: 'top', trigger: 'hover'});
    $('[data-toggle="tooltip"]').not('td .action-buttons [data-toggle="tooltip"]').tooltip();
    $('td .action-buttons [data-toggle="tooltip"]').tooltip({placement: 'left'});
    
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
    
    //      Save & reload
    
    let url, urlParams;
    
    $(document).on('click', '[data-toggle="save-and-update"]', function() {
        el = $(this).closest('form');
        url = new URL(location.origin + el.attr('action'));
        urlParams = new URLSearchParams(url.search);
        
        if (!urlParams.has('save-and-update')) {
            urlParams.append('save-and-update', 1);
        }
        
        el.attr('action', url.pathname + '?' + urlParams.toString()).submit();
    });
    
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
        el.closest('table').find('tbody').append(relHtml).find('[data-toggle="imperavi"]').click();
    });
    
    $(document).on('click', '.table-relations .btn-remove', function() {
        $(this).closest('tr').remove();
    });
    
    //      Session toggle
    
    $(document).on('click', '[data-toggle="toggle_session"]', function(e) {
        e.preventDefault();
        
        el = $(this);
        action = el.data('action');
        sendData = {
            "_csrf-backend": csrf,
            type: el.data('type'),
            value: el.data('value')
        };
        
        $.post(action, sendData, function(data) {
            if (el.data('execute') !== undefined) {
                eval(el.data('execute'));
            }
        });
    });
    
    //      Ajax button
    
    $(document).on('click', '[data-toggle="ajax-button"]', function(e) {
        e.preventDefault();
        
        el = $(this);
        action = el.data('action');
        sendData = {};
        
        $.get(action, sendData, function (data) {
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
        $('#ajax-mask').fadeIn(0);
        
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
                $('#ajax-mask').fadeOut(0);
                
                if (data === '1') {
                    $('#main-modal').modal('hide');
                } else {
                    $(el.data('el')).html(data);
                }
            }
        });
    });
});
