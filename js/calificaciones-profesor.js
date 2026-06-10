// calificaciones y examenes llegan inyectados desde dashboard-profesor.php

const subtitulosCal = {
    prog: 'Programación',
    bd: 'Bases de Datos',
    hci: 'HCI'
};

let asigActivaCal = 'prog';
let alumnoIdCal = null;

// se calcula la media sobre todas las notas del alumno
function calcularMediaCal(notas) {
    let suma = 0;
    let total = 0;
    for (const idEx in notas) {
        const val = notas[idEx];
        if (val !== null && !isNaN(val)) {
            suma = suma + parseFloat(val);
            total = total + 1;
        }
    }
    if (total === 0) return '—';
    return Math.round((suma / total) * 10) / 10;
}

function mostrarNotaCal(val) {
    if (val === null || val === '') return '—';
    if (isNaN(val)) return '—';
    return val;
}

// se pinta la lista de alumnos
function renderTablaCal() {
    const cuerpo = document.getElementById('cuerpoTablaAlumnos');
    cuerpo.innerHTML = '';

    const lista = calificaciones[asigActivaCal];

    for (let i = 0; i < lista.length; i++) {
        const alumno = lista[i];
        const fila = document.createElement('div');
        fila.className = 'tabla-fila';
        fila.style.cursor = 'pointer';

        fila.innerHTML =
            '<span class="col-alumno">' + alumno.nombre + '</span>' +
            '<span class="col-email" style="flex: 2;">' + alumno.email + '</span>' +
            '<span class="col-accion"><button class="btn-editar" style="background: none; border: none; color: #ff9e00; cursor: pointer; font-weight: 600;">&#9998; Ver/Editar</button></span>';

        fila.addEventListener('click', function() {
            mostrarDetalleCal(alumno.id);
        });

        cuerpo.appendChild(fila);
    }
}

// se selecciona la asignatura desde el hash
window.seleccionarAsignaturaHash = function(asig) {
    asigActivaCal = asig;

    const pestanas = document.querySelectorAll('.pill');
    for (let i = 0; i < pestanas.length; i++) {
        if (pestanas[i].getAttribute('data-asig') === asig) {
            pestanas[i].classList.add('activo');
        } else {
            pestanas[i].classList.remove('activo');
        }
    }

    document.getElementById('subtitulo').textContent = subtitulosCal[asig];

    // se vuelve al listado
    document.getElementById('vista-detalle-alumno').style.display = 'none';
    document.getElementById('vista-lista-alumnos').style.display = 'block';

    renderTablaCal();
};

// se muestran los detalles del alumno (filas dinamicas por examen)
function mostrarDetalleCal(id) {
    const lista = calificaciones[asigActivaCal];
    let alumno = null;
    for (let i = 0; i < lista.length; i++) {
        if (lista[i].id === id) {
            alumno = lista[i];
            break;
        }
    }
    if (!alumno) return;

    alumnoIdCal = id;

    document.getElementById('detalleNombreAlumno').textContent = alumno.nombre;
    document.getElementById('detalleEmailAlumno').textContent = alumno.email;

    // se pintan las filas de notas dinamicamente
    const filasCont = document.getElementById('detalleNotasFilas');
    filasCont.innerHTML = '';

    const examsAsig = examenes[asigActivaCal];
    if (examsAsig.length === 0) {
        filasCont.innerHTML = '<div class="tabla-fila" style="cursor: default;"><span style="flex: 1; color: #888;">No hay examenes creados todavia. Usa "Gestionar exámenes".</span></div>';
    } else {
        for (let j = 0; j < examsAsig.length; j++) {
            const ex = examsAsig[j];
            const nota = alumno.notas[ex.id];
            const fila = document.createElement('div');
            fila.className = 'tabla-fila';
            fila.style.cursor = 'default';
            fila.innerHTML =
                '<span style="flex: 2;">' + ex.titulo + '</span>' +
                '<span style="flex: 1; text-align: center; font-weight: 600;">' + mostrarNotaCal(nota) + '</span>';
            filasCont.appendChild(fila);
        }
    }

    document.getElementById('detalleNotaMedia').textContent = calcularMediaCal(alumno.notas);

    document.getElementById('vista-lista-alumnos').style.display = 'none';
    document.getElementById('vista-detalle-alumno').style.display = 'block';
}

// se recalcula la media en vivo mientras se editan los inputs
function actualizarMediaCal() {
    const inputs = document.querySelectorAll('.input-nota-ex');
    const notas = {};
    for (let i = 0; i < inputs.length; i++) {
        const idEx = inputs[i].getAttribute('data-id');
        const val = inputs[i].value;
        notas[idEx] = val !== '' ? parseFloat(val) : null;
    }
    document.getElementById('mediaPreview').textContent = calcularMediaCal(notas);
}

