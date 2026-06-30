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

            const menuBtn = document.getElementById('menu-btn');
            const sidebar = document.getElementById('mySidebar');

            if (menuBtn && sidebar) {
                menuBtn.addEventListener('click', function (event) {
                    event.stopPropagation();
                    sidebar.classList.toggle('hidden');
                });
            }

            // Dropdown toggles mapped to the explicit IDs inside your header file
            window.toggleSubMenu = function (event) {
                event.stopPropagation();
                const subMenu = document.getElementById('aidSubMenu');
                if (subMenu) subMenu.classList.toggle('dropdown-closed');
            };

            window.toggleFoodMenu = function (event) {
                event.stopPropagation();
                const foodMenu = document.getElementById('foodSubMenu');
                if (foodMenu) foodMenu.classList.toggle('dropdown-closed');
            };

            // Close sidebar dynamically if user clicks outside of it
            document.addEventListener('click', function (event) {
                if (sidebar && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                    sidebar.classList.add('hidden');
                }
            });

        });

        function prosesLogout() {
            window.location.href = "logout.php";
        }

        document.querySelectorAll(".icon").forEach(icon=>{
            icon.addEventListener("mouseover",()=>{
                icon.classList.add("hover")
            });

            icon.addEventListener("mouseleave",()=>{
                icon.classList.remove("hover")
            });

        });