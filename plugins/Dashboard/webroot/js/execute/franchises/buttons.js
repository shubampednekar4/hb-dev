"use strict";

const addBtn = document.getElementById('add_franchise_btn');
const closeBtn = document.getElementById('close_franchise_btn');

addBtn.addEventListener('click', () => {
    showAddAlert()
});

closeBtn.addEventListener('click', () => {
    showCloseAlert();
});

const showCloseAlert = () => {
    Swal.fire({
        title: "Please Wait...",
        text: "We are getting all open franchises",
        icon: 'info',
        didOpen: () => {
            Swal.showLoading();
            getOpenFranchises().then(franchises => {
                swal.fire({
                    title: 'Close Franchise',
                    html:
                        '<p>Please select the franchise that you wish to mark as closed:</p>' +
                        '<select class="form-control" id="franchise_id" name="franchise_id">' +
                        franchises.map(franchise => {
                            return `<option value="${franchise.franchise_id}">${franchise.franchise_name}</option>`
                        }) +
                        '</select>',
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    showConfirmButton: true,
                    showCancelButton: true,
                    showCloseButton: true,
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading(),
                    preConfirm: () => {
                        return closeFranchise(document.getElementById('franchise_id').value)
                            .catch(error => Swal.showValidationMessage(error));
                    },
                    didOpen: () => {
                      let select = document.getElementById('franchise_id');
                      $(select).select2({
                          width: '100%',
                          dropdownParent: $('.swal2-container'),
                      })
                    },
                }).then(response => {
                    if (response.isConfirmed) {
                        Swal.fire({
                            title: 'Franchise Closed',
                            text: 'The Franchise Was Successfully Closed',
                            icon: 'success',
                        });
                    }
                });
            })
                .catch(error => handleError(error));
        },
        allowOutsideClick: () => !Swal.isLoading(),
        showConfirmButton: false,
        showCancelButton: false,
    });
}

const getOpenFranchises = async () => {
    let response = await fetch('/franchises/get-open', {
        method: 'GET',
        headers: {Accept: 'application/json'}
    });

    if (!response.ok) {
        throw new Error('Could not get open franchises');
    }

    return response.json();
}

/**
 * Close franchise method
 *
 * @param {string} id Franchise ID of the franchise to be closed
 * @return {Promise<any>}
 */
const closeFranchise = async (id) => {
    let response = await fetch (`/franchises/manage-close/${id}`, {
        method: 'POST',
        headers: {
            'X-Csrf-Token': csrfToken,
            Accept: 'application/json'
        }
    });
    if (!response.ok) {
        throw new Error('Could not close franchise.');
    }
    return response.json();
}


const showAddAlert = () => {
    sessionStorage.clear();

    const addAlert = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            denyButton: 'btn btn-warning',
        },
        buttonsStyling: false,
    });

    addAlert.fire({
        title: 'Add Franchise',
        text: 'Choose one of the following',
        icon: 'info',
        confirmButtonText: 'Add With Operator',
        showDenyButton: true,
        denyButtonText: 'Add To Existing',
        showCloseButton: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return getStates().then(states => {
                if (states.length) {
                    return states;
                } else {
                    throw new Error(`Issue Found`);
                }
            })
                .catch(error => {
                    Swal.showValidationError(error);
                });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            showOperatorCreationAlert(result);
        } else if (result.isDenied) {
            Swal.showLoading();
            $.when(getOperators(), getStatuses())
                .then((operators, statuses) => {
                    showFranchiseCreationAlert(operators, statuses);
                });
        }
    });
}

