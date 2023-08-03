"use strict";
/* ------------------------------------------------- Initialization ------------------------------------------------- */

const countTabs = () => {
    const tabs = document.querySelectorAll('.location-tab-btn');
    return tabs.length;
};
const removeBtn = document.getElementById('location-delete-btn');
let tabCount = countTabs();
$(function () {
    let locationSelects = document.querySelectorAll('#location-card .location-select2');
    locationSelects.forEach(select => {
        let parent = document.getElementById(select.dataset.parent);
        if (select.multiple) {
            $(`#${select.id}`).select2({
                dropdownParent: $(parent),
                tags: true,
                width: '100%',
            });
        } else {
            $(`#${select.id}`).select2({
                dropdownParent: $(parent),
                width: '100%',
            });
        }
    });
});

/* ----------------------------------------------- Updates & Fillers ------------------------------------------------ */
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', () => {
        if (button.dataset.formOpen === 'false') {
            button.classList.remove('btn-primary');
            button.classList.add('btn-success')
            button.textContent = 'Save';
            button.dataset.formOpen = 'true';
        } else {
            button.classList.add('btn-primary');
            button.classList.remove('btn-success')
            button.textContent = 'Edit';
            button.dataset.formOpen = 'false';
            if (button.dataset.formType === 'franchise') {
                swal.fire({
                    title: 'Saving Franchise Information',
                    text: 'Please wait while we save the franchise information...',
                    icon: 'info',
                    didOpen: () => {
                        swal.showLoading();
                        return saveFranchiseData()
                            .then(franchise => {
                                fillFranchiseData(franchise);
                                swal.fire({
                                    title: 'Success',
                                    text: 'Franchise information was successfully saved!',
                                    icon: 'success'
                                });
                            }).catch(error => {
                                swal.hideLoading();
                                swal.fire({
                                    title: 'Something Went Wrong',
                                    text: 'We could not save the franchise information.',
                                    icon: 'error',
                                    didOpen: () => swal.showValidationMessage(error),
                                });
                            });
                    },
                    showConfirmButton: () => !swal.isLoading(),
                    showCancelButton: false,
                    allowOutsideClick: () => !swal.isLoading(),
                });
            } else {
                swal.fire({
                    title: 'Saving Operator Information',
                    text: 'Please wait while we save the operator information...',
                    icon: 'info',
                    didOpen: () => {
                        swal.showLoading();
                        return saveOperatorData()
                            .then(operator => {
                                fillOperatorData(operator);
                                swal.fire({
                                    title: 'Success',
                                    text: 'Operator information was successfully saved!',
                                    icon: 'success'
                                });
                            }).catch(error => {
                                swal.hideLoading();
                                swal.fire({
                                    title: 'Something Went Wrong',
                                    text: 'We could not save the operator information',
                                    icon: 'error',
                                    didOpen: () => swal.showValidationMessage(error),
                                })
                            })
                    },
                    showConfirmButton: () => !swal.isLoading(),
                    showCancelButton: false,
                    allowOutsideClick: () => !swal.isLoading(),
                });
            }
        }
    });
});

document.getElementById('add-location-btn').addEventListener('click', () => {
    swal.fire({
        title: 'One Moment',
        text: 'Please wait while we gather everything.',
        didOpen: () => {
            swal.showLoading();
            getStates().then(states => {
                swal.hideLoading();
                swal.fire({
                    title: 'Add Location',
                    html: renderLocationForm(states),
                    showCloseButton: true,
                    confirmButtonText: 'Done',
                    didOpen: () => {
                        let container = $('.swal2-container');
                        $(".location-select").each(function () {
                            $(this).select2({
                                dropdownParent: container,
                                width: '100%',
                                tags: $(this).attr('multiple') === 'multiple',
                            });
                        });
                    },
                    preConfirm: () => {
                        if (validateForm('location-form')) {
                            return saveNewLocationData()
                                .catch(error => {swal.showValidationMessage(`Issue: ${error}`)});
                        } else {
                            swal.showValidationMessage('Please check your information.');
                        }
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        swal.fire({
                            title: 'Success',
                            text: `The "${result.value.location_name}" location has been added.`,
                            icon: 'success',
                        });
                        getStates().then(states => {
                            let options = [];
                            states.forEach(state => {
                                options.push({
                                    value: state.state_id,
                                    text: state.full_name,
                                });
                            });
                            fillNewLocationData(result.value, options);
                            renewEditBtn();
                        }).catch(error => handleGeneralError(error));
                    }
                });
            })
        },
        allowOutsideClick: () => !swal.isLoading(),
    });
});

