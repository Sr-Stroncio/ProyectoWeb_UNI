var calificaciones = {
    prog: [
        { id: 1, nombre: 'Lief Simants', p1: 7.5, p2: 8.2, final: 9.1 },
        { id: 2, nombre: 'Merline Kirdsch', p1: 6.0, p2: 7.0, final: 8.0 },
        { id: 3, nombre: 'Debora Rawstorne', p1: 9.0, p2: 8.8, final: 9.5 },
        { id: 4, nombre: 'Kevan Pounds', p1: 5.5, p2: 6.5, final: 7.0 },
        { id: 5, nombre: 'Luelle Pridmore', p1: 8.0, p2: 8.5, final: 9.0 },
        { id: 6, nombre: 'Eolande Merriton', p1: 7.0, p2: 6.0, final: null }
    ],
    bd: [
        { id: 7, nombre: 'Lief Simants', p1: 6.5, p2: 7.0, final: 8.5 },
        { id: 8, nombre: 'Merline Kirdsch', p1: 8.0, p2: 7.5, final: 9.0 },
        { id: 9, nombre: 'Debora Rawstorne', p1: 7.0, p2: 8.0, final: 7.5 }
    ],
    hci: [
        { id: 10, nombre: 'Lief Simants', p1: 8.5, p2: 9.0, final: 8.0 },
        { id: 11, nombre: 'Kevan Pounds', p1: 6.0, p2: null, final: 7.0 }
    ]
};

var subtitulos = {
    prog: 'Programación · 28 alumnos',
    bd: 'Bases de Datos · 24 alumnos',
    hci: 'HCI · 25 alumnos'
};

var asigActiva = 'prog';
var alumnoId = null;
var nextId = 20;
var ordenAscendente = true;

var cuerpoTabla = document.getElementById('cuerpoTabla');
var modalFondo = document.getElementById('modalFondo');
var modalTitulo = document.getElementById('modalTitulo');
var inputAlumno = document.getElementById('inputAlumno');
var inputP1 = document.getElementById('inputP1');
var inputP2 = document.getElementById('inputP2');
var inputFinal = document.getElementById('inputFinal');
var mediaPreview = document.getElementById('mediaPreview');
var btnBorrar = document.getElementById('btnBorrarAlumno');

// calcula la media solo con las notas que existen
function calcularMedia(p1, p2, final) {
    var notas = [];
    if (p1 !== null && p1 !== '') notas.push(parseFloat(p1));
    if (p2 !== null && p2 !== '') notas.push(parseFloat(p2));
    if (final !== null && final !== '') notas.push(parseFloat(final));
    if (notas.length === 0) return null;
    var suma = notas.reduce(function(a, b) { return a + b; }, 0);
    return Math.round((suma / notas.length) * 10) / 10;
}

function mostrarNota(val) {
    return (val === null || val === '') ? '—' : val;
}

function renderTabla() {
    cuerpoTabla.innerHTML = '';
    var lista = calificaciones[asigActiva];

    lista.forEach(function(alumno) {
        var media = calcularMedia(alumno.p1, alumno.p2, alumno.final);

        var fila = document.createElement('div');
        fila.className = 'tabla-fila';
        fila.setAttribute('data-id', alumno.id);
        fila.innerHTML =
            '<span class="col-alumno">' + alumno.nombre + '</span>' +
            '<span class="col-nota">' + mostrarNota(alumno.p1) + '</span>' +
            '<span class="col-nota">' + mostrarNota(alumno.p2) + '</span>' +
            '<span class="col-nota">' + mostrarNota(alumno.final) + '</span>' +
            '<span class="col-media">' + (media !== null ? media : '—') + '</span>' +
            '<span class="col-accion"><button class="btn-editar">&#9998; Editar</button></span>';

        fila.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-editar')) return;
            abrirEditar(alumno.id);
        });

        fila.querySelector('.btn-editar').addEventListener('click', function(e) {
            e.stopPropagation();
            abrirEditar(alumno.id);
        });

        cuerpoTabla.appendChild(fila);
    });
}

function actualizarMedia() {
    var media = calcularMedia(inputP1.value, inputP2.value, inputFinal.value);
    mediaPreview.textContent = media !== null ? media : '—';
}

function abrirNuevo() {
    alumnoId = null;
    modalTitulo.textContent = 'Nueva calificación';
    inputAlumno.value = '';
    inputP1.value = '';
    inputP2.value = '';
    inputFinal.value = '';
    mediaPreview.textContent = '—';
    btnBorrar.classList.add('oculto');
    modalFondo.classList.add('visible');
}