const showOperatorCreationAlert = (states) => {
    let options = '';
    states.value.forEach(state => {
        options += `<option value="${state.state_id}">${state.full_name}</option>`;
    });

    const operatorSwal = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            denyButton: 'btn btn-default',
        },
        buttonsStyling: false,
    });

    operatorSwal.fire({
        title: 'Create Operator',
        html:
            '<form id="create_operator_form" novalidate>' +
            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="first-name">First Name</label>' +
            '<input class="form-control" type="text" id="first-name" name="first_name" required autocomplete="off">' +
            '<div class="invalid-feedback text-left">First Name is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="last-name">Last Name</label>' +
            '<input class="form-control" type="text" id="last-name" name="last_name" required autocomplete="off">' +
            '<div class="invalid-feedback text-left">Last Name is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="phone">Phone Number</label>' +
            '<input class="form-control" type="tel" id="phone" name="phone" required autocomplete="off">' +
            '<div class="invalid-feedback text-left">Phone is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="email">Email</label>' +
            '<input class="form-control" type="email" id="email" name="email" required autocomplete="off">' +
            '<div class="invalid-feedback text-left">Email is required and must be formatted correctly</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="login">Username/Operator ID</label>' +
            '<input class="form-control" type="text" id="login" name="user_login" required' +
            ' autocomplete="off">' +
            '<div class="invalid-feedback text-left">Login/Username is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="password">Password</label>' +
            '<input class="form-control" type="password" id="password" name="password" required autocomplete="off">' +
            '<div class="invalid-feedback text-left">Password is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="street-address">Address</label>' +
            '<input class="form-control" type="text" id="street-address" name="street_address" required' +
            ' autocomplete="off">' +
            '<div class="invalid-feedback text-left">Street Address is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="city">City</label>' +
            '<input class="form-control" type="text" id="city" name="city" required autocomplete="off">' +
            '<div class="invalid-feedback text-left">City is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group d-flex flex-column" id="state-id-parent">' +
            '<label class="text-left" for="state">State</label>' +
            '<select class="form-control" id="state-id" name="state_id" required>' +
            '<option>Nothing has been selected</option>' +
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
            '<input class="form-control" type="text" id="zip" name="zip" required autocomplete="off">' +
            '<div class="invalid-feedback text-left">Zip is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</form>',
        showConfirmButton: true,
        confirmButtonText: 'Next <i class="material-icons">arrow_right</i>',
        showDenyButton: true,
        denyButtonText: '<i class="material-icons">arrow_left</i> Back',
        reverseButtons: true,
        showCloseButton: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            let data = {};
            let inputs = $("#create_operator_form :input");
            let shouldContinue = true;
            inputs.each(function () {
                if (!$(this).is(':valid')) {
                    shouldContinue = false;
                    $("#create_operator_form").addClass('was-validated');
                    Swal.showValidationMessage('Information is incomplete. Fill all fields.');
                }
            });
            if (shouldContinue) {
                inputs.each(function () {
                    let name = $(this).attr('name');
                    let key = 'operator.' + name;
                    sessionStorage.setItem(key, $(this).val());
                    data[name] = $(this).val();
                });
                sessionStorage.setItem('operator.created', 'true');
                return createOperator(data).then(response => {
                    if (response.message) {
                        throw new Error(response.message)
                    }
                    return response;
                })
                    .catch(error => {
                        Swal.showValidationMessage(`Unable to save operator: ${error}`);
                    });
            }
        },
        didOpen: () => {
            $("#state-id").select2({dropdownParent: ".swal2-container"});
        }
    }).then((result) => {
        if (result.isDenied) {
            showAddAlert();
        } else if (result.isConfirmed) {
            $.when(getOperators(), getStatuses())
                .then((operators, statuses) => {
                    showFranchiseCreationAlert(operators, statuses);
                });
        }
    });
}