const renewEditBtn = () => {
    const variableEditButtons = document.querySelectorAll('.variable-edit-btn');
    const locationTabs = document.querySelectorAll('.location-tab');
    const toggles = document.querySelectorAll('.location-toggle');
    locationTabs.forEach(locationTab => {
        $(locationTab).on('shown.bs.tab', function () {
            variableEditButtons.forEach(variableEditButton => {
                variableEditButton.dataset.currentTab = this.dataset.locationId;
            });
        });
    });
    let locationId = document.getElementById('variable-edit-btn').dataset.currentTab;
    toggles.forEach(toggle => {
        $(toggle).addClass('collapse');
        if (!toggle.classList.contains('location-form')) {
            $(toggle).collapse('show');
        }
    });
    let info = $(`#location-info-${locationId}`);
    let form = $(`#location-form-${locationId}`);
    info.addClass('collapse show');
    form.addClass('collapse');
    let infos = document.querySelectorAll('.location-info');
    infos.forEach(info => {
        $(info).on('show.bs.collapse', () => {
            let btn = document.getElementById('variable-edit-btn');
            btn.classList.remove('btn-success');
            btn.classList.add('btn-primary');
            btn.textContent = 'Edit';
        }).on('hide.bs.collapse', () => {
            let btn = document.getElementById('variable-edit-btn');
            btn.classList.add('btn-success');
            btn.classList.remove('btn-primary');
            btn.textContent = 'Save';
        }).on('shown.bs.collapse', () => {
            let btn = document.getElementById('variable-edit-btn');
            btn.dataset.save = 'false';
        }).on('hidden.bs.collapse', () => {
            let btn = document.getElementById('variable-edit-btn');
            btn.dataset.save = 'true';
        })
    });
    document.getElementById('variable-edit-btn').addEventListener('click', function () {
        let locationId = document.getElementById('variable-edit-btn').dataset.currentTab;
        let nestedInfo = $(`#location-info-${locationId}`);
        let nestedForm = $(`#location-form-${locationId}`);
        nestedInfo.collapse('toggle');
        nestedForm.collapse('toggle');
    });
}
renewEditBtn();
/**
 * Save franchise information data
 *
 * @return {Promise<any>}
 */
const saveFranchiseData = async () => {
    let raw = new FormData(document.getElementById('franchise-form-element'));
    let data = new URLSearchParams(raw);
    let response = await fetch('/franchises/save-info', {
        body: data,
        headers: {
            Accept: 'application/json',
            'X-Csrf-Token': csrfToken,
        },
        method: 'post'
    });

    if (!response.ok) {
        throw new Error('Server returned issue with save');
    }

    return response.json();
};

/**
 * Fill franchise data method
 *
 * @param {Object} data
 */
const fillFranchiseData = (data) => {
    let status = document.createElement('span');
    status.classList.add('badge');
    switch (data.franchise_status) {
        case 'Active':
            status.classList.add('badge-success')
            status.textContent = 'Open';
            break;
        case 'Inactive':
            status.classList.add('badge-danger');
            status.textContent = 'Closed';
            break;
        case 'For Sale':
            status.classList.add('badge-warning');
            status.textContent = 'For Sale';
            break
        default:
            status.classList.add('badge-danger');
            status.textContent = 'Something Went Wrong';
    }
    document.getElementById('staticTitle').textContent = data.franchise_name;
    document.getElementById('staticFranchiseName').textContent = data.franchise_name;
    document.getElementById('staticFranchiseStatus').innerHTML = '';
    document.getElementById('staticFranchiseStatus').appendChild(status);
    document.getElementById('staticFranchiseStateOwnerName').textContent = data.state_owner.full_name;
    document.getElementById('staticFranchiseDescription').textContent = data.franchise_description;
    document.getElementById('staticFranchiseTerritories').textContent = data.franchise_number_of_territories;
    document.title = `Heaven's Best » ${data.franchise_name}`;
};

