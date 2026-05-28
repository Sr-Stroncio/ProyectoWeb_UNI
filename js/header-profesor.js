// sidebar movil

var sidebar = document.getElementById('sidebar');
var btnMenu = document.getElementById('btnMenu');
var overlay = document.getElementById('overlay');

btnMenu.addEventListener('click', function() {
    sidebar.classList.toggle('abierto');
    overlay.classList.toggle('activo');
});

overlay.addEventListener('click', function() {
    sidebar.classList.remove('abierto');
    overlay.classList.remove('activo');
});

// abrir y cerrar submenus de asignaturas
var asigs = document.querySelectorAll('.nav-asig');

for (var i = 0; i < asigs.length; i++) {
    asigs[i].addEventListener('click', function() {
        var item = this;
        var id = item.getAttribute('data-id');
        var sub = document.getElementById('sub-' + id);

        // cierra los otros
        var submenus = document.querySelectorAll('.submenu');
        for (var j = 0; j < submenus.length; j++) {
            if (submenus[j] !== sub) {
                submenus[j].classList.remove('visible');
            }
        }
        var navAsigs = document.querySelectorAll('.nav-asig');
        for (var k = 0; k < navAsigs.length; k++) {
            if (navAsigs[k] !== item) {
                navAsigs[k].classList.remove('abierto');
            }
        }

        sub.classList.toggle('visible');
        item.classList.toggle('abierto');
    });
}