function toggleMenu() {
    const menuItems = document.querySelector('.menu-items');
    const hamburger = document.querySelector('.hamburger');
    menuItems.classList.toggle('active');
    hamburger.classList.toggle('active');
}

// Añadir clase active al enlace actual
document.addEventListener('DOMContentLoaded', function() {
    const currentLocation = location.href;
    const menuItems = document.querySelectorAll('.nav-link');
    menuItems.forEach(item => {
        if(item.href === currentLocation) {
            item.classList.add('active');
        }
    });
});
