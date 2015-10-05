$(function() {
    $(document).on('click', '[data-toggle="modal"]', function(e) {
        e.preventDefault();

        var btn = $(this);
        var url = btn.attr('href');
        var title = btn.data('title');
        var role = btn.attr('role');
        var data_target = btn.data('target');
        var modal =  $('#myModal').clone();

        $('.navbar-brand').html('<div class="loader"><img src="/bundles/tempoapp/images/loading-bubbles.svg" /></div>');

        modal.attr('id', 'modal' + parseInt(Math.random()*1000));
        modal.find('.modal-title').html(title);

        if (btn.hasClass('btn-danger')) {
            modal.find('button.confirm').removeClass('btn-primary').addClass('btn-danger');
        }

        if (role != 'dialog') {
            modal.find('.modal-footer button.confirm').remove();
        }
        $('#dialog').append(modal);

        if (data_target !== undefined) {
            url = data_target;
            modal.find('button.confirm').on('click', function(e) {
                window.location = btn.attr('href');
            });
        }

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

        modal.on('hidden.bs.modal', function (event) {
            $('.navbar-brand').html('Tempo');
            $(".modal-backdrop").remove();
        });

        var fantomas = $(modal).find('button.fantomas');
        if(fantomas) {
            modal.find('button.confirm').on('click', function(e) {
                $(this).closest('.modal').find("form .fantomas").click();
            });
        }
    });
});
