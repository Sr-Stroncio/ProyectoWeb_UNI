// calificaciones
if (typeof calificaciones === 'undefined') {
    var calificaciones = { prog: [], bd: [], hci: [] };
}

if (typeof examenes === 'undefined') {
    var examenes = { prog: [], bd: [], hci: [] };
}

var subtitulosCal = {
    prog: 'Programación',
    bd: 'Bases de Datos',
    hci: 'HCI'
};

var asigActivaCal = 'prog';
var alumnoIdCal = null;

// se calcula la media sobre todas las notas del alumno
function calcularMediaCal(notas) {
    var suma = 0;
    var total = 0;
    for (var idEx in notas) {
        var val = notas[idEx];
        if (val !== null && val !== '' && !isNaN(val)) {
            suma = suma + parseFloat(val);
            total = total + 1;
        }
    }
    if (total === 0) return '—';
    return Math.round((suma / total) * 10) / 10;
}

function mostrarNotaCal(val) {
    if (val === null || val === '' || isNaN(val)) return '—';
    return val;
}

// se pinta la lista de alumnos
function renderTablaCal() {
    var cuerpo = document.getElementById('cuerpoTablaAlumnos');
    if (!cuerpo) return;
    cuerpo.innerHTML = '';

    var lista = calificaciones[asigActivaCal];
    if (!lista) return;

    for (var i = 0; i < lista.length; i++) {
        (function(alumno) {
            var fila = document.createElement('div');
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
        })(lista[i]);
    }
}

// se selecciona la asignatura desde el hash
window.seleccionarAsignaturaHash = function(asig) {
    asigActivaCal = asig;

    var pestanas = document.querySelectorAll('.pill');
    for (var i = 0; i < pestanas.length; i++) {
        if (pestanas[i].getAttribute('data-asig') === asig) {
            pestanas[i].classList.add('activo');
        } else {
            pestanas[i].classList.remove('activo');
        }
    }

    if (document.getElementById('subtitulo')) {
        document.getElementById('subtitulo').textContent = subtitulosCal[asig];
    }

    // se vuelve al listado
    if (document.getElementById('vista-detalle-alumno')) {
        document.getElementById('vista-detalle-alumno').style.display = 'none';
    }
    if (document.getElementById('vista-lista-alumnos')) {
        document.getElementById('vista-lista-alumnos').style.display = 'block';
    }

    renderTablaCal();
};

