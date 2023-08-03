"use strict";

$(function () {
    // Elements and Queries
    const receiptTotal = $('#receipt-total');
    const addFields = $(".hb-add");
    const advertisingCost = $("#advertising-cost");
    const advertisingPercentage = $("#advertising-percentage");

    // Configuration
    const zero = 0.00;
    const decimal = 2;
    const percentMultiplier = 100;
    const eventType = 'input';
    let receiptTotalValue = zero;

    /**
     * Add all summable fields and put into the total field.
     * Calculate the advertising percentage and put it into the advertising percentage field.
     */
    addFields.on(eventType, function() {
        receiptTotalValue = zero;
        addFields.each(function () {
            if ($(this).val()) {
                receiptTotalValue += parseFloat($(this).val());
            }
        });
        receiptTotal.val(receiptTotalValue.toFixed(decimal).toString());
        if (advertisingCost.val()) {
            advertisingPercentage.val((parseFloat(advertisingCost.val()) / parseFloat(receiptTotal.val()) * percentMultiplier).toFixed(decimal).toLocaleString());
        }

    });

    /**
     * Calculate the advertising percentage and put it into the advertising percentage field.
     */
    advertisingCost.on(eventType, function () {
        if (advertisingCost.val()) {
            advertisingPercentage.val((parseFloat(advertisingCost.val()) / parseFloat(receiptTotal.val()) * percentMultiplier).toFixed(decimal).toLocaleString());
        }
    });
});
