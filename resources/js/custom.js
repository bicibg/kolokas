import $ from 'jquery';

$(document).ready(function () {
    $('.categories-picker').selectpicker({
        dropupAuto: false,
        size: 10,
        liveSearch: true,
        liveSearchNormalize: true,
        style: '',
        styleBase: 'form-control'
    });
});
window.lockScroll = function () {
    if ($('body').hasClass('lock-scroll')) {
        $('body').removeClass('lock-scroll');
    } else {
        $('body').addClass('lock-scroll');
    }
}
