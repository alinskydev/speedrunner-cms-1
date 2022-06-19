$(function () {

    let el, sentData;

    //      Ajax function

    function ajaxSend(event, el, url, method = 'get', sentData = {}, callback = false) {
        event.preventDefault();

        let ajaxExtraParams = {},
            insertType = el.data('sr-insert-type');

        if (sentData instanceof FormData) {
            ajaxExtraParams = {
                processData: false,
                contentType: false
            };
        }

        $.ajax({
            ...ajaxExtraParams,
            ...{
                url: url,
                type: method,
                data: sentData,

                success: function (data) {

                    //      Setting data to wrapper

                    switch (typeof (el.data('sr-wrapper'))) {
                        case 'string':
                            if (insertType === undefined) {
                                $(el.data('sr-wrapper')).html(data);
                            } else {
                                eval("$(el.data('sr-wrapper'))." + insertType + "(data)");
                            }
                            break;

                        case 'object':
                            for (key in el.data('sr-wrapper')) {
                                $(el.data('sr-wrapper')[key]).html(data[key]);
                            }
                            break;
                    }

                    //      Callbacks init

                    if (callback !== false) {
                        callback(data);
                    }

                    if (el.data('sr-callback') !== undefined) {
                        eval(el.data('sr-callback'));
                    }
                }
            }
        });
    }

    //      Ajax button

    $(document).on('click', '[data-sr-trigger*="ajax-button"]', function (event) {
        el = $(this);
        ajaxSend(event, el, el.data('sr-url'), el.data('sr-method'));
    });

    //      Ajax form

    $(document).on('submit', '[data-sr-trigger*="ajax-form"]', function (event) {
        el = $(this);

        switch (el.attr('method')) {
            case 'get':
                sentData = el.serialize();
                break;
            case 'post':
                sentData = new FormData(el[0]);
                break;
        }

        ajaxSend(event, el, el.attr('action'), el.attr('method'), sentData);
    });

    //      Ajax change

    $(document).on('change', '[data-sr-trigger*="ajax-change"]', function (event) {
        el = $(this);

        sentData = {};
        sentData[el.data('sr-key')] = el.val();

        ajaxSend(event, el, el.data('sr-url'), el.data('sr-method'), sentData);
    });

    //      Ajax keypress

    $(document).on('keyup', '[data-sr-trigger*="ajax-keypress"]', function (event) {
        el = $(this);

        sentData = {};
        sentData[el.data('sr-key')] = el.val();

        if (el.val().length >= el.data('sr-min')) {
            ajaxSend(event, el, el.data('sr-url'), el.data('sr-method'), sentData);
        }
    });
});
