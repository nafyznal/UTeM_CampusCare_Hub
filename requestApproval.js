function approveRequest(index) {
    document.getElementById("actionStatus" + index).innerHTML =
        "<span class='approved-text'>Approved</span>";
}

function rejectRequest(index) {
    document.getElementById("actionStatus" + index).innerHTML =
        "<span class='rejected-text'>Rejected</span>";
}