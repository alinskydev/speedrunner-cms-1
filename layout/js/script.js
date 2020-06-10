$(function () {
    $('[data-toggle="popover"]').popover({placement: 'top', trigger: 'hover'});
    
    $(document).on('change', '.custom-file-input', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });
    
    $(document).on('click', '.nav-toggle', function() {
        $('.nav-wrapper').toggleClass('active');
        $('body').toggleClass('overflow-hidden');
    });
});