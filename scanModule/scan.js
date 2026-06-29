document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById("menu-btn");
    const sidebar = document.getElementById("nav-section");

    if (menuBtn && sidebar) {
        menuBtn.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();
            sidebar.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                sidebar.classList.add("hidden");
            }
        });
    }
});