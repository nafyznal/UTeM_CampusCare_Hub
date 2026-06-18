function approveRequest(index) {
    let confirmApprove = confirm("Are you sure you want to approve this request?");

    if (confirmApprove) {
        document.getElementById("actionStatus" + index).innerHTML =
            "<span class='approved-text'>Approved</span>";

        alert("Request approved successfully!");
    }
}

function rejectRequest(index) {
    let confirmReject = confirm("Are you sure you want to reject this request?");

    if (confirmReject) {
        document.getElementById("actionStatus" + index).innerHTML =
            "<span class='rejected-text'>Rejected</span>";

        alert("Request rejected successfully!");
    }
}

document.addEventListener("DOMContentLoaded", function () {

    const menuBtn = document.getElementById("menu-btn");
    const sidebar = document.getElementById("mySidebar");

    if (menuBtn && sidebar) {
        menuBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            sidebar.classList.toggle("hidden");
        });
    }

    document.addEventListener("click", function (event) {
        if (sidebar && menuBtn && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
            sidebar.classList.add("hidden");
        }
    });

});

function prosesLogout() {
    window.location.href = "logout.php";
}