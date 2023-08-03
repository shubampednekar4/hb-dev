"use strict";

$(function() {
    $('input[type=tel]').mask('000-000-0000');
    $('.money').on('change paste keyup', function (event) {
        let max = parseFloat($(this).attr('max'));
        let num = parseFloat($(this).val());
        if (num >= max) {
            $(this).val("999999.99");
        }
        let number = ($(this).val().split('.'));
        if (number[1] && number[1].length > 2)
        {
            let salary = parseFloat($(this).val());
            $(this).val( salary.toFixed(2));
        }
    })
});