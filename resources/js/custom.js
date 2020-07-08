$('.categories-picker').selectpicker({
    dropupAuto: false,
    size: 10,
    liveSearch: true,
    liveSearchNormalize: true,
    style: '',
    styleBase: 'form-control'
});

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

$(document).ready(function () {
    var toggleAffix = function (affixElement, scrollElement, wrapper) {

        var height = affixElement.outerHeight();
        //    top = wrapper.offset().top;

        if (scrollElement.scrollTop() >= 80) {
            wrapper.height(height);
            affixElement.addClass("affix");
        } else {
            affixElement.removeClass("affix");
            wrapper.height('auto');
        }

    };


    $('[data-toggle="affix"]').each(function () {
        var ele = $(this),
            wrapper = $('<div></div>');

        ele.before(wrapper);
        $(window).on('scroll resize', function () {
            toggleAffix(ele, $(this), wrapper);
        });

        // init
        toggleAffix(ele, $(window), wrapper);
    });

});