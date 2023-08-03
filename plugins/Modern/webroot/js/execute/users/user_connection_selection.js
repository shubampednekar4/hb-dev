"use strict";

$(function() {
    const userTypeSelector = $("#new-user-type");

    const stateOwnerContainer = $("#state-owner-selection-container");
    const stateOwnerSelect = $("#state-owner-id");

    const operatorContainer = $("#operator-selection-container");
    const operatorSelect = $("#existing-operator-id");
    const operatorStateSelect = $("#operator-state");
    const franchiseSateSelect = $("#state-id");
    userTypeSelector.on('change', function() {
        if ($(this).val() === '2') {
            operatorContainer.collapse('hide');
            operatorStateSelect.select2().end();
            franchiseSateSelect.select2().end();
            stateOwnerContainer.collapse('show');
            stateOwnerSelect.select2({
                dropdownParent: stateOwnerContainer,
            });
            operatorSelect.val(null).select2().end();
        } else if ($(this).val() === '3') {
            operatorContainer.collapse('show');
            stateOwnerContainer.collapse('hide');
            operatorSelect.select2({
                dropdownParent: operatorContainer,
            });
            operatorStateSelect.select2();
            franchiseSateSelect.select2();
        } else {
            operatorContainer.collapse('hide');
            stateOwnerContainer.collapse('hide');
            stateOwnerSelect.val(null).select2().end();
            operatorSelect.val(null).select2().end();
            operatorStateSelect.select2().end();
            franchiseSateSelect.select2().end();
        }
    });
});