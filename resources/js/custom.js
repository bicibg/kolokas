$(document).ready(function() {
    $('.categories-picker').selectpicker({
        dropupAuto: false,
        size: 10,
        liveSearch: true,
        liveSearchNormalize: true,
        style: '',
        styleBase: 'form-control'
    });
})

$(".image-checkbox").each(function () {
    if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
        $(this).addClass('image-checkbox-checked');
    } else {
        $(this).removeClass('image-checkbox-checked');
    }
});

// sync the state to the input
$(".image-checkbox").on("click", function (e) {
    $(this).toggleClass('image-checkbox-checked');
    var $checkbox = $(this).find('input[type="checkbox"]');
    $checkbox.prop("checked", !$checkbox.prop("checked"))

    e.preventDefault();
});

window.lockScroll = function()
{
    if ($('body').hasClass('lock-scroll')) {
        $('body').removeClass('lock-scroll');
    }
    else {
        $('body').addClass('lock-scroll');
    }
}
