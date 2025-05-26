$(document).ready(function () {
    $.delete = function (id, url) {
        sweetAlert({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {

            if (isConfirm) {
                sweetAlert("Shortlisted!", "Candidates are successfully shortlisted!", "success");
            } else {
                sweetAlert("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
    }
});