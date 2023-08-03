/**
 * Get states method
 *
 * @return {Promise<any>}
 */
const getStates = async () => {
    let response = await fetch('/states/get-all', {
        method: 'GET',
        headers: {Accept: 'application/json'}
    });

    if (response.status !== 200) {
        throw new Error("States could not be fetched");
    }

    return response.json();
};

"use strict"
const renderLocationForm = (states) => {
    let options = '';
    states.forEach(state => {
        options += `<option value="${state.state_id}">${state.full_name}</option>`;
    });

    return '<form id="location-form" novalidate>' +
        '<div class="tab-content" id="location-panes">' +
        '<div class="tab-pane active show" id="location1">' +
        '<div class="form-row">' +
        '<div class="col-12">' +
        '<div class="form-group">' +
        '<label for="location-name">Location Name</label>' +
        '<input class="form-control" type="text" id="location-name" name="name"' +
        ' required' +
        ' autocomplete="off">' +
        '<div class="invalid-feedback text-left">Location Name is required</div>' +
        '</div>' +
        '</div>' +
        '</div>' +

        '<div class="form-row">' +
        '<div class="col-12">' +
        '<div class="form-group">' +
        '<label for="address">Address</label>' +
        '<input class="form-control" type="text" id="address" name="address" required' +
        ' autocomplete="off">' +
        '<div class="invalid-feedback text-left">Address is required</div>' +
        '</div>' +
        '</div>' +
        '</div>' +

        '<div class="form-row">' +
        '<div class="col-12">' +
        '<div class="form-group">' +
        '<label for="city">City</label>' +
        '<input class="form-control" type="text" id="city" name="city" required' +
        ' autocomplete="off">' +
        '<div class="invalid-feedback text-left">City is required</div>' +
        '</div>' +
        '</div>' +
        '</div>' +

        '<div class="form-row">' +
        '<div class="col-12">' +
        '<div class="form-group d-flex flex-column text-left" id="state-parent">' +
        '<label for="state_id" class="text-left">State</label>' +
        '<select data-parent="state-parent" class="form-control text-left location-select" id="state_id"' +
        ' name="state_id" required>' +
        options +
        '</select>' +
        '<div class="invalid-feedback text-left">State is required</div>' +
        '</div>' +
        '</div>' +
        '</div>' +

        '<div class="form-row">' +
        '<div class="col-12">' +
        '<div class="form-group">' +
        '<label for="zip">Zip</label>' +
        '<input class="form-control" type="text" id="zip" name="zip" required' +
        ' autocomplete="off">' +
        '<div class="invalid-feedback text-left">Zip is required</div>' +
        '</div>' +
        '</div>' +
        '</div>' +

        '<div class="form-row">' +
        '<div class="col-12">' +
        '<div class="form-group d-flex flex-column text-left" id="cities_parent">' +
        '<label for="cities" class="text-left">Cities</label>' +
        '<select data-parent="cities_parent"  class="form-control text-left location-select" id="cities"' +
        ' name="cities[]" multiple' +
        ' required>' +
        '</select>' +
        '<div class="invalid-feedback text-left">Cities are required</div>' +
        '</div>' +

        '<div class="form-row">' +
        '<div class="col-12">' +
        '<div class="form-group d-flex flex-column text-left" id="zips_parent">' +
        '<label for="location1-zip_codes" class="text-left">Zip Codes</label>' +
        '<select data-parent="zips_parent" class="form-control text-left location-select" id="zip_codes"' +
        ' name="zips[]"' +
        ' multiple' +
        ' required>' +
        '</select>' +
        '<div class="invalid-feedback text-left">Zip Codes is required</div>' +
        '</div>' +

        '</form>';
}

/**
 * Form validation method
 *
 * Check if there was an issue with the form input.
 *
 * @param {string} formId Form from which inputs are to be validated
 * @return {boolean} Whether the inputs were valid.
 */
const validateForm = formId => {
    let result = true,
        errorOccurred = false,
        form = document.getElementById(formId),
        inputs = document.querySelectorAll(`#${formId} input`);
    try {
        inputs.forEach(input => {
            let invalidTextContainer = findInvalidTextContainer(input);
            invalidTextContainer.textContent = '';
            if (input instanceof HTMLInputElement) {
                if (!input.checkValidity()) {
                    result = false;
                    invalidTextContainer.textContent = input.validationMessage;
                }
            } else if (input instanceof HTMLTextAreaElement) {
                if (input.value === '' && input.required) {
                    result = false;
                    invalidTextContainer.textContent = 'This field cannot be empty';
                }
            } else {
                result = false;
                throw new TypeError(`Expected instance of HTMLInputElement or HTMLTextareaElement, got ${typeof input} instead`)
            }
        });
    } catch (error) {
        errorOccurred = true;
        handleError(error);
    }
    if (!result) {
        form.classList.add('was-validated');
    }
    return result && !errorOccurred;
}

/**
 * Validation Text Finder
 *
 * Find the container for the validation text.
 * You should place the validation text container immediately after the input for best result.
 * If you place it inside another element, this method will not find it.
 * You must make the element a `<div>` element for this method to work properly.
 *
 * @param {HTMLInputElement|HTMLTextAreaElement} input Input that is being validated
 * @return {HTMLDivElement} Container for validation text.
 * Element will be a `<div>`.
 */
const findInvalidTextContainer = (input) => {

    let container = input.nextElementSibling;
    try {
        while (!container.matches('.invalid-feedback')) {
            container = container.nextElementSibling;
        }
    } catch (error) {
        return document.createElement('div');
    }
    return container;
}

/**
 * Error Handler
 *
 * This will log the error to the console and display an alert to the user for debugging.
 * This should only be used on errors that have little to no chance of occurring in production.
 *
 * @param error Error that was thrown.
 */
const handleError = (error) => {
    console.error(`An error occurred while validating data: ${error}`);
    swal.fire({
        title: 'Validation Error',
        text: 'An error occurred while validating data. Change not submitted. See below message.',
        icon: 'error',
        didOpen: () => {
            swal.showValidationMessage(error);
        }
    });
};

const handleGeneralError = (error) => {
    console.error(`An error and needs to be corrected: ${error}`);
    swal.fire({
        title: 'Validation Error',
        text: 'An error and needs to be corrected. See below message.',
        icon: 'error',
        didOpen: () => {
            swal.showValidationMessage(error);
        }
    });
}