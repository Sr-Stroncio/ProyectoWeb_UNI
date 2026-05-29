if (typeof tareas === 'undefined') {
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
}

var nextIdTar = 5;
var filtroActivoTar = 'todas';
var tareaIdTar = null;

var cuerpoTablaTar = document.getElementById('cuerpoTabla');
var modalFondoTar = document.getElementById('modalFondoTar');
var modalTituloTar = document.getElementById('modalTituloTar');
var inputNombreTar = document.getElementById('inputNombreTar');
var inputAsigTar = document.getElementById('inputAsigTar');
var inputCierreTar = document.getElementById('inputCierreTar');
var inputTotalTar = document.getElementById('inputTotalTar');
var inputDescTar = document.getElementById('inputDescTar');
var inputEstadoTar = document.getElementById('inputEstadoTar');
var btnBorrarTar = document.getElementById('btnBorrarTareaTar');

function formatearFechaTar(fechaStr) {
    var meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
    var partes = fechaStr.split('-');
    
    if (partes.length < 3) return fechaStr;
    
    var dia = parseInt(partes[2]);
    var mesNum = parseInt(partes[1]);
    var mes = meses[mesNum - 1];
    return dia + ' ' + mes;
}

// se pinta la tabla usando forEach
function renderTablaTar() {
    cuerpoTablaTar.innerHTML = '';

    tareas.forEach(function(tarea) {
        if (filtroActivoTar !== 'todas' && tarea.estado !== filtroActivoTar) return;

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
            '<span class="col-cierre">' + formatearFechaTar(tarea.cierre) + '</span>' +
            '<span class="col-entregas">' +
                '<span class="entregas-texto">' + tarea.entregas + '/' + tarea.total + '</span>' +
                '<div class="barra-progreso"><div class="barra-relleno" style="width:' + porcentaje + '%"></div></div>' +
            '</span>' +
            '<span class="col-estado"><span class="badge ' + tarea.estado + '">' + tarea.estado + '</span></span>' +
            '<span class="col-accion"><button class="btn-ver" data-id="' + tarea.id + '">Ver entregas</button></span>';

        fila.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-ver')) return;
            abrirEditarTar(tarea.id);
        });

        fila.querySelector('.btn-ver').addEventListener('click', function(e) {
            e.stopPropagation();
            abrirEditarTar(tarea.id);
        });

        cuerpoTablaTar.appendChild(fila);
    });
}

function abrirNuevaTar() {
    tareaIdTar = null;
    modalTituloTar.textContent = 'Nueva tarea';
    inputNombreTar.value = '';
    inputAsigTar.value = 'Programación';
    inputCierreTar.value = '';
    inputTotalTar.value = '';
    inputDescTar.value = '';
    inputEstadoTar.value = 'futura';
    btnBorrarTar.classList.add('oculto');
    modalFondoTar.classList.add('visible');
}

function abrirEditarTar(id) {
    // se busca la tarea usando find
    var tarea = tareas.find(function(t) { return t.id === id; });
    if (!tarea) return;

    tareaIdTar = id;
    modalTituloTar.textContent = 'Editar tarea';
    inputNombreTar.value = tarea.nombre;
    inputAsigTar.value = tarea.asig;
    inputCierreTar.value = tarea.cierre;
    inputTotalTar.value = tarea.total;
    inputDescTar.value = tarea.desc;
    inputEstadoTar.value = tarea.estado;
    btnBorrarTar.classList.remove('oculto');
    modalFondoTar.classList.add('visible');
}

function cerrarModalTar() {
    modalFondoTar.classList.remove('visible');
    tareaIdTar = null;
}

function guardarTar() {
    var nombre = inputNombreTar.value.trim();
    if (!nombre) {
        alert('El nombre de la tarea no puede estar vacío.');
        return;
    }

    var asig = inputAsigTar.value;
    var cierre = inputCierreTar.value;
    var desc = inputDescTar.value.trim();
    var total = parseInt(inputTotalTar.value) || 0;
    var estado = inputEstadoTar.value;
    var idEnviar = tareaIdTar !== null ? tareaIdTar : '';

    var params = 'id=' + idEnviar +
                 '&nombre=' + encodeURIComponent(nombre) +
                 '&desc=' + encodeURIComponent(desc) +
                 '&asig=' + encodeURIComponent(asig) +
                 '&cierre=' + cierre;

    fetch('utils/guardar-tarea.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params
    })
    .then(function(r) { return r.text(); })
    .then(function(respuesta) {
        if (tareaIdTar === null) {
            tareas.push({
                id: parseInt(respuesta),
                nombre: nombre,
                asig: asig,
                cierre: cierre,
                total: total,
                entregas: 0,
                estado: estado,
                desc: desc
            });
        } else {
            var tarea = tareas.find(function(t) { return t.id === tareaIdTar; });
            if (tarea) {
                tarea.nombre = nombre;
                tarea.asig = asig;
                tarea.cierre = cierre;
                tarea.total = total || tarea.total;
                tarea.estado = estado;
                tarea.desc = desc;
            }
        }
        cerrarModalTar();
        renderTablaTar();
    });
}

function borrarTareaTar() {
    if (tareaIdTar === null) return;
    if (!confirm('¿Seguro que quieres eliminar esta tarea?')) return;

    var idBorrar = tareaIdTar;

    fetch('utils/borrar-tarea.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + idBorrar
    })
    .then(function() {
        tareas = tareas.filter(function(t) { return t.id !== idBorrar; });
        cerrarModalTar();
        renderTablaTar();
    });
}

document.getElementById('btnNuevaTarea').addEventListener('click', abrirNuevaTar);
document.getElementById('modalCerrarTar').addEventListener('click', cerrarModalTar);
document.getElementById('btnCancelarTar').addEventListener('click', cerrarModalTar);
document.getElementById('btnGuardarTar').addEventListener('click', guardarTar);
document.getElementById('btnBorrarTareaTar').addEventListener('click', borrarTareaTar);

modalFondoTar.addEventListener('click', function(e) {
    if (e.target === modalFondoTar) cerrarModalTar();
});

// se configuran los botones de filtro
var botonesFiltroTar = document.querySelectorAll('.filtro');
botonesFiltroTar.forEach(function(btn) {
    btn.addEventListener('click', function() {
        botonesFiltroTar.forEach(function(b) {
            b.classList.remove('activo');
        });
        btn.classList.add('activo');
        filtroActivoTar = btn.getAttribute('data-filtro');
        renderTablaTar();
    });
});

// se realiza el arranque inicial
renderTablaTar();