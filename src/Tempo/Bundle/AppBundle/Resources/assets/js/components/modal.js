$(function() {
    $(document).on('click', '[data-toggle="modal"]', function(e) {
        e.preventDefault();

        $('.navbar-brand').html('<div class="loader"><img src="/bundles/tempoapp/images/loading-bubbles.svg" /></div>');

        var btn = $(this),
            url = btn.attr('href'),
            title = btn.data('title'),
            role = btn.attr('role'),
            redirect = btn.data('redirect'),
            data_target = 'modal'+parseInt(Math.random()*1000),
            modal =  $('#myModal').clone();

        modal.attr('id', data_target);
        modal.find('.modal-title').html(title);
        var modalData = '';

        if (role != 'dialog') {
            modal.find('.modal-footer button.confirm').remove();
        }
        $('#dialog').append(modal);

        if (url.indexOf('#') === 0) {
            $(url).show().appendTo(modal.find('.modal-body'));
            modal.modal();
        } else {
            $.get(url, function(data) {
                modal.find('.modal-body').html(data);
            }).success(function() {
                modal.modal();
                $('.navbar-brand .loader').remove();
                $('.navbar-brand').html('Tempo');
                $('input:text:visible:first').focus();
            });
        }

        var fantomas = $(modal).find('button.fantomas');
        if(fantomas) {
            modal.find('button.confirm').on('click', function(e) {
                $(this).closest('.modal').find("form .fantomas").click();
            });
        }
    });
});