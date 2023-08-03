"use strict";
console.log("called this file");
$(function () {
    $("#sendReportBtn").on('click', () => {
        let startDate = $("#start-date").val();
        let endDate = $("#end-date").val()
        swal.fire({
            title: "Starting Report",
            text: "Are you sure you are ready to start this report. After you start it, it will take a few moments" +
                " first for the system to communicate with the shop, then you will need to wait until the report is" +
                " emailed to you.",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            showLoaderOnConfirm: true,
            icon: "info",
            preConfirm: () => {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}});
                return $.post('/woocommerce/start-commission-report', {
                    startDate: startDate,
                    endDate: endDate,
                })
                    .then(response => {
                        return response
                    })
                    .catch((x, r, error) => {
                        swal.showValidationError(`Request failed: ${error}`);
                    });
            },
            allowOutsideClick: () => !swal.isLoading()
        })
            .then(result => {
                if (result) {
                    swal.fire({
                        title: 'Report Started',
                        icon: "success",
                        text: 'The commission report is now being written. It will be sent to you in a few minutes' +
                            ' via email.',
                    });
                    
                    console.log(result);
                    console.log(result['value']['jobs_resp']);
                    console.log("data");
                    
                    $("#commissionsReportModal").modal('hide');
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}});
                    $.post('/generate-report/process-orders',{
                        "pdf_jobs": result['value']['jobs_resp']
                    });
                } else {
                    swal.fire({
                        title: 'Warning',
                        text: 'Something Went Wrong',
                        icon: "warning",
                    });
                }
            });
    });
});