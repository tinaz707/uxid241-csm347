const openMenu = document.getElementById('menu-open-icon');
const closeMenu = document.getElementById('menu-close-icon');

const menu = document.getElementById('main-menu');


openMenu.addEventListener("click", () =>{
    openMenu.classList.toggle('hide');
    closeMenu.classList.toggle('hide');
    menu.classList.toggle('show');
})

closeMenu.addEventListener("click", () =>{
    openMenu.classList.toggle('hide');
    closeMenu.classList.toggle('hide');
    menu.classList.toggle('show');
})