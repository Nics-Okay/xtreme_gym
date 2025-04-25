// public/js/star-rating.js

document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star-rating .star');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const value = this.getAttribute('data-value');
            ratingInput.value = value;

            // Remove 'selected' class from all stars
            stars.forEach(s => s.classList.remove('selected'));

            // Add 'selected' class to the clicked star and all previous stars
            for (let i = 0; i < value; i++) {
                stars[i].classList.add('selected');
            }
        });
    });
});
