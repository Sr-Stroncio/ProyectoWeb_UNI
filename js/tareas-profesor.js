var tareas = [
    {
        id: 1,
        nombre: 'Práctica 3 — Algoritmos',
        asig: 'Programación',
        cierre: '2025-05-15',
        total: 28,
        entregas: 22,
        estado: 'abierta',
        desc: 'Implementar los algoritmos de ordenación vistos en clase.'
    },
    {
        id: 2,
        nombre: 'Tarea SQL básico',
        asig: 'BD',
        cierre: '2025-05-12',
        total: 31,
        entregas: 31,
        estado: 'cerrada',
        desc: 'Consultas básicas sobre la base de datos de ejemplo.'
    },
    {
        id: 3,
        nombre: 'Entrega Prototipo P2',
        asig: 'HCI',
        cierre: '2025-05-20',
        total: 25,
        entregas: 8,
        estado: 'abierta',
        desc: 'Segunda entrega del prototipo de alta fidelidad.'
    },
    {
        id: 4,
        nombre: 'Examen Parcial 2',
        asig: 'Programación',
        cierre: '2025-05-22',
        total: 28,
        entregas: 0,
        estado: 'futura',
        desc: 'Examen de los temas 4, 5 y 6.'
    }
];

var nextId = 5;
var filtroActivo = 'todas';
var tareaId = null;

var cuerpoTabla = document.getElementById('cuerpoTabla');
var modalFondo = document.getElementById('modalFondo');
var modalTitulo = document.getElementById('modalTitulo');
var inputNombre = document.getElementById('inputNombre');
var inputAsig = document.getElementById('inputAsig');
var inputCierre = document.getElementById('inputCierre');
var inputTotal = document.getElementById('inputTotal');
var inputDesc = document.getElementById('inputDesc');
var inputEstado = document.getElementById('inputEstado');
var btnBorrar = document.getElementById('btnBorrarTarea');


function formatearFecha(fechaStr) {
    // formato: 2025-05-15 -> "15 may"
    var meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
    var partes = fechaStr.split('-');
    var dia = parseInt(partes[2]);
    var mes = meses[parseInt(partes[1]) - 1];
    return dia + ' ' + mes;
}

function renderTabla() {
    cuerpoTabla.innerHTML = '';

    tareas.forEach(function(tarea) {
        if (filtroActivo !== 'todas' && tarea.estado !== filtroActivo) return;

        var porcentaje = 0;
        if (tarea.total > 0) {
            porcentaje = Math.round((tarea.entregas / tarea.total) * 100);
        }

        var fila = document.createElement('div');
        fila.className = 'tabla-fila';
        fila.setAttribute('data-id', tarea.id);
        fila.innerHTML =
            '<span class="col-tarea nombre-tarea">' + tarea.nombre + '</span>' +
            '<span class="col-asig">' + tarea.asig + '</span>' +
            '<span class="col-cierre">' + formatearFecha(tarea.cierre) + '</span>' +
            '<span class="col-entregas">' +
                '<span class="entregas-texto">' + tarea.entregas + '/' + tarea.total + '</span>' +
                '<div class="barra-progreso"><div class="barra-relleno" style="width:' + porcentaje + '%"></div></div>' +
            '</span>' +
            '<span class="col-estado"><span class="badge ' + tarea.estado + '">' + tarea.estado + '</span></span>' +
            '<span class="col-accion"><button class="btn-ver" data-id="' + tarea.id + '">Ver entregas</button></span>';

        fila.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-ver')) return;
            abrirEditar(tarea.id);
        });

        fila.querySelector('.btn-ver').addEventListener('click', function(e) {
            e.stopPropagation();
            abrirEditar(tarea.id);
        });

        cuerpoTabla.appendChild(fila);
    });
}

function abrirNueva() {
    tareaId = null;
    modalTitulo.textContent = 'Nueva tarea';
    inputNombre.value = '';
    inputAsig.value = 'Programación';
    inputCierre.value = '';
    inputTotal.value = '';
    inputDesc.value = '';
    inputEstado.value = 'futura';
    btnBorrar.classList.add('oculto');
    modalFondo.classList.add('visible');
}

function abrirEditar(id) {
    var tarea = tareas.find(function(t) { return t.id === id; });
    if (!tarea) return;

    tareaId = id;
    modalTitulo.textContent = 'Editar tarea';
    inputNombre.value = tarea.nombre;
    inputAsig.value = tarea.asig;
    inputCierre.value = tarea.cierre;
    inputTotal.value = tarea.total;
    inputDesc.value = tarea.desc;
    inputEstado.value = tarea.estado;
    btnBorrar.classList.remove('oculto');
    modalFondo.classList.add('visible');
}

function cerrarModal() {
    modalFondo.classList.remove('visible');
    tareaId = null;
}

function guardar() {
    var nombre = inputNombre.value.trim();
    if (!nombre) {
        alert('El nombre de la tarea no puede estar vacío.');
        return;
    }

    if (tareaId === null) {
        var nueva = {
            id: nextId++,
            nombre: nombre,
            asig: inputAsig.value,
            cierre: inputCierre.value,
            total: parseInt(inputTotal.value) || 0,
            entregas: 0,
            estado: inputEstado.value,
            desc: inputDesc.value.trim()
        };
        tareas.push(nueva);
    } else {
        var tarea = tareas.find(function(t) { return t.id === tareaId; });
        if (tarea) {
            tarea.nombre = nombre;
            tarea.asig = inputAsig.value;
            tarea.cierre = inputCierre.value;
            tarea.total = parseInt(inputTotal.value) || tarea.total;
            tarea.estado = inputEstado.value;
            tarea.desc = inputDesc.value.trim();
        }
    }

    cerrarModal();
    renderTabla();
}

function borrarTarea() {
    if (tareaId === null) return;
    if (!confirm('¿Seguro que quieres eliminar esta tarea?')) return;

    tareas = tareas.filter(function(t) { return t.id !== tareaId; });
    cerrarModal();
    renderTabla();
}

document.getElementById('btnNuevaTarea').addEventListener('click', abrirNueva);
document.getElementById('modalCerrar').addEventListener('click', cerrarModal);
document.getElementById('btnCancelar').addEventListener('click', cerrarModal);
document.getElementById('btnGuardar').addEventListener('click', guardar);
document.getElementById('btnBorrarTarea').addEventListener('click', borrarTarea);

modalFondo.addEventListener('click', function(e) {
    if (e.target === modalFondo) cerrarModal();
});

document.querySelectorAll('.filtro').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filtro').forEach(function(b) {
            b.classList.remove('activo');
        });
        btn.classList.add('activo');
        filtroActivo = btn.getAttribute('data-filtro');
        renderTabla();
    });
});

renderTabla();