function abrirEditarCal() {
    if (alumnoIdCal === null) return;

    const lista = calificaciones[asigActivaCal];
    let alumno = null;
    for (let i = 0; i < lista.length; i++) {
        if (lista[i].id === alumnoIdCal) {
            alumno = lista[i];
            break;
        }
    }
    if (!alumno) return;

    document.getElementById('modalNombreAlumno').textContent = alumno.nombre;

    // se generan los inputs de notas dinamicamente
    const contInputs = document.getElementById('notasInputs');
    contInputs.innerHTML = '';

    const examsAsig = examenes[asigActivaCal];
    if (examsAsig.length === 0) {
        contInputs.innerHTML = '<p style="color: #888;">No hay examenes. Crea uno desde "Gestionar exámenes".</p>';
    } else {
        for (let j = 0; j < examsAsig.length; j++) {
            const ex = examsAsig[j];
            const nota = alumno.notas[ex.id];
            let valor = '';
            if (nota || nota === 0) {
                valor = nota;
            }
            const grupo = document.createElement('div');
            grupo.className = 'nota-grupo';
            grupo.innerHTML =
                '<label class="campo-label">' + ex.titulo + '</label>' +
                '<input class="campo-input input-nota-ex" type="number" data-id="' + ex.id + '" value="' + valor + '" placeholder="—" min="0" max="10" step="0.1">';
            contInputs.appendChild(grupo);
        }

        // se enganchan los listeners de los nuevos inputs
        const inputs = document.querySelectorAll('.input-nota-ex');
        for (let k = 0; k < inputs.length; k++) {
            inputs[k].addEventListener('input', actualizarMediaCal);
        }
    }

    actualizarMediaCal();
    document.getElementById('modalFondo').classList.add('visible');
}

function cerrarModalCal() {
    document.getElementById('modalFondo').classList.remove('visible');
}

function guardarCal() {
    if (alumnoIdCal === null) return;

    const inputs = document.querySelectorAll('.input-nota-ex');
    const lista = calificaciones[asigActivaCal];
    let alumno = null;
    for (let i = 0; i < lista.length; i++) {
        if (lista[i].id === alumnoIdCal) {
            alumno = lista[i];
            break;
        }
    }

    // se monta el body con notas[id]=valor
    const partes = ['alumno_id=' + alumnoIdCal];
    for (let k = 0; k < inputs.length; k++) {
        const idEx = inputs[k].getAttribute('data-id');
        const val = inputs[k].value;
        partes.push('notas[' + idEx + ']=' + (val !== '' ? val : ''));
        if (alumno) {
            alumno.notas[idEx] = val !== '' ? parseFloat(val) : null;
        }
    }
    const params = partes.join('&');

    fetch('utils/guardar-notas-profesor.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params
    });

    cerrarModalCal();
    mostrarDetalleCal(alumnoIdCal);
}

// gestion de examenes

function renderListaExamenesEx() {
    const cont = document.getElementById('listaExamenesEx');
    cont.innerHTML = '';

    const lista = examenes[asigActivaCal];
    if (lista.length === 0) {
        cont.innerHTML = '<p style="color: #888; margin: 0;">No hay examenes creados.</p>';
        return;
    }

    for (let i = 0; i < lista.length; i++) {
        const ex = lista[i];
        const fila = document.createElement('div');
        fila.className = 'examen-fila';
        fila.innerHTML =
            '<input class="campo-input examen-titulo-input" type="text" value="' + ex.titulo + '" data-id="' + ex.id + '">' +
            '<button class="btn-accion examen-guardar" data-id="' + ex.id + '">Guardar</button>' +
            '<button class="btn-modal-borrar examen-borrar" data-id="' + ex.id + '" style="padding: 6px 10px;">Eliminar</button>';

        cont.appendChild(fila);
    }

    // listeners de cada boton
    const botonesGuardar = cont.querySelectorAll('.examen-guardar');
    for (let g = 0; g < botonesGuardar.length; g++) {
        botonesGuardar[g].addEventListener('click', function() {
            let id = parseInt(this.getAttribute('data-id'));
            const input = cont.querySelector('.examen-titulo-input[data-id="' + id + '"]');
            renombrarExamenEx(id, input.value.trim());
        });
    }

    const botonesBorrar = cont.querySelectorAll('.examen-borrar');
    for (let b = 0; b < botonesBorrar.length; b++) {
        botonesBorrar[b].addEventListener('click', function() {
            let id = parseInt(this.getAttribute('data-id'));
            borrarExamenEx(id);
        });
    }
}

function abrirGestionarExamenesEx() {
    renderListaExamenesEx();
    document.getElementById('inputNuevoExamen').value = '';
    document.getElementById('modalFondoEx').classList.add('visible');
}

function cerrarGestionarExamenesEx() {
    document.getElementById('modalFondoEx').classList.remove('visible');
}