// se muestran los detalles del alumno (filas dinamicas por examen)
function mostrarDetalleCal(id) {
    var lista = calificaciones[asigActivaCal];
    var alumno = null;
    for (var i = 0; i < lista.length; i++) {
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
    var filasCont = document.getElementById('detalleNotasFilas');
    filasCont.innerHTML = '';

    var examsAsig = examenes[asigActivaCal];
    if (examsAsig.length === 0) {
        filasCont.innerHTML = '<div class="tabla-fila" style="cursor: default;"><span style="flex: 1; color: #888;">No hay examenes creados todavia. Usa "Gestionar exámenes".</span></div>';
    } else {
        for (var j = 0; j < examsAsig.length; j++) {
            var ex = examsAsig[j];
            var nota = alumno.notas[ex.id];
            var fila = document.createElement('div');
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
    var inputs = document.querySelectorAll('.input-nota-ex');
    var notas = {};
    for (var i = 0; i < inputs.length; i++) {
        var idEx = inputs[i].getAttribute('data-id');
        var val = inputs[i].value;
        notas[idEx] = val !== '' ? parseFloat(val) : null;
    }
    document.getElementById('mediaPreview').textContent = calcularMediaCal(notas);
}

function abrirEditarCal() {
    if (alumnoIdCal === null) return;

    var lista = calificaciones[asigActivaCal];
    var alumno = null;
    for (var i = 0; i < lista.length; i++) {
        if (lista[i].id === alumnoIdCal) {
            alumno = lista[i];
            break;
        }
    }
    if (!alumno) return;

    document.getElementById('modalNombreAlumno').textContent = alumno.nombre;

    // se generan los inputs de notas dinamicamente
    var contInputs = document.getElementById('notasInputs');
    contInputs.innerHTML = '';

    var examsAsig = examenes[asigActivaCal];
    if (examsAsig.length === 0) {
        contInputs.innerHTML = '<p style="color: #888;">No hay examenes. Crea uno desde "Gestionar exámenes".</p>';
    } else {
        for (var j = 0; j < examsAsig.length; j++) {
            var ex = examsAsig[j];
            var nota = alumno.notas[ex.id];
            var valor = nota !== null && nota !== undefined ? nota : '';
            var grupo = document.createElement('div');
            grupo.className = 'nota-grupo';
            grupo.innerHTML =
                '<label class="campo-label">' + ex.titulo + '</label>' +
                '<input class="campo-input input-nota-ex" type="number" data-id="' + ex.id + '" value="' + valor + '" placeholder="—" min="0" max="10" step="0.1">';
            contInputs.appendChild(grupo);
        }

        // se enganchan los listeners de los nuevos inputs
        var inputs = document.querySelectorAll('.input-nota-ex');
        for (var k = 0; k < inputs.length; k++) {
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

    var inputs = document.querySelectorAll('.input-nota-ex');
    var lista = calificaciones[asigActivaCal];
    var alumno = null;
    for (var i = 0; i < lista.length; i++) {
        if (lista[i].id === alumnoIdCal) {
            alumno = lista[i];
            break;
        }
    }

    // se monta el body con notas[id]=valor
    var partes = ['alumno_id=' + alumnoIdCal];
    for (var k = 0; k < inputs.length; k++) {
        var idEx = inputs[k].getAttribute('data-id');
        var val = inputs[k].value;
        partes.push('notas[' + idEx + ']=' + (val !== '' ? val : ''));
        if (alumno) {
            alumno.notas[idEx] = val !== '' ? parseFloat(val) : null;
        }
    }
    var params = partes.join('&');

    fetch('utils/guardar-notas-profesor.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params
    });

    cerrarModalCal();
    mostrarDetalleCal(alumnoIdCal);
}

// --- gestion de examenes ---

function renderListaExamenesEx() {
    var cont = document.getElementById('listaExamenesEx');
    cont.innerHTML = '';

    var lista = examenes[asigActivaCal];
    if (lista.length === 0) {
        cont.innerHTML = '<p style="color: #888; margin: 0;">No hay examenes creados.</p>';
        return;
    }

    for (var i = 0; i < lista.length; i++) {
        (function(ex) {
            var fila = document.createElement('div');
            fila.className = 'examen-fila';
            fila.innerHTML =
                '<input class="campo-input examen-titulo-input" type="text" value="' + ex.titulo + '" data-id="' + ex.id + '">' +
                '<button class="btn-accion examen-guardar" data-id="' + ex.id + '">Guardar</button>' +
                '<button class="btn-modal-borrar examen-borrar" data-id="' + ex.id + '" style="padding: 6px 10px;">Eliminar</button>';

            cont.appendChild(fila);
        })(lista[i]);
    }

    // listeners de cada boton
    var botonesGuardar = cont.querySelectorAll('.examen-guardar');
    for (var g = 0; g < botonesGuardar.length; g++) {
        botonesGuardar[g].addEventListener('click', function() {
            var id = parseInt(this.getAttribute('data-id'));
            var input = cont.querySelector('.examen-titulo-input[data-id="' + id + '"]');
            renombrarExamenEx(id, input.value.trim());
        });
    }

    var botonesBorrar = cont.querySelectorAll('.examen-borrar');
    for (var b = 0; b < botonesBorrar.length; b++) {
        botonesBorrar[b].addEventListener('click', function() {
            var id = parseInt(this.getAttribute('data-id'));
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
    var titulo = document.getElementById('inputNuevoExamen').value.trim();
    if (!titulo) {
        alert('El titulo no puede estar vacio.');
        return;
    }

    var params = 'id=&titulo=' + encodeURIComponent(titulo) + '&asig=' + asigActivaCal;

    fetch('utils/guardar-examen.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params
    })
    .then(function(r) { return r.text(); })
    .then(function(nuevoId) {
        examenes[asigActivaCal].push({ id: parseInt(nuevoId), titulo: titulo, fecha: '' });
        // se inicializa la nota null para todos los alumnos
        var lista = calificaciones[asigActivaCal];
        for (var i = 0; i < lista.length; i++) {
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
    var params = 'id=' + id + '&titulo=' + encodeURIComponent(titulo) + '&asig=' + asigActivaCal;

    fetch('utils/guardar-examen.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params
    })
    .then(function() {
        var lista = examenes[asigActivaCal];
        for (var i = 0; i < lista.length; i++) {
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
        var lista = examenes[asigActivaCal];
        var nuevos = [];
        for (var i = 0; i < lista.length; i++) {
            if (lista[i].id !== id) nuevos.push(lista[i]);
        }
        examenes[asigActivaCal] = nuevos;
        // se quita la nota de todos los alumnos
        var alums = calificaciones[asigActivaCal];
        for (var j = 0; j < alums.length; j++) {
            delete alums[j].notas[id];
        }
        renderListaExamenesEx();
    });
}

function exportarCSVCal() {
    var lista = calificaciones[asigActivaCal];
    var examsAsig = examenes[asigActivaCal];

    // cabecera dinamica
    var cabecera = ['Alumno', 'Correo'];
    for (var c = 0; c < examsAsig.length; c++) {
        cabecera.push(examsAsig[c].titulo);
    }
    cabecera.push('Media');

    var filas = [cabecera.join(',')];

    for (var i = 0; i < lista.length; i++) {
        var alumno = lista[i];
        var linea = [alumno.nombre, alumno.email];
        for (var e = 0; e < examsAsig.length; e++) {
            linea.push(mostrarNotaCal(alumno.notas[examsAsig[e].id]));
        }
        linea.push(calcularMediaCal(alumno.notas));
        filas.push(linea.join(','));
    }

    var blob = new Blob([filas.join('\n')], { type: 'text/csv;charset=utf-8;' });
    var url = URL.createObjectURL(blob);
    var enlace = document.createElement('a');
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

var modalFondoCal = document.getElementById('modalFondo');
modalFondoCal.addEventListener('click', function(e) {
    if (e.target === modalFondoCal) cerrarModalCal();
});

document.getElementById('btnExportarCSV').addEventListener('click', exportarCSVCal);
document.getElementById('btnGestionarExamenes').addEventListener('click', abrirGestionarExamenesEx);
document.getElementById('modalCerrarEx').addEventListener('click', cerrarGestionarExamenesEx);
document.getElementById('btnCerrarEx').addEventListener('click', cerrarGestionarExamenesEx);
document.getElementById('btnAnadirExamen').addEventListener('click', anadirExamenEx);

var modalFondoExCal = document.getElementById('modalFondoEx');
modalFondoExCal.addEventListener('click', function(e) {
    if (e.target === modalFondoExCal) cerrarGestionarExamenesEx();
});

var pestanasCal = document.querySelectorAll('.pill');
for (var p = 0; p < pestanasCal.length; p++) {
    pestanasCal[p].addEventListener('click', function() {
        for (var q = 0; q < pestanasCal.length; q++) {
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
