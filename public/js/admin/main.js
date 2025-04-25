// Menu functionality
function initMenu() {
    const currentUrl = window.location.href;
    let permanentDropdown = null;

    document.querySelectorAll(".menu-item").forEach(item => {
        const dropdown = item.nextElementSibling;
        const chevron = item.querySelector(".chevron");
        const links = dropdown ? dropdown.querySelectorAll("a") : [];

        links.forEach(link => {
            if (link.href === currentUrl) {
                dropdown?.classList.add("show");
                chevron?.classList.add("rotate");
                permanentDropdown = dropdown;
            }
        });

        item.addEventListener("click", function() {
            if (dropdown !== permanentDropdown) {
                document.querySelectorAll(".dropdown-content").forEach(d => {
                    if (d !== permanentDropdown && d !== dropdown) d.classList.remove("show");
                });

                document.querySelectorAll(".chevron").forEach(c => {
                    if (c !== permanentDropdown?.previousElementSibling.querySelector(".chevron") && c !== chevron) {
                        c.classList.remove("rotate");
                    }
                });

                dropdown?.classList.toggle("show");
                chevron?.classList.toggle("rotate");
            }
        });
    });
}

// Modal functions
function showModal() {
    const modal = document.getElementById('confirmationModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    }
}

function closeModal() {
    const modal = document.getElementById('confirmationModal');
    if (modal) {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
    }
}

// Clock functionality
function initClock() {
    function updateClockAndDate() {
        const clockElement = document.getElementById('clock');
        const dateElement = document.getElementById('date');
        const now = new Date();

        // Time formatting
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const amPm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;

        // Date formatting
        const options = { month: 'long', day: 'numeric', year: 'numeric' };
        const formattedDate = now.toLocaleDateString(undefined, options);

        // Update elements if they exist
        if (clockElement) clockElement.textContent = `${String(hours).padStart(2, '0')}:${minutes}:${seconds} ${amPm}`;
        if (dateElement) dateElement.textContent = formattedDate;
    }

    setInterval(updateClockAndDate, 1000);
    updateClockAndDate();
}

// Star rating functionality
function initStarRating() {
    const stars = document.querySelectorAll('.star-rating .star');
    const ratingInput = document.getElementById('rating');

    if (stars.length > 0 && ratingInput) {
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;

                stars.forEach(s => s.classList.remove('selected'));
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('selected');
                }
            });
        });
    }
}