function anadirExamenEx() {
    let titulo = document.getElementById('inputNuevoExamen').value.trim();
    if (!titulo) {
        alert('El titulo no puede estar vacio.');
        return;
    }

    const params = 'id=&titulo=' + encodeURIComponent(titulo) + '&asig=' + asigActivaCal;

    fetch('utils/guardar-examen.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params
    })
    .then(function(r) { return r.text(); })
    .then(function(nuevoId) {
        examenes[asigActivaCal].push({ id: parseInt(nuevoId), titulo: titulo, fecha: '' });
        // se inicializa la nota null para todos los alumnos
        const lista = calificaciones[asigActivaCal];
        for (let i = 0; i < lista.length; i++) {
            lista[i].notas[nuevoId] = null;
        }
        document.getElementById('inputNuevoExamen').value = '';
        renderListaExamenesEx();
    });
}

function renombrarExamenEx(id, titulo) {
    if (!titulo) {
        alert('El titulo no puede estar vacio.');
        return;
    }
    const params = 'id=' + id + '&titulo=' + encodeURIComponent(titulo) + '&asig=' + asigActivaCal;

    fetch('utils/guardar-examen.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params
    })
    .then(function() {
        const lista = examenes[asigActivaCal];
        for (let i = 0; i < lista.length; i++) {
            if (lista[i].id === id) {
                lista[i].titulo = titulo;
                break;
            }
        }
        alert('Examen renombrado.');
    });
}

function borrarExamenEx(id) {
    if (!confirm('Seguro que quieres borrar este examen? Se perderan todas las notas asociadas.')) return;

    fetch('utils/borrar-examen.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
    })
    .then(function() {
        const lista = examenes[asigActivaCal];
        const nuevos = [];
        for (let i = 0; i < lista.length; i++) {
            if (lista[i].id !== id) nuevos.push(lista[i]);
        }
        examenes[asigActivaCal] = nuevos;
        // se quita la nota de todos los alumnos
        const alums = calificaciones[asigActivaCal];
        for (let j = 0; j < alums.length; j++) {
            delete alums[j].notas[id];
        }
        renderListaExamenesEx();
    });
}

function exportarCSVCal() {
    const lista = calificaciones[asigActivaCal];
    const examsAsig = examenes[asigActivaCal];

    // cabecera dinamica
    const cabecera = ['Alumno', 'Correo'];
    for (let c = 0; c < examsAsig.length; c++) {
        cabecera.push(examsAsig[c].titulo);
    }
    cabecera.push('Media');

    const filas = [cabecera.join(',')];

    for (let i = 0; i < lista.length; i++) {
        let alumno = lista[i];
        const linea = [alumno.nombre, alumno.email];
        for (let e = 0; e < examsAsig.length; e++) {
            linea.push(mostrarNotaCal(alumno.notas[examsAsig[e].id]));
        }
        linea.push(calcularMediaCal(alumno.notas));
        filas.push(linea.join(','));
    }

    const blob = new Blob([filas.join('\n')], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const enlace = document.createElement('a');
    enlace.href = url;
    enlace.download = 'calificaciones-' + asigActivaCal + '.csv';
    enlace.click();
}

// listeners
document.getElementById('btnVolverLista').addEventListener('click', function() {
    document.getElementById('vista-detalle-alumno').style.display = 'none';
    document.getElementById('vista-lista-alumnos').style.display = 'block';
    renderTablaCal();
});

document.getElementById('btnEditarNotasAlumno').addEventListener('click', abrirEditarCal);
document.getElementById('modalCerrar').addEventListener('click', cerrarModalCal);
document.getElementById('btnCancelar').addEventListener('click', cerrarModalCal);
document.getElementById('btnGuardar').addEventListener('click', guardarCal);

const modalFondoCal = document.getElementById('modalFondo');
modalFondoCal.addEventListener('click', function(e) {
    if (e.target === modalFondoCal) cerrarModalCal();
});

document.getElementById('btnExportarCSV').addEventListener('click', exportarCSVCal);
document.getElementById('btnGestionarExamenes').addEventListener('click', abrirGestionarExamenesEx);
document.getElementById('modalCerrarEx').addEventListener('click', cerrarGestionarExamenesEx);
document.getElementById('btnCerrarEx').addEventListener('click', cerrarGestionarExamenesEx);
document.getElementById('btnAnadirExamen').addEventListener('click', anadirExamenEx);

const modalFondoExCal = document.getElementById('modalFondoEx');
modalFondoExCal.addEventListener('click', function(e) {
    if (e.target === modalFondoExCal) cerrarGestionarExamenesEx();
});

const pestanasCal = document.querySelectorAll('.pill');
for (let p = 0; p < pestanasCal.length; p++) {
    pestanasCal[p].addEventListener('click', function() {
        for (let q = 0; q < pestanasCal.length; q++) {
            pestanasCal[q].classList.remove('activo');
        }
        this.classList.add('activo');
        asigActivaCal = this.getAttribute('data-asig');
        document.getElementById('subtitulo').textContent = subtitulosCal[asigActivaCal];

        document.getElementById('vista-detalle-alumno').style.display = 'none';
        document.getElementById('vista-lista-alumnos').style.display = 'block';

        renderTablaCal();
    });
}

renderTablaCal();
