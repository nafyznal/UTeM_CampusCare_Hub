function approveRequest(index) {
    let confirmApprove = confirm("Are you sure you want to approve this request?");

    if (confirmApprove) {
        document.getElementById("actionStatus" + index).innerHTML =
            "<span class='approved-text'>Approved</span>";
    }
}

function rejectRequest(index) {
    let confirmReject = confirm("Are you sure you want to reject this request?");

    if (confirmReject) {
        document.getElementById("actionStatus" + index).innerHTML =
            "<span class='rejected-text'>Rejected</span>";
    }
}