const showFranchiseCreationAlert = (operators, statuses) => {
    const franchiseAlert = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            denyButton: 'btn btn-default',
        },
        buttonsStyling: false,
    });

    let operatorOptions = '';
    let checkId = sessionStorage.getItem('operator.user_login');
    for (let i = 0; i < operators.length; i++) {
        let id = operators[i].operator_id;
        let name = operators[i].operator_first_name + " " + operators[i].operator_last_name;
        operatorOptions += `<option value="${id}"${checkId === id ? ' selected' : null}>${name} (${id})</option>`;
    }

    let statusOptions = '';
    for (let i = 0; i < statuses.length; i++) {
        statusOptions += `<option value="${statuses[i]}">${statuses[i]}</option>`;
    }

    franchiseAlert.fire({
        title: "Add Franchise",
        html:
            '<p>Step 1: Franchise Information</p>' +
            '<form id="franchise_form" novalidate>' +
            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group d-flex flex-column" id="operator_id_parent">' +
            '<label for="operator_id" class="text-left">Operator</label>' +
            '<select class="form-control" id="operator_id" name="operator_id" required>' +
            '<option value="0">(Choose One)</option>' +
            operatorOptions +
            '</select>' +
            '<div class="invalid-feedback text-left">Operator is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="name">Franchise Name</label>' +
            '<input class="form-control" type="text" id="name" name="name" required autocomplete="off">' +
            '<div class="invalid-feedback text-left">Franchise Name is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="description">Location Description</label>' +
            '<textarea class="form-control" id="description" name="description" required' +
            ' autocomplete="off"></textarea>' +
            '<div class="invalid-feedback text-left">Location Description is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group d-flex flex-column" id="status_parent">' +
            '<label for="status" class="text-left">Status</label>' +
            '<select class="form-control" id="status" name="status" required>' +
            '<option value="0">(Choose One)</option>' +
            statusOptions +
            '</select>' +
            '<div class="invalid-feedback text-left">Status is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</form>',
        didOpen: () => {
            let container = $('.swal2-container');
            $("#operator_id").select2({dropdownParent: container});
            $("#status").select2({dropdownParent: container});
        },
        showCloseButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Next <i class="material-icons">arrow_right</i>',
        showDenyButton: true,
        denyButtonText: '<i class="material-icons">arrow_left</i> Back',
        reverseButtons: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            let inputs = $("#franchise_form :input, #franchise_form select");
            let shouldContinue = true;
            inputs.each(function () {
                if (!$(this).is(':valid')) {
                    $("#franchise_form").addClass('was-validated');
                    Swal.showValidationMessage('Information is incomplete. Fill all fields.');
                    shouldContinue = false;
                }
            });
            if (shouldContinue) {
                let data = {};
                inputs.each(function () {
                    let key = 'franchise.' + $(this).attr('name')
                    sessionStorage.setItem(key, $(this).val());
                    data[$(this).attr('name')] = $(this).val();
                });
                return createFranchise(data).catch(error => {
                    Swal.showValidationMessage(`Franchise could not be created. Server issue: ${error.message}`);
                });
            }

        }
    }).then((result) => {
        if (result.isConfirmed) {
            sessionStorage.clear();
            sessionStorage.setItem('franchise_id', result.value.franchise_id);
            $.when(getStates()).then(states => {showLocationAlert(states)});
        } else if (result.isDenied) {
            let check = sessionStorage.getItem('operator.created');
            if (check === 'true') {
                showOperatorCreationAlert()
            } else {
                showAddAlert();
            }
        }
    });
}

/**
 *
 */
