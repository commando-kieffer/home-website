document.addEventListener("DOMContentLoaded", () => {
    const burgerButton = document.querySelector('.menu-burger');
    const mobileMenu = document.querySelector('.mobile-menu');

    burgerButton.addEventListener('click', () => {
        burgerButton.classList.toggle('active');
        mobileMenu.classList.toggle('active');
    });
});
