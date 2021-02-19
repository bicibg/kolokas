$(document).ready(function () {
    $('.categories-picker').selectpicker({
        dropupAuto: false,
        size: 10,
        liveSearch: true,
        liveSearchNormalize: true,
        style: '',
        styleBase: 'form-control'
    });

    // $(".image-checkbox").each(function () {
    //     if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
    //         $(this).addClass('image-checkbox-checked');
    //     } else {
    //         $(this).removeClass('image-checkbox-checked');
    //     }
    // });
    // $(".image-checkbox").on("click", function() {
    //     $(this).toggleClass('image-checkbox-checked');
    //     var $checkbox = $(this).find('input[type="checkbox"]').first();
    //     // $checkbox.attr("checked", "checked");
    //     // $checkbox[0].dispatchEvent(new Event('input'));
    //     console.log($checkbox[0]);
    // });

})

window.lockScroll = function () {
    if ($('body').hasClass('lock-scroll')) {
        $('body').removeClass('lock-scroll');
    } else {
        $('body').addClass('lock-scroll');
    }
}
