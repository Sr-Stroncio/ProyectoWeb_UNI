// sidebar movil

const sidebar = document.getElementById('sidebar');
const btnMenu = document.getElementById('btnMenu');
const overlay = document.getElementById('overlay');

btnMenu.addEventListener('click', function() {
    sidebar.classList.toggle('abierto');
    overlay.classList.toggle('activo');
});

overlay.addEventListener('click', function() {
    sidebar.classList.remove('abierto');
    overlay.classList.remove('activo');
});

// abrir y cerrar submenus de asignaturas
const asigs = document.querySelectorAll('.nav-asig');

for (let i = 0; i < asigs.length; i++) {
    asigs[i].addEventListener('click', function() {
        const item = this;
        const id = item.getAttribute('data-id');
        const sub = document.getElementById('sub-' + id);

        // cierra los otros
        const submenus = document.querySelectorAll('.submenu');
        for (let j = 0; j < submenus.length; j++) {
            if (submenus[j] !== sub) {
                submenus[j].classList.remove('visible');
            }
        }
        const navAsigs = document.querySelectorAll('.nav-asig');
        for (let k = 0; k < navAsigs.length; k++) {
            if (navAsigs[k] !== item) {
                navAsigs[k].classList.remove('abierto');
            }
        }

        sub.classList.toggle('visible');
        item.classList.toggle('abierto');
    });
}