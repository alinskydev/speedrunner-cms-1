$(function() {

    //      INIT
    
    $(document).on('change', '.custom-file-input', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    $(document).on('click', '.nav-toggle', function() {
        $('.nav-wrapper').toggleClass('active');
        $('body').toggleClass('overflow-hidden');
    });

    //      DATETIME

    function dateTimePickFunc() {
        $('[data-toggle="datepicker"]').datepicker({
            format: 'dd.mm.yyyy',
            minViewMode: 0,
            weekStart: 1,
            todayBtn: 'linked',
            todayHighlight: true,
            constrainInput: false,
            autoclose: true
        });

        $('input[name*="Search[created]"], input[name*="Search[updated]"]').datepicker({
            format: 'dd.mm.yyyy',
            minViewMode: 0,
            weekStart: 1,
            todayBtn: 'linked',
            todayHighlight: true,
            constrainInput: false,
            autoclose: true,
            fontAwesome: true
        });

        $('[data-toggle="datetimepicker"]').datetimepicker({
            format: 'dd.mm.yyyy hh:ii',
            weekStart: 1,
            todayBtn: 'linked',
            todayHighlight: true,
            autoclose: true,
            fontAwesome: true
        });
    };

    //      SELECTPICKER

    function selectFunc() {
        $('[data-toggle="selectpicker"]').select2({
            allowClear: true,
            placeholder: ' '
        });
    };

    //      FORM AUTOCOMPLETE OFF

    $('form').attr('autocomplete', 'off');

    //      FORM VALIDATE TOGGLE ERROR TAB

    var tab;

    $(document).on('afterValidate', '#edit-form', function(event, messages, errorAttributes) {
        if (errorAttributes.length > 0) {
            el = $('#' + errorAttributes[0].id);
            tab = el.parents('.tab-pane').attr('id');

            $(this).find('.nav-pills a[href="#' + tab + '"]').tab('show');

            return false;
        }
    });

    //      POPOVER & TOOLTIP

    $('[data-toggle="popover"]').popover({placement: 'top', trigger: 'hover'});
    $('[data-toggle="tooltip"]').not('td.action-column [data-toggle="tooltip"]').tooltip();
    $('td.action-column [data-toggle="tooltip"]').tooltip({placement: 'top'});

    //      TOAST

    var alertJson,
        alertLoaderColors = {
            success: '#80CFB1',
            warning: '#F5C480',
            danger: '#F5A480',
            info: '#80D1D5'
        };

    if ($('#main-alert').html().trim() !== '[]') {
        alertJson = JSON.parse($('#main-alert').html());

        for (key in alertJson) {
            $.toast({
                heading: alertJson[key],
                position: 'bottom-right',
                loaderBg: alertLoaderColors[key],
                icon: key,
                hideAfter: 4000,
                stack: 10
            });
        }
    }

    //      LAUNCH & AJAX_REBUILD

    $('.table-relations tbody').sortable({handle: '.table-sorter', placeholder: 'sortable-placeholder'});

    dateTimePickFunc();
    selectFunc();

    $(document).ajaxStart(function() {
        $('#ajax-mask').fadeIn(0);
    });

    $(document).ajaxComplete(function() {
        $('#ajax-mask').fadeOut(0);
        $('.table-relations tbody').sortable({handle: '.table-sorter', placeholder: 'sortable-placeholder'});

        dateTimePickFunc();
        selectFunc();
    });
    
    //      GRID VIEW FOOTER BUTTONS
    
    var selection = $('.grid-view [name="selection[]"]');
    
    $(document).on('change', '.grid-view [name="selection[]"]', function() {
        $('.grid-view .common-buttons').addClass('d-none');
        
        selection.each(function() {
            if ($(this).prop('checked')) {
                $('.grid-view .common-buttons').removeClass('d-none');
            }
        });
    });
    
    //      ELFINDER
    
    $(document).on('click', '.btn-elfinder-remove', function() {
        $(this).parents('.elfinder-container').find('img').remove();
        $(this).parents('.elfinder-container').find('input').val('');
    });
    
    //      TABLE RELATIONS
    
    var el, rand,
        relHtml, relHtmlTmp = [],
        elFinderUrl = $('meta[name="elfinder-connection-url"]').attr('content'),
        ckEditorImageUploadUrl = $('meta[name="ckeditor-image_upload-connection-url"]').attr('content'),
        ckEditorImagesUrl = $('meta[name="ckeditor-images-connection-url"]').attr('content');

    $('.table-new-relation').each(function() {
        relHtmlTmp[$(this).data('table')] = $('<div/>').append($(this).clone().removeClass('table-new-relation')).html();
        $(this).remove();
    });

    $(document).on('click', '.table-relations .btn-add', function() {
        el = $(this);
        rand = new Date;
        rand = rand.getTime();

        relHtml = relHtmlTmp[el.data('table')].replace(/\__key__/g, rand);
        el.parents('table').find('tbody').append(relHtml);

        $('#elfinder-' + rand + 'browse').on('click', function() {
            elFinderId = $(this).attr('id').replace('browse', '');
            console.log(elFinderUrl);
            window.elfinderBrowse(elFinderId, elFinderUrl);
        });

        if ($('#redactor-' + rand).length > 0) {
            $('#redactor-' + rand).redactor({
                imageUpload: ckEditorImageUploadUrl,
                imageManagerJson: ckEditorImagesUrl,
                plugins: ['fontcolor', 'fontsize', 'table', 'clips', 'fullscreen', 'imagemanager'],
                lang: 'en',
                uploadImageFields: {
                    "_csrf-backend": $('meta[name="csrf-token"]').attr('content')
                },
                uploadFileFields: {
                    "_csrf-backend": $('meta[name="csrf-token"]').attr('content')
                },
                imageUploadErrorCallback: function (response) {
                    alert('An error occurred during the upload process!');
                }
            });
        }
    });

    $(document).on('click', '.table-relations .btn-remove', function() {
        $(this).parents('tr').remove();
    });

    $(document).on('click', '.table-relations .btn-view', function() {
        $(this).toggleClass('btn-xs btn-info btn-success');
        $(this).find('i').toggleClass('fa-eye fa-check');
        $(this).parents('td').toggleClass('over-all');
        $(this).parents('td').find('textarea').focus();
    });

    //      SESSION

    $(document).on('click', '[data-toggle="toggle_session"]', function(e) {
        e.preventDefault();

        el = $(this);
        action = el.data('action');
        sendData = {
            "_csrf-backend": $('meta[name="csrf-token"]').attr('content'),
            "type": el.data('type'),
            "value": el.data('value')
        };

        $.post(action, sendData, function(data) {
            if (el.data('execute') !== undefined) {
                eval(el.data('execute'));
            }
        });
    });

    //      HOTKEYS

    $(document).on('keydown', function(e) {
        if (e.altKey) {
            e.preventDefault();

            switch (e.keyCode) {
                case 67:
                    break;
                case 83:
                    $('#edit-form').submit();
                    break;
            }
        }
    });
});
