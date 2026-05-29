if (typeof recursos === 'undefined') {
    var recursos = [];
}

var filtroAsigRec = 'todas';
var recursoIdRec = null;

var listaRecursosRec = document.getElementById('listaRecursos');
var modalFondoRec = document.getElementById('modalFondoRec');
var modalTituloRec = document.getElementById('modalTituloRec');
var inputTituloRec = document.getElementById('inputTituloRec');
var inputDescRec = document.getElementById('inputDescRec');
var inputAsigRec = document.getElementById('inputAsigRec');
var inputUrlRec = document.getElementById('inputUrlRec');
var inputEstadoRec = document.getElementById('inputEstadoRec');
var btnBorrarRec = document.getElementById('btnBorrarRecursoRec');

function nombreAsigRec(codigo) {
    if (codigo === 'prog') return 'Programación';
    if (codigo === 'bd') return 'BD';
    if (codigo === 'hci') return 'HCI';
    return '';
}

function filtrarRecursosPorAsignatura(codigo) {
    filtroAsigRec = codigo;
    var sub = document.getElementById('subtituloRec');
    if (sub) {
        if (codigo === 'todas') {
            sub.textContent = 'Todas las asignaturas';
        } else {
            sub.textContent = nombreAsigRec(codigo);
        }
    }
    renderRecursosRec();
}

function renderRecursosRec() {
    listaRecursosRec.innerHTML = '';

    var hayAlguno = false;
    for (var i = 0; i < recursos.length; i++) {
        var r = recursos[i];
        if (filtroAsigRec !== 'todas' && r.asig !== nombreAsigRec(filtroAsigRec)) continue;
        hayAlguno = true;

        var card = document.createElement('div');
        card.className = 'recurso-card';
        card.setAttribute('data-id', r.id);

        var enlace = '';
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
            var id = parseInt(this.getAttribute('data-id'));
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
    var r = null;
    for (var i = 0; i < recursos.length; i++) {
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
    var titulo = inputTituloRec.value.trim();
    if (!titulo) {
        alert('El titulo no puede estar vacio.');
        return;
    }

    var desc = inputDescRec.value.trim();
    var asig = inputAsigRec.value;
    var url = inputUrlRec.value.trim();
    var estado = inputEstadoRec.value;
    var idEnviar = recursoIdRec !== null ? recursoIdRec : '';

    var params = 'id=' + idEnviar +
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
            for (var i = 0; i < recursos.length; i++) {
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

    var idBorrar = recursoIdRec;

    fetch('utils/borrar-recurso.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + idBorrar
    })
    .then(function() {
        var nuevos = [];
        for (var i = 0; i < recursos.length; i++) {
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
