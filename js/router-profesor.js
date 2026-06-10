// router del hash
function routerHash() {
    const hash = window.location.hash || '#inicio';

    const paneles = document.querySelectorAll('.seccion-panel');
    for (let i = 0; i < paneles.length; i++) {
        paneles[i].style.display = 'none';
    }

    const navItems = document.querySelectorAll('.nav-item, .nav-item-link-wrap');
    for (let j = 0; j < navItems.length; j++) {
        navItems[j].classList.remove('activo');
    }

    if (hash.indexOf('#calificaciones-') === 0) {
        document.getElementById('sec-calificaciones').style.display = 'flex';
        const asig = hash.replace('#calificaciones-', '');
        if (window.seleccionarAsignaturaHash) {
            window.seleccionarAsignaturaHash(asig);
        }
    } else if (hash === '#tareas') {
        document.getElementById('sec-tareas').style.display = 'flex';
        if (window.filtrarTareasPorAsignatura) {
            window.filtrarTareasPorAsignatura('todas');
        }
        const linkT = document.querySelector('a[href="pages/dashboard-profesor.php#tareas"]');
        if (linkT) {
            linkT.parentNode.classList.add('activo');
        }
    } else if (hash.indexOf('#tareas-') === 0) {
        document.getElementById('sec-tareas').style.display = 'flex';
        const asigTareas = hash.replace('#tareas-', '');
        if (window.filtrarTareasPorAsignatura) {
            window.filtrarTareasPorAsignatura(asigTareas);
        }
    } else if (hash.indexOf('#recursos-') === 0) {
        document.getElementById('sec-recursos').style.display = 'flex';
        const asigRecursos = hash.replace('#recursos-', '');
        if (window.filtrarRecursosPorAsignatura) {
            window.filtrarRecursosPorAsignatura(asigRecursos);
        }
    } else if (hash === '#calendario') {
        document.getElementById('sec-calendario').style.display = 'flex';
        const linkC = document.querySelector('a[href="pages/dashboard-profesor.php#calendario"]');
        if (linkC) {
            linkC.parentNode.classList.add('activo');
        }
    } else if (hash === '#anuncios' || hash === '#anuncios-nuevo') {
        document.getElementById('sec-anuncios').style.display = 'flex';
        const linkA = document.querySelector('a[href="pages/dashboard-profesor.php#anuncios"]');
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
        const linkI = document.querySelector('a[href="pages/dashboard-profesor.php"]');
        if (linkI) {
            linkI.parentNode.classList.add('activo');
        }
    }
}

window.addEventListener('hashchange', routerHash);
routerHash();
