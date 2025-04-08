const menuIcon = document.getElementById('menu-icon');
const menu = document.getElementById('menu-container');
const closeMenu = document.getElementById('close-button');

// Opening Menu
menuIcon.addEventListener('click', () => {
    menu.classList.add('active');
});

// Close menu through menu button X
closeMenu.addEventListener('click', () => {
    menu.classList.remove('active');
});

// Close menu by clicking outside
document.addEventListener('click', (event) => {
    if (!menu.contains(event.target) && !menuIcon.contains(event.target)) {
        menu.classList.remove('active');
    }
});