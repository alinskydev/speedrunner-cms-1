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
    
    //      File manager
    
    let fileManagerId, fileManagerParams,
        fileManagerUrl = $('meta[name="file-manager-connection-url"]').attr('content');
    
    $(document).on('click', '[data-toggle="file_manager"] .yii2-elfinder-select-button', function() {
        if ($(this).hasClass('elfinder-initialized')) {
            return false;
        }
        
        fileManagerId = $(this).closest('.elfinder-container').find('.yii2-elfinder-input').attr('id');
        fileManagerParams = 'menubar=no,toolbar=no,location=no,directories=no,status=no,fullscreen=no,width=900,height=600';
        
        alexantr.elFinder.registerSelectButton($(this).attr('id'), fileManagerUrl + '?id=' + fileManagerId);
        window.open(fileManagerUrl + '?id=' + fileManagerId, 'elfinder-select-file', fileManagerParams).focus();
    });
    
    $(document).on('click', '.btn-elfinder-remove', function() {
        $(this).closest('.elfinder-container').find('img, audio, video').remove();
        $(this).closest('.elfinder-container').find('input').removeAttr('value');
    });
    
    //      Text editor
    
    let textEditorBaseUrl = $('meta[name="text-editor-base-url"]').attr('content'),
        textEditorFilePickerUrl = $('meta[name="text-editor-file-picker-connection-url"]').attr('content'),
        textEditorImageUploadUrl = $('meta[name="text-editor-image-upload-connection-url"]').attr('content');
    
    alexantr.tinyMceWidget.setBaseUrl(textEditorBaseUrl);
    
    let textEditorParams = {
        height: '300px',
        language: $('html').attr('lang'),
        relative_urls: false,
        force_p_newlines : true,
        forced_root_block : false,
        fontsize_formats: '8px 10px 12px 14px 16px 18px 24px 36px 48px',
        file_picker_callback: alexantr.elFinder.filePickerCallback({
            title: 'File manager',
            width: 900,
            height: 500,
            file: textEditorFilePickerUrl
        }),
        images_upload_url: textEditorImageUploadUrl,
        plugins: [
            'advlist autolink lists link charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'table contextmenu paste textcolor colorpicker advcode',
            'media image'
        ],
        menu: [],
        toolbar: [
            'undo redo | cut copy paste | fontselect | fontsizeselect | styleselect | bold italic underline strikethrough superscript subscript | forecolor backcolor',
            'outdent indent | alignleft aligncenter alignright alignjustify | bullist numlist table | link anchor image media | charmap | searchreplace visualblocks preview code fullscreen'
        ]
    };
    
    $(document).on('click', '[data-toggle="text_editor"]', function() {
        if ($(this).prev('.mce-tinymce').length === 0) {
            alexantr.tinyMceWidget.register($(this).attr('id'), textEditorParams);
        }
    });
    
    //      Sortable
    
    $(document).on('mouseenter', '[data-toggle="sortable"]', function() {
        if (!$(this).hasClass('ui-sortable')) {
            $(this).sortable({
                handle: '.table-sorter',
                placeholder: 'sortable-placeholder',
                start: function(event, ui) {
                    ui.placeholder.height(ui.helper.outerHeight());
                }
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
        el.closest('table').find('tbody').append(relHtml).find('[data-toggle="text_editor"]').click();
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
});