const showLocationAlert = (states) => {
    let options = '';
    states.forEach(state => {
        options += `<option value="${state.state_id}">${state.full_name}</option>`;
    });

    const locationAlert = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            denyButton: 'btn btn-default',
        },
        buttonsStyling: false,
    });

    locationAlert.fire({
        title: 'Add Franchise',
        html:
            '<p>Step 2: Locations</p>' +
            '<form id="location-form" novalidate>' +
            `<input type="hidden" name="franchise_id" id="franchise_id" value="${sessionStorage.getItem('franchise_id')}">` +
            '<div class="card" id="dropdown-parent">' +
            '<div class="card-header card-header-primary card-header-tabs">' +
            '<div>' +
            '<div class="nav-tabs-wrapper">' +
            '<span class="nav-tabs-title">Locations:</span>' +
            '<ul class="nav nav-tabs" data-tabs="tabs" id="tabs">' +
            '<li class="nav-item">' +
            '<a href="#location1" class="nav-link active" data-toggle="tab" id="location1-tab">New Location</a>' +
            '</li>' +
            '<button type="button" id="add-location-btn" class="ml-2 bg-white text-dark btn btn-round btn-sm' +
            ' btn-just-icon">' +
            '<i class="material-icons">add</i>' +
            '</button>' +
            '</ul>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="card-body">' +
            '<div class="tab-content" id="location-panes">' +
            '<div class="tab-pane active show" id="location1">' +
            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="location1-name">Location Name</label>' +
            '<input class="form-control location-name" type="text" id="location1-name" name="location[1][name]"' +
            ' required' +
            ' autocomplete="off">' +
            '<div class="invalid-feedback text-left">Location Name is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="location1-address">Address</label>' +
            '<input class="form-control" type="text" id="location1-address" name="location[1][address]" required' +
            ' autocomplete="off">' +
            '<div class="invalid-feedback text-left">Address is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="location1-city">City</label>' +
            '<input class="form-control" type="text" id="location1-city" name="location[1][city]" required' +
            ' autocomplete="off">' +
            '<div class="invalid-feedback text-left">City is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group d-flex flex-column text-left" id="location1-state-parent">' +
            '<label for="location1-state_id" class="text-left">State</label>' +
            '<select class="form-control text-left" id="location1-state_id" name="location[1][state_id]" required>' +
            options +
            '</select>' +
            '<div class="invalid-feedback text-left">State is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group">' +
            '<label for="location1-zip">Zip</label>' +
            '<input class="form-control" type="text" id="location1-zip" name="location[1][zip]" required' +
            ' autocomplete="off">' +
            '<div class="invalid-feedback text-left">Zip is required</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group d-flex flex-column text-left" id="status_parent">' +
            '<label for="location1-cities" class="text-left">Cities</label>' +
            '<select class="form-control text-left" id="location1-cities" name="location[1][cities][]" multiple' +
            ' required>' +
            '</select>' +
            '<div class="invalid-feedback text-left">Cities are required</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<div class="form-group d-flex flex-column text-left" id="status_parent">' +
            '<label for="location1-zip_codes" class="text-left">Zip Codes</label>' +
            '<select class="form-control text-left" id="location1-zip_codes" name="location[1][zip_codes][]" multiple' +
            ' required>' +
            '</select>' +
            '<div class="invalid-feedback text-left">Zip Codes is required</div>' +
            '</div>' +

            '<div class="form-row">' +
            '<div class="col-12">' +
            '<button id="first-remove-btn" type="button" class="btn btn-sm btn-danger location-pane-remove-btn"' +
            ' disabled>Cannot Remove' +
            ' Only' +
            ' Location</button>' +
            '</div>' +
            '</div>' +

            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</form>',
        didOpen: () => {
            document.getElementById('first-remove-btn').addEventListener('click', () => {
                removeLocationPane('location1', 'location1-tab');
            });

            document.getElementById('add-location-btn').addEventListener('click', () => {
                let tabData = newLocationTab({states: states});
                let pane = document.createElement('div');
                pane.classList.add('tab-pane');
                pane.id = `location${locationCount}`;
                tabData.forEach(data => {pane.appendChild(data);});
                document.getElementById('location-panes').appendChild(pane);
                let newTab = document.createElement('li');
                newTab.classList.add('nav-item');
                let newLink = document.createElement('a');
                newLink.classList.add('nav-link');
                newLink.href = `#location${locationCount}`;
                newLink.setAttribute('data-toggle', 'tab');
                newLink.id = `location${locationCount}-tab`;
                newLink.textContent = 'New Location';
                newTab.appendChild(newLink);
                document.getElementById('tabs').insertBefore(newTab, document.getElementById('add-location-btn'));
                let container = $('.swal2-container');
                $(`#location${locationCount}-state_id`).select2({
                    dropdownParent: container,
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Nothing Has Been Selected',
                });
                $(`#location${locationCount}-cities`).select2({
                    dropdownParent: container,
                    tags: true,
                    width: '100%',
                });
                $(`#location${locationCount}-zip_codes`).select2({
                    dropdownParent: container,
                    tags: true,
                    width: '100%',
                });
                $(`#location${locationCount}-tab`).tab('show');
            });
        },
        preConfirm: () => {
            return sendLocations(marshalLocationData()).catch(error => {
                Swal.showValidationMessage(error);
            });
        },
        showLoaderOnConfirm: true,
        showCloseButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Finish <i class="material-icons">arrow_right</i>',
        showDenyButton: true,
        denyButtonText: '<i class="material-icons">arrow_left</i> Back',
        reverseButtons: true,
        width: '800px',
    }).then((result) => {
        if (result.isConfirmed) {
            console.log(result.value);
            showFranchiseSuccessAlert();
        }
    });
    let container = $('.swal2-container');
    $("#location1-state_id").select2({
        dropdownParent: container,
        allowClear: true,
        placeholder: 'Nothing Has Been Selected',
    });
    $("#location1-cities").select2({
        dropdownParent: container,
        tags: true,
    });
    $('#location1-zip_codes').select2({
        dropdownParent: container,
        tags: true,
    });
    document.querySelector('.location-name').addEventListener('input', function () {
        document.querySelector('.nav-link.active').textContent = this.value !== '' ? this.value : 'New Location';
    });
};