/**
 * Save operator data method
 *
 * @return {Promise<any>}
 */
const saveOperatorData = async () => {
    let raw = new FormData(document.getElementById('operator-form-element'));
    let data = new URLSearchParams(raw);
    let response = await fetch('/operators/save-info', {
        body: data,
        headers: {
            Accept: 'application/json',
            'X-Csrf-Token': csrfToken,
        },
        method: 'post'
    });

    if (!response.ok) {
        throw new Error('Server returned issue with save');
    }

    return response.json();
};

/**
 * Fill operator data method
 *
 * @param {object} operator
 */
const fillOperatorData = (operator) => {
    let allElements = document.querySelectorAll('.staticOp'),
        name = document.getElementById('staticOpName'),
        email = document.getElementById('staticOpEmail'),
        phone = document.getElementById('staticOpPhone'),
        address = document.getElementById('staticOpAddress'),
        username = document.getElementById('staticOpUsername'),
        nameLink = document.createElement('a'),
        emailLink = document.createElement('a'),
        phoneLink = document.createElement('a'),
        usernameLink = document.createElement('a');

    // Clear content
    allElements.forEach(element => element.innerHTML = '');

    // name
    nameLink.href = `/operators/view/${operator.operator_id}`;
    nameLink.textContent = operator.full_name;
    name.appendChild(nameLink);

    // email
    emailLink.href = `mailto:${operator.operator_email}`;
    emailLink.textContent = operator.operator_email;
    email.appendChild(emailLink);

    // phone
    phoneLink.href = `tel:${operator.operator_phone}`;
    phoneLink.textContent = operator.operator_phone;
    phone.appendChild(phoneLink);

    // address
    address.innerHTML = `${operator.operator_address}<br/>${operator.operator_city}, ${operator.state.abbrev} ${operator.operator_zip}`;

    // username
    usernameLink.href = `/users/view/${operator.user_id}`
    usernameLink.textContent = operator.user.user_username
    username.appendChild(usernameLink);
};


/**
 * Save new location data method
 *
 * @return {Promise<any>}
 */
const saveNewLocationData = async () => {
    let raw = new FormData(document.getElementById('location-form'));
    let data = new URLSearchParams(raw);
    let response = await fetch('/locations/add', {
        method: 'post',
        body: data,
        headers: {
            'X-Csrf-Token': csrfToken,
            Accept: 'application/json'
        }
    });

    if (!response.ok) {
        throw new Error('Could not save location');
    }

    return response.json();
}

/**
 * Fill new location data method
 *
 * @param {Object} data
 * @param {Object[]} states
 */
