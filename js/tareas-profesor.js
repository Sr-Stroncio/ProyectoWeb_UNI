// las tareas llegan inyectadas desde dashboard-profesor.php

let filtroActivoTar = 'todas';
let filtroAsigTar = 'todas';
let tareaIdTar = null;

const cuerpoTablaTar = document.getElementById('cuerpoTabla');
const modalFondoTar = document.getElementById('modalFondoTar');
const modalTituloTar = document.getElementById('modalTituloTar');
const inputNombreTar = document.getElementById('inputNombreTar');
const inputAsigTar = document.getElementById('inputAsigTar');
const inputCierreTar = document.getElementById('inputCierreTar');
const inputDescTar = document.getElementById('inputDescTar');
const inputArchivoTar = document.getElementById('inputArchivoTar');
const archivoActualTar = document.getElementById('archivoActualTar');
const btnBorrarTar = document.getElementById('btnBorrarTareaTar');
const extenderBloqueTar = document.getElementById('extenderBloqueTar');
const inputExtenderTar = document.getElementById('inputExtenderTar');
const inputExtenderUnidadTar = document.getElementById('inputExtenderUnidadTar');
const btnExtenderTar = document.getElementById('btnExtenderTar');

function formatearFechaTar(fechaStr) {
    // las tareas sin fecha limite llegan con la fecha vacia
    if (!fechaStr) return '';

    const meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
    const partes = fechaStr.split('-');
    const dia = parseInt(partes[2]);
    const mesNum = parseInt(partes[1]);
    const mes = meses[mesNum - 1];
    return dia + ' ' + mes;
}

// se calcula el estado a partir de la fecha de cierre
function calcularEstadoTar(cierre) {
    if (!cierre) return 'abierta';
    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);
    const fechaCierre = new Date(cierre);
    if (fechaCierre < hoy) return 'cerrada';
    return 'abierta';
}

// se traduce el codigo de asignatura (prog/bd/hci) al nombre que esta en la tarea
function nombreAsigTar(codigo) {
    if (codigo === 'prog') return 'Programación';
    if (codigo === 'bd') return 'BD';
    if (codigo === 'hci') return 'HCI';
    return '';
}

// se cambia el filtro de asignatura desde fuera (lo llama el router)
function filtrarTareasPorAsignatura(codigo) {
    filtroAsigTar = codigo;
    const sub = document.getElementById('subtituloTar');
    if (codigo === 'todas') {
        sub.textContent = 'Todas las asignaturas';
    } else {
        sub.textContent = nombreAsigTar(codigo);
    }
    renderTablaTar();
}

// se pinta la tabla de tareas
function renderTablaTar() {
    cuerpoTablaTar.innerHTML = '';

    for (let i = 0; i < tareas.length; i++) {
        let tarea = tareas[i];
        if (filtroActivoTar !== 'todas' && tarea.estado !== filtroActivoTar) continue;
        if (filtroAsigTar !== 'todas' && tarea.asig !== nombreAsigTar(filtroAsigTar)) continue;

        let porcentaje = 0;
        if (tarea.total > 0) {
            porcentaje = Math.round((tarea.entregas / tarea.total) * 100);
        }

        let enlacePdf = '';
        if (tarea.archivo) {
            enlacePdf = ' <a class="tarea-pdf" href="' + tarea.archivo + '" target="_blank">PDF</a>';
        }

        const fila = document.createElement('div');
        fila.className = 'tabla-fila';
        fila.setAttribute('data-id', tarea.id);

        fila.innerHTML =
            '<span class="col-tarea nombre-tarea">' + tarea.nombre + enlacePdf + '</span>' +
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
            if (e.target.classList.contains('tarea-pdf')) return;
            abrirEditarTar(tarea.id);
        });

        fila.querySelector('.btn-ver').addEventListener('click', function(e) {
            e.stopPropagation();
            abrirEditarTar(tarea.id);
        });

        cuerpoTablaTar.appendChild(fila);
    }
}

function abrirNuevaTar() {
    tareaIdTar = null;
    modalTituloTar.textContent = 'Nueva tarea';
    inputNombreTar.value = '';
    inputAsigTar.value = 'Programación';
    inputCierreTar.value = '';
    inputDescTar.value = '';
    inputArchivoTar.value = '';
    archivoActualTar.classList.add('oculto');
    btnBorrarTar.classList.add('oculto');
    extenderBloqueTar.classList.add('oculto');
    modalFondoTar.classList.add('visible');
}

