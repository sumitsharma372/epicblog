const navItems = document.querySelector('.nav_items');
const navOpenBtn = document.querySelector('#open_nav-btn');
const closeNavBtn = document.querySelector('#close_nav-btn');

navOpenBtn.addEventListener('click', () => {
    navItems.style.display = 'flex';
    navOpenBtn.style.display = 'none';
    closeNavBtn.style.display = 'inline-block';
})
closeNavBtn.addEventListener('click', () => {
    navItems.style.display = 'none';
    navOpenBtn.style.display = 'inline-block';
    closeNavBtn.style.display = 'none';
})

const sidebar = document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show_sidebar-btn');
const hideSidebarBtn = document.querySelector('#hide_sidebar-btn');

showSidebarBtn.addEventListener('click', () => {
    sidebar.style.left = '0';
    showSidebarBtn.style.display = 'none';
    hideSidebarBtn.style.display = 'inline-block';
})
hideSidebarBtn.addEventListener('click', () => {
    sidebar.style.left = '-100%';
    showSidebarBtn.style.display = 'inline-block';
    hideSidebarBtn.style.display = 'none';
})