/**
 * Show franchise success alert method
 */
const showFranchiseSuccessAlert = () => {
    Swal.fire({
        title: "Success",
        icon: 'success',
        text: 'The franchise has been created!',
    });
}

/**
 * Get operators method
 *
 * @return {Promise<any>}
 */
const getOperators = async () => {
    const response = await fetch('/operators/get-operators', {
        method: 'GET',
        mode: 'cors',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
        },

    });
    return response.json();
}

/**
 * Get statuses method
 *
 * @return {Promise<any>}
 */
const getStatuses = async () => {
    const response = await fetch('/franchises/get-statuses', {
        method: 'GET',
        mode: 'cors',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/json'}
    });
    return response.json();
}

/**
 * Create operators method
 *
 * @param data
 * @return {Promise<Response>}
 */
const createOperator = async (data) => {
    let response = await fetch('/operators/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Csrf-Token': csrfToken,
        },
        body: JSON.stringify(data),
    });

    return response.json();
};

/**
 * Create franchise method
 *
 * Create the initial franchise, without locations.
 *
 * @param data Franchiwse data for initial franchise creation.
 * @return {Promise<any>} Result of request.
 */
const createFranchise = async (data) => {
    let formatted = new URLSearchParams(data);
    let response = await fetch('/franchises/create', {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Csrf-Token': csrfToken,
        },
        body: formatted,
    }).catch(error => {throw new Error(`Could not add franchise: ${error.statusText}`)});
    return response.json();
};

let locationCount = 1;

/**
 *
 * @return {*[]}
 */
const newLocationTab = (selectData) => {
    locationCount++;
    let stateOptions = [];
    selectData.states.forEach((state) => {
        stateOptions.push({
            value: state.state_id,
            text: state.full_name,
        });
    });

    let data = {
        text: {
            name: {
                label: 'Location Name',
                id: `location${locationCount}-name`,
                name: `location[${locationCount}]name`,
                abbrev: 'name',
            },
            address: {
                label: 'Address',
                id: `location${locationCount}-address`,
                name: `location[${locationCount}][address]`,
                abbrev: 'address',
            },
            city: {
                label: 'City',
                id: `location${locationCount}-city`,
                name: `location[${locationCount}][city]`,
                abbrev: 'city',
            },
            zip: {
                label: 'Zip',
                id: `location${locationCount}-zip`,
                name: `location[${locationCount}][zip]`,
                abbrev: 'zip',
            },
        },
        single: {
            state: {
                label: 'State',
                id: `location${locationCount}-state_id`,
                name: `location[${locationCount}][state_id]`,
                options: stateOptions,
            },
        },
        multiple: {
            cities: {
                label: 'Cities',
                id: `location${locationCount}-cities`,
                name: `location[${locationCount}][cities][]`,
            },
            zips: {
                label: 'Zip Codes',
                id: `location${locationCount}-zip_codes`,
                name: `location[${locationCount}][zip_codes][]`,
            },
        },
    };
    let fields = [];
    fields.push(createTextField(data.text.name));
    fields.push(createTextField(data.text.address));
    fields.push(createTextField(data.text.city));
    fields.push(createSingleSelect(data.single.state));
    fields.push(createTextField(data.text.zip));
    fields.push(createMultipleSelect(data.multiple.cities));
    fields.push(createMultipleSelect(data.multiple.zips));
    fields.push(createRemoveButton());
    return fields;
};