function abrirEditarTar(id) {
    // se busca la tarea
    let tarea = null;
    for (let i = 0; i < tareas.length; i++) {
        if (tareas[i].id === id) {
            tarea = tareas[i];
            break;
        }
    }
    if (!tarea) return;

    tareaIdTar = id;
    modalTituloTar.textContent = 'Editar tarea';
    inputNombreTar.value = tarea.nombre;
    inputAsigTar.value = tarea.asig;
    inputCierreTar.value = tarea.cierre;
    inputDescTar.value = tarea.desc;
    inputArchivoTar.value = '';
    inputExtenderTar.value = '';

    // si la tarea ya tiene un PDF se muestra un enlace para verlo
    if (tarea.archivo) {
        archivoActualTar.innerHTML = 'Archivo actual: <a href="' + tarea.archivo + '" target="_blank">ver PDF</a>';
        archivoActualTar.classList.remove('oculto');
    } else {
        archivoActualTar.classList.add('oculto');
    }

    btnBorrarTar.classList.remove('oculto');
    extenderBloqueTar.classList.remove('oculto');
    modalFondoTar.classList.add('visible');
}

function extenderTar() {
    if (tareaIdTar === null) return;
    let cantidad = parseInt(inputExtenderTar.value) || 0;
    if (cantidad <= 0) {
        alert('Introduce una cantidad valida para extender el plazo.');
        return;
    }
    let unidad = inputExtenderUnidadTar.value;
    const idEnviar = tareaIdTar;

    const params = 'id=' + idEnviar + '&cantidad=' + cantidad + '&unidad=' + unidad;

    fetch('utils/extender-tarea.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params
    })
    .then(function(r) { return r.text(); })
    .then(function(nuevaFechaFull) {
        // la respuesta viene como "YYYY-MM-DD HH:MM:SS", se coge solo la fecha
        const nuevaFecha = nuevaFechaFull.split(' ')[0];
        let tarea = null;
        for (let i = 0; i < tareas.length; i++) {
            if (tareas[i].id === idEnviar) {
                tarea = tareas[i];
                break;
            }
        }
        if (tarea && nuevaFecha) {
            tarea.cierre = nuevaFecha;
            tarea.estado = calcularEstadoTar(nuevaFecha);
            inputCierreTar.value = nuevaFecha;
            // se mueve tambien el evento del calendario a la nueva fecha
            for (let j = 0; j < eventos.length; j++) {
                if (eventos[j].tipo === 'tarea' && eventos[j].id === idEnviar) {
                    eventos[j].fecha = nuevaFecha;
                    break;
                }
            }
        }
        inputExtenderTar.value = '';
        renderTablaTar();
        refrescarCalendario();
        alert('Plazo extendido. Nueva fecha: ' + nuevaFecha);
    });
}

function cerrarModalTar() {
    modalFondoTar.classList.remove('visible');
    tareaIdTar = null;
}

