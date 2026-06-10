// los recursos llegan inyectados desde dashboard-profesor.php

let filtroAsigRec = 'todas';
let recursoIdRec = null;

const listaRecursosRec = document.getElementById('listaRecursos');
const modalFondoRec = document.getElementById('modalFondoRec');
const modalTituloRec = document.getElementById('modalTituloRec');
const inputTituloRec = document.getElementById('inputTituloRec');
const inputDescRec = document.getElementById('inputDescRec');
const inputAsigRec = document.getElementById('inputAsigRec');
const inputUrlRec = document.getElementById('inputUrlRec');
const inputEstadoRec = document.getElementById('inputEstadoRec');
const btnBorrarRec = document.getElementById('btnBorrarRecursoRec');

function nombreAsigRec(codigo) {
    if (codigo === 'prog') return 'Programación';
    if (codigo === 'bd') return 'BD';
    if (codigo === 'hci') return 'HCI';
    return '';
}

function filtrarRecursosPorAsignatura(codigo) {
    filtroAsigRec = codigo;
    const sub = document.getElementById('subtituloRec');
    if (codigo === 'todas') {
        sub.textContent = 'Todas las asignaturas';
    } else {
        sub.textContent = nombreAsigRec(codigo);
    }
    renderRecursosRec();
}

function renderRecursosRec() {
    listaRecursosRec.innerHTML = '';

    let hayAlguno = false;
    for (let i = 0; i < recursos.length; i++) {
        let r = recursos[i];
        if (filtroAsigRec !== 'todas' && r.asig !== nombreAsigRec(filtroAsigRec)) continue;
        hayAlguno = true;

        const card = document.createElement('div');
        card.className = 'recurso-card';
        card.setAttribute('data-id', r.id);

        let enlace = '';
        if (r.url) {
            enlace = '<a class="recurso-link" href="' + r.url + '" target="_blank">Abrir enlace</a>';
        }

        card.innerHTML =
            '<div class="recurso-top">' +
                '<span class="recurso-asig">' + r.asig + '</span>' +
                '<span class="recurso-estado ' + r.estado + '">' + r.estado + '</span>' +
            '</div>' +
            '<p class="recurso-titulo">' + r.titulo + '</p>' +
            '<p class="recurso-desc">' + (r.desc || '') + '</p>' +
            enlace;

        card.addEventListener('click', function(e) {
            if (e.target.classList.contains('recurso-link')) return;
            let id = parseInt(this.getAttribute('data-id'));
            abrirEditarRec(id);
        });

        listaRecursosRec.appendChild(card);
    }

    if (!hayAlguno) {
        listaRecursosRec.innerHTML = '<p class="lista-vacia">No hay recursos para mostrar.</p>';
    }
}

function abrirNuevoRec() {
    recursoIdRec = null;
    modalTituloRec.textContent = 'Nuevo recurso';
    inputTituloRec.value = '';
    inputDescRec.value = '';
    inputAsigRec.value = 'Programación';
    inputUrlRec.value = '';
    inputEstadoRec.value = 'activo';
    btnBorrarRec.classList.add('oculto');
    modalFondoRec.classList.add('visible');
}

function abrirEditarRec(id) {
    let r = null;
    for (let i = 0; i < recursos.length; i++) {
        if (recursos[i].id === id) {
            r = recursos[i];
            break;
        }
    }
    if (!r) return;

    recursoIdRec = id;
    modalTituloRec.textContent = 'Editar recurso';
    inputTituloRec.value = r.titulo;
    inputDescRec.value = r.desc || '';
    inputAsigRec.value = r.asig;
    inputUrlRec.value = r.url || '';
    inputEstadoRec.value = r.estado || 'activo';
    btnBorrarRec.classList.remove('oculto');
    modalFondoRec.classList.add('visible');
}

function cerrarModalRec() {
    modalFondoRec.classList.remove('visible');
    recursoIdRec = null;
}

function guardarRec() {
    let titulo = inputTituloRec.value.trim();
    if (!titulo) {
        alert('El titulo no puede estar vacio.');
        return;
    }

    let desc = inputDescRec.value.trim();
    let asig = inputAsigRec.value;
    let url = inputUrlRec.value.trim();
    let estado = inputEstadoRec.value;
    const idEnviar = recursoIdRec !== null ? recursoIdRec : '';

    const params = 'id=' + idEnviar +
                 '&titulo=' + encodeURIComponent(titulo) +
                 '&desc=' + encodeURIComponent(desc) +
                 '&asig=' + encodeURIComponent(asig) +
                 '&url=' + encodeURIComponent(url) +
                 '&estado=' + estado;

    fetch('utils/guardar-recurso.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params
    })
    .then(function(r) { return r.text(); })
    .then(function(respuesta) {
        if (recursoIdRec === null) {
            recursos.push({
                id: parseInt(respuesta),
                titulo: titulo,
                desc: desc,
                asig: asig,
                url: url,
                estado: estado
            });
        } else {
            for (let i = 0; i < recursos.length; i++) {
                if (recursos[i].id === recursoIdRec) {
                    recursos[i].titulo = titulo;
                    recursos[i].desc = desc;
                    recursos[i].asig = asig;
                    recursos[i].url = url;
                    recursos[i].estado = estado;
                    break;
                }
            }
        }
        cerrarModalRec();
        renderRecursosRec();
    });
}

function borrarRecursoRec() {
    if (recursoIdRec === null) return;
    if (!confirm('Seguro que quieres eliminar este recurso?')) return;

    const idBorrar = recursoIdRec;

    fetch('utils/borrar-recurso.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + idBorrar
    })
    .then(function() {
        const nuevos = [];
        for (let i = 0; i < recursos.length; i++) {
            if (recursos[i].id !== idBorrar) {
                nuevos.push(recursos[i]);
            }
        }
        recursos = nuevos;
        cerrarModalRec();
        renderRecursosRec();
    });
}

document.getElementById('btnNuevoRecurso').addEventListener('click', abrirNuevoRec);
document.getElementById('modalCerrarRec').addEventListener('click', cerrarModalRec);
document.getElementById('btnCancelarRec').addEventListener('click', cerrarModalRec);
document.getElementById('btnGuardarRec').addEventListener('click', guardarRec);
btnBorrarRec.addEventListener('click', borrarRecursoRec);

modalFondoRec.addEventListener('click', function(e) {
    if (e.target === modalFondoRec) cerrarModalRec();
});

window.filtrarRecursosPorAsignatura = filtrarRecursosPorAsignatura;

renderRecursosRec();
