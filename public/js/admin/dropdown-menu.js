document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.href;

    document.querySelectorAll(".menu-dropdown").forEach(item => {
        const dropdown = item.nextElementSibling;
        const chevron = item.querySelector(".chevron");
        const links = dropdown ? dropdown.querySelectorAll("a") : [];

        item.addEventListener("click", function () {
            document.querySelectorAll(".dropdown-content").forEach(d => {
                if (d !== dropdown) d.classList.remove("show");
            });

            document.querySelectorAll(".chevron").forEach(c => {
                if (c !== chevron) c.classList.remove("rotate");
            });

            dropdown?.classList.toggle("show");
            chevron?.classList.toggle("rotate");
        });
    });
});