const fillNewLocationData = (data, states) => {
    let infoContainer = document.createElement('div'),
        formContainer = document.createElement('div'),
        form = document.createElement('form'),
        tabs = document.getElementById('locationTabs'),
        panes = document.getElementById('location-panes'),
        cityStrings = [],
        zipStrings = [];
    data.assoc_cities.forEach(city => cityStrings.push(city.city_name));
    data.assoc_zips.forEach(zip => zipStrings.push(zip.zip_code));
    infoContainer.classList.add('location-toggle', 'show', 'location-info');
    infoContainer.id = `location-info-${data.location_id}`;
    formContainer.classList.add('location-form', 'location-toggle');
    formContainer.id = `location-form-${data.location_id}`;
    form.method = 'post';
    form.action = `/franchises/view/${data.franchise_id}`;
    let infoGroups = [
        createInfoGroup({
            name: 'Name',
            label: 'Location Name',
            id: data.location_id,
            value: data.location_name,
        }),
        createInfoGroup({
            name: 'Address',
            label: 'Address',
            id: data.location_id,
            value: `<br/>${data.location_address}<br/>${data.main_city.city_name}, ${data.state.abbrev} ${data.main_zip.zip_code}`,
        }),
        createInfoGroup({
            name: 'Cities',
            label: 'Cities',
            id: data.location_id,
            value: cityStrings.join(', ').toString(),
        }),
        createInfoGroup({
            name: 'Zips',
            label: 'Zip Codes',
            id: data.location_id,
            value: zipStrings.join(', ').toString(),
        }),
    ];
    infoGroups.forEach(group => infoContainer.appendChild(group));
    let inputGroups = [
        createTextInput({
            name: 'location_name',
            required: true,
            labelText: 'Location Name',
            idEnd: 'name',
            locationId: data.location_id,
            value: data.location_name,
        }),
        createTextInput({
            name: 'location_address',
            required: true,
            labelText: 'Address',
            idEnd: 'address',
            locationId: data.location_id,
            value: data.location_address
        }),
        createTextInput({
            name: 'main_city[city_name]',
            required: true,
            labelText: 'City',
            idEnd: 'city',
            locationId: data.location_id,
            value: data.main_city.city_name
        }),
        createSelectInput({
            name: 'state_id',
            required: true,
            labelText: 'State',
            idEnd: 'state',
            locationId: data.location_id,
            options: states,
            value: data.state_id
        }, false),
        createTextInput({
            name: 'main_zip[zip_code]',
            required: true,
            labelText: 'Zip Code',
            idEnd: 'zip',
            locationId: data.location_id,
            value: data.main_zip.zip_code,
        }),
        createSelectInput({
            name: 'cities[city_name]',
            required: true,
            labelText: 'Cities',
            idEnd: 'cities-city-name',
            locationId: data.location_id,
            values: data.assoc_cities.map(city => {
                return {
                    value: city.city_id,
                    text: city.city_name,
                };
            }),
        }),
        createSelectInput({
            name: 'zips[zip_code]',
            required: true,
            labelText: 'Zips',
            idEnd: 'zips-zip-codes',
            locationId: data.location_id,
            values: data.assoc_zips.map(zip => {
                return {
                    value: zip.zip_id,
                    text: zip.zip_code,
                }
            }),
        }),
    ];
    form.appendChild(createHiddenInput({
        name: "location_id",
        value: data.location_id,
    }));
    inputGroups.forEach(group => form.appendChild(group));
    formContainer.appendChild(form);
    panes.appendChild(createLocationPane(data.location_id, infoContainer, formContainer));
    tabs.insertBefore(createLocationTab(data.location_id, data.location_name), document.getElementById('add-location-btn'));
    let select2Inputs = document.querySelectorAll(`#location-form-${data.location_id} .select2`);
    select2Inputs.forEach(input => {
        if (input.multiple) {
            $(input).select2({
                dropdownParent: $(`#location${data.location_id}${input.id}Parent`),
                tags: true,
                width: '100%',
            })
        } else {
            $(input).select2({
                dropdownParent: $(`#location${data.location_id}${input.id}Parent`),
                width: '100%',
            })
        }
    });
    removeBtn.disabled = false;
    removeBtn.innerText = 'Remove';
    tabCount++;
    renewEditBtn();
    $(`#location${data.location_id}-tab`).tab('show');
};

/**
 *
 * @param {object} options
 * @return {HTMLDivElement}
 */
const createTextInput = (options) => {
    let input = document.createElement('input');
    input.type = 'text';
    input.id = `location-${options.locationId}-${options.idEnd}`;
    input.classList.add('form-control');
    input.name = options.name;
    input.required = true;
    input.value = options.value;
    return addToGroup(input, options.labelText);
}

/**
 * Create select input method
 *
 * @param {object} options
 * @param {boolean} multiple
 */
