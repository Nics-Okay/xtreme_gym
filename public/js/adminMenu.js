document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.href; // Get the current page URL
    let permanentDropdown = null;

    document.querySelectorAll(".menu-item").forEach(item => {
        const dropdown = item.nextElementSibling;
        const chevron = item.querySelector(".chevron");
        const links = dropdown ? dropdown.querySelectorAll("a") : [];

        // Check if any link in the dropdown matches the current page
        links.forEach(link => {
            if (link.href === currentUrl) {
                dropdown.classList.add("show");
                chevron.classList.add("rotate");
                permanentDropdown = dropdown; // Mark this as the permanent dropdown
            }
        });

        item.addEventListener("click", function () {
            // Toggle behavior for clicked dropdown
            if (dropdown !== permanentDropdown) {
                document.querySelectorAll(".dropdown-content").forEach(d => {
                    if (d !== permanentDropdown && d !== dropdown) d.classList.remove("show");
                });

                document.querySelectorAll(".chevron").forEach(c => {
                    if (c !== permanentDropdown?.previousElementSibling.querySelector(".chevron") && c !== chevron) {
                        c.classList.remove("rotate");
                    }
                });

                dropdown.classList.toggle("show");
                chevron.classList.toggle("rotate");
            }
        });
    });
});
