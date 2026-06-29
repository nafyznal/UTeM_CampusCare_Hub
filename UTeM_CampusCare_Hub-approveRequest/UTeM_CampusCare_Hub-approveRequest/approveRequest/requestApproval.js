function approveRequest(index, itemName, requestorName) {
    let confirmApprove = confirm("Are you sure you want to approve this request?");

    if (confirmApprove) {
        let statusCell = document.getElementById("actionStatus" + index);
        let qrCell = document.getElementById("qrCode" + index);

        statusCell.innerHTML = "<span class='approved-text'>Approved</span>";

        let requestId = "REQ100" + index;

        let qrData =
            "Request ID: " + requestId +
            " | Requestor: " + requestorName +
            " | Item: " + itemName +
            " | Status: Approved" +
            " | Location: UTeM FTMK" +
            " | Map: https://maps.google.com/?q=UTeM+FTMK+Melaka";

        let qrUrl =
            "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data="
            + encodeURIComponent(qrData);

        qrCell.innerHTML =
            "<a href='" + qrUrl + "' target='_blank'>" +
            "<img src='" + qrUrl + "' class='approval-qr' alt='QR Code'>" +
            "</a>";

        let actionCell = event.target.parentElement;
        actionCell.innerHTML = "<span class='approved-text'>Completed</span>";

        alert("Request approved successfully. QR code generated!");
    }
}

function rejectRequest(index) {
    let confirmReject = confirm("Are you sure you want to reject this request?");

    if (confirmReject) {
        let statusCell = document.getElementById("actionStatus" + index);
        let qrCell = document.getElementById("qrCode" + index);

        statusCell.innerHTML = "<span class='rejected-text'>Rejected</span>";
        qrCell.innerHTML = "-";

        let actionCell = event.target.parentElement;
        actionCell.innerHTML = "<span class='rejected-text'>Rejected</span>";

        alert("Request rejected successfully!");
    }
}