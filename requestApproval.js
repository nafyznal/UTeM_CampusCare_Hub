function approveRequest(index, itemName, requestorName) {
    let confirmApprove = confirm("Are you sure you want to approve this request?");

    if (!confirmApprove) return;

    fetch("updateRequestStatus.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ requestId: index, status: "Approved" })
    })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert("Failed to approve request: " + data.message);
                return;
            }

            let statusCell = document.getElementById("actionStatus" + index);
            let qrCell = document.getElementById("qrCode" + index);

            statusCell.innerHTML = "<span class='approved-text'>Approved</span>";

            // QR must contain ONLY the plain numeric RequestID.
            // scanner.php validates with ctype_digit(), so no labels,
            // no separators, no URLs - just the number.
            let qrData = String(index);

            let qrUrl =
                "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data="
                + encodeURIComponent(qrData);

            // Human-readable details are shown as a caption next to the QR,
            // NOT encoded inside it.
            qrCell.innerHTML =
                "<a href='" + qrUrl + "' target='_blank'>" +
                "<img src='" + qrUrl + "' class='approval-qr' alt='QR Code'>" +
                "</a>" +
                "<div class='qr-caption'>" +
                    "Request #" + index + "<br>" +
                    escapeHtml(requestorName) + " &mdash; " + escapeHtml(itemName) +
                "</div>";

            let actionCell = event.target.parentElement;
            actionCell.innerHTML = "<span class='approved-text'>Completed</span>";

            alert("Request approved successfully. QR code generated!");
        })
        .catch(err => {
            console.error(err);
            alert("Something went wrong while approving the request.");
        });
}

function rejectRequest(index) {
    let confirmReject = confirm("Are you sure you want to reject this request?");

    if (!confirmReject) return;

    fetch("updateRequestStatus.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ requestId: index, status: "Rejected" })
    })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert("Failed to reject request: " + data.message);
                return;
            }

            let statusCell = document.getElementById("actionStatus" + index);
            let qrCell = document.getElementById("qrCode" + index);

            statusCell.innerHTML = "<span class='rejected-text'>Rejected</span>";
            qrCell.innerHTML = "-";

            let actionCell = event.target.parentElement;
            actionCell.innerHTML = "<span class='rejected-text'>Rejected</span>";

            alert("Request rejected successfully!");
        })
        .catch(err => {
            console.error(err);
            alert("Something went wrong while rejecting the request.");
        });
}

// Small helper to safely insert requestor/item names into the caption HTML,
// since they're plain strings here (not already escaped on this side).
function escapeHtml(str) {
    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}