// router del hash
function routerHash() {
    var hash = window.location.hash || '#inicio';

    var paneles = document.querySelectorAll('.seccion-panel');
    for (var i = 0; i < paneles.length; i++) {
        paneles[i].style.display = 'none';
    }

    var navItems = document.querySelectorAll('.nav-item, .nav-item-link-wrap');
    for (var j = 0; j < navItems.length; j++) {
        navItems[j].classList.remove('activo');
    }

    if (hash.indexOf('#calificaciones-') === 0) {
        document.getElementById('sec-calificaciones').style.display = 'flex';
        var asig = hash.replace('#calificaciones-', '');
        if (window.seleccionarAsignaturaHash) {
            window.seleccionarAsignaturaHash(asig);
        }
    } else if (hash === '#tareas') {
        document.getElementById('sec-tareas').style.display = 'flex';
        if (window.filtrarTareasPorAsignatura) {
            window.filtrarTareasPorAsignatura('todas');
        }
        var linkT = document.querySelector('a[href="/pages/dashboard-profesor.php#tareas"]');
        if (linkT) {
            linkT.parentNode.classList.add('activo');
        }
    } else if (hash.indexOf('#tareas-') === 0) {
        document.getElementById('sec-tareas').style.display = 'flex';
        var asigTareas = hash.replace('#tareas-', '');
        if (window.filtrarTareasPorAsignatura) {
            window.filtrarTareasPorAsignatura(asigTareas);
        }
    } else if (hash.indexOf('#recursos-') === 0) {
        document.getElementById('sec-recursos').style.display = 'flex';
        var asigRecursos = hash.replace('#recursos-', '');
        if (window.filtrarRecursosPorAsignatura) {
            window.filtrarRecursosPorAsignatura(asigRecursos);
        }
    } else if (hash === '#calendario') {
        document.getElementById('sec-calendario').style.display = 'flex';
        var linkC = document.querySelector('a[href="/pages/dashboard-profesor.php#calendario"]');
        if (linkC) {
            linkC.parentNode.classList.add('activo');
        }
    } else if (hash === '#anuncios' || hash === '#anuncios-nuevo') {
        document.getElementById('sec-anuncios').style.display = 'flex';
        var linkA = document.querySelector('a[href="/pages/dashboard-profesor.php#anuncios"]');
        if (linkA) {
            linkA.parentNode.classList.add('activo');
        }
        if (hash === '#anuncios-nuevo') {
            if (window.abrirNuevoAnuncioModal) {
                window.abrirNuevoAnuncioModal();
            }
            window.history.replaceState(null, null, '#anuncios');
        }
    } else {
        document.getElementById('sec-inicio').style.display = 'flex';
        var linkI = document.querySelector('a[href="/pages/dashboard-profesor.php"]');
        if (linkI) {
            linkI.parentNode.classList.add('activo');
        }
    }
}

window.addEventListener('hashchange', routerHash);
routerHash();
