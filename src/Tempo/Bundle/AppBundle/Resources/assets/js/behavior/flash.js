$(function() {

    var flash = $(".flash-container");

    if (flash.length > 0) {
        flash.show();
        flash.click(function() {
            return $(this).slideUp("slow");
        });

        flash.slideDown("slow");
        setTimeout((function() {
            return flash.slideUp("slow");
        }), 3000);
    }
});