/**
 * Create Remove Button Elements
 *
 * Create the needed elements for a remove tab pan button.
 *
 * @return {HTMLDivElement} "Ready to render" remove button elements.
 */
const createRemoveButton = (paneId) => {
    // Initialize
    let row = document.createElement('div');
    let col = document.createElement('div');
    let btn = document.createElement('button');

    // Configure
    btn.type = 'button';
    btn.classList.add('btn', 'btn-sm', 'btn-danger', 'location-pane-remove-btn');
    btn.disabled = false;
    btn.textContent = 'Remove Location';
    const panelId = `location${locationCount}`;
    const btnId = `location${locationCount}-tab`;
    btn.addEventListener('click', () => {removeLocationPane(panelId, btnId)});
    col.classList.add('col-12');
    row.classList.add('form-row');

    //Assemble
    col.appendChild(btn);
    row.appendChild(col);

    // Reset All Buttons to Not Disabled And Text Reflect That
    document.querySelectorAll('.location-pane-remove-btn').forEach(locationBtn => {
        locationBtn.disabled = false;
        locationBtn.textContent = 'Remove Location';
    });

    // Finish
    return row;
}

/**
 * Create Text Input Elements
 *
 * Create needed elements for a text input on the locations popup screen.
 *
 * @param {Object} data Information required to create the input elements.
 * @return {HTMLDivElement} "Ready to render" text input elements.
 */
const createTextField = (data) => {
    // Initialize
    let row = document.createElement('div');
    let col = document.createElement('div');
    let group = document.createElement('div');
    let label = document.createElement('label');
    let input = document.createElement('input');
    let error = document.createElement('div');

    // Configure
    row.classList.add('form-row');
    col.classList.add('col-12');
    group.classList.add('form-group');
    label.setAttribute('for', data.id);
    label.textContent = data.label;
    input.setAttribute('type', 'text');
    input.id = data.id;
    input.required = true;
    input.classList.add('form-control');
    input.setAttribute('name', data.name);
    if (data.abbrev === 'name') {
        input.classList.add('location-name');
        input.addEventListener('input', function () {
            document.querySelector('.nav-link.active').textContent = this.value !== '' ? this.value : 'New Location';
        });
    }
    error.classList.add('invalid-feedback');
    error.classList.add('text-left');
    error.textContent = `${data.label} is required.`;

    // Assemble
    group.appendChild(label);
    group.appendChild(input);
    group.appendChild(error);
    col.appendChild(group);
    row.appendChild(col);

    // Finish
    return row;
};

/**
 * Create Single Select Elements
 *
 * Create needed elements for a single select input on the locations popup screen.
 *
 * @param {Object} data Information required to create the select elements.
 * @return {HTMLDivElement} "Ready to render" single select input elements.
 */
const createSingleSelect = (data) => {
    // Initialize
    let row = document.createElement('div');
    let col = document.createElement('div');
    let group = document.createElement('div');
    let label = document.createElement('label');
    let select = document.createElement('select');
    let empty = document.createElement('option');
    let error = document.createElement('div');

    // Configure
    row.classList.add('form-row');
    col.classList.add('col-12');
    group.classList.add('form-group');
    group.classList.add('d-flex');
    group.classList.add('flex-column');
    group.classList.add('text-left');
    label.setAttribute('for', data.id);
    label.textContent = data.label;
    select.setAttribute('name', data.name);
    select.id = data.id;
    select.required = true;
    select.classList.add('form-control');
    empty.value = null;
    empty.textContent = 'Nothing Has Been Selected';
    error.classList.add('invalid-feedback');
    error.classList.add('text-left');
    error.textContent = `${data.label} is required.`;

    // Create Options
    select.appendChild(empty);
    data.options.forEach((optionData) => {
        let option = document.createElement('option');
        option.value = optionData.value;
        option.textContent = optionData.text;
        select.appendChild(option);
    });

    // Assemble
    group.appendChild(label);
    group.appendChild(select);
    group.appendChild(error);
    col.appendChild(group);
    row.appendChild(col);

    return row;
};

