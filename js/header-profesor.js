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

asigs.forEach(function(item) {
    item.addEventListener('click', function() {
        var id = item.getAttribute('data-id');
        var sub = document.getElementById('sub-' + id);

        // cierra los otros
        document.querySelectorAll('.submenu').forEach(function(s) {
            if (s !== sub) s.classList.remove('visible');
        });
        document.querySelectorAll('.nav-asig').forEach(function(n) {
            if (n !== item) n.classList.remove('abierto');
        });

        sub.classList.toggle('visible');
        item.classList.toggle('abierto');
    });
});