function guardarTar() {
    let nombre = inputNombreTar.value.trim();
    if (!nombre) {
        alert('El nombre de la tarea no puede estar vacío.');
        return;
    }

    let asig = inputAsigTar.value;
    let cierre = inputCierreTar.value;
    let desc = inputDescTar.value.trim();
    const estado = calcularEstadoTar(cierre);
    const idEnviar = tareaIdTar !== null ? tareaIdTar : '';

    // se valida que el archivo, si lo hay, sea un PDF de como mucho 10 MB
    if (inputArchivoTar.files.length > 0) {
        const archivo = inputArchivoTar.files[0];
        if (archivo.type !== 'application/pdf') {
            alert('El archivo tiene que ser un PDF.');
            return;
        }
        if (archivo.size > 10 * 1024 * 1024) {
            alert('El archivo no puede pesar más de 10 MB.');
            return;
        }
    }

    // se usa FormData para poder enviar el PDF junto con los demas campos
    const datos = new FormData();
    datos.append('id', idEnviar);
    datos.append('nombre', nombre);
    datos.append('desc', desc);
    datos.append('asig', asig);
    datos.append('cierre', cierre);
    if (inputArchivoTar.files.length > 0) {
        datos.append('archivo', inputArchivoTar.files[0]);
    }

    fetch('utils/guardar-tarea.php', {
        method: 'POST',
        body: datos
    })
    .then(function(r) { return r.text(); })
    .then(function(respuesta) {
        // la respuesta viene como "id|ruta_archivo" (cualquiera de los dos puede ir vacio)
        const partes = respuesta.split('|');
        const idNuevo = partes[0];
        const archivoNuevo = partes[1] || '';

        if (tareaIdTar === null) {
            tareas.push({
                id: parseInt(idNuevo),
                nombre: nombre,
                asig: asig,
                cierre: cierre,
                total: 0,
                entregas: 0,
                estado: estado,
                desc: desc,
                archivo: archivoNuevo
            });
            // la tarea nueva tambien es un evento del calendario
            if (cierre) {
                eventos.push({
                    id: parseInt(idNuevo),
                    titulo: nombre,
                    asig: asig,
                    fecha: cierre,
                    hora: '',
                    tipo: 'tarea'
                });
            }
        } else {
            let tarea = null;
            for (let i = 0; i < tareas.length; i++) {
                if (tareas[i].id === tareaIdTar) {
                    tarea = tareas[i];
                    break;
                }
            }
            if (tarea) {
                tarea.nombre = nombre;
                tarea.asig = asig;
                tarea.cierre = cierre;
                tarea.estado = estado;
                tarea.desc = desc;
                // solo se cambia el archivo si se ha subido uno nuevo
                if (archivoNuevo !== '') {
                    tarea.archivo = archivoNuevo;
                }
            }
            // se actualiza tambien el evento del calendario
            for (let i = 0; i < eventos.length; i++) {
                if (eventos[i].tipo === 'tarea' && eventos[i].id === tareaIdTar) {
                    eventos[i].titulo = nombre;
                    eventos[i].asig = asig;
                    eventos[i].fecha = cierre;
                    break;
                }
            }
        }
        cerrarModalTar();
        renderTablaTar();
        refrescarCalendario();
    });
}

function borrarTareaTar() {
    if (tareaIdTar === null) return;
    if (!confirm('¿Seguro que quieres eliminar esta tarea?')) return;

    const idBorrar = tareaIdTar;

    fetch('utils/borrar-tarea.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + idBorrar
    })
    .then(function() {
        let nuevas = [];
        for (let i = 0; i < tareas.length; i++) {
            if (tareas[i].id !== idBorrar) {
                nuevas.push(tareas[i]);
            }
        }
        tareas = nuevas;
        // se quita tambien el evento del calendario
        let eventosNuevos = [];
        for (let i = 0; i < eventos.length; i++) {
            if (eventos[i].tipo === 'tarea' && eventos[i].id === idBorrar) {
                continue;
            }
            eventosNuevos.push(eventos[i]);
        }
        eventos = eventosNuevos;
        cerrarModalTar();
        renderTablaTar();
        refrescarCalendario();
    });
}

document.getElementById('btnNuevaTarea').addEventListener('click', abrirNuevaTar);
document.getElementById('modalCerrarTar').addEventListener('click', cerrarModalTar);
document.getElementById('btnCancelarTar').addEventListener('click', cerrarModalTar);
document.getElementById('btnGuardarTar').addEventListener('click', guardarTar);
document.getElementById('btnBorrarTareaTar').addEventListener('click', borrarTareaTar);
btnExtenderTar.addEventListener('click', extenderTar);

modalFondoTar.addEventListener('click', function(e) {
    if (e.target === modalFondoTar) cerrarModalTar();
});

// se configuran los botones de filtro
const botonesFiltroTar = document.querySelectorAll('.filtro');
for (let i = 0; i < botonesFiltroTar.length; i++) {
    botonesFiltroTar[i].addEventListener('click', function() {
        for (let j = 0; j < botonesFiltroTar.length; j++) {
            botonesFiltroTar[j].classList.remove('activo');
        }
        this.classList.add('activo');
        filtroActivoTar = this.getAttribute('data-filtro');
        renderTablaTar();
    });
}

// se expone la funcion para que el router pueda llamarla
window.filtrarTareasPorAsignatura = filtrarTareasPorAsignatura;

// se realiza el arranque inicial
renderTablaTar();