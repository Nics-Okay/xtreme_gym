const openLogoutModal = document.getElementById('openLogoutModal');
const closeLogoutModal = document.getElementById('closeLogoutModal');
const logoutModal = document.getElementById('logoutModal');

const openModal = () => logoutModal.style.display = 'block';
const closeModal = () => logoutModal.style.display = 'none';

openLogoutModal.addEventListener('click', (e) => {
    e.preventDefault();
    openModal();
});

closeLogoutModal.addEventListener('click', closeModal);

window.addEventListener('click', (e) => {
    if (e.target === logoutModal) {
        closeModal();
    }
});