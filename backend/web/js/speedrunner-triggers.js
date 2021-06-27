$(function() {
    
    let el, url, sendData,
        csrf = $('meta[name="csrf-token"]').attr('content');
    
    //      Datepicker
    
    let datepickerOptions = {
        weekStart: 1,
        todayBtn: 'linked',
        todayHighlight: true,
        autoclose: true,
        fontAwesome: true
    };
    
    $(document).on('mousedown', '[data-sr-trigger*="datepicker"], input[name*="Search[created_at]"], input[name*="Search[updated_at]"]', function() {
        if (!$(this).hasClass("hasDatepicker")) {
            $(this).datetimepicker({...datepickerOptions, ...{
                format: 'dd.mm.yyyy',
                startView: 2,
                minView: 2
            }}).datetimepicker('show');
        }
    });
    
    $(document).on('mousedown', '[data-sr-trigger*="datetimepicker"]', function() {
        if (!$(this).hasClass("hasDatepicker")) {
            $(this).datetimepicker({...datepickerOptions, ...{
                format: 'dd.mm.yyyy hh:ii'
            }}).datetimepicker('show');
        }
    });
    
    $(document).on('mousedown', '[data-sr-trigger*="timepicker"]', function() {
        if (!$(this).hasClass("hasDatepicker")) {
            $(this).datetimepicker({...datepickerOptions, ...{
                format: 'hh:ii',
                formatViewType: 'time',
                startView: 1,
                maxView: 1
            }}).datetimepicker('show');
        }
    });
    
    //      Select2
    
    $(document).on('mousedown', '[data-sr-trigger*="select2"]', function() {
        if (!$(this).hasClass('select2-hidden-accessible')) {
            $(this).select2({
                allowClear: true,
                placeholder: ' '
            }).select2('open');
        }
    });
    
    $(document).on('mousedown', '[data-sr-trigger*="select2-ajax"]', function() {
        url = $(this).data('url');
        
        if (!$(this).hasClass('select2-hidden-accessible')) {
            $(this).select2({
                allowClear: true,
                placeholder: ' ',
                ajax: {
                    url: url,
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
    
    $(document).on('mousedown', '[data-sr-trigger*="file_manager"] .yii2-elfinder-select-button', function() {
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
        textEditorImageUploadUrl = $('meta[name="text-editor-image-upload-connection-url"]').attr('content'),
        textEditorParams = JSON.parse($('meta[name="text-editor-params"]').attr('content'));
    
    alexantr.tinyMceWidget.setBaseUrl(textEditorBaseUrl);
    
    $(document).on('click', '[data-sr-trigger*="text_editor"]', function() {
        if ($(this).prev('.mce-tinymce').length === 0) {
            alexantr.tinyMceWidget.register($(this).attr('id'), textEditorParams);
        }
    });
    
    //      Sortable
    
    $(document).on('mouseenter', '[data-sr-trigger*="sortable"]', function() {
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
    
    //      Popover & tooltip
    
    $('[data-sr-trigger*="popover"]').popover({placement: 'top', trigger: 'hover'});
    $('[data-sr-trigger*="tooltip"]').not('td .action-buttons [data-sr-trigger*="tooltip"]').tooltip();
    $('td .action-buttons [data-sr-trigger*="tooltip"]').tooltip({placement: 'left'});
    
    //      Toggle session
    
    $(document).on('click', '[data-sr-trigger*="toggle_session"]', function(event) {
        event.preventDefault();
        
        el = $(this);
        url = el.data('sr-url');
        sendData = {
            "_csrf-backend": csrf,
            name: el.data('sr-name'),
            value: el.data('sr-value')
        };
        
        $.post(url, sendData, function(data) {
            if (el.data('sr-callback') !== undefined) {
                eval(el.data('sr-callback'));
            }
        });
    });
});