const createSelectInput = (options, multiple = true) => {
    let select = document.createElement('select');
    select.id = `location-${options.locationId}-${options.idEnd}`;
    select.classList.add('select2');
    select.name = options.name;
    select.required = options.required;
    if (!multiple) {
        let selectOptions = options.options
        selectOptions.forEach(selectOption => {
            let option = document.createElement('option');
            option.value = selectOption.value;
            option.textContent = selectOption.text;
            if (option.value === options.value) {
                option.selected = true;
            }
            select.appendChild(option);
        });
    } else {
        select.multiple = true;
        let selectOptions = [];
        options.values.forEach(selectOption => {
            let option = document.createElement('option');
            option.value = selectOption.value;
            option.textContent = selectOption.text;
            option.selected = true;
            selectOptions.push(option);
        });
        selectOptions.forEach(option => select.appendChild(option));
    }
    return addToGroup(select, options.labelText, `location${options.locationId}${select.id}Parent`);
}

/**
 * Add to group method
 *
 * @param {HTMLElement} element
 * @param {string} labelText
 * @param {string|null} parentValue
 * @return {HTMLElement}
 */
const addToGroup = (element, labelText, parentValue = null) => {
    let label = document.createElement('label'),
        validText = document.createElement('div'),
        group = document.createElement('div'),
        column = document.createElement('div'),
        row = document.createElement('div');
    label.setAttribute('for', element.id);
    label.textContent = labelText;
    validText.classList.add('invalid-input');
    group.classList.add('form-group');
    if (parentValue) {
        group.id = parentValue
    }
    row.classList.add('form-row');
    column.classList.add('col-12');

    group.appendChild(label);
    group.appendChild(element);
    group.appendChild(validText);
    column.appendChild(group);
    row.appendChild(column);
    return row;
}

/**
 * Create info group method
 *
 * @param {object} options
 * @return {HTMLDivElement}
 */
const createInfoGroup = (options) => {
    let row = document.createElement('div'),
        column = document.createElement('div'),
        header = document.createElement('span'),
        container = document.createElement('span');
    row.classList.add('row');
    column.classList.add('col-12', 'lead', 'my-2');
    header.classList.add('font-weight-bold');
    header.textContent = `${options.label}: `;
    container.id = `staticLocation${options.name}-${options.id}`;
    if (options.name === 'address') {
        container.innerHTML = '<br/>' + options.value;
    } else {
        container.innerHTML = options.value;
    }
    column.appendChild(header);
    column.appendChild(container);
    row.appendChild(column);
    return row;
}

/**
 * Create location tab method
 *
 * @param {string} id
 * @param {string} name
 * @return {HTMLLIElement}
 */
const createLocationTab = (id, name) => {
    let item = document.createElement('li'),
        link = document.createElement('a');
    item.classList.add('nav-item', 'location-tab');
    item.dataset.locationId = id;
    link.href = `#location${id}`;
    link.classList.add('nav-link', 'location-tab-btn');
    link.dataset.toggle = 'tab';
    link.dataset.key = id;
    link.id = `location${id}-tab`;
    link.textContent = name;
    item.appendChild(link);
    return item;
}

/**
 * Create location pane method
 *
 * @param {string} id
 * @param {HTMLDivElement} info
 * @param {HTMLDivElement} form
 * @return {HTMLDivElement}
 */
const createLocationPane = (id, info, form) => {
    let container = document.createElement('div');
    container.classList.add('tab-pane');
    container.id = `location${id}`;
    container.appendChild(info);
    container.appendChild(form);
    return container;
}

/**
 * Create hidden input element
 *
 * @param options
 * @return {HTMLInputElement}
 */
const createHiddenInput = (options) => {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = options.name;
    input.value = options.value;
    return input;
}

/**
 * Fill location data method
 *
 * @param {string|Object} data
 */
const saveLocationData = async (data) => {
    let response = await fetch('/locations/edit', {
        method: 'post',
        headers: {
            Accepts: 'application/json',
            'X-Csrf-Token': csrfToken,
        },
        body: data,
    });

    if (!response.ok) {
        throw new Error('Could not update existing location');
    }

    return response.json();
}

