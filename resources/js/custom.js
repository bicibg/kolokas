$(document).ready(function () {
    $('.categories-picker').selectpicker({
        dropupAuto: false,
        size: 10,
        liveSearch: true,
        liveSearchNormalize: true,
        style: '',
        styleBase: 'form-control'
    });

    // // init the state from the input
    // $(".image-checkbox").each(function () {
    //     if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
    //         $(this).addClass('image-checkbox-checked');
    //     } else {
    //         $(this).removeClass('image-checkbox-checked');
    //     }
    // });
    //
    // // sync the state to the input
    // $(".image-checkbox").on("click", function (e) {
    //     if ($(this).hasClass('image-checkbox-checked')) {
    //         $(this).removeClass('image-checkbox-checked');
    //         $(this).find('input[type="checkbox"]').first().removeAttr("checked");
    //     } else {
    //         $(this).addClass('image-checkbox-checked');
    //         $(this).find('input[type="checkbox"]').first().attr("checked", "checked");
    //     }
    //
    //     e.preventDefault();
    // });
});
window.lockScroll = function () {
    if ($('body').hasClass('lock-scroll')) {
        $('body').removeClass('lock-scroll');
    } else {
        $('body').addClass('lock-scroll');
    }
}