/**
 * Create Multiple Select Elements
 *
 * Create needed elements for a multiple select input on the locations popup screen.
 *
 * @param {Object} data Information required to create the select elements.
 * @return {HTMLDivElement} "Ready to render" multiple select input elements.
 */
const createMultipleSelect = (data) => {
    // Initialize
    let row = document.createElement('div');
    let col = document.createElement('div');
    let group = document.createElement('div');
    let label = document.createElement('label');
    let select = document.createElement('select');
    let error = document.createElement('div');

    // Configure
    row.classList.add('form-row');
    col.classList.add('col-12');
    group.classList.add('form-group');
    group.classList.add('d-flex');
    group.classList.add('flex-column');
    group.classList.add('text-left');
    label.setAttribute('for', data.id);
    label.textContent = data.label;
    select.setAttribute('name', data.name);
    select.id = data.id;
    select.required = true;
    select.multiple = true;
    select.classList.add('form-control');
    error.classList.add('invalid-feedback');
    error.classList.add('text-left');
    error.textContent = `${data.label} is required.`;

    // Assemble
    group.appendChild(label);
    group.appendChild(select);
    group.appendChild(error);
    col.appendChild(group);
    row.appendChild(col);

    return row;
};

/**
 * Locations add method
 *
 * Add locations to existing franchise.
 * Franchise must have already been saved to DB for this method to be valid.
 *
 * @param {string} id Franchise ID for the Franchise to which the locations are being added.
 * @param {Object} data Location data for all locations in an orders Object form.
 * @return {Promise<any>} Result of the request in JSON form.
 */
const addLocations = async (id, data) => {
    let response = await fetch(`locations/add/${id}`, {
        body: JSON.stringify(data),
        method: 'POST',
        headers: {
            'X-Csrf-Token': csrfToken,
            Accept: 'application/json',
            'Content-Type': 'application/json',
        }
    });
    return response.json();
};

document.querySelectorAll('.location-pan-remove-btn').forEach(button => {button.addEventListener('click', () => {top.alert('good')})})

/**
 * Remove Location Pane method
 *
 * Remove the locationPane given in the ID.
 * Check to make sure there isn't only one button left.
 * If there is one button left, disable and change the text to reflect that.
 *
 * @param {string} paneId ID of the pane that should be removed.
 * @param {string} btnId ID of the button that should ALSO be removed
 * @return {void} This method does not return anything.
 */
const removeLocationPane = (paneId, btnId) => {
    let current = document.getElementById(paneId);
    let nearest = current.previousElementSibling ? current.previousElementSibling : current.nextElementSibling;
    current.remove();
    while (nearest) {
        if (nearest.matches('.tab-pane')) break;
        nearest = nearest.previousElementSibling;
    }
    let removeButtons = document.querySelectorAll('.location-pane-remove-btn');
    if (removeButtons.length === 1) {
        removeButtons.forEach(removeButton => {
            removeButton.disabled = true;
            removeButton.textContent = 'Cannot Remove Only Location';
        });
    }
    document.getElementById(btnId).remove();
    let jNearest = $(`#${nearest.id}-tab`);
    jNearest.tab('show');
};

/**
 * Gather Form Data
 *
 * Gather all form data and then consolidate it into an array.
 *
 * @return {FormData}
 */
const marshalLocationData = () => {
    return new FormData(document.getElementById('location-form'));
};

const sendLocations = async (rawData) => {
    const data = new URLSearchParams(rawData);
    let response = await fetch('/locations/add-many', {
        headers: {
            Accept: 'application/json',
            'X-Csrf-Token': csrfToken,
        },
        method: 'POST',
        body: data,
    });

    if (!response.ok) {
        throw new Error('Could not send new locations');
    }

    return response.json();
}