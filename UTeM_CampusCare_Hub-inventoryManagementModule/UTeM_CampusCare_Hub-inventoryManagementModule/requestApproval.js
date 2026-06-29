function approveRequest(index) {
    if (confirm("Are you sure you want to approve this request?")) {
        document.getElementById("actionStatus" + index).innerHTML =
            "<span class='approved-text'>Approved</span>";

        alert("Request approved successfully!");
    }
}

function rejectRequest(index) {
    if (confirm("Are you sure you want to reject this request?")) {
        document.getElementById("actionStatus" + index).innerHTML =
            "<span class='rejected-text'>Rejected</span>";

        alert("Request rejected successfully!");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById("menu-btn");
    const navSection = document.getElementById("nav-section");

    if (menuBtn && navSection) {
        menuBtn.addEventListener("click", function () {
            navSection.classList.toggle("hidden");
        });
    }
});