document.addEventListener('DOMContentLoaded', function () {
    const toggleSidebar = document.querySelector('.toggle-sidebar');
    const sidebar = document.querySelector('.floating-sidebar');

    toggleSidebar.addEventListener('click', function () {
        sidebar.classList.toggle('shrink-sidebar');
        sidebar.classList.toggle('expanded-sidebar');
    });
});