const fillLocationData = (id, data) => {
    let name = document.getElementById(`staticLocationName-${id}`),
        address = document.getElementById(`staticLocationAddress-${id}`),
        cities = document.getElementById(`staticLocationCities-${id}`),
        zips = document.getElementById(`staticLocationZips-${id}`),
        citiesArray = data.assoc_cities.map(city => {
            return city.city_name;
        }),
        zipsArray = data.assoc_zips.map(zip => {
            return zip.zip_code;
        })
    name.textContent = data.location_name;
    address.innerHTML = `${data.location_address}<br/>${data.main_city.city_name}, ${data.state.abbrev} ${data.main_zip.zip_code}`;
    cities.textContent = citiesArray.join(', ');
    zips.textContent = zipsArray.join(', ');
}

document.getElementById('variable-edit-btn').addEventListener('click', function () {
    let id = this.dataset.currentTab,
        container = document.getElementById(`location-form-${id}`),
        form = document.querySelector(`#${container.id} form`);
    let formData = new FormData(form);
    let body = new URLSearchParams(formData);
    if (this.dataset.save === 'true') {
        if (tabCount === 1) {
            removeBtn.innerText = 'Cannot Remove Only Location';
            removeBtn.disabled = true;
        } else {
            removeBtn.innerText = 'Remove Location';
            removeBtn.disabled = false;
        }
        swal.fire({
            title: 'Saving Location',
            text: 'Please wait while we save this location\'s data',
            icon: 'info',
            showConfirmButton: false,
            showCancelButton: false,
            allowOutsideClick: () => swal.isLoading(),
            didOpen: () => {
                swal.showLoading();
                saveLocationData(body).then(location => {
                    swal.hideLoading();
                    fillLocationData(this.dataset.currentTab, location);
                    swal.fire({
                        title: 'Location Saved',
                        text: `${location.location_name}'s data has been saved.`,
                        icon: 'success',
                    });
                }).catch(error => swal.showValidationMessage(error));
            }
        });
    } else {
        removeBtn.disabled = false;
        removeBtn.innerText = 'Discard';
    }
});

removeBtn.addEventListener('click', function () {
    let toggleBtn = document.getElementById('variable-edit-btn');
    let id = toggleBtn.dataset.currentTab;
    if (toggleBtn.classList.contains('btn-success')) {
        let info = document.getElementById(`location-info-${id}`),
            form = document.getElementById(`location-form-${id}`);
        $(info).collapse('toggle');
        $(form).collapse('toggle');
        this.innerText = 'Remove Location';
        if (tabCount === 1) {
            this.innerText = 'Cannot Remove Only Location';
            this.disabled = true;
        } else {
            this.innerText = 'Remove';
            this.disabled = false;
        }
    } else {
        let locationName = document.getElementById(`staticLocationName-${id}`).innerText;
        swal.fire({
            title: 'Are you sure?',
            text: `Are you sure you want to delete the "${locationName}" location? This cannot be undone.`,
            icon: 'warning',
            showConfirmButton: true,
            showCancelButton: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return deleteLocation(id)
                    .then(location => location)
                    .catch(error => handleGeneralError(error));
            },
            allowOutsideClick: () => !swal.isLoading(),
        }).then(response => {
            if (response.isConfirmed) {
                let id = response.value.location_id,
                    removeElements = [];
                removeElements.push(document.getElementById(`location${id}`));
                removeElements.push(document.getElementById(`location${id}-tab`));
                removeElements.forEach(element => element.remove());
                tabCount--;
                if (tabCount === 1) {
                    this.innerText = 'Cannot Remove Only Location';
                    this.disabled = true;
                }
                swal.fire({
                    title: `${locationName} Removed`,
                    text: `This location has been removed from the franchise.`,
                    icon: 'success',
                });
                let newTabs = document.querySelectorAll('.location-tab-btn');
                let tab = newTabs[0];
                $(tab).tab('show');
            }
        });
    }
});

/**
 * Delete location method
 *
 * @param id Location ID to be removed.
 * @return {Promise<any>}
 */
const deleteLocation = async (id) => {
    let response = await fetch(`/locations/delete/${id}`, {
        method: 'post',
        headers: {Accept: 'application/json', 'X-Csrf-Token': csrfToken}
    });

    if (!response.ok) {
        throw new Error('Could not delete location');
    }

    return response.json();
}