function abrirEditar(id) {
    var lista = calificaciones[asigActiva];
    var alumno = lista.find(function(a) { return a.id === id; });
    if (!alumno) return;

    alumnoId = id;
    modalTitulo.textContent = 'Editar calificación — ' + alumno.nombre;
    inputAlumno.value = alumno.nombre;
    inputP1.value = alumno.p1 !== null ? alumno.p1 : '';
    inputP2.value = alumno.p2 !== null ? alumno.p2 : '';
    inputFinal.value = alumno.final !== null ? alumno.final : '';
    actualizarMedia();
    btnBorrar.classList.remove('oculto');
    modalFondo.classList.add('visible');
}

function cerrarModal() {
    modalFondo.classList.remove('visible');
    alumnoId = null;
}

function guardar() {
    var nombre = inputAlumno.value.trim();
    if (!nombre) {
        alert('El nombre del alumno no puede estar vacío.');
        return;
    }

    var p1 = inputP1.value !== '' ? parseFloat(inputP1.value) : null;
    var p2 = inputP2.value !== '' ? parseFloat(inputP2.value) : null;
    var fin = inputFinal.value !== '' ? parseFloat(inputFinal.value) : null;

    if (alumnoId === null) {
        calificaciones[asigActiva].push({
            id: nextId++,
            nombre: nombre,
            p1: p1,
            p2: p2,
            final: fin
        });
    } else {
        var lista = calificaciones[asigActiva];
        var alumno = lista.find(function(a) { return a.id === alumnoId; });
        if (alumno) {
            alumno.nombre = nombre;
            alumno.p1 = p1;
            alumno.p2 = p2;
            alumno.final = fin;
        }
    }

    cerrarModal();
    renderTabla();
}

function borrarAlumno() {
    if (alumnoId === null) return;
    if (!confirm('¿Seguro que quieres eliminar este alumno?')) return;

    calificaciones[asigActiva] = calificaciones[asigActiva].filter(function(a) {
        return a.id !== alumnoId;
    });

    cerrarModal();
    renderTabla();
}

function exportarCSV() {
    var lista = calificaciones[asigActiva];
    var filas = ['Alumno,Parcial 1,Parcial 2,Final,Media'];

    lista.forEach(function(alumno) {
        var media = calcularMedia(alumno.p1, alumno.p2, alumno.final);
        filas.push([
            alumno.nombre,
            mostrarNota(alumno.p1),
            mostrarNota(alumno.p2),
            mostrarNota(alumno.final),
            media !== null ? media : '—'
        ].join(','));
    });

    var contenido = filas.join('\n');
    var blob = new Blob([contenido], { type: 'text/csv;charset=utf-8;' });
    var url = URL.createObjectURL(blob);
    var enlace = document.createElement('a');
    enlace.href = url;
    enlace.download = 'calificaciones-' + asigActiva + '.csv';
    enlace.click();
    URL.revokeObjectURL(url);
}

function ordenarPorMedia() {
    calificaciones[asigActiva].sort(function(a, b) {
        var ma = calcularMedia(a.p1, a.p2, a.final) || 0;
        var mb = calcularMedia(b.p1, b.p2, b.final) || 0;
        return ordenAscendente ? ma - mb : mb - ma;
    });
    ordenAscendente = !ordenAscendente;
    renderTabla();
}

document.getElementById('btnNuevaCalif').addEventListener('click', abrirNuevo);
document.getElementById('modalCerrar').addEventListener('click', cerrarModal);
document.getElementById('btnCancelar').addEventListener('click', cerrarModal);
document.getElementById('btnGuardar').addEventListener('click', guardar);
document.getElementById('btnBorrarAlumno').addEventListener('click', borrarAlumno);
document.getElementById('btnExportarCSV').addEventListener('click', exportarCSV);
document.getElementById('btnOrdenar').addEventListener('click', ordenarPorMedia);

inputP1.addEventListener('input', actualizarMedia);
inputP2.addEventListener('input', actualizarMedia);
inputFinal.addEventListener('input', actualizarMedia);

modalFondo.addEventListener('click', function(e) {
    if (e.target === modalFondo) cerrarModal();
});

document.querySelectorAll('.pill').forEach(function(pill) {
    pill.addEventListener('click', function() {
        document.querySelectorAll('.pill').forEach(function(p) { p.classList.remove('activo'); });
        pill.classList.add('activo');
        asigActiva = pill.getAttribute('data-asig');
        document.getElementById('subtitulo').textContent = subtitulos[asigActiva];
        renderTabla();
    });
});

renderTabla();